<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function all(){
        $role = \App\Role::all('id','role_name');
        if($role){
            parent::success($role);
        }
        parent::fail($this->errorCode['noContent'],"暂无相关内容");
    }
}
