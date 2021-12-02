<!DOCTYPE html>
<html>
<head>
<title>@yield('title')</title>
<meta charset="utf-8">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shCore.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushPhp.min.js"></script>

<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/styles/shCoreDefault.min.css">
<link type="text/css" rel="stylesheet" href="/static/css/public.css">

<script type="text/javascript">
     SyntaxHighlighter.all();
</script>

@section('head')
@show
</head>
<body>

<div class="container">
	<h2>Onion - PHP 框架</h2>
	<nav class="nav nav5">
		<ul>
			<li>
				<a href="#">系统架构</a>
				<ul>
					<li><a href="{{ route('framework:container') }}">容器和依赖注入</a></li>
					<li><a href="{{ route('framework:service') }}">服务提供者</a></li>
					<li><a href="{{ route('framework:middleware') }}">中间件</a></li>
					<li><a href="{{ route('framework:event') }}">事件机制</a></li>
					<li><a href="{{ route('framework:facade') }}">Facade</a></li>
					<li><a href="{{ route('framework:router') }}">路由搜索、分组</a></li>
					<li><a href="{{ route('framework:database:logic') }}">数据库复杂逻辑条件解析</a></li>
				</ul>
			</li>
			<li>
				<a href="#">开发文档</a>
				<ul>
					<li><a href="{{ route('doc:router') }}">路由</a></li>
					<li><a href="{{ route('doc:middleware') }}">中间件</a></li>
					<li><a href="{{ route('doc:event') }}">事件</a></li>
					<li><a href="{{ route('doc:request') }}">请求</a></li>
					<li><a href="{{ route('doc:response') }}">响应</a></li>
					<li><a href="{{ route('doc:cookie') }}">Cookie</a></li>
					<li><a href="{{ route('doc:session') }}">Session</a></li>
					<li><a href="{{ route('doc:redis') }}">Redis</a></li>
					<li><a href="{{ route('doc:view') }}">视图</a></li>
					<li><a href="{{ route('doc:encrypter') }}">加密 / 解密</a></li>
				</ul>
			</li>
			<li>
				<a href="#">数据库文档</a>
				<ul>
					<li><a href="{{ route('doc:database:model') }}">模型</a></li>
					<li><a href="{{ route('doc:database:tf') }}">表名 / 字段</a></li>
					<li><a href="{{ route('doc:database:general') }}">增删改查</a></li>
					<li><a href="{{ route('doc:database:query') }}">构造查询条件</a></li>
					<li><a href="{{ route('doc:database:join') }}">多表连接</a></li>
					<li><a href="{{ route('doc:database:debug') }}">构造 / 获取SQL语句</a></li>
					<li><a href="{{ route('doc:database:transacation') }}">事务操作</a></li>
					<li><a href="{{ route('doc:database:event') }}">监听数据库操作</a></li>
				</ul>
			</li>
			<li>
				<a href="#">分布式数据库</a>
				<ul>
					<li><a href="{{ route('doc:database:singleServer') }}">单台服务器</a></li>
					<li><a href="{{ route('doc:database:rwSeparation') }}">一主库多备库</a></li>
					<li><a href="{{ route('doc:database:verticalSharding') }}">数据分片: 垂直切分</a></li>
					<li><a href="{{ route('doc:database:horizontalSharding') }}">数据分片: 水平切分</a></li>
				</ul>
			</li>
			<li>
				<a href="#">安装配置</a>
				<ul>
					<li><a href="{{ route('doc:installation:quickStart') }}">快速开始</a></li>
					<li><a href="{{ route('doc:installation:configuration') }}">基本配置</a></li>
					<li><a href="{{ route('doc:installation:redisConfiguration') }}">Redis配置</a></li>
					<li><a href="{{ route('doc:installation:sessionConfiguration') }}">Session配置</a></li>
					<li><a href="{{ route('doc:installation:debug') }}">调试模式</a></li>
					<li><a href="{{ route('doc:installation:cli') }}">命令行模式</a></li>
				</ul>
			</li>
			<li>
				<a href="#">在线交流</a>
				<ul>
					<li><a href="{{ route('chatroom') }}">在线交流</a></li>
					<li><a href="{{ route('doc:about') }}">关于我们</a></li>
				</ul>
			</li>
		</ul>
	</nav>

	@section('content')
	@show
</div>
</body>
</html>