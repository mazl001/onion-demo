<?php $__env->startSection('title', '开发文档: 基本配置'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
基本配置


所有配置文件都放置在 config 目录下. 每个选项都有说明，请仔细阅读这些说明，并熟

悉这些选项配置. 在应用里, 你可以通过 Config::get('配置文件名.数组键名') 方法读

取配置信息. 例如: Config::get('app.timezone').



环境变量


应用程序常常需要根据不同的运行环境设置不同的值. 例如，你会希望在本机开发环境上有

与正式环境不同的缓存驱动. 类似这种环境变量，只需通过 .env.json 配置文件就可轻松

完成. 在应用里, 你可以通过 $_ENV 数组获取 .env.json 文件的环境变量.
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>