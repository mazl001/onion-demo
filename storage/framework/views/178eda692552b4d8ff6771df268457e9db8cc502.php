<?php $__env->startSection('title', '开发文档: 命令行模式'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
开发的时候, 有时需要在命令行下执行控制器的某方法, 例如执行一些定时任务. 命令

行模式下, 除了不会加载 HTTP 中间件、 Cookie, 框架的其他所有功能都能正常使用.




1，首先cd到站点目录public下，创建 PHP 文件 (例如 cli.php), 加入以下代码.

其中 WebsocketController@server 为你要执行的控制器的方法.


if (PHP_SAPI != "cli") exit;

require '../vendor/autoload.php';

use Onion\Container\Application;

$app = new Application(realpath(dirname(__DIR__)));

$app->kernel->cli('WebsocketController@server');




2、执行以下命令

php cli.php
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>