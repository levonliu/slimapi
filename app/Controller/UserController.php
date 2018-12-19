<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-19
 * Time: 下午4:27
 */

namespace App\Controller;


use App\Repository\UserRepository;

class UserController extends Controller
{
    public function getUser($req, $res, $arg)
    {
        $user = UserRepository::getUser();

        return success(['data'=>$user]);
    }
}