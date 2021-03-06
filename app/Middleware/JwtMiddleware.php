<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-5
 * Time: 下午1:29
 */

namespace App\Middleware;

use Exception;
use Firebase\JWT\JWT;

class JwtMiddleware
{
    public function __invoke($request, $response, $next)
    {
        try{
            $JWTConfig = config('jwt');
            $token = $request->getServerParam('HTTP_AUTHORIZATION');
            if (!$token) {
                throw new Exception("身份丢失！",401);
            }
            // 身份检测
            $payload = JWT::decode($token, $JWTConfig['key'], array($JWTConfig['hash']));
            app('store')->set('user', $payload);
            return $next($request, $response);
        }catch(Exception $e){
            switch((int)$e->getCode()){
                case 401:
                    $message = $e->getMessage();
                    break;
                case 0:
                    $message = '身份失效，请登录!';
                    break;
                default:
                    $message = '请停止恶意操作!!!';
                    break;
            }
            app('logger')->addError("身份验证错误:".$e->getMessage());
            $data = [ 'message' => $message];
            return response($data, 401);
        }
    }
}