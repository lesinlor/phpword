<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * 通过模型查找出来的内容需要隐藏
     * @var array
     */
    protected $hidden = [
        'created_at','flag','updated_at','created_user_id','updated_user_id'
    ];

    protected $guarded = [];

    public function menus($role){
        $item = $this->find($role);
        $menus = $item->role_auth;
        if($menus == '[]'){
            //权限为空
            return null;
        }
        return substr($menus,1,strlen($menus)-2);
    }
}
