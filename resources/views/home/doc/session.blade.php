@extends('home.public')

@section('title', '开发文档: Session')

@section('content')
<pre class="brush:php;toolbar:false">
1、读取Session

//获取单个Session值
$name 	  = Session::get('name');

//获取所有Session
$sessions = Session::all();




2、设置Session (不支持为单个session设置时间)

Session::set('name', 'caesar');

Session::set('age', 18);




3、删除Session

//删除单个Session
Session::remove('name');

//删除所有Session
Session::removeAll();
</pre>
@endsection