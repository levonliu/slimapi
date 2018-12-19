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
    /**
     * @param $req
     * @param $res
     * @param $arg
     *
     * @return mixed
     */
    public function getMenu($req, $res, $arg)
    {
        $menus = MenuRepository::getList();

        return success(['data'=>$menus]);
    }
}