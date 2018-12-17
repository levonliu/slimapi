<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-17
 * Time: 上午10:53
 */

namespace App\Controller;

use App\Repository\MenuRepository;

class MenuController extends Controller
{
    public function getMenu($req, $res, $arg)
    {
        $menu = MenuRepository::getList();
    }
}