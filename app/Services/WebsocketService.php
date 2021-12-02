<?php
namespace app\Services;

class WebsocketService {

    /**
     * 服务器端socket
     */
    private $master;

    private $sockets;


    /**
     * 用户登录时的回调方法
     */
    public $onLogin = null;

    /**
     * 接到聊天信息时的回调方法
     */
    public $onChat = null;


    public function __construct($address, $port) {
        
        try {
            $this->master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

            socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1);

            socket_bind($this->master, $address, $port);

            socket_listen($this->master);

        } catch (Exception $e) {
            die(socket_strerror(socket_last_error()).PHP_EOL);
        }

        $this->sockets[0] = ['socket' => $this->master];

        $this->log("server started, address:{$address}, port:{$port}");
    }


    public function run() {

        $write = $except = $tv_sec = null;

        while(True) {
            $changes = $this->getSockets();

            socket_select($changes, $write, $except, $tv_sec);

            foreach($changes as $socket) {

                if ($socket == $this->master) {
                    
                    if (($client = socket_accept($this->master)) === false) {
                        $this->log("socket accept failed: ".socket_strerror(socket_last_error($socket)));
                        continue;
                    }

                    //客户端连接成功后, 进行 websocket 握手
                    $content = trim(socket_read($client, 1024));
                    $this->respond($client, ['type' => 'handshake', 'content' => $content]);
                } else {
                    $bytes = socket_recv($socket, $buf, 1024, 0);

                    if ($bytes < 9) {
                        //有客户端下线, 通知所有客户端更新用户列表
                        $this->respond($socket, ['type' => 'logout']);
                    } else {
                        //解码客户端消息, 回复
                        $recv_msg = json_decode($this->decrypt($buf), true);
                        $this->respond($socket, $recv_msg);
                    }
                }
            }
        }
    }


    public function respond($socket, $recv_msg) {
        socket_getpeername($socket, $ip, $port);

        switch ($recv_msg['type']) {
            case 'handshake':
                $this->handshaking($socket, $recv_msg['content']);

                $this->sockets[(int)$socket] = ['socket' => $socket];

                //握手成功后, 通知客户端进行登录
                $this->sendMsg($socket, json_encode(['command' => 'login']));

                $this->log("New client, ip: {$ip}, port: {$port}");
            break;

            case 'chat':
                $username = $this->sockets[(int)$socket]['username'];
                if (is_callable($this->onChat)) {
                    call_user_func_array($this->onChat, [$username, $recv_msg['content']]);
                }

                $msg = json_encode([
                    'command'   => 'updateMsgList',
                    'username'  => htmlspecialchars($username), 
                    'content'   => htmlspecialchars($recv_msg['content'])
                ]);

                $this->broadcast($msg);
            break;

            case 'login':
                $this->sockets[(int)$socket]['username'] = htmlspecialchars($recv_msg['username']);
                if (is_callable($this->onLogin)) {
                    call_user_func_array($this->onLogin, [$ip, $recv_msg['username']]);
                }

                $msg = json_encode([
                    'command' => 'updateUserList',
                    'users'   => $this->getUsers()
                ]);
                $this->broadcast($msg);
            break;

            case 'logout':
                unset($this->sockets[(int)$socket]);

                $msg = json_encode([
                    'command' => 'updateUserList',
                    'users'   => $this->getUsers()
                ]);
                $this->broadcast($msg);
            break;
        }
    }

    /**
     * @param $msg  未加密字符串
     */
    public function sendMsg($socket, $msg) {
        $encryptMsg = $this->encrypt($msg);
        return socket_write($socket, $encryptMsg, strlen($encryptMsg));
    }

    /**
     * @param $msg  未加密字符串
     */
    public function broadcast($msg) {
        foreach ($this->getSockets() as $socket) {
            if ($socket != $this->master) {
                $this->sendMsg($socket, $msg);
            }
        }
    }

    /**
     * 获取客户端socket列表
     */
    public function getSockets() {
        return array_column($this->sockets, 'socket');
    }

    /**
     * 获取已登录用户列表
     */
    public function getUsers() {
        return array_unique(array_column($this->sockets, 'username'));
    }

    /**
     * websocket 握手
     */
    public function handshaking ($client, $content) {

        //定义头部信息
        $headers = [];

        if(preg_match('/Sec-WebSocket-Key:.*\r\n/', $content, $matchs)) {
            $headers['Sec-WebSocket-Key'] = trim(chop(str_replace('Sec-WebSocket-Key:',"",$matchs[0])));
        }

        //设置返回头
        $secKey = $headers['Sec-WebSocket-Key'];
        $websocket_accept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: 127.0.0.1\r\n" .
            "WebSocket-Location: ws://127.0.0.1:9999/websocket/websocket\r\n".
            "Sec-WebSocket-Accept:$websocket_accept\r\n\r\n";
        //写入缓冲
        return socket_write($client, $upgrade, strlen($upgrade));
    }

    /**
     * 解码
     */
    public function decrypt($buffer) {
        $len = $masks = $data = $decoded = null;
        $len = ord($buffer[1]) & 127;

        if ($len === 126) {
            $masks = substr($buffer, 4, 4);
            $data = substr($buffer, 8);
        } else if ($len === 127) {
            $masks = substr($buffer, 10, 4);
            $data = substr($buffer, 14);
        } else {
            $masks = substr($buffer, 2, 4);
            $data = substr($buffer, 6);
        }

        for ($index = 0; $index < strlen($data); $index++) {
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }

        return $decoded;
    }

    /**
     * 编码
     */
    public function encrypt($msg) {
        $frame = [];
        $frame[0] = '81';
        $len = strlen($msg);
        if ($len < 126) {
            $frame[1] = $len < 16 ? '0' . dechex($len) : dechex($len);
        } else if ($len < 65025) {
            $s = dechex($len);
            $frame[1] = '7e' . str_repeat('0', 4 - strlen($s)) . $s;
        } else {
            $s = dechex($len);
            $frame[1] = '7f' . str_repeat('0', 16 - strlen($s)) . $s;
        }

        $data = '';
        $l = strlen($msg);
        for ($i = 0; $i < $l; $i++) {
            $data .= dechex(ord($msg{$i}));
        }
        $frame[2] = $data;

        $data = implode('', $frame);

        return pack("H*", $data);
    }

    public function log($msg) {
        echo($msg.PHP_EOL);
    }   
}