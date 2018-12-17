<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-17
 * Time: 上午11:02
 */

namespace App\Repository;


class MenuRepository extends Repository
{
    /**
     * 1. 获取当前用户所属组
     * 2. 在当前组获取所属规则
     * 3. 获取规则下的菜单
     */
    public function getList()
    {
        $uid = app('store')->get('user')->id;
    }
}