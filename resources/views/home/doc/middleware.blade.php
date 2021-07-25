@extends('home.public')

@section('title', '开发文档: 中间件')

@section('content')
<pre class="brush:php;toolbar:false">
配置文件: app/middleware.php

global数组里都是应用程序会自动加载的全局中间件

route 数组里是路由中间件, 可以在路由定义中使用, 不会自动加载




1、 创建中间件. 中间件必须实现 handle(Request $request, Closure $next) 方法, 

可以在后面追加中间件参数.


演示文件: app\Http\Middlewares\DemoMiddleware.php

class DemoMiddleware {

    public function handle(Request $request, Closure $next, $name = 'Stephen') {

        //在 $next($request) 前的代码, 它会在 Controller@action 执行前被执行

        echo '中间件前置操作: method '.__METHOD__.' is called, name: '.$name.'<br>';



        $response = $next($request);



        //在 $next($request) 后的代码, 它会在 Controller@action 执行后被执行

        echo '中间件后置操作: method '.__METHOD__.' is called, name: '.$name.'<br>';

        return $response;
    }
}




2、 注册中间件, 只需将该类追加到配置文件 config/middleware.php 数组中即可:

return [
    /*
    |--------------------------------------------------------------------------
    | 路由中间件
    |--------------------------------------------------------------------------
    */
    'route' => [
        'auth'  =>  app\Http\Middleware\DemoMiddleware::class
    ]
];




3、指派中间件, 可以通过以下两种方式:

    方式一、指派路由中间件:

    Route::get('user', ['middleware' => 'auth:John', 'uses' => 'RouteController@middleware']);


    方式二、指派控制器中间件:

    在 控制器类 中定义: protected $middleware = ['auth:John'];



例子中: auth 为 中间件名称, config/middleware.php文件route数组中的 键名

例子中: John 为 中间件参数, 使用冒号 : 区隔中间件名称与参数，多个参数可使用逗号分隔




4、为了测试中间件, 我们创建一个控制器RouteController

演示文件: app\Http\Controllers\Home\RouteController;

class RouteController {

    public function middleware(Request $request) {
        echo '路由控制器操作: method '.__METHOD__.' is called<br>';
    }
}




5、定义路由, 访问控制器, 查看输出, 验证中间件运行流程

中间件前置操作: method app\Http\Middleware\DemoMiddleware::handle is called, name: John

路由控制器操作: method app\Http\Controllers\Home\RouteController::middleware is called

中间件后置操作: method app\Http\Middleware\DemoMiddleware::handle is called, name: John

</pre>
@endsection