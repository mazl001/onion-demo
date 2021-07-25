<?php
return [
    /*
    |--------------------------------------------------------------------------
    | 应用程序配置文件
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | 加密密钥
    |--------------------------------------------------------------------------
    | 
    | 建议设置为32位的随机字符串, 用于加密Cookie
    */
	'appKey'			 =>	$_ENV['app']['key'],



    /*
    |--------------------------------------------------------------------------
    | 应用是否在维护
    |--------------------------------------------------------------------------
    */
	'downForMaintenance' => false,
	


    /*
    |--------------------------------------------------------------------------
    | 应用维护提示信息
    |--------------------------------------------------------------------------
    */
	'maintenanceTips' 	 => 'Be right back.',



    /*
    |--------------------------------------------------------------------------
    | 默认时区
    |--------------------------------------------------------------------------
    */
	'timezone' 			 => 'PRC',
];