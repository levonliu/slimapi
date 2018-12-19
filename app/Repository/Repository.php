<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 */

namespace App\Repository;

use Exception;

abstract class Repository
{
    public function __construct()
    {

    }

    /**
     *  不允许使用new的方式新建对象
     * 因为仓储只是存粹的数据操作
     *
     * @param $name
     * @param $arg
     *
     * @throws Exception
     */
    public function __call($name, $arg)
    {
        throw new Exception("The error way to use Repository");
    }

    /**
     * 静态调用方法
     *
     * @param    [type]     $name [description]
     * @param    [type]     $arg  [description]
     *
     * @return   [type]           [description]
     */
    public static function __callStatic($name, $arg)
    {
        return (new static)->$name(...$arg);
    }

    /**
     * 获取当前仓储同名直接解析的模型
     *
     * @return string
     */
    protected function getModel()
    {
        $class      = get_class($this);
        $model_name = substr($class, strrpos($class, "\\") + 1);
        if(strpos($model_name, "Repository") !== false) {
            $model_name = str_replace('Repository', '', $model_name);
        }

        return 'Models\\'.$model_name;
    }

}