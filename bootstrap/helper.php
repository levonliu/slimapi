<?php
/**
 * Created by PhpStorm.
 * User: liuwen
 * 辅助函数
 */
if(!function_exists('dd')) {
    /**
     * 断点打印数据
     *
     * @param null $value
     */
    function dd($value = null)
    {
        echo '<pre>';
        print_r($value);
        die();
    }
}


if(!function_exists('app')) {
    /**
     * 获取应用对象
     * @DateTime 2018-11-21
     *
     * @param    [type]     $value [description]
     *
     * @return   [type]            [description]
     */
    function app($value = null)
    {
        $app = $GLOBALS["app"];
        if(empty($value)) {
            return $app;
        }

        return $app->getContainer()->get($value);
    }
}

if(!function_exists('config')) {
    /**
     * 获取配置文件
     * @DateTime 2018-11-21
     *
     * @param    [type]     $value [description]
     *
     * @return   [type]            [description]
     */
    function config($value = null)
    {
        $config = app('settings');
        if(empty($value)) {
            return $config;
        }
        if(isset($config[$value])) {
            return $config[$value];
        } else {
            throw new \Exception("not find the {$value} config");
        }
    }
}


if(!function_exists('response')) {
    /**
     * 返回一个response
     * @DateTime 2018-11-22
     *
     * @param    string  $content [description]
     * @param    integer $status  [description]
     * @param    array   $headers [description]
     *
     * @return   [type]              [description]
     */
    function response($content = '', $status = 200, array $headers = [])
    {
        $response = app('response');
        $response = $response->withStatus($status);
        if($headers) {
            foreach($headers as $key => $value) {
                $response = $response->withHeader($key, $value);
            }
        }

        return $response->withJson($content);
    }
}

if (! function_exists('success')) {
    /**
     * 公共成功返回
     * @DateTime 2018-11-22
     * @param    [type]     $msg [description]
     * @return   [type]          [description]
     */
    function success(...$msg)
    {
        $data = [
            'message' => '操作成功',
        ];
        foreach ($msg as $v) {
            if (is_array($v)) {
                $data = array_merge($data, $v);
            }
        }
        return response($data, 200);
    }
}

if (! function_exists('error')) {
    /**
     * 公共错误返回
     * @DateTime 2018-11-22
     * @param    [type]     $e [description]
     * @return   [type]        [description]
     */
    function error($e=null){
        $message = '';
        $error = '';
        if (!is_object($e)) {
            return response($e, 400);
        }
        if ((int)$e->getCode() === 0) {
            $message = $e->getMessage();
        }else{
            $message = 'System Error!!!';
            $error = $e->getMessage();
            app('logger')->addError($e->getMessage());
        }
        $data = [
            'error' => $error,
            'message' => $message,
            'code' => $e->getCode()
        ];
        // 开发模式下才显示错误详情
        $config = config();
        if ( $config['model'] === 'production') {
            unset($data['error']);
        }
        return response($data, 400);
    }
}
