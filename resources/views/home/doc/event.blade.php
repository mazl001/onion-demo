@extends('home.public')

@section('title', '开发文档: 事件')

@section('content')
<pre class="brush:php;toolbar:false">
配置文件: config/event.php, 你可以在配置文件内添加观察者, 程序会自动加载.

observers 数组    	观察者, 用于监听单个事件

subscribers 数组  	观察者, 用于监听多个事件

系统事件: 数据库服务在增删改查操作时, 会自动触发 insert、 delete、 update、 select 事件.




1、 监听单个事件

你可以通过 Event::attach('事件名称', '事件观察者') 方法, 手动监听单个事件.

事件观察者 可以是匿名函数, 也可以是实现了 handle() 方法的类.


//事件观察者: 匿名函数
Event::attach('myEvent', function() {

});

//事件观察者: 实现了 handle() 方法的类
Event::attach('myEvent', \app\Observers\Demo::class);


演示文件: app\Observers\Demo.

namespace app\Observers;

class Demo {
	public function handle() {
		var_dump('事件测试: '.__METHOD__.' is called');
	}
}




2、监听多个事件 

你可以通过 Event::subscribe('事件观察者类名') 方法, 手动监听多个事件. 例如: 

Event::subscribe(\app\Subscribers\Demo::class) 将监听 insert、 delete事件.


演示文件: \app\Subscribers\Demo.

namespace app\Subscribers;

class Demo {

	public function onInsert($SQL, $PDOValues, $result) {
		$this->show($SQL, $PDOValues, $result);
	}

	public function onDelete($SQL, $PDOValues, $result) {
		$this->show($SQL, $PDOValues, $result);
	}
}




3、触发事件:
	
通过 Event::notify('事件名称', ['事件参数数组']) 方法触发事件
</pre>
@endsection