@extends('home.public')

@section('title', '简介: 服务提供者')

@section('content')
<pre class="brush:php;toolbar:false">
前面简单介绍了 "容器" 的概念. "容器" 是升级版的工厂类, 可以在创建实例的同时解决类的依赖. 

初始时, "容器" 不能提供任何服务. 我们通过绑定(注册) "接口或标识符" 到 "具体实现" 的方式, 

让容器拥有各种各样的服务能力, 而 "服务提供者" 则是用于提供统一的绑定场所. 


应用 (容器) 中的每个核心组件都有一个 "服务提供者", 包括路由、 视图、 事件管理、数据库管理

等. 你可以在 config/provider.php 配置文件里查看项目目前有哪些 "服务提供者".



例子: 

假如应用里需要用到一个短信验证的服务，我们可以使用一个 "服务提供者" 将 "短信验证服务"

绑定到 "应用 (容器)" 中.




1、定义短信服务类

演示文件: app\Services\TestService;


class TestService {

	/**
	 * 模拟发送验证码
	 */
	public function send($phone, $code) {
		echo "$phone, 你的验证码为 $code <br>";
	}
}




2、 创建服务提供者. 服务提供者 必须继承 Onion\Providers\ServiceProvider 抽象类, 

实现register、 boot方法. 

演示文件: app\Providers\TestServiceProvider.php, 


class TestServiceProvider extends ServiceProvider {

	//在 register 方法中，你可以将 服务 注册至 容器 之中
	public function register() {
		$this->application->singleton('testService', TestService::class);
	}

	//boot 方法是在所有的 服务提供者 注册完成之后调用
	public function boot() {
		
	}
}




3、注册服务提供者

定义完服务提供者类后，接下来我们需要将该服务提供者注册到应用中，很简单，

只需将该类追加到配置文件 config/provider.php 数组中即可:


return [

	//其他服务提供者
    
    app\Providers\TestServiceProvider::class,
];




4、为了测试该服务提供者, 我们创建一个控制器DemoController

演示文件: app\Http\Controllers\Home\DemoController;


class DemoController {

	public function service() {
		app('testService')->send('19876543210', '1234');
	}
}
</pre>
@endsection