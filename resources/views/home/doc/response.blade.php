@extends('home.public')

@section('title', '开发文档: 响应')

@section('content')
<pre class="brush:php;toolbar:false">
1、自定义响应 (自定义: 响应内容、状态码、http头信息)


class DemoController {

	public function response() {

		$header   = ['content-type' => 'text/html; charset=UTF-8'];
		
		$response = new \Onion\Http\Response('hello world', '200', $header);

		return $response;
	}
}




2、自定义响应内容, 并设置Cookie


class DemoController {

	public function responseWithCookie() {

		$minutes = 1;

		$response = new \Onion\Http\Response('hello world');

		$response->withCookie('name', 'John', $minutes);

		return $response;
	}
}




3、输出json

如果响应内容是数组，框架将内容自动转化为json格式，并设置HTTP头信息


class DemoController {

	public function json() {
		return ['status' => 0, 'message' => 'success'];
	}
}
</pre>
@endsection