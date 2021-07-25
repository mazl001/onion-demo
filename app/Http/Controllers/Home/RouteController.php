<?php
namespace app\Http\Controllers\Home;

use Onion\Http\Request;


/**
 * 控制器：路由功能演示
 */
class RouteController {


	/**
	 * 演示: 路由分组
	 */
	public function group() {
		return 'method '.__METHOD__.' is called';
	}


	/**
	 * 演示: 指定路由到控制器动作
	 */
	public function action() {
		return 'method '.__METHOD__.' is called';
	}



	/**
	 * 演示: 路由中间件
	 */
	public function middleware(Request $request) {
		echo '路由控制器操作: method '.__METHOD__.' is called<br>';
	}


	/**
	 * 演示: 路由控制器命名空间
	 */
	public function namespace() {
		return 'method '.__METHOD__.' is called';
	}


	/**
	 * 演示: CSRF 保护
	 * VerifyCsrfToken 中间件会自动验证token, 不需要在控制器里手动验证token
	 */
	public function csrf(Request $request) {
		if ($request->getMethod() == 'POST') {
			return '_token: '.$request->input('_token');
		}

		//模板路径 /resource/views/home/token.blade.php
		return view('home.token');		
	}


	/**
	 * 演示: 请求方法伪造
	 */
	public function method(Request $request) {
		if ($request->getMethod() == 'GET') {
			return view('home.method');
		}

		return 'method: '.$request->getMethod();
	}
}