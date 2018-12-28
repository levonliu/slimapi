<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-19
 * Time: 下午6:09
 */

namespace App\Controller;


use App\Repository\CustomerRepository;
use Exception;

class CustomerController extends Controller
{
    public static $sex   = ['1' => '男', '2' => '女'];
    public static $level = ['1' => '普通', '2' => 'VIP'];

    /**
     * 客户列表
     * @param $req
     * @param $res
     * @param $arg
     *
     * @return mixed
     */
    public function lists($req, $res, $arg)
    {
        try {
            $params = $req->getParams();
            $query  = CustomerRepository::formatQuery($params);
            $data   = CustomerRepository::lists($query);
            foreach($data['rows'] as $k => &$v) {
                $v['sex_name']   = self::$sex[$v['sex']];
                $v['level_name'] = self::$level[$v['level']];
            }
            return success(['data' => $data]);
        }catch(Exception $e) {
            return error($e);
        }
    }

    /**
     * 客户新增
     * @param $req
     * @param $res
     * @param $arg
     *
     * @return mixed
     */
    public function create($req, $res, $arg)
    {
        try{
            $params = $req->getParams();
            $params['sex'] = array_search($params['sex_name'],self::$sex);
            $params['level'] = array_search($params['level_name'],self::$level);
            $status = CustomerRepository::create($params);
            if ($status === false) {
                throw new Exception("新增失败");
            }
            return success(['success' => true]);
        }catch(Exception $e){
            return error($e);
        }
    }

    /**
     * 客户更新
     * @param $req
     * @param $res
     * @param $arg
     *
     * @return mixed
     */
    public function update($req, $res, $arg)
    {
        try {
            $params = $req->getParams();
            $params['sex'] = array_search($params['sex_name'],self::$sex);
            $params['level'] = array_search($params['level_name'],self::$level);
            $status = CustomerRepository::update($params,$arg['id']);
            if ($status === false) {
                throw new Exception("更新失败");
            }
            return success(['success' => true]);
        }catch(Exception $e) {
            return error($e);
        }
    }

    /**
     * 客户删除 （逻辑删除）
     * @param $req
     * @param $res
     * @param $arg
     *
     * @return mixed
     */
    public function cancel($req, $res, $arg)
    {
        try{
            $data['deleted'] = 1;
            $status = CustomerRepository::update($data,$arg['id']);
            if ($status === false) {
                throw new Exception("删除失败");
            }
            return success(['success' => true]);
        }catch(Exception $e){
            return error($e);
        }
    }
}