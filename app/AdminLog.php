<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{

    protected $table = 'admin_logs';

    public $timestamps = false;

    public function writeLog($act){
        $this->user_id = $_SESSION['user_id'];
        $this->nickname = $_SESSION['nickname'];
        $this->action = $act;
        $this->save();
    }
}
