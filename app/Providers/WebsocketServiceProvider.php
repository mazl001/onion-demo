<?php
namespace app\Providers;

use Onion\Providers\ServiceProvider;
use app\Services\WebsocketService;


class WebsocketServiceProvider extends ServiceProvider {

    //在 register 方法中，你可以将 服务 注册至 容器 之中
    public function register() {
        $this->application->singleton('websocketService', function() {
            return new WebsocketService('127.0.0.1', 9999);
        });
    }

    //boot 方法是在所有的 服务提供者 注册完成之后调用
    public function boot() {
        
    }
}