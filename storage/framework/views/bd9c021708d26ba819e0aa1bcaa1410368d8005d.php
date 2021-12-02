<?php $__env->startSection('title', '开发文档: 下载安装'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
运行环境要求

PHP >= 7.0




安装Composer

参考 https://docs.phpcomposer.com/00-intro.html#Downloading-the-Composer-Executable




创建项目

切换到你的WEB根目录, 运行命令 composer create-project mazl/onion




测试运行

访问项目 public 目录, 例如: http://localhost/onion/public/index.php, 输出 hello world.




源码下载:

https://github.com/mazl001/onion      (不含演示代码)

https://github.com/mazl001/onion-demo (包含演示代码)




隐藏 index.php:

项目入口文件为 public/index.php, 可以通过配置让 URL 不需要 index.php 即可访问:

1、apache 服务器, 需要开启 mod_rewrite 模块, 在 public 目录下创建 .htaccess 文件

<IfModule mod_rewrite.c>
  Options +FollowSymlinks -Multiviews
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>


2、nginx 服务器, 可以在网站设置中增加以下设置来开启「优雅链接」

location / {
    try_files $uri $uri/ /index.php?$query_string;
}
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>