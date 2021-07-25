<?php
namespace app\Services;

class TestService {

	/**
	 * 模拟发送验证码
	 */
	public function send($phone, $code) {
		echo "$phone, 你的验证码为 $code <br>";
	}
		
}