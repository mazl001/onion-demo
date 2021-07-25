@extends('home.public')

@section('title', '简介: 路由搜索、分组')

@section('content')
<pre class="brush:php;toolbar:false">

1、一维数组转化为多维数组, 在路由搜索中的应用


例子:
	
	路由地址: 'sellercenter/trade/itemlist';

	路由动作: 'TradeController@itemlist';



首先, 将路由地址分割为一维数组
	
	$url = ['sellercenter', 'trade', 'itemlist'];


其次, 将一维数组转化为多维数组, 并关联路由动作

	$routes['sellercenter']['trade']['itemlist']['_route'] = 
		'TradeController@itemlist';


搜素路由时, 只需从路由数组中查找:

	$routes['sellercenter']['trade']['itemlist']['_route']

不再需要遍历整个路由数组.




/**
 * 演示一个简单的路由搜索功能:
 *
 * 真实的路由搜索还需要匹配路由参数, 会更复杂一些
 */
$url 	= 'sellercenter/trade/itemlist';

$action = 'TradeController@itemlist';

$url = explode('/', $url);

foreach (array_reverse($url) as $value) {
	$routes = [$value => $routes ?? ['_route' => $action]];
}


var_dump($routes['sellercenter']['trade']['itemlist']['_route'].'<br>');





2、 简单介绍路由分组的实现



路由分组功能支持无限嵌套, 里层的分组 (子分组) 将会继承 "所有" 外层分组 (父分组) 的属性

分组属性采用 栈 结构存储, 先进后出

       _________________
      |              	|       栈顶: 继承所有父分组属性: ['name' => 'admin:']
         最里层分组属性     ->   属性: ['name' => 'admin:', 'middleware' => 'auth']
	  |_________________|       
      |				  	|
         上级父分组属性     ->   属性: ['name' => 'admin:']
      |_________________|
      |                 |
         上上级父分组属性
      |_________________|
      |                 |
           ........
      |_________________|
      |               	|
         最外层父分组属性   ->   栈底: []
      |_________________|



class Route {

	public static $stack = [];

	public static function group($attributes, $callback) {

		//当前, 栈顶的属性, 即父分组的属性
		$top = end(self::$stack) ?: [];

		//合并父分组和现分组的属性, 压到栈顶
		array_push(self::$stack, array_merge($top, $attributes));

		//在匿名函数中, 通过获取栈顶的属性, 即可获取现分组的属性
		call_user_func($callback);

		//匿名函数运行完, 弹出栈顶分组属性
		array_pop(self::$stack);
	}	
}



//外层分组 (父分组)
Route::group(['name' => 'admin:'], function() {
	
	//属性: ['name' => 'admin:']
	var_dump(end(Route::$stack));


	//里层的分组 (子分组), 将会继承所有父分组的属性
	Route::group(['middleware' => 'auth'], function() {

		//属性: ['name' => 'admin:', 'middleware' => 'auth']
		var_dump(end(Route::$stack));

	});
});
</pre>
@endsection