<?php
namespace app\Http\Controllers\Home;

use Onion\Container\Application;
use app\Models\User;
use Onion\Http\Request;
use Onion\Http\Response;


/**
 * 控制器：基本功能演示
 */
class DemoController {

    /**
     * 演示: 获取请求参数 query_string、post parameters
     */
    public function input(Request $request) {

        //获取所有参数
        $input  = $request->input();

        //获取某个参数
        $id     = $request->input('id');

        //获取请求方法
        $method = $request->getMethod();

        //获取Json参数 自动解码为数组
        if ($request->isJson()) {
            $status = $request->input('status');
        }
    }



    /**
     * 演示: 获取路由参数
     */
    public function param($id) {
        return $id;
    }



    /**
     * 演示: 视图 (使用Blade模板引擎)
     */
    public function view() {

        //模板路径: /resource.views/home/homepage.blade.php
        return view('home.homepage', ['name' => 'John']);
    }



    /**
     * 演示: 读取Cookie
     */
    public function getCookie() {

        //获取单个Cookie值
        $name    = Cookie::get('name');

        //获取所有Cookie
        $cookies = Cookie::all();
    }



    /**
     * 演示: 设置Cookie
     */
    public function setCookie() {

        $minutes = 1;

        Cookie::set('name', 'stephen', $minutes);

        Cookie::set('age', 18);
    }


    /**
     * 演示: 删除Cookie
     */
    public function removeCookie() {

        //删除单个Cookie
        Cookie::remove('name');

        //删除所有Cookie
        Cookie::removeAll();
    }



    /**
     * 演示: 自定义响应 (自定义: 响应内容、状态码、http头信息)
     */
    public function response() {

        $header   = ['content-type' => 'text/html; charset=UTF-8'];
        
        $response = new Response('hello world', '200', $header);

        return $response;
    }



    /**
     * 演示: 自定义响应内容, 并设置Cookie
     */
    public function responseWithCookie() {

        $minutes = 1;

        $response = new Response('hello world');

        $response->withCookie('name', 'John', $minutes);

        return $response;
    }


    /**
     * 演示: 读取Session
     */
    public function getSession() {

        //获取单个Session值
        $name     = Session::get('name');

        //获取所有Session
        $sessions = Session::all();
    }



    /**
     * 演示: 设置Session
     */
    public function setSession() {
        
        Session::set('name', 'caesar');

        Session::set('age', 18);
    }


    /**
     * 演示: 删除Session
     */
    public function removeSession() {
        //删除单个Session
        Session::remove('name');

        //删除所有Session
        Session::removeAll();
    }


    /**
     * 演示: Redis操作
     */
    public function redis() {

        "静态方法名: Redis命令, 方法参数: Redis命令的参数";


        Redis::set('name', 'caesar');

        $name = Redis::get('name');

        var_dump($name);
        Redis::hset('hashTable', 'name', 'napoleon', 'age', 18);

        $name = Redis::hget('hashTable', 'name');
    }



    /**
     * 演示: Redis事务
     * 只能在单服务器模式下使用
     */
    public function redisTransaction() {
        
        $response = Redis::transaction(function ($transaction) {
            $transaction->set('foo', 'bar');
            $transaction->get('foo');
        });
    }



    /**
     * 演示: Redis管道 批量执行多条命令
     */
    public function redisPipeline() {

        $response = Redis::pipeline(function($pipe) {

            $pipe->set('name', 'da vinci');

            $pipe->get('name');

            $pipe->set('age', 12);

            $pipe->get('age');
        });
    }


    /**
     * 演示: 依赖注入
     */ 
    public function inject($id, User $user, Request $request, $name = 'John') {

        "如果对参数进行类型约束, 会自动触发依赖注入";

        "需要自动进行依赖注入的参数必须放在: 路由参数之后、可选路由参数之前";

        var_dump($id);

        var_dump(get_class($user));

        var_dump(get_class($request));

        var_dump($name);
    }



    /**
     * 演示: 输出json
     * 如果响应内容是数组，框架将内容自动转化为json格式，并设置HTTP头信息
     */
    public function json() {
        return ['status' => 0, 'message' => 'success'];
    }



    /**
     * 演示: 加解密
     */
    public function encrypter() {
        //加密
        $encrypt = Encrypter::encrypt('hello world');

        //解密
        $decrypt = Encrypter::decrypt($encrypt);
    }



    /**
     * 演示: 监听数据库操作
     */
    public function monitor() {
        $user = new User;

        $user->select();
    }



    /**
     * 演示: 事件机制
     */
    public function event() {
        //添加事件观察者: 匿名函数方式
        Event::attach('myEvent', function($id) {
            var_dump('事件测试: '. __METHOD__.' is called, id: '.$id);
        });

        //添加事件观察者: 类名方式
        Event::attach('myEvent', \app\Observers\Demo::class);

        //触发事件
        //Event::notify('myEvent', [2020]);

        //添加事件观察者, 监听多个事件
        //Event::subscribe(\app\Subscribers\Demo::class);

        Event::notify('select', [1, 2, 3]);
    }


    /**
     * 演示: 服务提供者
     */
    public function service() {
        app('testService')->send('19876543210', '1234');
    }


    /**
     * 列出所有演示文件, 正式使用时可清理
     */
    public function demoFileList() {
        $files = [
            //控制器
            '/app/Http/Controllers/Admin/IndexController.php',
            '/app/Http/Controllers/Home/DatabaseController.php',
            '/app/Http/Controllers/Home/DatabaseQueryController.php',
            '/app/Http/Controllers/Home/DemoController.php',
            '/app/Http/Controllers/Home/DocController.php',
            '/app/Http/Controllers/Home/FrameworkController.php',
            '/app/Http/Controllers/Home/RouteController.php',

            //中间件
            '/app/Http/Middleware/DemoMiddleware.php',

            //模型
            '/app/Models/Profile.php',
            '/app/Models/User.php',

            //事件
            '/app/Observers/Demo.php',
            '/app/Subscribers/Demo.php',

            //服务
            '/app/Services/TestService.php',
            '/app/Providers/TestServiceProvider.php',

            //路由
            '/routes/home/databasa.php',
            '/routes/home/demo.php',
            '/routes/home/doc.php',
            '/routes/home/framework.php',
            '/routes/home/route.php',

            //静态文件目录
            '/resources/view/',
            '/public/static/'
        ];
    }
}