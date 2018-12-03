<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * 辅助函数
 */
if(!function_exists('dd')) {
    /**
     * 断点打印数据
     *
     * @param null $value
     */
    function dd($value = null)
    {
        echo '<pre>';
        print_r($value);
        die();
    }
}


if (! function_exists('app')) {
    /**
     * 获取应用对象
     * @DateTime 2018-11-21
     * @param    [type]     $value [description]
     * @return   [type]            [description]
     */
    function app($value = null){
        $app = $GLOBALS["app"];
        if (empty($value)) {
            return $app;
        }
        return $app->getContainer()->get($value);
    }
}

if (! function_exists('config')) {
    /**
     * 获取配置文件
     * @DateTime 2018-11-21
     * @param    [type]     $value [description]
     * @return   [type]            [description]
     */
    function config($value = null){
        $config = app('settings');
        if (empty($value)) {
            return $config;
        }
        if(isset($config[$value])){
            return $config[$value];
        }else{
            throw new \Exception("not find the {$value} config");
        }
    }
}