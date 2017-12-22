<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConcordatImg extends Model
{
    protected $table = 'concordat_img';

    protected $guarded = [

    ];


    /**
     * 删除图片
     * @param $concordat_id
     * @param $token
     * @param $path
     * @return bool|null
     * @throws \Exception
     */
    public function delPic($concordat_id, $token, $path){
        $concordatImg = $this->where([
            ['concordat_id',(int)$concordat_id],
            ['directory', $token],
            ['path', $path]
        ])->first();
        if($concordatImg)
            return $concordatImg->delete();
        return false;
    }

}
