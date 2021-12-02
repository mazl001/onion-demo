<?php
/*
|--------------------------------------------------------------------------
| 路由: 开发文档
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'Home', 'prefix' => 'doc', 'name' => 'doc:'], function() {

	//路由文档
	Route::get('router', 'DocController@router')->name('router');

	//中间件文档
	Route::get('middleware', 'DocController@middleware')->name('middleware');

	//请求文档
	Route::get('request', 'DocController@request')->name('request');

	//响应文档
	Route::get('response', 'DocController@response')->name('response');

	//Cookie文档
	Route::get('cookie', 'DocController@cookie')->name('cookie');

	//Session文档
	Route::get('session', 'DocController@session')->name('session');

	//Redis文档
	Route::get('redis', 'DocController@redis')->name('redis');

	//事件文档
	Route::get('event', 'DocController@event')->name('event');

	//视图文档
	Route::get('view', 'DocController@view')->name('view');
	
	//视图文档
	Route::get('encrypter', 'DocController@encrypter')->name('encrypter');

	//数据库文档
	Route::group(['prefix' => 'database', 'name' => 'database:'], function() {

		//模型
		Route::get('model', 'DocController@databaseModel')->name('model');

		//表名、字段
		Route::get('tf', 'DocController@databaseTableAndField')->name('tf');

		//增删改查
		Route::get('general', 'DocController@databaseGeneral')->name('general');

		//构造查询条件
		Route::get('query', 'DocController@databaseQuery')->name('query');

		//多表连接
		Route::get('join', 'DocController@databaseJoin')->name('join');

		//数据库调试
		Route::get('debug', 'DocController@databaseDebug')->name('debug');

		//监听数据库操作
		Route::get('event', 'DocController@databaseEvent')->name('event');
		
		//事务操作
		Route::get('transacation', 'DocController@databaseTransacation')->name('transacation');

		//单台数据库
		Route::get('singleServer', 'DocController@databaseSingleServer')->name('singleServer');

		//一主库多备库
		Route::get('rwSeparation', 'DocController@databaseRwSeparation')->name('rwSeparation');
		
		//数据分片: 垂直切分
		Route::get('verticalSharding', 'DocController@databaseVerticalSharding')->name('verticalSharding');
		
		//数据分片: 水平切分
		Route::get('horizontalSharding', 'DocController@databaseHorizontalSharding')->name('horizontalSharding');
	});


	//安装文档
	Route::group(['prefix' => 'installation', 'name' => 'installation:'], function() {

		//下载安装
		Route::get('quickStart', 'DocController@quickStart')->name('quickStart');

		//基本配置
		Route::get('configuration', 'DocController@configuration')->name('configuration');

		//Redis配置
		Route::get('redisConfiguration', 'DocController@redisConfiguration')->name('redisConfiguration');

		//Session配置
		Route::get('sessionConfiguration', 'DocController@sessionConfiguration')->name('sessionConfiguration');

		//调试信息
		Route::get('debug', 'DocController@debug')->name('debug');

		//命令行模式
		Route::get('cli', 'DocController@cli')->name('cli');
	});


	//框架介绍
	Route::get('about', 'DocController@about')->name('about');
});