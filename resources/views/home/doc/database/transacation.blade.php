@extends('home.public')

@section('title', '数据库文档: 事务操作')

@section('content')
<pre class="brush:php;toolbar:false">
使用 DB::transaction 方法可以进行事务操作. 程序会连接主服务器，启动事务, 执行匿名函

数. 如果匿名函数返回 false 或者 抛出异常时, 事务将会自动回滚; 否则. 事务将会自动提交.



使用默认的数据库连接, 开启事务:

DB::transaction(function(){

    $user = new User;

    $id = $user->field('id')->master(true)->where(['name' => '小明'])->find();

    $user->where(['id' => $id])->delete();

    //匿名函数返回false,事务将会自动回滚; 否则. 事务将会自动提交
    return false;
})




使用其他数据库连接, 开启事务. 必须确保数据库连接和匿名函数内的模型使用的连接一样.

例如: 开启事务时使用 home 连接, 匿名函数内的 User 模型也必须使用 home 连接:

DB::getConnection('home')->transaction(function() {

    $user = new User;

    $id = $user->field('id')->master(true)->where(['id' => '1'])->find();

    $user->where(['id' => $id])->update(['name' => '小明']);

    //匿名函数返回false,事务将会自动回滚; 否则. 事务将会自动提交
    return false;
});
</pre>
@endsection