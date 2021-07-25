<?php
namespace app\Subscribers;

/**
 * 演示: 事件观察者 (监听多个事件)
 */
class Demo {

	/**
	 * 事件监听: insert
	 * @param string $SQL 			执行的SQL语句
	 * @param array  $PDOValues		预处理SQL语句绑定的参数
	 * @param mixed  $result        执行结果
	 */
	public function onInsert($SQL, $PDOValues, $result) {
		$this->show($SQL, $PDOValues, $result);
	}

	/**
	 * 事件监听: delete
	 * @param string $SQL 			执行的SQL语句
	 * @param array  $PDOValues		预处理SQL语句绑定的参数
	 * @param mixed  $result        执行结果
	 */
	public function onDelete($SQL, $PDOValues, $result) {
		$this->show($SQL, $PDOValues, $result);
	}

	/**
	 * 事件监听: update
	 * @param string $SQL 			执行的SQL语句
	 * @param array  $PDOValues		预处理SQL语句绑定的参数
	 * @param mixed  $result        执行结果
	 */
	public function onUpdate($SQL, $PDOValues, $result) {
		$this->show($SQL, $PDOValues, $result);
	}

	/**
	 * 事件监听: select
	 * @param string $SQL 			执行的SQL语句
	 * @param array  $PDOValues		预处理SQL语句绑定的参数
	 * @param mixed  $result        执行结果
	 */
	public function onSelect($SQL, $PDOValues, $result) {
		$this->show($SQL, $PDOValues, $result);
	}

	/**
	 * 展示信息
	 * @param string $SQL 			执行的SQL语句
	 * @param array  $PDOValues		预处理SQL语句绑定的参数
	 * @param mixed  $result        执行结果
	 */
	protected function show($SQL, $PDOValues, $result) {
		var_dump($SQL);
		var_dump($PDOValues);
		var_dump($result);
		echo '<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=1)" color=#987cb9 SIZE=3>';
	}
}