<?php
/*
|--------------------------------------------------------------------------
| 路由: 基本功能演示
|--------------------------------------------------------------------------
*/
Route::group(['namespace' => 'Home'], function() {

	//获取请求参数
	Route::match(['get', 'post'], 'input', 'DemoController@input');

	//获取路由参数
	Route::get('param/{id}', 'DemoController@param');

	//视图
	Route::get('view', 'DemoController@view');


	//自定义响应内容
	Route::get('response', 'DemoController@response');

	//自定义响应内容, 并设置Cookie
	Route::get('response/cookie', 'DemoController@responseWithCookie');


	//读取Cookie
	Route::get('cookie/get', 'DemoController@getCookie');

	//设置Cookie
	Route::get('cookie/set', 'DemoController@setCookie');

	//删除Cookie
	Route::get('cookie/remove', 'DemoController@removeCookie');


	//读取Session
	Route::get('session/get', 'DemoController@getSession');

	//设置Session
	Route::get('session/set', 'DemoController@setSession');

	//删除Session
	Route::get('session/remove', 'DemoController@removeSession');


	//Redis操作
	Route::get('redis', 'DemoController@redis');

	//Redis事务
	Route::get('redis/transaction', 'DemoController@redisTransaction');

	//Redis管道
	Route::get('redis/pipeline', 'DemoController@redisPipeline');


	//输出json
	Route::get('json', 'DemoController@json');

	//依赖注入
	Route::get('inject/{id}/{name?}', 'DemoController@inject');

	//加密、解密
	Route::get('encrypter', 'DemoController@encrypter');

	//服务提供者
	Route::get('service', 'DemoController@service');

	//事件机制
	Route::get('event', 'DemoController@event');
	
	//监听数据库操作
	Route::get('monitor', 'DemoController@monitor');

	//使用到演示文件列表
	Route::get('demoFileList', 'DemoController@demoFileList');
});