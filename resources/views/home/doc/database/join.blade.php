@extends('home.public')

@section('title', '数据库文档: 多表连接')

@section('content')
<pre class="brush:php;toolbar:false">
1、多表查询

//同一数据库内多表查询
DB::table(['user' => 'u', 'profile'=>'p'])->where('u.id = p.user_id')->select();

//同一主机, 不同数据库多表查询
DB::tableWithoutPrefix(['home.onion_user' => 'u', 'demo.onion_profile' =>'p'])
                    ->where('u.id = p.user_id')->select();




2、多表连接

你可以使用 join("连接的表", "连接条件", "连接类型") 方法进行表连接, 系统会给 "连接的表" 

自动加上表前缀, "连接条件" 只支持字符串参数, "连接类型" 支持 left、right、inner, full.




使用model类进行表连接:

$user = new User;
$user->alias('u')->join(['profile' => 'p'], 'u.id = p.user_id', 'left')
                              ->select();
                                      
执行: SELECT  FROM `onion_user` as `u` left JOIN  `onion_profile` as `p` ON 
      u.id = p.user_id

         


如果不需要自动添加表前缀，可以使用 DB::tableWithoutPrefix 方法:

DB::table(['user' => 'u'])->join(['profile' => 'p'], 'u.id = p.user_id', 'left')
                                  ->select();

DB::tableWithoutPrefix(['onion_user' => 'u'])
    ->join(['onion_profile' => 'p'], 'u.id = p.user_id', 'left')->select();

执行: SELECT  FROM `onion_user` as `u` left JOIN  `onion_profile` as `p` ON 
      u.id = p.user_id
</pre>
@endsection