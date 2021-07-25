@extends('home.public')

@section('title', '开发文档: 路由')

@section('content')
<pre class="brush:php;toolbar:false">
1、指定miss路由 

支持以下两种写法: 匿名函数、 字符串, 例如: Home\RouteController@miss

Route::miss(function() {
	return '404 Not Found';
});




2、基本路由

支持的HTTP动作: get、post、put、patch、delete, 你可以指定路由到匿名函数 或 控制器动作.

为了保护网站不受到 跨网站请求伪造 攻击, post、put、patch、delete 请求需要验证CSRF token.

请参考路由 Route::match(['get', 'post'], 'csrf', 'Home\RouteController@csrf');

Route::get('/', function() {
    return 'GET: It works.';
});

Route::get('controller/action', 'Home\RouteController@action');




3、响应多个HTTP动作的路由

Route::match(['get', 'post'], 'match', function () {
    return 'MATCH: hello world';
});




4、响应所有的HTTP动作的路由

Route::any('any', function () {
    return 'ANY: hello world';
});




5、基础路由参数

路由参数命名规则: 字母、数字、下划线, 路由参数名称 需要和 匿名函数的参数名称 保持一致.

Route::get('posts/{postId}/comments/{commentId}', function ($postId, $commentId) {
	return 'GET '.$postId.' COMMENTS '.$commentId;
});




6、可选的路由参数

有时候你需要指定可选的路由参数，可以在参数名称后面加上 ? 来实现

注意：可选参数只能放在路由地址最后

Route::get('member/{name?}', function ($name = 'John') {
    return $name;
});




7、正则表达式限制参数

Route::get('user/{id}', function ($id) {

})->where('id', '[0-9]+');


Route::get('user/{id}/{name}', function ($id, $name) {

})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);


如果你想要全局性的正则表达式限制, 可以在 Onion\Providers\RouteServiceProvider
的 boot 方法里定义这些模式.

class RouteServiceProvider extends ServiceProvider {

    public function boot(Router $router) {
        $router->pattern('id', '[0-9]+');
    }
}




8、命名路由

命名路由让你可以方便的为特定路由生成 URL 或进行重定向, 支持以下两种方式:


方式一: 在路由定义后方链式调用 name 方法: 

Route::get('profile/{id}', function($id) {
    
    return route('profile', ['id' => $id]);
    
})->name('profile');


方式二: 使用 name 数组键指定 名称路由:

Route::get('profile/{id}', ['name' => 'profile', function ($id) {
 
    return route('profile', ['id' => $id]);
 
}]);


一旦你在指定的路由中分配了名称，则可通过 route 函数来使用路由名称生成 URL:

route('路由名称', ['路由参数数组']), 例如: route('profile', ['id' => 1]);




9、重定向

一旦你在指定的路由中分配了名称，则可通过 redirect 函数来重定向: 

redirect('路由名称', ['路由参数数组']), 例如: redirect('profile', ['id' => 1]);

Route::get('redirect', function() {

	return redirect('profile', ['id' => 1]);  //return不能省略 
});




10、路由中间件

middleware 数组键指定 路由中间件, 指定多个中间件可使用数组参数

例子中: auth 为 中间件名称, config/middleware.php文件route数组中的 键名

例子中: John 为 中间件参数, 使用冒号 : 区隔中间件名称与参数，多个参数可使用逗号分隔

Route::get('auth', ['middleware' => 'auth:John', 'uses' => 'Home\RouteController@middleware']);




11、指定命名空间

你可以使用 namespace 参数来指定相同的 PHP 命名空间给控制器群组. 默认根命名空间为:

app\Http\Controllers, 你可以指定根命名空间之后的部分命名空间, 开头结尾不需要加'\'

Route::group(['namespace' => 'Home'], function() {
	Route::get('namespace', 'RouteController@namespace');
});




12、子域名路由

子域名可以像路由 URL 分配路由参数，让你在路由或控制器中获取子域名参数

