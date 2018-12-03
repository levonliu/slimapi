<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 下午1:42
 */

namespace App\Repository;
use Exception;

abstract class Repository
{
    public function __construct()
    {

    }
    /**
     * 不允许使用new的方式新建对象
     * 因为仓储只是存粹的数据操作
     * @DateTime 2018-11-22
     * @param    [type]     $name [description]
     * @param    [type]     $arg  [description]
     * @return   [type]           [description]
     */
    public function __call($name, $arg)
    {
        throw new Exception("The error way to use Repository");
    }
    /**
     * 静态调用方法
     * @DateTime 2018-11-22
     * @param    [type]     $name [description]
     * @param    [type]     $arg  [description]
     * @return   [type]           [description]
     */
    public static function __callStatic($name, $arg)
    {
        return (new static)->$name(...$arg);
    }

}