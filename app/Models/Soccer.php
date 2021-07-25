<?php
namespace app\Models;

use Onion\Database\Model;

class Soccer extends Model {
    protected $connection = 'sports';

    // /**
    //  * 设置连接名称, 可用于分库 (配置文件 config/databasa.php 里connections数组的键名)
    //  */
    // public function setConnection(...$args) {
    //     $this->connection = 'sports_'.$args[0];
    //     return $this;
    // }

    // /**
    //  * 设置表名, 可用于分表
    //  */
    // public function setTable(...$args) {
    //     $this->table = 'soccer_'.$args[0];
    //     return $this;
    // }    
}