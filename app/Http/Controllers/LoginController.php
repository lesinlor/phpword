<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function login(){
        $username = parent::rq('username');
        $password = parent::rq('password');

        if(empty($username) || !preg_match("/^[a-zA-Z]{1}\w{3,10}/",$username)){
            parent::fail($this->errorCode['invalidUserName'],'用户名格式错误');
        }

        if(!preg_match("/^.{6,20}$/", $password)){
            parent::fail($this->errorCode['invalidPassword'],'密码格式有误');
        }
        $user = new \App\User();
        $data = $user->where('username',$username)->first();
        //校验密码
        if(!$data->toArray())
            parent::fail($this->errorCode['userNotExists'],'用户不存在');
        if($data->password != md5($password.config('app.key'))){
            parent::fail($this->errorCode['incorrectPassword'],'密码有误');
        }
        $data = $data->toArray();
        unset($data['password']);
        parent::success($data);

    }

}
