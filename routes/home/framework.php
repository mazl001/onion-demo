<?php
/*
|--------------------------------------------------------------------------
| 路由: 系统架构介绍
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'Home', 'prefix' => 'framework', 'name' => 'framework:'], function() {

	//容器和依赖注入
	Route::get('container', 'FrameworkController@container')->name('container');

	//服务提供者
	Route::get('service', 'FrameworkController@service')->name('service');

	//中间件
	Route::get('middleware', 'FrameworkController@middleware')->name('middleware');

	//事件
	Route::get('event', 'FrameworkController@event')->name('event');

	//Facade
	Route::get('facade', 'FrameworkController@facade')->name('facade');

	//路由搜素
	Route::get('router', 'FrameworkController@router')->name('router');

	//数据库查询: 逻辑条件处理
	Route::get('logic', 'FrameworkController@logic')->name('database:logic');
});