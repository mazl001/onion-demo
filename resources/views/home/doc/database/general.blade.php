@extends('home.public')

@section('title', '数据库文档: 增删改查')

@section('content')
<pre class="brush:php;toolbar:false">
1、 添加

 $user = new User;

 //添加单行记录 (返回新增的ID)
 $data = [
    'name'  =>  '小明'
 ];
 $lastInsertId = $user->insert($data);


 //批量添加多行记录 (返回新增的行数)
 $data = [
    ['name' => '小红'],
    ['name' => '小王']
 ];
 $user->insert($data);




2、不存在时添加，存在时更新 (使用mysql duplicate语法)

$user = new User;

$insertData = [
    'id'   => 1,
    'name' => '小王'
];

$updateData = [
    'name' => '老王'
];

$user->duplicate($updateData)->insert($insertData);




3、删除

$map = [
    'name'  => '小王'
];
$user = new User;
$rowCount = $user->where($map)->delete();

//如果没有设置条件，不会进行删除操作, 并返回false
$rowCount = $user->delete();

//强制删除全表, 需传入参数: true
$rowCount = $user->delete(true);




4、更新

$map = [
    'name' => '小明'
];

$data = [
    'name' => '明哥' 
];

$user = new User;
$rowCount = $user->where($map)->update($data);




5、查找多行记录

$user = new User;
$user->field('id, name')->limit(2)->order('id')->select();




6、查找单行记录 (查找多个字段时，返回数组; 查找单个字段时，返回字符串)

$user = new User;

$response = $user->field('id, name')->where('id', 1)->find();
var_dump(is_array($response));

$response = $user->field('name')->where('id', 1)->find();
var_dump(is_string($response));




7、分页

paginate 方法可以指定每页显示的记录数. 该方法返回数据记录、 简单的分页html (不带css样式).

你可以修改 Onion\Database\drivers\PDOConnection 的 paginate 方法自定义 分页html.

$user = new User;

$result = $user->order('id', 'desc')->paginate(10);

数据记录:       $result['list'];

简单的分页html: $result['page'];




8、列出不同（distinct）的值, 该方法只是简单的在SQL语句中添加distinct关键词

$user = new User;

$user->distinct(true)->field('name')->select();

$user->field('distinct(name)')->select();




9、分组
 
$user = new User;

$user->field('count(id), name')->group('name')->select();

$user->field(['count(id)' => 'total', 'name'])->group('name')->select();




10、分组筛选

$user = new User;

//having只接受字符串参数
$user->field(['count(id)' => 'total', 'name'])
                 ->group('name')->having('total > 1')->select();




11、排序

$user = new User;

//单字段 默认降序
$user->field('id, name')->order('id')->select();

//单字段 手动升序
$user->field(['id', 'name'])->order('id', 'asc')->select();

//多个字段进行排序
$user->field('id, name')->order(['name' => 'desc', 'id' => 'asc'])->select();




12、行数约束

$user = new User;

//指定偏移记录数、返回记录数
$user->field('id, name')->limit(1, 2)->select();

//指定返回记录数
$user->field('id, name')->limit(2)->select();




13、统计

$user = new User;

//计算总数
$user->field('sum(id)')->find();

//去重 计算行数
$field = ['count(distinct name)' => 'total'];
$user->field($field)->find();




14、分区

$user = new User;

//字符串参数：
$user->partition('p1,p2')->field('*')->select();

//数组参数：
$user->partition(['p1', 'p2', 'p3'])->field('*')->select();




15、额外的关键字, 只是简单的将extra关键词添加到SQL语句中

$user = new User;

$user->extra('SQL_NO_CACHE')->select();




16、查询加锁, 参考 https://dev.mysql.com/doc/refman/5.6/en/innodb-locking-reads.html

查询加锁是在事务内起作用的，它们能够保证当前session事务所锁定的行不会被其他session所修改.


FOR UPDATE: 可以为数据库中的行上一个排它锁, 当一个事务的操作未完成时候, 其他事务可以读取

            但是不能写入或更新.


LOCK IN SHARE MODE: 共享锁允许其他事务加共享锁读取，但是，不允许其他事务去做修改，或者加

                    排它锁.


DB::transaction(function(){
 
    $user = new User;

    $user->lock('FOR UPDATE')->select();

    $user->lock('LOCK IN SHARE MODE')->select();
});
</pre>
@endsection