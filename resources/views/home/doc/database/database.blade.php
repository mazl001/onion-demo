@extends('home.public')

@section('title', '开发文档: 数据库基本操作')

@section('content')
<pre class="brush:php;toolbar:false">
namespace app\Http\Controllers\Home;

use Exception;
use Onion\Database\Model;
use app\Models\User;


/**
 * 控制器：数据库操作演示
 */
class DatabaseController {

	/**
	 * 构造函数
	 */
	public function __construct() {
		//监听数据库增删改查事件, 可以获得数据库执行的SQL语句、PDO绑定值、SQL执行结果.
		Event::subscribe(\app\Subscribers\Database::class);
	}



	/**
	 * 演示: 获取上次执行的SQL语句
	 */
	public function getLastSQL() {


		'new User 效果类似于 DB::table("user"), 执行的都是以下(伪)代码:
		(new \Onion\Database\DatabaseManager(...))->getConnection(...)->table("user")';


		$user = new User;

		$user->where('id', 1)->select();

		//获取SQL语句
		$SQL = $user->getLastSQL();

		//参数为 false 时, 获取PDO prepare方法真实调用的SQL语句
		$SQL = $user->getLastSQL(false);



		DB::table('user')->where('id', 1)->select();

		$SQL = DB::getLastSQL();

		$SQL = DB::getLastSQL(false);

		$SQL = DB::table('user')->getLastSQL();
	}



	/**
	 * 演示: 构造SQL语句
	 */
	public function buildSQL() {
		$user = new User;

		$map = [
			'id'	=>	1,
			'name'	=>	'小明'
		];

		//execute(false): 只构造SQL语句，不真正执行SQL语句
		list($SQL, $PDOValues) = $user->where($map)->execute(false)->select();

		//SQL预处理语句(字符串)
		var_dump($SQL);

		//SQL预处理语句中命名占位符绑定的值(数组)
		var_dump($PDOValues);
	}



	/**
	 * 演示: 指定表名
	 */
	public function table() {
		//User模型默认使用表名 user(小写), 可以通过修改User类的table属性指定表名
		$user = new User;

		//SQL执行时，程序会自动加上表前缀，假设前缀是 Onion_
		$user->select(); 				   			//SELECT * FROM Onion_user
		$user->alias('user')->select();    			//SELECT * FROM Onion_user AS user
		$user->alias(['user' => 'u'])->select(); 	//SELECT * FROM Onion_user AS u

		//指定表名，字符串参数:
		DB::table('user u, profile as p')->select();

	    //指定表名，数组参数: (设置表别名时，推荐用数组参数)
		DB::table(['user' => 'u', 'profile' => 'p'])->select();

		//指定表名，且不自动加前缀:
		DB::tableWithoutPrefix('Onion_user')->select();
	}



	/**
	 * 演示: 指定字段
	 */
	public function field() {
		$user = new User;


		"field函数使用字符串参数时，程序使用 逗号 来识别多个字段, 使用 空格或as关键词 来识别字段别名.
		一些复杂的字段，将会导致程序识别错误，例如:
		
		field('IFNULL(1,2)') 		会被错误识别成多个字段
		field('COUNT(distinct id)')	会被错误识别成别名为id
		
		因此，此类复杂字段(包含逗号、空格、AS关键字)请使用数组参数:
		field(['IFNULL(1,2)' 		=> 'alias'])
		field(['COUNT(distinct id)' => 'alias'])";


		//字符串参数: 
		$user->field('id, name as username')->select();

		//字符串参数，使用函数时:
		$user->field('count(id) total')->select();

		//数组参数:
		$user->field(['id', 'name' => 'username'])->select();

		//数组参数，使用函数时: 
		$user->field(['count(distinct id)' => 'total'])->select();
	}



	/**
	 * 演示: 添加操作
	 */
	public function insert() {
		$user = new User;

		//添加单行记录
		$data = [
			'name'	=>	'小明'
		];
		$lastInsertId = $user->insert($data);


		//批量添加多行记录
		$data = [
			['name' => '小红'],
			['name' => '小王']
		];
		$user->insert($data);
	}



	/**
	 * 演示: 不存在时添加，存在时更新 (使用mysql duplicate语法)
	 */
	public function duplicate() {

		$insertData = [
			'id'   => 1,
			'name' => '小王'
		];

		$updateData = [
			'name' => '老王'
		];

		$user = new User;
		$user->duplicate($updateData)->insert($insertData);
	}



	/**
	 * 演示：删除
	 */
	public function delete() {
		$map = [
			'name'	=> '小王'
		];
		$user = new User;
		$rowCount = $user->where($map)->delete();

		//没有设置条件时，不进行删除操作, 返回false
		$rowCount = $user->delete();

		//强制删除全表, 传递参数: true
		$rowCount = $user->delete(true);
	}



	/**
	 * 演示：更新
	 */	
	public function update() {
		$map = [
			'name' => '小明'
		];

		$data = [
			'name' => '明哥' 
		];

		$user = new User;
		$rowCount = $user->where($map)->update($data);
	}



	/**
	 * 演示：查找
	 */
	public function select() {
		$user = new User;
		$user->field('id, name')->limit(2)->order('id')->select();
	}



