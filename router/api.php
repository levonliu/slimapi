<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 上午10:30
 */

$app->get('/',function(){
    echo '123';
});

$app->get('/test',function(){
   echo 'this is a test';
});

//login
$app->post('/login','App\Controller\LoginController:login');
