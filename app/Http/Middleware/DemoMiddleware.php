<?php
namespace app\Http\Middleware;

use Closure;
use Onion\Container\Application;
use Onion\Http\Request;

class DemoMiddleware {

	public function handle(Request $request, Closure $next, $name = 'Stephen') {

		'在 $next($request) 前的代码, 它会在 Controller@action 执行前被执行';

		echo '中间件前置操作: method '.__METHOD__.' is called, name: '.$name.'<br>';


		$response = $next($request);


		'在 $next($request) 后的代码, 它会在 Controller@action 执行后被执行';

		echo '中间件后置操作: method '.__METHOD__.' is called, name: '.$name.'<br>';

		return $response;
	}
}