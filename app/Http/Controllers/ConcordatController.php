<?php

namespace App\Http\Controllers;

use App\Concordat;
use Illuminate\Http\Request;


class ConcordatController extends Controller
{

    public $concordat;

    function __construct(Concordat $concordat)
    {
        parent::__construct();
        $this->concordat = $concordat;
    }

    /**
     * 列表
     */
    public function all(){
        $st = parent::rq('st');
        $et = parent::rq('et');
        $type = parent::rq('type');
        $section = parent::rq('section');
        $sop = parent::rq('sop'); //时长操作符
        $money = parent::rq('money');//金额
        $mop = parent::rq('mop'); //金额比较
        $sort = parent::rq('sort'); //排序方式
        $name = parent::rq('name'); //排序字段
        $offset = (int)parent::rq('offset');
        $limit = (int)parent::rq('limit');

        $limit = ($limit && $limit < 3000 && $limit >0) ? $limit : 20;
        $offset = $offset > 0 ? $offset : 0;

        if(!empty($st))
            $st .= " 00:00:00";
        if(!empty($et))
            $et .= " 23:59:59";

        $param = compact('st','et','type','section','sop','money','mop','sort','name');

        $data = $this->concordat->lists($param,$offset,$limit);

        if($data->toArray()){
            $type = \App\ConcordatType::all(array('id','name','flag'))->keyBy('id');
            foreach ($data as &$item){
                $item['type_name'] = array_key_exists((int)$item['type'],$type) ? $type[(int)$item['type']]['name'] : '';
                $item['st'] = date('Y-m-d',$item['st']);
                $item['et'] = date('Y-m-d',$item['et']);
            }
            unset($item);
            $meta = array(
                'total' => (int)$this->concordat->countLists($param),
                'current' => count($data),
                'offset' => $offset,
                'limit' => $limit
            );
            parent::success($data,$meta);
        }
        parent::fail($this->errorCode['noContent'],'暂无相关内容');
    }

    /**
     * 查看
     */
    public function show(){
        $c_id = (int)parent::rq('id');
        if(!$c_id)
            parent::fail($this->errorCode['paramError'],'参数错误');
        $data = $this->concordat->find($c_id);
        if($data){
//            $type = \App\ConcordatType::all(array('id','name','flag'))->keyBy('id');
//            if(array_key_exists((int)$data->type,$type))
//                $data->type_name = $type[(int)$data->type]['name'];
            $detail = $data->toArray();
            $detail['st'] = date('Y-m-d',$data->st);
            $detail['et'] = date('Y-m-d',$data->et);
            unset($detail['created_user_id']);
            unset($detail['updated_user_id']);
            /*************获取合同图片*********/
            $imgs = $data->images()->get(['directory','path']);
            if($imgs){
                foreach ($imgs as $item){
                    $detail['files'][] = '/contract/'.$item->directory .'/'.$item->path;
                }
            }else{
                $detail['files'] = [];
            }
            /*************获取合同图片*********/
            parent::success($detail);
        }
        parent::fail($this->errorCode['noContent'],'暂无相关数据');
    }

    /**
     * 新增
     */
    public function store(){
        $this->validate(request(),[
            'name' => 'required|string|max:255|unique:concordats',
            'address' => 'required|string',
            'money' => 'required',
            'st' => 'required|date_format:Y-m-d',
            'et' => 'required|date_format:Y-m-d',
            'grade' => 'required|integer',
            'concat' => 'required|string',
            'telephone' => 'required',
            'signature' => 'required',
            'per_money' => 'required',
            'batch' => 'required',
            'area' => 'required',
            'charge' => 'required',
            'subject' => 'required',
            'place' => 'required'
        ]);

        $this->concordat->name = parent::rq('name');
        $this->concordat->address = parent::rq('address');
        $this->concordat->money = (int)parent::rq('money');
        $this->concordat->st = strtotime(parent::rq('st'));
        $this->concordat->et = strtotime(parent::rq('et'));
        $this->concordat->grade = (int)parent::rq('grade');
        $this->concordat->concat = parent::rq('concat');
        $this->concordat->telephone = parent::rq('telephone');
        $this->concordat->created_user_id = $_SESSION['user_id'];
        $this->concordat->updated_user_id = $_SESSION['user_id'];
        $this->concordat->signature = parent::rq('signature');
        $this->concordat->per_money = parent::rq('per_money');
        $this->concordat->batch = parent::rq('batch');
        $this->concordat->area = parent::rq('area');
        $this->concordat->area = parent::rq('charge');
        $this->concordat->subject = parent::rq('subject');
        $this->concordat->place = parent::rq('place');
        $this->concordat->comment = parent::rq('comment');
        if($this->concordat->save())
            parent::success(array(
                'id' => $this->concordat->id
            ));
        parent::fail($this->errorCode['addConcordatFail'],'更新合同失败');

    }

    /**
     * 编辑
     */
    public function edit(){
        $c_id = (int)parent::rq('id');
        if(!$c_id)
            parent::fail($this->errorCode['paramError'],'参数错误');
        $newConcordat = $this->concordat->find($c_id);
        if(!empty(parent::rq('name'))){
            $newConcordat->name = parent::rq('name');
        }
        if(!empty(parent::rq('address'))) {
            $newConcordat->address = parent::rq('address');
        }
        if(!empty(parent::rq('money'))){
            $newConcordat->money = (int)parent::rq('money');
        }
        if(!empty(parent::rq('st'))){
            $newConcordat->st = strtotime(parent::rq('st'));
        }
        if(!empty(parent::rq('et'))) {
            $newConcordat->et = strtotime(parent::rq('et'));
        }
        if(!empty(parent::rq('grade'))){
            $newConcordat->grade = (int)parent::rq('grade');
        }
        if(!empty(parent::rq('concat'))){
            $newConcordat->concat = parent::rq('concat');
        }
        if(!empty(parent::rq('telephone')) && preg_match("/^1[34578]{1}[0-9]{9}$/",parent::rq('telephone'))){
            $newConcordat->telephone = parent::rq('telephone');
        }
        $newConcordat->updated_user_id = $_SESSION['user_id'];
        if($newConcordat->save())
            parent::success();
        parent::fail($this->errorCode['updateConcordatFail'],'更新合同失败');
    }
}
