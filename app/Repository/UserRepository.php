<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 下午1:46
 */

namespace App\Repository;

use App\Model\User;
use App\Model\AuthGroupAccess;
use App\Model\AuthGroup;
use App\Model\AuthRule;

class UserRepository extends Repository
{

    protected function findByUserPass($username, $password)
    {
        $filed = [
            'id',
            'name',
            'phone',
        ];
        $where = [
            ['name', $username],
            ['password', $password],
        ];
        $user  = User::where($where)->select($filed)->first();
        return $user;
    }

    public function getUser()
    {
        $user = [];

        $user['name'] = app('store')->get('user')->name;
        $user['phone'] = app('store')->get('user')->phone;
        //获取组
        $uid = app('store')->get('user')->id;
        $group_str = AuthGroupAccess::where('uid', '=', $uid)->value('groups');
        $group_ids = explode(',',$group_str);
        if(empty($group_ids)){
            return [];
        }
        $groups = AuthGroup::whereIn('id', $group_ids)->where([['status',1]])->select(['id', 'rules'])->get();

        //获取规则id
        $rule_ids    = [];
        foreach ($groups as $g) {
            $rule_ids = array_merge($rule_ids, array_filter(explode(',', $g->rules)));
        }
        unset($g);
        $rule_ids = array_unique($rule_ids);
        if (empty($rule_ids)) {
            return [];
        }

        $code = AuthRule::whereIn('id',$rule_ids)->where([['status',1]])->select(['code'])->get()->toArray();
        $rules = array_column($code,'code');
        $user['rules'] = $rules;

        return $user;
    }
}