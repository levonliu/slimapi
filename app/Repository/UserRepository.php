<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 下午1:46
 */

namespace App\Repository;

use App\Model\User;

class UserRepository extends Repository
{

    protected function getUserInfo($username, $password)
    {
        $filed = [
            'id',
            'name',
        ];
        $where = [
            ['name', $username],
            ['password', $password],
        ];
        $user  = User::where($where)->select($filed)->first();
        return $user;
    }
}