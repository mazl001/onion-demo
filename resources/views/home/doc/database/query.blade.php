@extends('home.public')

@section('title', '数据库文档: 构造查询条件')

@section('content')
<pre class="brush:php;toolbar:false">
1、字符串条件查询


单字段条件查询:

(new User)->where('id', '!=', 1)->select();


操作符(即第二个参数) 为等号时，可以省略:

(new User)->where('id', 1)->select();


原生SQL语句查询 (原生SQL语句查询, 程序不会进行PDO值绑定，存在SQL注入风险，不推荐使用):

(new User)->where('id = 1 and name = "小明"')->select();


原生SQL语句查询，手动进行PDO值绑定:

(new User)->where('id != :id and name = :name', [':id' => 1, ':name' => '小明'])->select();




2、数组条件查询
 
条件数组中每一个元素就是一个条件, 元素可以是键值对 'id' => 1，也可以是一个

数组 [id, '=', 1], 中间等号可以省略.


【温馨提示】 

以下写法, id = 1将会被覆盖: $map = [ 'id' => 1, 'id' => 2 ];

相同字段，多个条件可以使用以下写法: $map = [['id', 1], ['id', 2]];


$map = [
    'id' => 1,
    ['name', 'like', '%小明%']
];
(new User)->where($map)->select();

$map = [
    ['id', 1],
    ['id', 2],
    '_logic' => 'or'
];
(new User)->where($map)->select();   




3、AND、OR查询. 默认逻辑关系是AND:

$map = [
    'id'    => 1,
    'name'  => '小明'
];
(new User)->where($map)->select();


使用OR逻辑关系, 只需在条件数组中添加'_logic'键值 (可以使用_or函数简化):

$map = [
    ['id', 1],
    ['id', 2],
    '_logic' => 'or'
];
(new User)->where($map)->select();


你可以使用 _or、 _and函数方便地构造查询条件:

_or([$a, $b])                  解析为： $a or  $b;
_and([$a, $b])                 解析为： $a and $b;
_and([$a, $b, _or([$c, $d])])  解析为： $a and $b and ($c or $d);

$map = [
    'id'    => 1,
    'name'  => '小明'
];
(new User)->where(_or($map))->select();
(new User)->where(_and($map))->select();


演示复杂逻辑关系, 以下条件会被解析为： 

id = 1 and status != 0 and (name = 'stephen' or name = 'peter'):

$mapOr = _or([
    ['name', 'stephen'],
    ['name', 'peter']
]);

$mapAnd = _and([
            'id' => 1,
            ['status', '!=', 0],
            $mapOr
        ]);

(new User)->where($mapAnd)->select();




3、in查询

//字符串条件查询：
(new User)->where('id', 'in', [1, 2, 3])->select();

//数组条件查询：
$map = [
    ['id', 'in', [1, 2, 3]]
];
(new User)->where($map)->select();




4、like查询

//字符串条件查询：
(new User)->where('name', 'like', '%小明%')->select();

//数组条件查询：
$map = [
    ['name', 'like', '%小明%']
];
(new User)->where($map)->select();




5、between查询

//字符串条件查询：
(new User)->where('id', 'between', [1, 3])->select();

//数组条件查询：
$map = [
    ['id', 'between', [1, 3]]
];
(new User)->where($map)->select();




6、正则表达式查询

//字符串条件查询：
(new User)->where('id', 'regexp', '[0-9]+')->select();

//数组条件查询：
$map = [
    ['id', 'regexp', '[0-9]+']
];
(new User)->where($map)->select();




7、null、not null查询

//字符串条件查询：
(new User)->where('name', 'is', 'null')->select();

//数组条件查询：
$map = [
    ['name', 'is', 'not null']
];
(new User)->where($map)->select();




8、if查询

//IF查询只支持数组形式参数
$field = [
    'if(status = 1, "正常", "不正常")' => 'status'
];

(new User)->field($field)->where('id', 1)->select();

//IFNULL查询只支持数组形式参数
$field = [
    'ifnull(NULL, "内容为空")' => 'empty'
];

(new User)->field($field)->where('id', 1)->select();




9、case查询

//CASE查询只支持数组形式参数, 且CASE语句需要加上括号
$case ="(CASE status 
            WHEN 1 THEN '正常' 
            WHEN 0 THEN '不正常' 
        ELSE '不知道' 
        END)";


$field = [
    $case => 'status'
];

(new User)->field($field)->where('id', 1)->select();




10、exists查询

步骤: 使用模型的 execute(false) 方法构造出SQL语句、获取PDO绑定的值, 
     
      再使用 where 方法 (原生SQL语句查询，手动进行PDO值绑定方式) 进行exists查询


$profile = new Profile;

//步骤1、使用execute(false)方法, 构造出子查询的SQL语句
list($SQL, $PDOValues) = $profile->alias('profile')->where('profile.user_id = user.id')
                                 ->execute(false)->select();

//步骤2、使用 where 原生SQL语句查询, 进行 exists查询
$user = new User;
$user->alias('user')->where("exists ($SQL)", $PDOValues)->select();


//更复杂的查询, 可以使用以下形式:
$PDOValues[':id'] = 1;
$user->alias('user')->where("id = :id and exists ($SQL)", $PDOValues)
                 ->select();




11、指定某些值不进行PDO值绑定 (数据表字段、mysql函数作为条件时)


应用场景: 假设想要查询数据表中 id字段和user_id字段 相同的记录, 如果使用：

    PDOStatement->bindValue(':user_id', 'user_id')

期望执行的是: where id =  user_id  (表字段)
实际执行的是: where id = 'user_id' (字符串)

你可以通过bindExcept方法指定哪些 "值" 不需要进行PDO值绑定


$profile = new Profile;

//执行: SELECT * FROM profile WHERE id = user_id (此处user_id为表字段, 非普通字符串)
$profile->where('id', 'user_id')->bindExcept('user_id')->select();

//执行: SELECT * FROM user WHERE name = user()   (此处user()为mysql函数, 非普通字符串)
(new User)->where('name', 'user()')->bindExcept('user()')->select();

//多个值使用数组参数:
(new User)->where(['id' => 'concat(id)', 'name' => 'user()'])
                      ->bindExcept(['concat(id)', 'user()'])->select();
</pre>
@endsection