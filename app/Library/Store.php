<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-5
 * Time: 下午1:39
 */

namespace App\Library;


class Store
{
    // 实例对象
    public static $instance;

    // 数据存储器
    private $store = [];

    // 防止构造本身
    private function __construct(){
    }

    public static function getinstance(){
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // 存储数据
    public function set($key, $value){
        $this->store[$key] = $value;
    }

    // 获取数据
    public function get($key){
        return $this->has($key) ? $this->store[$key]: null;
    }

    // 检查是否有该数据
    public function has($key)
    {
        return isset($this->store[$key]) ? true: false;
    }
}