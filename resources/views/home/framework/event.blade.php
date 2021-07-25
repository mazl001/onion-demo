@extends('home.public')

@section('title', '简介: 事件机制')

@section('content')
<pre class="brush:php;toolbar:false">
事件机制使用观察者模式实现. 它定义了一种一对多的依赖关系，让多个观察者对象

同时监听某一个主题对象. 这个主题对象在状态变化时，会通知所有的观察者对象.




简单介绍下事件机制是怎么实现的:



1、定义事件调度器: 

class Event {

	/**
	 * 观察者数组
	 */
	protected static $observers = [];


	/**
	 * 增加观察者: 监听单个事件
	 * @param string $event    事件名称
	 * @param object $observer 观察者对象
	 * @param string $method   回调方法名称
	 */
	public static function attach($event, $observer, $method = 'handle') {
		self::$observers[$event][] = [$observer, $method];
	}


	/**
	 * 增加观察者: 监听多个事件
	 * @param string $subscriber 类名
	 */
	public static function subscribe($subscriber) {

		//通过反射获得类内以 on 开头的方法, 添加为观察者
		$class   = new ReflectionClass($subscriber);
		$methods = $class->getMethods();

		foreach ($methods as $method) {
			$methodName = $method->getName();

			if (substr($methodName, 0, 2) === 'on') {

				$event = lcfirst(substr($methodName, 2));
				self::attach($event, new $subscriber, $methodName);
			
			}
		}
	}


	/**
	 * 通知所有订阅该事件的观察者, 某个事件发生了
	 * @param string $event    事件名称
	 * @param array  $params   参数
	 */
	public static function notify($event, $params = []) {
		foreach (self::$observers[$event] as $observer) {
			call_user_func_array($observer, $params);
		}
	}
}




2、定义观察者: 用于监听单个事件: 

class Observer {
	public function handle() {
		var_dump(__METHOD__);
	}
}




3、定义观察者: 用于监听多个事件:

class DatabaseObserver {

	//监听insert事件
	public function onInsert() {
		var_dump(__METHOD__);
	}


	//监听delete事件
	public function onDelete() {
		var_dump(__METHOD__);
	}


	//监听update事件
	public function onUpdate() {
		var_dump(__METHOD__);
	}


	//监听delete事件
	public function onSelect() {
		var_dump(__METHOD__);
	}
}




4、监听单个事件, 并触发start事件.

Event::attach('start', new Observer);
Event::notify('start', ['参数数组']);




5、监听多个事件, 例如: 你可以同时监听数据库的增删改查操作

Event::subscribe(DatabaseObserver::class);
Event::notify('insert', ['参数数组']);
Event::notify('delete', ['参数数组']);
Event::notify('update', ['参数数组']);
Event::notify('select', ['参数数组']);
</pre>
@endsection