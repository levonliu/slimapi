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

        return 'App\Model\\'.$model_name;
    }

    /**
     * 格式化查询条件
     * @param    array      $data 查询条件
     * @return   array            数据
     */
    protected function formatQuery($data)
    {
        $query = [];
        $query['page']  = $data['page'] ?: 0;
        $query['limit'] = $data['limit'] ?: 10;
        $query['order'] = $data['querySort'] ?? [];

        /**
         *  列表关键字查询(两者必须同时存在)
         *
         * @params queryKeyWord 关键字
         * @params queryKeyFields 查询的字段
         */
        $queryKeyWord   = $data['queryKeyWord'] ?? '';
        $queryKeyFields = $data['queryKeyFields'] ?? [];
        if(!empty($queryKeyWord) && !empty($queryKeyFields)) {
            foreach($queryKeyFields as $v) {
                $column[] = [$v, 'like', '%'.$queryKeyWord.'%', 'or'];
            }
            unset($v);
            $query['where'][] = [null, 'where-common', $column];
        }

        return $query;
    }

    /**
     * 获取查询列表
     * @param    array      $where 查询条件
     * @return   array             查询结果
     */
    protected function lists($where){
        $model = $this->getModel();
        $model = $model::where('deleted',0);
        if (isset($where['where'])) {
            foreach ($where['where'] as $k => $v) {
                $this->makeWhere($model, $v);
            }
            unset($k, $v);
        }
        $count = $model->count();
//        dd(app('database')::getQueryLog());

        if (isset($where['page']) && isset($where['limit'])) {
            $where['page']  = $where['page']  ?: 1;
            $where['limit'] = $where['limit'] ?: 10;
            $offset = ($where['page'] - 1) * $where['limit'];
            $model->offset($offset)->limit($where['limit']);
        }
        if (isset($where['order'])) {
            $model->orderBy($where['order'][0], $where['order'][1]);
        }
        $list = $model->get()->toArray();

        $data = [
            'rows' => $list,
            'total' => $count
        ];
        return $data;
    }
    /**
     * 构造查询条件
     * @DateTime 2018-12-04
     * @param    [type]     &$model 查询的模型
     * @param    [type]     $v      查询的条件
     */
    protected function makeWhere(&$model, $v){
        $type = strtolower($v[1]);
        switch ($type) {
            case 'in':
                $model->whereIn($v[0], $v[2]);
                break;
            case 'not-in':
                $model->whereNotIn($v[0], $v[2]);
                break;
            case 'intime':
                $model->whereBetween($v[0], $v[2]);
                break;
            case 'not-intime':
                $model->whereNotBetween($v[0], $v[2]);
                break;
            case 'between':
                $model->whereBetween($v[0], $v[2]);
                break;
            case 'not-between':
                $model->whereNotBetween($v[0], $v[2]);
                break;
            case 'like':
                $model->where($v[0], 'like', '%'.$v[2].'%');
                break;
            case 'not-like':
                $model->where($v[0], 'not like', $v[2]);
                break;
            case 'equal':
                $model->where($v[0], '=', $v[2]);
                break;
            case 'not-equal':
                $model->where($v[0], '<>', $v[2]);
                break;
            case 'where-common':
                $model->where($v[2]);
                break;
            default:
                $model->where($v[0], $v[1], $v[2]);
                break;
        }
    }

}