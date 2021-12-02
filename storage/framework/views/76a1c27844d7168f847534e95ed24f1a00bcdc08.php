<?php $__env->startSection('title', '开发文档: Redis'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
Redis 服务使用 Predis 操作库实现. Predis 是 Redis 官方首推的 PHP 客户端开发包. 
 
参考文档 https://packagist.org/packages/predis/predis




1、Redis基本操作

使用方式 Redis::命令名称('命令参数'), 例如:

Redis::set('name', 'caesar');

Redis::get('name');

Redis::hset('hashTable', 'name', 'napoleon', 'age', 18);

Redis::hget('hashTable', 'name');




2、Redis事务操作 (只能在单服务器模式下使用)

$response = Redis::transaction(function ($transaction) {

    $transaction->set('foo', 'bar');

    $transaction->get('foo');

});




3、Redis管道技术, 用于批量执行多条命令

$response = Redis::pipeline(function($pipe) {

	$pipe->set('name', 'da vinci');

	$pipe->get('name');

	$pipe->set('age', 12);

	$pipe->get('age');
});
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>