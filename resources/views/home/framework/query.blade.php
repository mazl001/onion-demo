@extends('home.public')

@section('title', '简介: 数据库复杂逻辑条件解析')

@section('content')
<pre class="brush:php;toolbar:false">
数据库复杂逻辑条件解析:

数据库查询时, 相同逻辑关系的条件可以用以下数组结构描述, 支持嵌套使用:

$map = [

	'_logic' => 'and/or',

	'数组中每个元素就是一个查询条件'
];




例如: id = 1 and status = 0 可以用以下数组结构描述:

$map = [

	'_logic' => 'and',

	'id'     => 1,

	'status' => 0		
];




例如: id = 1 and status = 0 and (province = '浙江省' or province = '江苏省') 用以下数组结构描述:

$map = [

	'_logic' => 'and',

	'id'     => 1,

	'status' => 0,

	[
		'_logic' => 'or',

		['province', '浙江省'],

		['province', '江苏省']
	],
];


显然, 条件数组有明显的递归结构, 解析时条件数组时, 根据数组中 _logic 键即可拼接条件.
遇到嵌套的逻辑条件时, 只需递归的调用解析函数.




/**
 * 演示一个复杂条件的解析:
 *	
 * age = 20 and ((province = 浙江省 and gender = 男) or (province = 江苏省 and gender = 男))
 */
$conditions = [

	'_logic' => 'and',

	'age' 	 => 20,

	[
		'_logic' => 'or',

		[
			'_logic'	=> 'and',
			'province' 	=> '浙江省',
			'gender'   	=> '男'
		],

		[
			'_logic'	=> 'and',
			'province' 	=> '江苏省',
			'gender'   	=> '男'
		],
	],
];




/**
 * 解析函数
 */
function parseCondition($conditions) {
	$result = [];

	foreach ($conditions as $key => $value) {

		if (is_array($value) and isset($value['_logic'])) {
			$result[] = parseCondition($value);
		} elseif ($key !== '_logic'){
			$result[] = implode(' = ', [$key, $value]);
		}
	}

	return '('.implode(' '.$conditions['_logic'].' ', $result).')';
}




/**
 * 获得解析结果
 */
$conditions = parseCondition($conditions);
var_dump($conditions);
</pre>
@endsection