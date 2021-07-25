<?php
namespace app\Observers;

class Demo {
	public function handle() {
		var_dump('事件测试: '.__METHOD__.' is called');
	}
}