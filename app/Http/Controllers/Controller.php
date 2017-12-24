<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const HTTP_VERSION = 'HTTP/1.1';

    const SUCCESS_STATUS = 200;

    protected $errorCode;

    function  __construct()
    {
        $this->errorCode = config('mine.errorCode', array()); //获取自定义errorCode
        self::_permission();
    }

    private function _permission(){
        $route = config('mine.unPermission');
        if(in_array(Request::getRequestUri(),$route))
            return true;
        /********用户未登录,返回403*********/
        if(!session('user_id')){
            header('HTTP/1.1 403');
            self::fail($this->errorCode['noAuth'],'请先登录');
        }
    }

    /**
     * 请求参数
     * @param null $key
     * @param null $default
     * @return array|mixed
     */
    public function rq($key = null, $default = null){
        if(!$key)
            return \request()->all();
        return \request()->get($key, $default);
    }


    /**
     * 成功返回
     * @param array $data
     * @param array $meta
     * @param null $message
     */
    public function success($data = array(), $meta = array(), $message = null){
        $return = array(
            'code' => 0,
            'message' => $message,
            'data' => $data
        );
        if(is_array($meta) && !empty($meta)){
            $return['meta'] = $meta;
        }
        echo json_encode($return);exit();
    }

    /**
     * 请求失败返回
     * @param $code
     * @param null $message
     */
    public function fail($code,$message = null){
        echo json_encode(array(
            'code' => (int)$code,
            'message' => $message
        ));
        exit();
    }

}
