<?php $__env->startSection('title', '数据库文档: 增删改查'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
1、指定表名 (指定表别名时, as 关键字可以省略)
  
 User模型默认使用表名 user(小写、单数), 程序会自动加上配置的表前缀, 可以通过修改

 User模型的table属性指定表名.


 $user = new User;

 $user->select();                            //SELECT * FROM onion_user
 $user->alias('user')->select();             //SELECT * FROM onion_user AS user
 $user->alias(['user' => 'u'])->select();    //SELECT * FROM onion_user AS u


 //指定表名，使用字符串参数:
 DB::table('user u, profile as p')->select();

 //指定表名，使用数组参数: (设置表别名时，推荐用数组参数)
 DB::table(['user' => 'u', 'profile' => 'p'])->select();

 //指定表名，且不自动加前缀:
 DB::tableWithoutPrefix('onion_user')->select();




2、指定字段 (指定字段别名时, as 关键字可以省略)


 $user = new User;

 //使用字符串参数: 
 $user->field('id,name as username')->select();

 //使用字符串参数，字段包含函数时:
 $user->field('count(id) total')->select();

 //使用数组参数:
 $user->field(['id', 'name' => 'username'])->select();

 //使用数组参数，字段包含函数时:
 $user->field(['count(distinct id)' => 'total'])->select();




3、指定表名注意事项:

 new User 效果类似于 DB::table('user'), 执行的都是以下(伪)代码:
 (new \Onion\Database\DatabaseManager(...))->getConnection(...)->table('user')




4、指定字段注意事项:

 field函数使用字符串参数时，程序使用 "逗号" 来识别多个字段, 使用 "空格或as关键词" 来识别

 字段别名. 一些复杂的字段，将会导致程序识别错误，例如:


 field('IFNULL(1,2)')        会被错误识别成多个字段: "IFNULL(1"、 "2"

 field('COUNT(distinct id)') 会被错误识别成别名为id: "COUNT(distinct"、 "id)"


 因此，此类复杂字段(包含逗号、空格、AS关键字)请使用数组参数:


 field(['IFNULL(1,2)'        => 'alias'])

 field(['COUNT(distinct id)' => 'alias'])
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>