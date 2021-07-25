@extends('home.public')

@section('title', '数据库文档: 单台服务器')

@section('content')
<pre class="brush:php;toolbar:false">
数据库配置文件放置在 config/database.php. 在这个配置文件内你可以定义所有的

数据库连接，以及指定默认使用哪个连接. 单台服务器 的配置如下:



return [
    //默认数据连接标识
    'default'     => 'home',

    //数据库连接信息
    'connections' => [

        //数据库配置信息
        'home' => [
            //驱动类型 (目前只支持mysql)
            'driver'     => 'mysql',
            
            //表前缀
            'prefix'    =>  'onion_',

            //服务器连接参数
            'servers'   => [
                //服务器地址 
                'host'       => ['127.0.0.1'],
                //服务器端口
                'port'       => [3306],
                //数据库名 
                'database'   => ['home'],
                //用户名
                'username'   => ['your_username'],
                //密码
                'password'   => ['your_password'],
                //数据库编码
                'charset'    => ['utf8']
            ]


            /**
             * 如果要通unix socket连接, 你需要修改配置为:
             *
             * 'servers'   => [
             *   //socket地址
             *   'socket'     => ['your_socket_path']
             *   //数据库名 
             *   'database'   => ['your_database'],
             *   //用户名
             *   'username'   => ['your_username'],
             *   //密码
             *   'password'   => ['your_password'],
             *   //数据库编码
             *   'charset'    => ['utf8']
             * ]
             */
        ],


        //在后面定义多个数据库连接信息...
        'admin' => [
            //驱动类型 (目前只支持mysql)
            'driver'     => 'mysql',
            
            //表前缀
            'prefix'    =>  'onion_',

            //服务器连接参数
            'servers'   => [
                //服务器地址 
                'host'       => ['127.0.0.1'],
                //服务器端口
                'port'       => [3306],
                //数据库名 
                'database'   => ['admin'],
                //用户名
                'username'   => ['your_username'],
                //密码
                'password'   => ['your_password'],
                //数据库编码
                'charset'    => ['utf8']
            ]
        ]
    ]
];




你可以在 Model 类里指明使用的连接名称, 例如下面的 User 模型将会使用 admin 数据库连接.

默认连接名称为 数据库配置 default 键的值: home.


class User extends \Onion\Database\Model {
    
    /**
     * 方式一: 通过属性设置连接名称 (配置文件 config/databasa.php 里connections数组的键名)
     */    
    protected $connection = 'admin';

    /**
     * 方式二: 通过调用setConnection方法设置连接名称, 可用于分库
     */
    public function setConnection(...$args) {
        $this->connection = $args[0];
        return $this;
    } 
}

//使用User类定义的连接名称
(new User)->select();

//动态切换连接
(new User)->setConnection('admin')->select();
</pre>
@endsection