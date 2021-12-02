<?php $__env->startSection('title', '开发文档: 基本配置'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
在开发阶段，可以修改 .env.json 文件的 app.debug 选项开启调试模式,

开启后, 异常信息 (包含源代码、 文件地址等敏感信息) 将会被输出到浏览器


你可以在 Onion\Bootstrap\HandleExceptions 的 exceptionHandler 

方法中自定义异常处理方式.
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>