<?php $__env->startSection('title', '数据库文档: 一主库多从库'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
数据库配置文件放置在 config/database.php. 在这个配置文件内你可以定义所有的数据库

连接，以及指定默认使用哪个连接. 


"一主多备结构" 可以实现数据库读写分离. 在有少量写和大量读时, 这种结构是非常有用的. 可

以把读分摊到备库上. 配置和单台服务器差不多简单, 只需在 servers 数组中增加备用服务器

连接信息. 


"第一台服务器" 将会被设置为主服务器, 其他的都是备用服务器. 写操作(insert、 delete、 

update、事务) 将会连接主服务器, 读操作 (select) 将会随机连接备用服务器, 同一个HTTP

请求会一直连接同一台备用服务器.

                             _________
                            |         |
                            |         |
                            |127.0.0.1|  主库, 只处理写操作
                            |         |
                            |_________|
                                  
                  _______________|_______________
                 |               |               |
                 |               |               |
             _________       _________       _________
            |         |     |         |     |         |
            |         |     |         |     |         |
            |127.0.0.2|     |127.0.0.3|     |127.0.0.4| 备库, 随机连接, 只处理读操作
            |         |     |         |     |         |
            |_________|     |_________|     |_________|

               备库             备库             备库


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

            //服务器连接参数, 各台服务器的连接参数 (hosts除外) 相同时, 只需填写一个
            'servers'   => [
                //服务器地址 
                'host'       => ['127.0.0.1', '127.0.0.2', '127.0.0.3', '127.0.0.4'],
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

        //可以继续添加不同数据库连接...
    ]
];




使用方法和单服务器一样, 你可以在 Model 类里指明使用的连接名称, 例如下面的 User 模型将会

使用 admin 数据库连接. 默认连接名称为 数据库配置 default 键的值.


class User extends \Onion\Database\Model {
    /**
     * 方式一: 通过属性设置连接名称 (配置文件 config/databasa.php 里connections数组的键名)
     */    
    protected $connection = 'admin';

    /**
     * 方式二: 通过方法设置连接名称, 可用于分库
     */
    public function setConnection(...$args) {
        $this->connection = $args[0];
        return $this;
    } 
}




Model 类的 master(true|false) 方法可以强制连接主备库. 例如：对 "主库" 进行更新操作后，

马上进行查询，数据可能未同步到 "备库" 时，可使用该方法读取到 "主库" 上的最新数据.


$user = new User;

//更新操作, 将会连接主库
$user->where('id', 1)->update(['name' => 'stephen']);

//读操作, 默认连接从库, 这里可能读取到未更新的 "旧数据"
$user->where('id', 1)->select();

//强制连接主库, 读取最新数据
$user->master(true)->where('id', 1)->select();
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>