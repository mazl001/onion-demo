<?php $__env->startSection('title', '数据库文档: 单台服务器'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
定义一个模型类很简单, 只需继承 \Onion\Database\Model 类, 默认表名为模型类文件名

(单数、小写), 默认使用的数据库连接为 config/database.php 中 default 键.




class User extends \Onion\Database\Model {
    
    /**
     * 修改这个属性, 可以自定义表名
     */
    protected $table = 'user';

    /**
     * 修改这个属性, 可以自定义连接名称
     */
    protected $connection = 'admin'; 

    /**
     * 动态设置表名, 可用于分表
     */
    public function setTable(...$args) {
        $this->table = $args[0];
        return $this;
    }

    /**
     * 动态设置连接名称, 可用于分库
     */
    public function setConnection(...$args) {
        $this->connection = $args[0];
        return $this;
    }
}




如果你希望用其他数据表名, 只需在模型类中修改 $table 属性, 或调用 setTable 方法.

如果你希望用其他数据库连接, 只需在模型类中修改 $connection 属性, 或调用 setConnection 方法.


$user = new User;

//例如, 分库时动态设置连接名
$user->setConnection('connection_user_5')->select();

//例如, 分表时动态设置表名
$user->setTable('user_5')->select();
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>