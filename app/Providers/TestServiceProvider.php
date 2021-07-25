<?php
namespace app\Providers;

use Onion\Providers\ServiceProvider;
use app\Services\TestService;


class TestServiceProvider extends ServiceProvider {

	//在 register 方法中，你可以将 服务 注册至 容器 之中
	public function register() {
		$this->application->singleton('testService', TestService::class);
	}

	//boot 方法是在所有的 服务提供者 注册完成之后调用
	public function boot() {
		
	}
}