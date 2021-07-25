@extends('home.public')

@section('title', '数据库文档: 数据分片')

@section('content')
<pre class="brush:php;toolbar:false">
数据库配置文件放置在 config/database.php. 在这个配置文件内你可以定义所有的数据库

连接，以及指定默认使用哪个连接. 


"一主多备结构" 将 "所有" 数据分发到多个服务器上, 然后在备库进行读查询. 因为只有单台

主库, 那么不管有多少备库, 写容量都是无法扩展的. 如果想扩展写容量, 就必须切分数据.


"数据分片" 简单来说, 就是指通过某种特定的条件, 将存放在同一个数据库中的数据分散存放到

多个数据库(主机)上面以达到分散单台设备负载的效果. 切分模式: 垂直拆分、水平拆分.


"水平切分": 以某些字段为依据 (例如id), 按照一定规则 (例如取模), 将一个库 (表)上的数据

拆分到多个库 (表) 上, 以降低单库 (表) 大小, 达到提升性能的目的的方法.


例如: 假设有10亿行记录的用户表，你可以将 id 为 1-1亿 的记录分到第一个库，1亿-2亿 的分到

第二个库, 以此类推... 每个数据库内又可以继续分表, 解决单一表数据量过大的问题, 假设分为10

张表, 每张1千万行记录, user_1 - user10.



return [
    //默认数据连接标识
    'default'     => 'home',

    //数据库连接信息
    'connections' => [

        //1号数据库: 存储 id 为 1-1亿 的记录
        'user_connection_1' => [
            //驱动类型 (目前只支持mysql)
            'driver'     => 'mysql',
            
            //表前缀
            'prefix'    =>  'onion_',

            //服务器连接参数, 各台服务器的连接参数 (hosts除外) 相同时, 只需填写一个
            'servers'   => [
                //服务器地址 
                'host'       => ['1.1.1.0', '1.1.1.1', '1.1.1.2', '1.1.1.3'],
                //服务器端口
                'port'       => [3306],
                //数据库名 
                'database'   => ['user'],
                //用户名
                'username'   => ['your_username'],
                //密码
                'password'   => ['your_password'],
                //数据库编码
                'charset'    => ['utf8']
            ]
        ],


         //2号数据库: 存储 id 为 1亿-2亿 的记录
        'user_connection_2' => [
            //驱动类型 (目前只支持mysql)
            'driver'     => 'mysql',
            
            //表前缀
            'prefix'    =>  'onion_',

            //服务器连接参数 (各台服务器的参数相同时, 只需填写一个)
            'servers'   => [
                //服务器地址 
                'host'       => ['1.1.2.0', '1.1.2.1', '1.1.2.2', '1.1.2.3'],
                //服务器端口
                'port'       => [3306],
                //数据库名 
                'database'   => ['user'],
                //用户名
                'username'   => ['your_username'],
                //密码
                'password'   => ['your_password'],
                //数据库编码
                'charset'    => ['utf8']
            ]
        ],   


         //3号数据库: 存储 id 为 2亿-3亿 的记录
        'user_connection_3' => [
            //驱动类型 (目前只支持mysql)
            'driver'     => 'mysql',
            
            //表前缀
            'prefix'    =>  'onion_',

            //服务器连接参数 (各台服务器的参数相同时, 只需填写一个)
            'servers'   => [
                //服务器地址 
                'host'       => ['1.1.3.0', '1.1.3.1', '1.1.3.2', '1.1.3.3'],
                //服务器端口
                'port'       => [3306],
                //数据库名 
                'database'   => ['user'],
                //用户名
                'username'   => ['your_username'],
                //密码
                'password'   => ['your_password'],
                //数据库编码
                'charset'    => ['utf8']
            ]
        ],

        //以此类推...
    ]
];




如果用户 id 为 201,000,000, 根据前面假设, 这个记录应该存储在 3 号数据库 1 号分表里.

你也可以选择动态分配, 创建数据表存储分片信息, 给定用户 id 就可以获得存储的数据库、表信息.

 _________________________________________
|           |                 |           |
|  user_id  |  connection_id  |  table_id |
|___________|_________________|___________|
|           |                 |           |
| 201000000 |        3        |     1     |
|___________|_________________|___________|



class User extends \Onion\Database\Model {

    /**
     * 设置连接名称, 可用于分库
     */
    public function setConnection(...$args) {
        $this->connection = $args[0];
        return $this;
    }

    /**
     * 设置表名, 可用于分表
     */
    public function setTable(...$args) {
        $this->table = $args[0];
        return $this;
    }
}

//查找用户 id 为 201,000,000 的记录

(new User)->setConnection('user_connection_3')->setTable('user_1')->find();
</pre>
@endsection