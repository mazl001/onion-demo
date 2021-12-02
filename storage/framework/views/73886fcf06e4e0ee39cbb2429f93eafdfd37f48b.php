<?php $__env->startSection('title', '开发文档: 框架介绍'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
Session 服务通过 session_set_save_handler 设置用户自定义会话存储方式,

目前支持 "file", "database", "redis" 存储方式, 配置文件: config/session.php


如果session的储存方式为 database, 需创建数据表. (请根据实际情况修改表名前缀)


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(255) NOT NULL,
  `session_expires` int(11) UNSIGNED NOT NULL,
  `session_data` text NOT NULL,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>