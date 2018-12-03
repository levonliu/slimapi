<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * Date: 18-12-3
 * Time: 上午11:40
 */

namespace App\Middleware;


class CorsMiddleware
{
    public function __invoke($request, $response, $next)
    {
        $config = config('cors');
        $origin = $request->getServerParam('HTTP_ORIGIN') ?: '';
        if (in_array($origin, $config['Origin'])) {
            // 不使用witHeader方法，是因为跨域开发的时候，调试内容不能返回给浏览器
            header('Content-Type: text/html; charset= UTF-8');
            header("Access-Control-Allow-Origin: {$origin}"); // 允许跨域
            header("Access-Control-Allow-Methods: {$config['Methods']}");
            header("Access-Control-Allow-Headers: {$config['Headers']}");
            header("Access-Control-Expose-Headers: Authorization");
            header("Access-Control-Max-Age: 1728000");
        }
        return $next($request, $response);
    }
}