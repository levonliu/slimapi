<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 *
 * DIC configuration
 */

$container = $app->getContainer();

// init database
$container['database'] = function($c) {
    $capsule  = new Illuminate\Database\Capsule\Manager();
    $database = $c->get('settings')['database'];
    $capsule->addConnection($database);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

// init monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// 数据管理
$container['store'] = function($c){
    return App\Library\Store::getinstance();
};
