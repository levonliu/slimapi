<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-17
 * Time: 上午11:02
 */

namespace App\Repository;

use App\Model\AuthGroupAccess;
use App\Model\AuthGroup;
use App\Model\AuthRule;
use App\Model\Menu;

class MenuRepository extends Repository
{
    /**
     * 1. 获取当前用户所属组
     * 2. 在当前组获取所属规则
     * 3. 获取规则下的菜单
     */
    public function getList()
    {
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

        //获取父级菜单
        $menu_ids = AuthRule::whereIn('id',$rule_ids)->where([['status',1]])->select(['menu_id'])->get()->toArray();
        $menu_ids = array_unique(array_column($menu_ids,'menu_id'));
        $menus = Menu::whereIn('id',$menu_ids)->where([['deleted','0']])->select(['title','path','icon'])->get()->toArray();

        return $menus;

    }
}