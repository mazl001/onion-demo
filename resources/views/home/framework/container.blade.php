@extends('home.public')

@section('title', '简介: 容器和依赖注入')

@section('content')
<pre class="brush:php;toolbar:false">
简单介绍下容器和依赖注入, 从工厂模式开始说起:



/**
 * 先随便定义两个类
 */
class Apple {};
class Banana{};



/**
 * 工厂模式1.0版本: 由(工厂实现类)决定实例化哪一个类
 */
class FactoryOne {
	public function make($abstract) {
		switch ($abstract) {
			case 'Apple':	return new Apple;
			case 'Banana':  return new Banana;
		}
	}
}

$apple = (new FactoryOne)->make('Apple');






/**
 * 工厂模式2.0版本: 自定义实例化哪一个类
 */
class FactoryTwo {
	public $bindings;

	public function bind($abstract, $concrete) {
		$this->bindings[$abstract] = $concrete;
	}

	public function make($abstract) {
		return $this->bindings[$abstract];
	}
}

$factoryTwo = new FactoryTwo;
$factoryTwo->bind('Apple',  new Apple);
$factoryTwo->bind('Banana', new Banana);

$apple = $factoryTwo->make('Apple');





/**
 * 工厂模式2.0版本 缺点:
 *
 * 假如有 Fruit 类, 它依赖于 Apple 类、 Banana 类,
 *
 * 那么要 实例化 Fruit 类, 需要先实例 Apple 类, Banana 类
 *
 */
class Fruit {
	public function __construct(Apple $apple, Banana $banana) {
		
	}
}

$factoryTwo = new FactoryTwo;
$factoryTwo->bind('Apple',  new Apple);
$factoryTwo->bind('Banana', new Banana);

//需要先实例化 Apple 类, Banana 类
$apple 	= $factoryTwo->make('Apple');
$banana = $factoryTwo->make('Banana');
$factoryTwo->bind('Fruit',  new Fruit($apple, $banana));

//最后才能实例化 Fruit类
$fruit  = $factoryTwo->make('Fruit');




/**
 * 工厂模式3.0版本: 容器和依赖注入
 *
 * 通过反射获取类的构造函数的参数
 *
 * 根据构造函数的参数的类型约束，自动在容器中搜寻符合的依赖需求, 
 * 自动注入到构造函数参数中.
 *
 * 这样一种方式，使得我们在创建一个实例的同时解决其依赖关系
 */
class Container {
	public $bindings;

	public function bind($abstract, $concrete) {
		$this->bindings[$abstract] = $concrete;
	}

	public function make($abstract) {
		$concrete = $this->bindings[$abstract];
		
		//获取类的构造函数的参数, 自动解决依赖需求
		$reflectionClass 			= new \ReflectionClass($concrete);

		if (!is_null($reflectionClass->getConstructor())) {
			$construtor 		 	= $reflectionClass->getConstructor();
			$reflectionParameters 	= $construtor->getParameters();
			$dependencies			= $this->getDependecies($reflectionParameters);
		}

		return $reflectionClass->newInstanceArgs($dependencies ?? []);
	}

	public function getDependecies($reflectionParameters) {
		foreach ($reflectionParameters as $parameter) {
			$className 		= $parameter->getClass()->getName();
			$dependencies[] = $this->make($className);
		}

		return $dependencies;
	}
}

$container = new Container;
$container->bind('Apple',  Apple::class);
$container->bind('Banana', Banana::class);
$container->bind('Fruit',  Fruit::class);

$fruit  = $container->make('Fruit');




/**
 * 我们可以通过绑定 接口或标识符 到 具体实现 的方式, 让容器拥有各种各样的功能 (服务).
 * 
 * 例如, 我们想让容器拥有缓存功能 (服务).  
 */

//定义接口
interface CacheInterface {
    public function set($key, $val);
    public function get($key);
}

//实现接口
class MyCache implements CacheInterface {
	protected $caches = [];

    public function set($key, $val) {
    	$this->caches[$key] = $val;
    }

    public function get($key) {
    	return $this->caches[$key];
    }
}

//绑定具体实现. 下一篇文章中的 服务提供者 用于为相关服务提供统一绑定场所
$container->bind(CacheInterface::class, new MyCache);
$cache = $container->make(CacheInterface::class);

$cache->set('name', 'stephen');
$name = $cache->get('name');
</pre>
@endsection