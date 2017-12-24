<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    protected $allow_extensions = ["png","jpg","jpeg"];

    protected $allow_max_size =  1048576; //1 * 1042 * 1024;

    function __construct()
    {
        parent::__construct();
    }

    public function upload(Request $request){

        ini_set('upload_max_filesize',10 * 1024 * 1024);

        $file = $request->file('file');//获取文件
        $name = parent::rq('id');
        if(!$file || !$name){
            parent::fail($this->errorCode['paramError'],'参数错误');
        }

        if(!$file->getClientOriginalExtension()){
            parent::fail($this->errorCode['imageExtensionInvalid'],'图片格式错误');
        }

        if(!in_array(strtolower($file->getClientOriginalExtension()),$this->allow_extensions)){
            parent::fail($this->errorCode['imageExtensionInvalid'], '图片格式错误');
        }

        $folder = md5($name);
        $savePath = $file->store($folder,'uploads');
        if(!$savePath)
            parent::fail($this->errorCode['uploadImageFail'], '图片上传失败');
        $savePath = '/contract/' . $savePath;
        parent::success($savePath);

    }

    /**
     * 保存图片
     * @param Request $request
     */
    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'files'=>'required',
            'id' => 'required|integer'
        ] );
        if($validator->fails()){
            parent::fail($this->errorCode['paramError'],'参数错误');
        }

        $files = explode('|',parent::rq('files'));

        $list = [];

        foreach ($files as $k => $v){
            $list[] = array(
                'concordat_id' => (int)parent::rq('id'),
                'path' => $v,
                'sort' => (int)$k + 1,
                'created_user_id' => $_SESSION['user_id'],
                'updated_user_id' => $_SESSION['user_id'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
        }

        if(\App\ConcordatImg::insert($list)){
            parent::success();
        }

        parent::fail($this->errorCode['addConcordatFail'],'新增合同失败');

    }

    /**
     * 删除图片
     * @param Request $request
     * @throws \Exception
     */
    public function delete(Request $request){
        $validator = Validator::make($request->all(),[
            'file' => 'required',
            'token' => 'required',
            'id' => 'required|integer'
        ]);
        if($validator->fails()){
            parent::fail($this->errorCode['paramError'],'参数错误');
        }
        $filePath = parent::rq('/contract/'.$this->rq('token').'/'.parent::rq('file'));
        $crashPath = '/tmp/'.parent::rq('token').'/'.parent::rq('file');
        if(Storage::exists($filePath)){
            parent::fail($this->errorCode['imageNotExists'],'图片不存在');
        }
        $tmp = Storage::directories('/tmp/'.parent::rq('token'));
        if(!$tmp){
            //创建目录
            Storage::makeDirectories('/tmp/'.parent::rq('token'));
        }
        Storage::move($filePath, $crashPath);
        $corImg = new \App\ConcordatImg();
        $bool = $corImg->delPic(parent::rq('id'), parent::rq('token'), parent::rq('file'));
        if($bool)
            parent::success();
        parent::fail($this->errorCode['deleteImageFail'], '删除图片失败');
    }

}
