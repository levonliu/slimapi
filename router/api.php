<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 上午10:30
 */

$app->get('/test', function() {
    echo 'this is a test';
});

//login
$app->post('/login', 'App\Controller\LoginController:login');


$app->group('/', function() {
    //用户
    $this->group('user', function() {
        $this->get('', 'App\Controller\UserController:getUser');
    });

    //菜单
    $this->group('menu', function() {
        $this->get('', 'App\Controller\MenuController:getMenu');
    });

    //客户
    $this->group('customer', function() {
        $this->get('', 'App\Controller\CustomerController:lists');     // 列表
        $this->get('/{id}', 'App\Controller\CustomerController:detail');     // 详情
        $this->post('', 'App\Controller\CustomerController:create');     // 新增
        $this->patch('/{id}', 'App\Controller\CustomerController:update');     // 更新
        $this->delete('/{id}', 'App\Controller\CustomerController:cancel');     // 删除
    });
})->add(new App\Middleware\JwtMiddleware());
