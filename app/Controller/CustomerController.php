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
    public function getCustomer($req, $res, $arg)
    {
        try{
            $param  = $req->getParams();
            $query = CustomerRepository::formatQuery($param);
            $data = CustomerRepository::lists($query);
            return success(['data'=>$data]);
        }catch(Exception $e){
            return error($e);
        }
    }
}