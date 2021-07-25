<?php
namespace app\Http\Controllers\Home;

use app\Models\User;
use app\Models\Profile;
use app\Models\Soccer;


/**
 * 控制器：数据库构造查询条件演示
 */
class DatabaseQueryController {

	/**
	 * 构造函数
	 */
	public function __construct() {
		//监听数据库增删改查事件, 可以获得数据库执行的SQL语句、PDO绑定值、SQL执行结果.
		Event::subscribe(\app\Subscribers\Demo::class);
	}

	/**
	 * 演示：字符串条件查询
	 */
	public function string() {
$user = new User;

$paginator = $user->order('id', 'desc')->paginate(10);

var_dump($paginator['list']);

var_dump($paginator['page']);

		// $user = new User;

		// $_ = $user->paginate(2);
		
		// //1、单字段条件查询
		// $user->where('id', '!=', 1)->select();

		// //操作符(即第二个参数) 为等号时，可以省略
		// $user->where('id', 1)->select();

		// //2、原生SQL语句查询
		// $warning = "原生SQL语句查询, 程序不会进行PDO值绑定，存在SQL注入风险，不推荐使用";
		// $user->where('id = 1 and name = "小明"')->select();

		// //3、原生SQL语句查询，手动进行PDO值绑定
		// $user->where('id != :id', [':id' => 1])->select();
	}



	/**
	 * 演示：数组条件查询
	 *
	 * 【温馨提示】 以下写法, id = 1将会被覆盖
	 *
	 * $map = [
	 *  	'id' => 1,
	 *		'id' => 2
	 * ];
     * 
     * 相同字段，多个条件可以使用以下写法：
     *
 	 * $map = [
	 *  	['id', 1],
	 *		['id', 2]
	 * ];
	 */
	public function array() {
		$user = new User;

		"条件数组中每一个元素就是一个条件,
		元素可以是键值对 'id' => 1，也可以是一个数组 [id, '=', 1], 等号可以省略";

		$map = [
			'id' => 1,
			['name', '小明']
		];
		$user->where($map)->select();

		$map = [
			'id' => 1,
			['name', '!=', '小明']
		];
		$user->where($map)->select();	
	}



	/**
	 * 演示：AND、OR查询
	 */
	public function logic() {
		$user = new User;

		//1、默认逻辑关系是AND
		$map = [
			'id' 	=> 1,
			'name'	=> '小明'
		];
		$user->where($map)->select();

		//2、使用OR逻辑关系(只需在条件数组中添加'_logic'键值，可以使用_or函数简化)
		$map = [
			['id', 1],
			['id', 2],
			'_logic' => 'or'
		];
		$user->where($map)->select();

		//3、使用 _or、 _and函数构造查询条件
		'_or([$a, $b])                 解析为： $a or $b;
		_and([$a, $b])                 解析为： $a and $b;
		_and([$a, $b, _or([$c, $d])])  解析为： $a and $b and ($c or $d)';

 		$map = [
			'id'	=> 1,
			'name'	=> '小明'
		];
		$user->where(_or($map))->select();
		$user->where(_and($map))->select();

		//4、复杂逻辑关系 
		//以下条件会被解析为： id = 1 and status != 0 and (name = 'stephen' or name = 'peter')
	   	$mapOr = _or([
	   		['name', 'stephen'],
	   		['name', 'peter']
	   	]);

	   	$mapAnd = _and([
	   				'id' => 1,
	   				['status', '!=', 0],
	   				$mapOr
	   			]);

	   	$user->where($mapAnd)->select();
	}



	/**
	 * 演示：in查询
	 */
	public function in() {
		$user = new User;

		//字符串条件查询：
		$user->where('id', 'in', [1, 2, 3])->select();

		//数组条件查询：
		$map = [
			['id', 'in', [1, 2, 3]]
		];
		$user->where($map)->select();
	}



	/**
	 * 演示：like查询
	 */
	public function like() {
		$user = new User;

		//字符串条件查询：
		$user->where('name', 'like', '%小明%')->select();

		//数组条件查询：
		$map = [
			['name', 'like', '%小明%']
		];
		$user->where($map)->select();
	}



	/**
	 * 演示：between查询
	 */
	public function between() {
		$user = new User;

		//字符串条件查询：
		$user->where('id', 'between', [1, 3])->select();

		//数组条件查询：
		$map = [
			['id', 'between', [1, 3]]
		];
		$user->where($map)->select();
	}



	/**
	 * 演示：正则表达式查询
	 */
	public function regexp() {
		$user = new User;

		//字符串条件查询：
		$user->where('id', 'regexp', '[0-9]+')->select();

		//数组条件查询：
		$map = [
			['id', 'regexp', '[0-9]+']
		];
		$user->where($map)->select();
	}



	/**
	 * 演示：null、not null查询
	 */
	public function null() {
		$user = new User;

		//字符串条件查询：
		$user->where('name', 'is', 'null')->select();

		//数组条件查询：
		$map = [
			['name', 'is', 'not null']
		];
		$user->where($map)->select();
	}



	/**
	 * 演示：if查询
	 */
	public function if() {
		$user = new User;

		//IF查询只支持数组形式参数
		$field = [
			'if(status = 1, "正常", "不正常")' => 'status'
		];

		$user->field($field)->where('id', 1)->select();

		//IFNULL查询只支持数组形式参数
		$field = [
			'ifnull(NULL, "内容为空")' => 'empty'
		];

		$user->field($field)->where('id', 1)->select();
	}



	/**
	 * 演示：case查询
	 */
	public function case() {
		$user = new User;


		//CASE查询只支持数组形式参数(CASE语句需要加上括号)
		$case ="(CASE status 
					WHEN 1 THEN '正常' 
					WHEN 0 THEN '不正常' 
				ELSE '不知道' 
				END)";


		$field = [
			$case => 'status'
		];

		$user->field($field)->where('id', 1)->select();
	}



	/**
	 * 演示：exists查询
	 */
	public function exists() {
		$profile = new Profile;

		//profile表名如果含有表前缀，可以使用alias方法设置别名. execute(false) 构造SQL语句
		list($SQL, $PDOValues) = $profile->alias('profile')->where('profile.user_id = user.id')
										 ->execute(false)->select();

		$user = new User;
		$user->alias('user')->where("exists ($SQL)", $PDOValues)->select();


		//更复杂的查询, 可以使用以下形式:
		$PDOValues[':id'] = 1;
		$user->alias('user')->where("id = :id and exists ($SQL)", $PDOValues)
						 ->select();
	}



	/** 
	 * 演示：字段条件、mysql函数条件查询
	 */
	public function native() {
		$profile = new Profile;


		"假设想要查询数据表中 id字段和user_id字段 相同的记录, 如果使用：

		PDOStatement->bindValue(':user_id', 'user_id')

		期望执行的是: where id =  user_id  (表字段)
		实际执行的是: where id = 'user_id' (字符串)

		你可以通过bindExcept方法指定哪些【值】不需要进行PDO值绑定";


		//SELECT * FROM profile WHERE id = user_id (此处user_id为表字段, 非普通字符串)
		$profile->where('id', 'user_id')->bindExcept('user_id')->select();

		//SELECT * FROM user WHERE name = user()   (此处user()为mysql函数, 非普通字符串)
		(new User)->where('name', 'user()')->bindExcept('user()')->select();

		//多个值使用数组参数:
		(new User)->where(['id' => 'concat(id)', 'name' => 'user()'])
							  ->bindExcept(['concat(id)', 'user()'])->select();
	}
}