Route::group(['domain' => '{acccount}.onion.com'], function() {
	Route::get('domain', function($account) {
        var_dump($account);
    });
});




13、路由前缀

通过路由分组属性中的 prefix, 在路由群组内为每个路由指定的 URL 加上前缀

你也可以使用 prefix 参数去指定路由群组中共用的参数

Route::group(['prefix' => 'admin'], function() {

	Route::get('users', function() {
		return 'url: admin/users';
	});
});




14、路由模型绑定

例如: 我们绑定 {_user} 参数至 app\Models\User 模型. 假如请求地址为 model/1 时,

      则会向方法注入 ID为1 的记录 (数组类型).

Route::model('_user', app\Models\User::class);

Route::get('model/{_user}', function($_user) {
    return $_user;
});


你可以在 Onion\Providers\RouteServiceProvider::boot 方法中定义全局性的模型绑定

class RouteServiceProvider extends ServiceProvider {

    public function boot(Router $router) {
        $router->model('_user', \app\Models\User::class);
    }
}




15、路由模型绑定 (使用 Route::bind 方法自定义自己的解析逻辑)

Route::bind('_user_customize', function($value) {

	$user = new app\Models\User;

	return $user->where('id', $value)->field('name')->find();
});

Route::get('model/customize/{_user_customize}', function($_user_customize) {
	return $_user_customize;
});




16、CSRF 保护

程序会为每个用户的 Session 自动生成一个 CSRF token , 用于保护应用程序不受跨网站请求

伪造攻击. 非GET请求时, 需要传递 _token 参数, 只需要在表单中添加 _token 字段.


<input type="hidden" name="_token" value="@{{ $_token }}">


VerifyCsrfToken 中间件会自动检测 _token 参数合法, 有时候你可能会希望一组 URL 不要

被 CSRF 保护, 可以在该中间件中增加 $except 属性来排除 URL.




17、请求方法伪造

HTML 表单没有支持 PUT、PATCH 或 DELETE 动作

程序设定, HTML 表单中 _method 字段送出的值将被作为 HTTP 的请求方法使用

Route::any('method', 'Home\RouteController@method');




18、路由分组演示

以下代码定义一个路由：
路由地址:         home/group
路由名称:         home:group
路由请求方法:     GET
路由动作:         app\Http\Controllers\Home\RouteController@group
路由域名限制:     home.onion.com
路由协议限制:     http
路由中间件:       auth

Route::group(['namespace' => 'Home', 'prefix' => 'home', 'name' => 'home:', 
    'domain' => 'home.onion.com', 'middleware' => ['auth'], 'http'], function() {
    
    Route::get('/group', ['uses' => 'RouteController@group', 'name' => 'group']);
});




19、路由分组公共属性 (Route::group函数第一个参数) 支持以下设置:

namespace   命名空间, 例如:"Home", 开头结尾不需要加'\'

prefix      路由地址前缀, 例如:"admin", 开头结尾不需要加'/'

name        路由名称, 例如:"admin:", 

domain      域名限制, 例如:"admin.domain.com"

middleware  路由中间件, 例如:"auth", config/middleware.php文件route数组中的【键名】

http        路由协议限定, 例如:"http", 限制只能使用http协议访问

https       路由协议限定, 例如:"https", 限制只能使用https协议访问




20、路由属性 (Route::get等函数第二个参数) 支持以下设置:

name        路由名称, 例如:"edit", 会在该名称前, 连接分组属性的路由名称

domain      域名限制, 例如:"admin.domain.com", 会覆盖分组属性的域名限制

middleware  路由中间件, 例如:"auth", 会合并分组属性的路由中间件

http        路由协议限定, 例如:"http", 会覆盖分组属性的路由协议限定

https       路由协议限定, 例如:"https", 会覆盖分组属性的路由协议限定

uses        路由操作, 支持: 匿名函数、字符串 (类似Controller@action)
</pre>
@endsection