<?php
use app\Models\User;

/**
 * 路由：数据库操作演示
 */
Route::group(['namespace' => 'Home', 'prefix' => 'database'], function() {

	//调试
	Route::group(['prefix' => 'debug'], function() {
		//获取上次执行的SQL语句
		Route::get('getLastSQL', 'DatabaseController@getLastSQL');

		//构造SQL语句
		Route::get('buildSQL', 'DatabaseController@buildSQL');

		//切换数据库连接
		Route::get('connection', 'DatabaseController@connection');
	});

	//条件查询
	Route::group(['prefix' => 'where'], function() {
		//字符串条件查询
		Route::get('string', 'DatabaseQueryController@string');

		//数组条件查询
		Route::get('array', 'DatabaseQueryController@array');

		//AND、OR查询
		Route::get('logic', 'DatabaseQueryController@logic');

		//in查询
		Route::get('in', 'DatabaseQueryController@in');

		//like查询
		Route::get('like', 'DatabaseQueryController@like');

		//between查询
		Route::get('between', 'DatabaseQueryController@between');

		//if查询
		Route::get('if', 'DatabaseQueryController@if');

		//case查询
		Route::get('case', 'DatabaseQueryController@case');

		//regexp查询
		Route::get('regexp', 'DatabaseQueryController@regexp');

		//null/not null查询
		Route::get('null', 'DatabaseQueryController@null');

		//exists查询
		Route::get('exists', 'DatabaseQueryController@exists');

		//字段条件、mysql函数条件查询
		Route::get('native', 'DatabaseQueryController@native');
	});

	//增
	Route::get('insert', 'DatabaseController@insert');

	//增加/更新
	Route::get('duplicate', 'DatabaseController@duplicate');

	//删
	Route::get('delete', 'DatabaseController@delete');
	
	//改
	Route::get('update', 'DatabaseController@update');
	
	//查
	Route::get('select', 'DatabaseController@select');
	
	//查 (单行记录)
	Route::get('find', 'DatabaseController@find');

	//统计
	Route::get('aggregate', 'DatabaseController@aggregate');

	//指定表名
	Route::get('table', 'DatabaseController@table');

	//指定字段
	Route::get('field', 'DatabaseController@field');

	//多表连接
	Route::get('join', 'DatabaseController@join');

	//多表查询
	Route::get('multiTableQuery', 'DatabaseController@multiTableQuery');

	//监听数据库操作
	Route::get('event', 'DatabaseController@event');

	//主从服务器操作
	Route::get('master', 'DatabaseController@master');

	//去重
	Route::get('distinct', 'DatabaseController@distinct');

	//分组
	Route::get('group', 'DatabaseController@group');

	//分组筛选
	Route::get('having', 'DatabaseController@having');

	//排序
	Route::get('order', 'DatabaseController@order');

	//行数约束
	Route::get('limit', 'DatabaseController@limit');

	//事务
	Route::get('transaction', 'DatabaseController@transaction');

	//分区
	Route::get('partition', 'DatabaseController@partition');
	
	//额外的关键字
	Route::get('extra', 'DatabaseController@extra');
	
	//查询加锁
	Route::get('lock', 'DatabaseController@lock');
});