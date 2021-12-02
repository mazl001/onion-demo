<?php
namespace app\Http\Controllers\Home;

use Onion\Http\Request;


class WebsocketController {
    
    public function server() {
        $websocketService = app('websocketService');

        $websocketService->onLogin = function($ip, $username) {
            Redis::hset('chat_users', $ip, $username);
        };

        $websocketService->onChat = function($username, $content) {
            Redis::rpush('chat_messages', json_encode([
                'username' => $username,
                'content'  => $content,
                'time'     => time()
            ]));
        };

        $websocketService->run();
    }

    public function client() {
        $messages = Redis::lrange('chat_messages', -100, -1);
        $username = Redis::hget('chat_users', get_client_ip());

        array_walk($messages, function(&$value, $key) {
            $value = json_decode($value, 'true');
        });

        $data = ['messages' => $messages, 'username' => $username];
        return view('home.websocket.client', $data);
    }
}