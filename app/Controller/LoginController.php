<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 下午2:19
 */

namespace App\Controller;
use Exception;
use Firebase\JWT\JWT;
use App\Repository\UserRepository;

class LoginController extends Controller
{
    public function login($req, $res, $arg)
    {
        try{
            $param  = $req->getParams();
            $user = UserRepository::findByUserPass($param['username'],$param['password']);
            if($user){
                // 当前请求来源
                $origin = $req->getServerParam('HTTP_ORIGIN') ? $req->getServerParam('HTTP_ORIGIN') :'';
                $exp_time = config('session');
                // 配置载荷
                $user->for = 'computer';
                $user->iss = config('base_url');
                $user->aud = $origin;
                $user->iat = time();
                $user->exp = time() + $exp_time;
                $JWTConfig = config('jwt');
                // 生成token
                $token = JWT::encode($user, $JWTConfig['key'], $JWTConfig['hash']);
                return success(['token'=>$token]);
            }else{
                throw new Exception("账号或密码错误");
            }
        }catch(Exception $e){
            return error($e);
        }
    }
}