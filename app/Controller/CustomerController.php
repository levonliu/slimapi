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

    public function getCustomer($req, $res, $arg)
    {
        try {
            $param = $req->getParams();
            $query = CustomerRepository::formatQuery($param);
            $data  = CustomerRepository::lists($query);
            foreach($data['rows'] as $k => &$v) {
                $v['sex_name']   = self::$sex[$v['sex']];
                $v['level_name'] = self::$level[$v['level']];
            }

            return success(['data' => $data]);
        }catch(Exception $e) {
            return error($e);
        }
    }
}