<?php
namespace app\Http\Controllers\Home;


class FrameworkController {

	/**
	 * 架构介绍: 容器和依赖注入
	 */
	public function container() {
		return view('home.framework.container');
	}


	/**
	 * 架构介绍: 服务提供者
	 */
	public function service() {
		return view('home.framework.service');
	}


	/**
	 * 架构介绍: 中间件
	 */
	public function middleware() {
		return view('home.framework.middleware');
	}


	/**
	 * 架构介绍: 事件机制
	 */
	public function event() {
		return view('home.framework.event');		
	}


	/**
	 * 架构介绍: Facade
	 */
	public function facade() {

		$timezone = Config::get('app.timezone');
		
		return view('home.framework.facade');
	}


	/**
	 * 架构介绍: 路由
	 */
	public function router() {
		return view('home.framework.router');
	}


	/**
	 * 架构介绍: 数据库查询: 逻辑条件处理
	 */
	public function logic() {
		return view('home.framework.query');
	}
}