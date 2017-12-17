<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function  __construct()
    {
        self::_permission();
        self::_autoTrace();
    }

    private function _permission(){
        /********用户未登录,返回403*********/
        if(!isset($_SESSION['user_id'])){
            header('403 HTTP/1.1');
            return array(
                'code' => 1001,
                'message' => '请先登录'
            );
        }
    }

    private function _autoTrace(){

    }
}
