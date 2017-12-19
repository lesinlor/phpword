<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function upload(Request $request){
//        $file = $request->file('img');
//        $filePath =[];  // 定义空数组用来存放图片路径
//        foreach ($file as $key => $value) {
//            // 判断图片上传中是否出错
//            if (!$value->isValid()) {
//                exit("上传图片出错，请重试！");
//            }
//            if(!empty($value)){//此处防止没有多文件上传的情况
//                $allowed_extensions = ["png", "jpg", "gif"];
//                if ($value->getClientOriginalExtension() && !in_array($value->getClientOriginalExtension(), $allowed_extensions)) {
//                    exit('您只能上传PNG、JPG或GIF格式的图片！');
//                }
//                $destinationPath = '/uploads/'.date('Y-m-d'); // public文件夹下面uploads/xxxx-xx-xx 建文件夹
//                $extension = $value->getClientOriginalExtension();   // 上传文件后缀
//                $fileName = date('YmdHis').mt_rand(100,999).'.'.$extension; // 重命名
//                $value->move(public_path().$destinationPath, $fileName); // 保存图片
//                $filePath[] = $destinationPath.'/'.$fileName;
//
//            }
//        }
//        // 返回上传图片路径，用于保存到数据库中
//        return $filePath;

        $file=$request->file('img');//获取文件
        $folder = md5(time());
        $savePath = $file->store($folder,'uploads');
        if($savePath)
            $savePath = '/contract/' . $savePath;
        return $savePath;
    }
}
