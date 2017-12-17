<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    function __construct(User $user)
    {
        parent::__construct();
        if($_SESSION['role_id'] != 1){
            header('HTTP/1.1 403');
            self::fail($this->errorCode['noAuth'],'没有权限');
        }
        $this->user = $user;
    }

    public function store()
    {
        $user_id = (int)parent::rq('id');
        $nickname = parent::rq('nickname');
        $username = parent::rq('username');
        $password = parent::rq('password');
        $role_id = (int)parent::rq('role_id') ?: 1;
        $flag = (int)parent::rq('flag');
        //user_id为空则为添加,不为空则是编辑
        if ($user_id) {
            $user = $this->user->find($user_id);
            if(!$user)
                parent::fail($this->errorCode['userNotExists'],'用户不存在');
            if (!empty($nickname)) {
                if (!self::_checkCnName($nickname)) {
                    parent::fail($this->errorCode['invalidNickName'], '用户名格式有误');
                }
                $user->nickname = $nickname;
            }
            if (!empty($username)) {
                if (!self::_checkEnName($username)) {
                    parent::fail($this->errorCode['invalidUserName'], '登录名格式有误');
                }
                $user->username = $username;

            }
            if (!empty($password)) {
                if (!self::_checkPassWord($password)) {
                    parent::fail($this->errorCode['invalidPassword'], '密码长度应该在6~20位之间');
                }
                $user->password = $password;

            }
            //判断是否需要进行权限更新
            if ($flag != $user->flag && in_array($flag, array(0, 1))) {
                $user->flag = $flag;
            }
            if ($flag != $user->role_id)
                $user->role_id = $role_id;
            if($user->save()){
                parent::success();
            }
            parent::fail($this->errorCode['updateUserFail'], '更新用户信息失败');
        } else {
            if (!$nickname || !$username || !$password) {
                parent::fail($this->errorCode['paramError'], '必选参数不能为空');
            }
            if (!self::_checkCnName($nickname)) {
                parent::fail($this->errorCode['invalidNickName'], '用户名格式有误');
            }
            if (!self::_checkEnName($username)) {
                parent::fail($this->errorCode['invalidUserName'], '登录名格式有误');
            }
            if (!self::_checkPassWord($password)) {
                parent::fail($this->errorCode['invalidPassword'], '密码长度应该在6~20位之间');
            }
            $param = array(
                'nickname' => $nickname,
                'username' => $username,
                'password' => md5($password . config('app.key')),
                'role_id' => $role_id,
                'flag' => in_array($flag, array('0', '1')) ? 1 : 0
            );
            if($this->user->create($param))
                parent::success();
            parent::fail($this->errorCode['addUserFail'],'添加用户失败');
        }


    }

    public function show(User $user)
    {
        $user = $this->user->find($user);
        if($user)
            parent::success($user);
        parent::fail($this->errorCode['noContent'],"暂无相关内容");
    }

    public function index(){
        $offset = (int)parent::rq('offset');
        $limit = (int)parent::rq('limit');
        $flag = parent::rq('flag');
        $role_id = (int)parent::rq('role_id');

        $limit = ($limit && $limit < 3000) ? $limit : 20;
        $offset = $offset > 0 ? $offset : 0;

        $param = array(
            'flag' => $flag,
            'role_id' => $role_id
        );
        $data = $this->user->userList($param,$offset,$limit);
        if($lists = $data->toArray()){
            $total = (int)$this->user->countUsers($param);
            $roles = \App\Role::all('id','role_name')->keyBy('id')->toArray();
            foreach ($lists as &$value){
                $value['role_name'] = !empty($roles) ? $roles[$value['role_id']]['role_name'] : '';
            }
            unset($value);
            $meta = array(
                'total' => $total,
                'current' => count($lists),
                'offset' => $offset,
                'limit' => $limit
            );
            parent::success($lists,$meta);
        }
        parent::fail($this->errorCode['noContent'],"暂无相关内容");
    }

    /**
     * 验证中文名,2~5个汉字
     * @param $name
     * @return bool
     */
    private function _checkCnName($name)
    {
        return true;
//        if (!preg_match("/^[x{4e00}-x{9fa5}]+$/u", $name))
//            return false;
//        if (mb_strlen($name) > 5 || mb_strlen($name) <= 1) {
//            return false;
//        }
    }

    /**
     * 验证英文名4~16
     * @param $name
     * @return int
     */
    private function _checkEnName($name)
    {
        return true;
//        return preg_match("/^[a-zA-Z]{1}[a-zA-Z0-9]{3}\w{0,12}$/", $name);
    }

    /**
     * 验证密码,6~20位
     * @param $password
     * @return int
     */
    private function _checkPassWord($password)
    {
        return true;
//        return preg_match("/^.{6,20}$/", $password);
    }
}