	/**
	 * 演示：查找 (单行记录)
	 * @return array  查找多个字段时，返回数组
	 * @return string 查找单个字段时，返回字符串
	 */
	public function find() {
		$user = new User;

		$response = $user->field('id, name')->where('id', 1)->find();
		var_dump(is_array($response));

		$response = $user->field('name')->where('id', 1)->find();
		var_dump(is_string($response));
	}



	/**
	 * 演示：统计
	 */
	public function aggregate() {
		$user = new User;

		//计算总数
		$user->field('sum(id)')->find();

		//去重 计算行数
		$field = ['count(distinct name)' => 'total'];
		$user->field($field)->find();
	}



	/**
	 * 演示：多表连接
	 */
	public function join() {


		"调用 DB::table 方法后, join方法的表名也会自动加上表前缀，
		 如果不要表前缀，可以使用 DB::tableWithoutPrefix 方法";

		
		DB::table(['user' => 'u'])->join(['profile' => 'p'], 'u.id = p.user_id', 'left')
			                      ->select();

		//使用model类进行表连接, join方法第二个参数为字符串
		$user = new User;
		$user->alias('u')->join(['profile' => 'p'], 'u.id = p.user_id', 'left')
			                          ->select();
	}



	/**
	 * 演示：列出不同（distinct）的值, 该方法只是简单的在SQL中添加distinct关键词
	 */
	public function distinct() {
		$user = new User;

		$user->distinct(true)->field('name')->select();

		$user->field('distinct(name)')->select();
	}



	/**
	 * 演示：分组
	 */
	public function group() {
		$user = new User;

		$user->field('count(id), name')->group('name')->select();

		$user->field(['count(id)' => 'total', 'name'])->group('name')->select();
	}



	/**
	 * 演示：分组筛选
	 */
	public function having() {
		$user = new User;

		//having接受字符串参数
		$user->field(['count(id)' => 'total', 'name'])
		                 ->group('name')->having('total > 1')->select();
	}



	/**
	 * 演示：排序
	 */
	public function order() {
		$user = new User;

		//单字段 默认降序
		$user->field('id, name')->order('id')->select();

		//单字段 手动升序
		$user->field(['id', 'name'])->order('id', 'asc')->select();

		//多个字段进行排序
		$user->field('id, name')->order(['name' => 'desc', 'id' => 'asc'])->select();
	}



	/**
	 * 演示：行数约束
	 */
	public function limit() {
		$user = new User;

		//指定偏移记录数、返回记录数
		$user->field('id, name')->limit(1, 2)->select();

		//指定返回记录数
		$user->field('id, name')->limit(2)->select();
	}



	/**
	 * 演示：分区
	 */
	public function partition() {
		$user = new User;

		//字符串参数：
		$user->partition('p1,p2')->field('*')->select();

		//数组参数：
		$user->partition(['p1', 'p2', 'p3'])->field('*')->select();
	}



	/**
	 * 演示：额外的关键字, 只是简单的将extra关键词添加到SQL语句中
	 */
	public function extra() {
		$user = new User;

		$user->extra('SQL_NO_CACHE')->select();
	}



	/**
	 * 演示：查询加锁
	 * @see https://dev.mysql.com/doc/refman/5.6/en/innodb-locking-reads.html
	 */
	public function lock() {
		$user = new User;


		"查询加锁是在事务内起作用的，所涉及的概念是行锁。它们能够保证当前
		session事务所锁定的行不会被其他session所修改";


		//FOR UPDATE: 可以为数据库中的行上一个排它锁, 当一个事务的操作未完成时候, 
		//其他事务可以读取但是不能写入或更新
		$user->lock('FOR UPDATE')->select();

		//LOCK IN SHARE MODE: 共享锁允许其他事务加共享锁读取，但是，不允许其他
		//事务去做修改，或者加排它锁
		$user->lock('LOCK IN SHARE MODE')->select();
	}



	/**
	 * 演示：主从服务器操作
	 * 需要在config/database.php文件配置主从服务器
	 */
	public function master() {
		$user = new User;

		//insert、update、delete、transaction默认使用主服务器
		$user->where(['name' => '小明'])->update(['name' => '小明-master']);

		//select默认使用从服务器
		$user->where(['name' => '小明-master'])->select();

		//使用master方法强制使用主服务器进行查询
		$user->master(true)->where(['name' => '小明-master'])->select();
	}



	/**
	 * 演示：事务
	 */	
	public function transaction() {


		"DB::transaction方法中，程序会连接主服务器，启动事务, 执行匿名函数";


		DB::transaction(function(){

			$user = new User;

			$id = $user->field('id')->master(true)->where(['name' => '小明'])->find();

			$user->where(['id' => $id])->delete();

			//匿名函数返回false,事务将会自动回滚; 否则. 事务将会自动提交
			return false;
		});
	}



	/**
	 * 演示：切换数据库连接
	 */	
	public function connection() {

		"demo 为 config/database.php 配置文件 connections数组的 【键名】";

		// 使用 demo 数据库配置
		DB::getConnection('demo')->table('user')->select();

		// 使用 默认 数据库配置 (简单写法)
		DB::table('user')->select();

		// 使用 默认 数据库配置 (繁琐写法)
		DB::getConnection()->table('user')->select();
	}
}
</pre>
@endsection