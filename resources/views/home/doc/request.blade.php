@extends('home.public')

@section('title', '开发文档: 请求')

@section('content')
<pre class="brush:php;toolbar:false">
1、获取请求参数

路由: Route::match(['get', 'post'], 'input', 'DemoController@input');

链接: input?id=1


class DemoController {

	public function input(Request $request) {

		//获取所有参数
		$input  = $request->input();

		//获取某个参数
		$id 	= $request->input('id');

		//获取请求方法
		$method = $request->getMethod();

		//获取Json参数, 系统会自动解码为数组
		if ($request->isJson()) {
			$status = $request->input('status');
		}
	}
}




2、获取路由参数

路由: Route::get('param/{id}', 'Home\DemoController@param');

链接: param/1


class DemoController {

	public function param($id) {
		return $id;
	}
}




3、依赖注入

如果对参数进行类型约束, 会自动触发依赖注入. 需要自动进行依赖注入的参数必须放在: 

路由参数之后、可选路由参数之前.


路由: Route::get('inject/{id}/{name?}', 'Home\DemoController@inject');

链接: inject/1/stephen


class DemoController {

	public function inject($id, User $user, Request $request, $name = 'John') {
		return $id.'-'.$name;
	}
}
</pre>
@endsection