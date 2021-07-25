<?php
namespace app\Http\Controllers\Home;


class DocController {

	/**
	 * 开发文档: 路由
	 */
	 public function router() {
	 	return view('home.doc.router');
	 }


	/**
	 * 开发文档: 中间件
	 */
	 public function middleware() {
	 	return view('home.doc.middleware');
	 }


	/**
	 * 开发文档: 请求
	 */
	 public function request() {
	 	return view('home.doc.request');
	 }


	/**
	 * 开发文档: 响应
	 */
	 public function response() {
	 	return view('home.doc.response');
	 }


	/**
	 * 开发文档: Cookie
	 */
	 public function cookie() {
	 	return view('home.doc.cookie');
	 }


	/**
	 * 开发文档: Session
	 */
	 public function session() {
	 	return view('home.doc.session');
	 }


	/**
	 * 开发文档: Redis
	 */
	 public function redis() {
	 	return view('home.doc.redis');
	 }


	/**
	 * 开发文档: 事件
	 */
	 public function event() {
	 	return view('home.doc.event');
	 }


	/**
	 * 开发文档: 视图
	 */
	 public function view() {
	 	return view('home.doc.view');
	 }


	/**
	 * 开发文档: 加密、解密
	 */
	 public function encrypter() {
	 	return view('home.doc.encrypter');
	 }


	/**
	 * 开发文档: 数据库模型
	 */
	 public function databaseModel() {
	 	return view('home.doc.database.model');
	 }


	/**
	 * 开发文档: 表名、字段
	 */
	 public function databaseTableAndField() {
	 	return view('home.doc.database.tableAndField');
	 }


	/**
	 * 开发文档: 增删改查
	 */
	 public function databaseGeneral() {
	 	return view('home.doc.database.general');
	 }


	/**
	 * 开发文档: 构造查询条件
	 */
	 public function databaseQuery() {
	 	return view('home.doc.database.query');
	 }


	/**
	 * 开发文档: 多表连接
	 */
	 public function databaseJoin() {
	 	return view('home.doc.database.join');
	 }
	 

	/**
	 * 开发文档: 数据库调试
	 */
	 public function databaseDebug() {
	 	return view('home.doc.database.debug');
	 }


	 
	/**
	 * 开发文档: 监听数据库操作
	 */
	 public function databaseEvent() {
	 	return view('home.doc.database.event');
	 }
	 
	/**
	 * 开发文档: 事务操作
	 */
	 public function databaseTransacation() {
	 	return view('home.doc.database.transacation');
	 }


	/**
	 * 开发文档: 单台数据库
	 */
	 public function databaseSingleServer() {
	 	return view('home.doc.database.singleServer');
	 }


	/**
	 * 开发文档: 一主库多从库
	 */
	 public function databaseRwSeparation() {
	 	return view('home.doc.database.rwSeparation');
	 }


	/**
	 * 开发文档: 数据分片: 垂直切分
	 */
	 public function databaseVerticalSharding() {
	 	return view('home.doc.database.verticalSharding');
	 }


	/**
	 * 开发文档: 数据分片: 水平切分
	 */
	 public function databaseHorizontalSharding() {
	 	return view('home.doc.database.horizontalSharding');
	 }


	/**
	 * 开发文档: 快速开始
	 */	 
	public function quickStart() {
	 	return view('home.doc.installation.quickStart');
	}



	/**
	 * 开发文档: 基本配置
	 */	 
	public function configuration() {
	 	return view('home.doc.installation.configuration');
	}



	/**
	 * 开发文档: Redis配置
	 */	 
	public function redisConfiguration() {
	 	return view('home.doc.installation.redis');
	}


	/**
	 * 开发文档: Session配置
	 */	 
	public function sessionConfiguration() {
	 	return view('home.doc.installation.session');
	}



	/**
	 * 开发文档: 调试信息
	 */	 
	public function debug() {
	 	return view('home.doc.installation.debug');
	}


	/**
	 * 开发文档: 框架介绍
	 */	 
	public function about() {
	 	return view('home.doc.about');
	}
}