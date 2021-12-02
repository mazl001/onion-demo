<?php $__env->startSection('title', '在线交流'); ?>

<?php $__env->startSection('head'); ?>
<script>
    /**
      *0：未连接
      *1：连接成功，可通讯
      *2：正在关闭
      *3：连接已关闭或无法打开
      */
    //创建一个webSocket 实例
    var webSocket  = new  WebSocket("ws://127.0.0.1:9999");

    // 存储用户名到全局变量,握手成功后发送给服务器
    var username = "<?php echo e($username); ?>";
    while (username == null || username == "") {
        username = prompt('请输入临时用户名', '游客' + uuid(8, 16));

        if (username.length > 16) {
            alert('用户名长度不能超过16个字符串');
            username = null;
        }
    }

    webSocket.onerror = webSocket.onopen = webSocket.onclose = function (event){
        document.getElementById("msg").innerHTML += "<p>系统消息: "+ sockState() +"</p>";
        document.getElementById("msg").scrollTop = document.getElementById("msg").scrollHeight;
        console.log("error"+event.data);
    };

    //监听消息
    webSocket.onmessage = function (event){
        var msg = JSON.parse(event.data);

        switch (msg.command) {
            case 'login':
                webSocket.send(JSON.stringify({'type': 'login', 'username': username}));
            break;

            case 'updateUserList':
                userList = document.getElementById("user_list");
                userList.innerHTML = "";
                
                for (x in msg.users) {
                    var p = document.createElement("li");
                    p.innerHTML = msg.users[x];
                    userList.appendChild(p);
                }
            break;

            case 'updateMsgList':
                msgList = document.getElementById("msg");
                msgList.innerHTML += "<p>"+msg.username+": "+msg.content+"</p>"
                msgList.scrollTop = msgList.scrollHeight;
            break;
        };
    };
 
    function sockState(){
        var status = ['未连接','连接成功, 可通讯','正在关闭','连接已关闭或无法打开'];
            return status[webSocket.readyState];
    }
 
    function send(event){
        var msg = document.getElementById('text').value;
        if (msg == '') {
            alert('消息不能为空');
            return;
        }

        if (msg.length > 1024) {
            alert('消息长度不能超过1024个字');
            return;
        }

        document.getElementById('text').value = '';
        webSocket.send(JSON.stringify({'type': 'chat', 'username': username, 'content': msg}));
    };

    function confirm(event) {
        if (13 == event.keyCode) {
            send();
        } else {
            return false;
        }
    }

    /**
     * 生产一个全局唯一ID作为用户名的默认值;
     *
     * @param  len
     * @param  radix
     * @returns  {string}
     */
    function uuid(len, radix) {
        var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.split('');
        var uuid = [], i;
        radix = radix || chars.length;

        if (len) {
            for (i = 0; i < len; i++) uuid[i] = chars[0 | Math.random() * radix];
        } else {
            var r;

            uuid[8] = uuid[13] = uuid[18] = uuid[23] = '-';
            uuid[14] = '4';

            for (i = 0; i < 36; i++) {
                if (!uuid[i]) {
                    r = 0 | Math.random() * 16;
                    uuid[i] = chars[(i == 19) ? (r & 0x3) | 0x8 : r];
                }
            }
        }

        return uuid.join('');
    }    
</script>

<style type="text/css">
.chatroom {
    width: 100%;
    height: 400px;
    border:1px solid #666; 
    background:#f9f9f9;
}

.user_list {
    float: left;
    width: 30%; 
    height: 100%; 
    border-right:1px solid #666; 
    background:#fff;
}

.user_list p {
    margin-left: 16px; 
    margin-top: 10px;
}

.user_list ul {
    height: 350px; 
    overflow: scroll;
}

.msg_list {
    float: right;
    width: 65%;
    height: 100%; 
    margin: 10px;
}

#msg {
    height:330px; 
    border:1px solid #666; 
    background:#fff;
    overflow: scroll; 
}

#msg p {
    margin-left: 10px;
}

.msg_list .msg_input {
    height: 40px; 
    margin: 10px 0px;
}

#text {
    height: 40px; 
    width: 75%;
}

#send {
    height: 40px; 
    width: 22%; 
    background-color: #e9686b; 
    color: #ffffff; 
    border: none; 
}
</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="chatroom">
    <div class="user_list">
        <p>在线用户</p>
        <ul id="user_list"></ul>
    </div>

    <div class="msg_list">
        <div id="msg">
            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p><?php echo e($message['username']); ?> : <?php echo e($message['content']); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>            
        </div>
        <div class="msg_input">
            <input id="text" onkeydown="confirm(event);" value="">
            <input id="send" type="submit" value="发送" onclick="send()">
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>