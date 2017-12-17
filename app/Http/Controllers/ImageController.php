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
        $validator = Validator::make($request->all(),[
           'img' => 'required|image'
        ]);
        if($validator->fails()){
            parent::fail($this->errorCode['uploadImageFail'],'参数错误');
        }
        $file = $request->file('img');
        $fileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalName();
        $savePath = '';
    }
}
