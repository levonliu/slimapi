<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-11-29
 * Time: 下午1:52
 */

require __DIR__.'/../vendor/autoload.php';

//init config
$settings   = ['settings' => []];
$conf_files = glob(__DIR__.'/conf/*.php');
array_push($conf_files, __DIR__.'/../config/config.php');
foreach($conf_files as $file) {
    $settings['settings'] = array_merge($settings['settings'], require $file);
}

// Instantiate the app
$app = new \Slim\App($settings);

// middleware
$app->add(new App\Middleware\CorsMiddleware());

// load common function
require __DIR__.'/helper.php';

// Set up dependencies
require __DIR__.'/dependencies.php';

// Register routes
foreach(glob(__DIR__.'/../router/*.php') as $route) {
    require $route;
}

// entry && init Eloquent ORM
$app->getContainer()->get('database');

return $app;