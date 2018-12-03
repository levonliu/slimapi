<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 *
 * DIC configuration
 */

$container = $app->getContainer();

// 数据模型需要立即执行一次
$container['database'] = function($c) {
    $capsule  = new Illuminate\Database\Capsule\Manager();
    $database = $c->get('settings')['database'];
    $capsule->addConnection($database);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};