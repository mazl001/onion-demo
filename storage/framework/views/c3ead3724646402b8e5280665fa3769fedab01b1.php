<?php $__env->startSection('title', '简介: 中间件'); ?>

<?php $__env->startSection('content'); ?>
<pre class="brush:php;toolbar:false">
HTTP中间件, 顾名思义是指在请求和响应中间，对请求数据进行处理、校验拦截，可以进行逻辑

判断是否允许进入下一个中间件; 常用于权限认证、日志记录等。框架内置了一些中间件, 例

如:维护、加密解密Cookie、发送Cookie、初始化Session、验证CSRF Token.




简单推导一下中间件是怎么实现的:



/**
 * 中间件运行流程, 可以简化为以下代码:
 */
$middleware1 = function () {
	echo "中间件 1 前置操作-->";

	$middleware2 = function () {
		echo "中间件 2 前置操作-->";

		$destination = function () {
			echo "controller@action操作-->";
		};

		$destination();

		echo "中间件 2 后置操作-->";
	};

	$middleware2();

	echo "中间件 1 后置操作<br>";
};


call_user_func($middleware1);

/**
 * 输出:
 * 中间件 1 前置操作-->中间件 2 前置操作-->controller@action操作-->
 * 中间件 2 后置操作-->中间件 1 后置操作
 */




/**
 * 把$middleware1、$middleware2、$destination独立出来, 可以继续简化为以下代码 
 */
$middleware1 = function (Closure $next) {
	echo "中间件 1 前置操作-->";

	$next();

	echo "中间件 1 后置操作-->";
};


$middleware2 = function (Closure $next) {
	echo "中间件 2 前置操作-->";

	$next();

	echo "中间件 2 后置操作<br>";
};


$destination = function () {
	echo "controller@action操作-->";
};




/**
 * 我们会想到用 $middleware1($middleware2($destination())) 的形式去调用它. 显然:
 * 
 * $destination() 				的返回值 必须是一个匿名函数, 以供 $middleware2 调用
 *
 * $middleware2($destination()) 的返回值 必须是一个匿名函数, 以供 $middleware1 调用
 *
 * $middleware1($middleware2($destination())) 的返回值也统一为匿名函数.
 *
 * 因此, 代码需要做一点调整, 让它们的返回值为匿名函数.
 */
$destination = function() {
	return function () {
		echo "controller@action操作-->";
	};
};


$middleware2 = function(Closure $next) {
	return function() use ($next) {
		echo "中间件 2 前置操作-->";

		$next();

		echo "中间件 2 后置操作-->";
	};
};


$middleware1 = function(Closure $next) {
	return function() use ($next) {
		echo "中间件 1 前置操作-->";

		$next();

		echo "中间件 1 后置操作<br>";
	};
};




/**
 * 最后的代码结构类似洋葱, 一层包一层
 */
$onion = $middleware1($middleware2($destination()));
call_user_func($onion);




/**
 * 为了容易看懂, 前面的代码, 手动给出 $middleware1($middleware2($destination())),
 *
 * 实际上, 框架中是使用了 PHP array_reduce 函数构造出这种结构.
 *
 * @see  https://www.php.net/manual/zh/function.array-reduce.php
 */
$middlewares = [$middleware1, $middleware2];

$onion = array_reduce(array_reverse($middlewares), function($carry, $item) {
	return $item($carry);
}, $destination());

call_user_func($onion);





/**
 * 我们可以根据需要, 考虑使用 Pipeline管道模式 对代码进行封装.
 * 
 * 管道模式, 可以将一个实例对象（例如request对象）在多个中间件之间传递，就像流水顺着管道
 * 
 * 依次流淌一般，最终呢，层层传递，你就得到了从头至尾一系列执行操作的 最终 结果。
 */
class Pipeline {

	protected $passable;

	protected $pipes;

	public function send($passable) {
		$this->passable = $passable;
		return $this;
	}


	public function through($pipes) {
		$this->pipes = $pipes;
		return $this;
	}

	public function then($destination) {
		$onion = array_reduce(array_reverse($this->pipes), function($carry, $item) {
			return $item($carry);
		}, $destination());

		return call_user_func($onion);
	}
}


(new Pipeline)->send('为了演示简单, 传递假的request')->through($middlewares)->then($destination);
</pre>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>