@extends('home.public')

@section('title', '数据库文档: 监听数据库操作')

@section('content')
<pre class="brush:php;toolbar:false">
数据库在进行增删改查操作时, 会自动触发事件, 你可以注册一个事件监听器来执行监听,

监听后可以获得执行的SQL语句、PDO绑定的值、执行结果.


//注册监听器
Event::attach('select', function($SQL, $PDOValues, $result) {
    var_dump(func_get_args());
});

$user = new User;

$user->where('id', 1)->select();




默认的事件名称: 增 -> insert, 删 -> delete, 改 -> update, 查 -> select.

你可以通过模型的 event 方法自定义事件名称.


//注册监听器
Event::attach('user_login', function($SQL, $PDOValues, $result) {
    var_dump(func_get_args());
});

$user = new User;

$user->where('id', 1)->event('user_login')->update(['login_time' => time()]);




如果你需要同时监听多个数据库操作, 请参考以下步骤:

1、 创建观察者, 按需实现 onInsert、 onDelete、 onUpdate、 onSelect 等方法.

演示文件: app\Subscribers\Demo

namespace app\Subscribers;

class Demo {

    /**
     * 事件监听: insert
     * @param string $SQL           执行的SQL语句
     * @param array  $PDOValues     预处理SQL语句绑定的参数
     * @param mixed  $result        执行结果
     */
    public function onInsert($SQL, $PDOValues, $result) {
        echo __METHOD__.' is called, SQL : '.$SQL.'<br>';
    }

    public function onDelete($SQL, $PDOValues, $result) {
        echo __METHOD__.' is called, SQL : '.$SQL.'<br>';
    }

    public function onUpdate($SQL, $PDOValues, $result) {
        echo __METHOD__.' is called, SQL : '.$SQL.'<br>';
    }

    public function onSelect($SQL, $PDOValues, $result) {
        echo __METHOD__.' is called, SQL : '.$SQL.'<br>';
    }
}




2、 注册观察者

定义完观察者类后，接下来我们需要将该观察者注册到应用中，只需将该类追加到配置

文件 config/event.php 的 subscribers 数组中即可.

return [

    'subscribers' => [
        //其他观察者

        \app\Subscribers\Demo::class
    ],
];

你也可以使用 Event::subscribe(\app\Subscribers\Demo::class)动态注册观察者;




3、为了测试该服务提供者, 我们创建一个模型User、 控制器DemoController

演示文件: Onion\Database\Model\User;
演示文件: app\Http\Controllers\Home\DemoController;

class User extends Model {

}

class DemoController {
    
    public function monitor() {
        $user = new User;

        $user->select();
    }
}




4、定义路由, 访问控制器后, 输出

app\Subscribers\Demo::onSelect is called, SQL : SELECT * FROM `onion_user`
</pre>
@endsection