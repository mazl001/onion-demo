<?php
namespace app\Models;

use Onion\Database\Model;

class User extends Model {
	
	/**
	 * 数据表名称 (系统自动添加前缀) 
	 * 可以通过修改 $table 属性指定表名
	 */
	protected $table = 'user';
}