<?php $__env->startSection('title', '简介: Facade'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
外观模式（Facade Pattern）通过引入一个外观角色, 为复杂的子系统调用提供一个易用的

入口, 来简化客户端与子系统之间的交互. 在框架中, Facade 为 "容器" 中注册的服务提供

了一个易于使用的「静态」接口.



使用前: 客户端->复杂的子系统

使用后: 客户端->外观角色(为复杂的子系统调用提供一个易用的入口)->复杂的子系统




例子: 
	Config::get('app.timezone');



你可能会疑惑:

1、没有导入 Config类 到当前命名空间, 框架里也没有 Config 类, 运行的是哪个文件的代码?

2、get方法不是静态方法, 却使用静态方式调用?




简单分析下代码运行流程:

1、config/facade.php 文件定义了 Facade 类别名数组

 return [
    /*
    |--------------------------------------------------------------------------
    | 注册Facade类别名
    | 注册后，将不在需要手动 use Onion\Facades\Route;
    |--------------------------------------------------------------------------
    */
	'aliases'	=> 	[
		'App'		=>	Onion\Facades\App::class,
		'Config'	=>	Onion\Facades\Config::class,
        'Cookie'    =>	Onion\Facades\Cookie::class,
        'DB'        =>	Onion\Facades\DB::class,
        'Event'     =>	Onion\Facades\Event::class,
		'Route'		=>	Onion\Facades\Route::class,
        'Redis'     =>	Onion\Facades\Redis::class,
        'Session'   =>	Onion\Facades\Session::class,
	]
 ];




2、在应用引导程序中, 通过 Onion\Facades\Facade::registerClassAlias 方法

创建类别名.
  

 spl_autoload_register(function($className) {

	$aliases = self::$application->config['facade.aliases'];
	
	class_alias($aliases[$abbrClassName], $className);
 });


 例如: 创建类 Onion\Facades\Config 的别名为 Config




3、当你调用 Config 类时, 实际调用的是 Onion\Facades\Config 类, 该类通

 过 Composer 自动加载.




4、Config::get 方法, 触发 Config::__callStatic方法, 最后调用

 Application->make('Config')->get 方法. 

 
 public static function __callStatic($method, $args) {
	$instance = self::$application->make(static::getFacadeAccessor());
	return call_user_func_array([$instance, $method], $args);
 }


 从容器中创建Config实例, 并调用该实例的get方法.
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>