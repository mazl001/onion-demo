@extends('home.public')

@section('title', '开发文档: 框架介绍')

@section('content')
<pre class="brush:php;toolbar:false">
Redis 服务使用 Predis 操作库实现. Predis 是 Redis 官方首推的 PHP 客户端开发包. 

参考文档 https://packagist.org/packages/predis/predis



Redis 服务支持单服务器模式、集群模式, 配置文件 config/redis.php



单服务器模式配置:

return [
    //默认连接标识
    'default' => 'single',

    'single'     =>  [
        'options'   => [],

        // 不需设置密码, 请使用:
        'servers' => '127.0.0.1:6379',

        // 如需配置密码, 请使用:
        'servers' => [
           'host'      => '127.0.0.1',
           'port'      => 6379,
           'password'  => 'foobared'
        ]
    ]
];



集群模式配置:

return [
    //默认连接标识
    'default' => 'cluster',

    'cluster'   =>  [
        'options'   => [
            'cluster' => 'redis',
        ],

        'servers'   => [
            [
                'host'      => '127.0.0.1',
                'port'      => 6380,
                'password'  => 'foobared'
            ],

            [
                'host'      => '127.0.0.1',
                'port'      => 6381,
                'password'  => 'foobared'
            ],

            [
                'host'      => '127.0.0.1',
                'port'      => 6382,
                'password'  => 'foobared'
            ]
        ],
    ]
];
</pre>
@endsection