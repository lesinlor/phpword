<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'password','role_id','last_login_at','last_login_ip','created_user_id','updated_user_id',
        'flag','username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_user_id','updated_user_id','updated_at'
    ];


    public function userList($param, $offset, $limit){
        $query = array();
        if($param['flag'] === 0 || $param['flag'] === '0' || $param['flag'] == 1){
            $query[] = ['flag', '=', (int)$param['flag']];
        }
        if($param['role_id']){
            $query[] = ['role_id','=',(int)$param['role_id']];
        }
        if(!empty($query)){
            return $this->where($query)
                        ->orderByDesc('role_id')
                        ->orderByDesc('created_at')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
        }
        return $this->orderByDesc('role_id')
                    ->orderByDesc('created_at')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
    }

    public function countUsers($param){
        $query = array();
        if($param['flag'] === 0 || $param['flag'] === '0' || $param['flag'] == 1){
            $query[] = ['flag', '=', (int)$param['flag']];
        }
        if($param['role_id']){
            $query[] = ['role_id','=',(int)$param['role_id']];
        }
        if(!empty($query)){
            return $this->where($query)
                ->orderByDesc('role_id')
                ->orderByDesc('created_at')
                ->count('id');
        }
        return $this->orderByDesc('role_id')
            ->orderByDesc('created_at')
            ->count('id');
    }

}
