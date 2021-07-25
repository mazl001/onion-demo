<?php
return [
	/**
	 * @see https://www.php.net/manual/zh/function.setcookie.php
	 */

    /*
    |--------------------------------------------------------------------------
    | Cookie 默认过期时间 单位 分钟
    |--------------------------------------------------------------------------
    | 
    | 如果设置成零，Cookie 会在会话结束时过期（也就是关掉浏览器时）
    */
    'lifetime' => 0,



    /*
    |--------------------------------------------------------------------------
    | Cookie 有效的服务器路径
    |--------------------------------------------------------------------------
    |
    | Cookie 有效的服务器路径。 设置成 '/' 时，Cookie 对整个域名 domain 有效。 如果设
    | 置成 '/foo/'， Cookie 仅仅对 domain 中 /foo/ 目录及其子目录有效（比如 /foo/bar/）。 
    |
    */
    'cookie_path' => '/',



    /*
    |--------------------------------------------------------------------------
    | Cookie 的有效域名/子域名
    |--------------------------------------------------------------------------
    |
    | Cookie 的有效域名/子域名。 设置成子域名（例如 'www.example.com'），会使 Cookie
	| 对这个子域名和它的三级域名有效（例如 w2.www.example.com）。 要让 Cookie 
	| 对整个域名有效（包括它的全部子域名），只要设置成域名就可以了
    |
    */
    'cookie_domain' => null,



    /*
    |--------------------------------------------------------------------------
    | Cookie 是否仅仅通过安全的 HTTPS 连接传给客户端
    |--------------------------------------------------------------------------
    |
    | 设置这个 Cookie 是否仅仅通过安全的 HTTPS 连接传给客户端。 设置成 true 时，只有
    | 安全连接存在时才会设置 Cookie。
    |
    */
    'cookie_secure' => false,



    /*
    |--------------------------------------------------------------------------
    | Cookie 是否仅可通过 HTTP 协议访问
    |--------------------------------------------------------------------------
    |
    | 设置成 true，Cookie 仅可通过 HTTP 协议访问。 这意思就是 Cookie 无法通过类似 JavaScript 
    | 这样的脚本语言访问。 要有效减少 XSS 攻击时的身份窃取行为，可建议用此设置（虽然不是所有浏览
    | 器都支持），不过这个说法经常有争议。 true 或 false
    |
    */
    'cookie_httponly' => true,
];