@extends('home.public')

@section('title', '开发文档: Cookie')

@section('content')
<pre class="brush:php;toolbar:false">
1、读取Cookie

//获取单个Cookie值
$name    = Cookie::get('name');

//获取所有Cookie
$cookies = Cookie::all();




2、设置Cookie

$minutes = 1;

Cookie::set('name', 'stephen', $minutes);

Cookie::set('age', 18);




3、删除Cookie

//删除单个Cookie
Cookie::remove('name');

//删除所有Cookie
Cookie::removeAll();




4、自定义响应内容, 并设置Cookie

class DemoController {

	public function responseWithCookie() {

		$minutes = 1;

		$response = new \Onion\Http\Response('hello world');

		$response->withCookie('name', 'John', $minutes);

		return $response;
	}
}
</pre>
@endsection