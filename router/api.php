<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 上午10:30
 */

$app->get('/test',function(){
   echo 'this is a test';
});

//login
$app->post('/login','App\Controller\LoginController:login');


$app->group('/',function(){
    //菜单
    $this->group('menu',function(){
       $this->get('','App\Controller\MenuController:getMenu');
    });
})->add(new App\Middleware\JwtMiddleware());
