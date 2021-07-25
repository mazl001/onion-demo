<?php
namespace app\Models;

use Onion\Database\Model;


class News extends \Onion\Database\Model {
     
    /**
     * 方式一: 通过属性设置连接名称 (配置文件 config/databasa.php 里connections数组的键名)
     */   
    protected $connection = 'technology';
 
    /**
     * 方式二: 通过方法设置连接名称, 可用于分库
     */
    public function setConnection(...$args) {
        $this->connection = $args[0];
        return $this;
    } 
}