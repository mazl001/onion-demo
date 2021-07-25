@extends('home.public')

@section('title', '数据库文档: 数据库调试')

@section('content')
<pre class="brush:php;toolbar:false">
1、获取上次执行的SQL语句

$user = new User;

$user->where('id', 1)->select();

//获取上次执行的SQL语句
$SQL = $user->sql();

//参数为false时, 获取PDO prepare方法真实调用的SQL语句, 包含参数占位符
$SQL = $user->sql(false);

//使用 DB::table 方法时, 获取SQL语句
$SQL = DB::table('user')->sql();




2、构造SQL语句

你可以通过模型的 execute(false) 方法, 只构造SQL语句, 不真正执行SQL语句.

返回值: SQL预处理语句(字符串)、 SQL预处理语句中命名占位符绑定的值(数组)


$user = new User;

$map = [
    'id'    =>  1,
    'name'  =>  '小明'
];

list($SQL, $PDOValues) = $user->where($map)->execute(false)->select();

list($SQL, $PDOValues) = $user->execute(false)->insert($map);




3、切换数据库连接

使用 demo 数据库配置 (demo 为 config/database.php 配置文件 connections数组的 "键名"):

DB::getConnection('demo')->table('user')->select();


使用 默认 数据库配置 (繁琐写法):

DB::getConnection()->table('user')->select();


使用 默认 数据库配置 (简单写法):

DB::table('user')->select();
</pre>
@endsection