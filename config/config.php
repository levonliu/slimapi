<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 上午10:15
 */

return [
    'app_debug' => 'true',

    //数据库配置
    'database' => [
        'driver'    => 'mysql',
        'host'      => '192.168.128.144',
        'database'  => 'saas',
        'username'  => 'root',
        'password'  => '12345abc',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => 's_',
    ],

    // 跨域配置
    'cors' => [
        'Origin'  => ['http://localhost:8080', 'http://127.0.0.1:9001', 'http://localhost:8081'],
        'Methods' => 'GET,POST,PUT,DELETE,HEAD,PATCH,OPTIONS',
        'Headers' => 'Origin,X-Requested-With,Content-Type,Accept,Authorization'
    ],

    // 身份认证
    'jwt' => [
        'key'   => 'QWERTYUJHGFSDSDFJRERTY',
        'hash'  => 'HS256',
    ],
];