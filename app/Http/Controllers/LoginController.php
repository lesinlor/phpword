<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function login(Request $request){
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
        if(!$data)
            parent::fail($this->errorCode['userNotExists'],'用户不存在');
        if($data->password != md5($password.config('app.key'))){
            parent::fail($this->errorCode['incorrectPassword'],'密码有误');
        }
        $_SESSION['user_id'] = (int)$data->id;
        $_SESSION['nickname'] = $data->nickname;
        $_SESSION['role_id'] = $data->role_id;
        $_SESSION['is_admin'] = $data->is_admin == 1 ? 1:0;
        $data->last_login_at = time();
        $data->last_login_ip = $_SERVER['REMOTE_ADDR'];
        $data->save();
        $data = $data->toArray();
        unset($data['password']);
        parent::success($data);

    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['role_id']);
        unset($_SESSION['nickname']);
        unset($_SESSION['is_admin']);
        parent::success();
    }

    public function info(){
        if(!isset($_SESSION['user_id'])){
            header('HTTP/1.1 403');
            parent::fail($this->errorCode['noAuth'],'请先登录');
        }
        $data = array(
            'user_id'=>(int)$_SESSION['user_id'],
            'role_id'=>(int)$_SESSION['role_id'],
            'is_admin'=>(int)$_SESSION['is_admin'],
            'nickname'=>$_SESSION['nickname']
        );
        parent::success($data);
    }

}
