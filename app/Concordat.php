<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concordat extends Model
{
    protected $hidden = [
        'created_at','updated_at'
    ];

    protected $fillable = [

    ];

    public function images(){
        return $this->hasMany('App\ConcordatImg','concordat_id');
    }

    /**
     * 查询合同列表
     * @param $param
     * @param $offset
     * @param $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function lists($param, $offset, $limit){
        $query = [];
        if(!empty($param['st'])){
            $query[] = ['st', '>=', strtotime($param['st'])];
        }
        if(!empty($param['et'])){
            $query[] = ['et', '<=', strtotime($param['et'])];
        }
        if(!empty($param['type'])){
            $query[] = ['type',(int)$param['type']];
        }
        if(!empty($param['section'])){
            $op = $param['sop'] == 'lt' ? '<' : ($param['op'] == 'gt' ?  '>' : '=');
            $query[] = ['section', $op, (int)$param['section']];
        }
        if(!empty($param['money'])){
            $op = $param['mop'] == 'lt' ? '<' : '>';
            $query[] = ['money', $op, (float)$param['money']];
        }
        if(!empty($param['sort'])){
            $sort = $param['sort'] == 'desc' ? 'desc' : 'asc';
        }else{
            $sort = 'desc';
        }
        if(!empty($param['name'])){
            $name = in_array($param['name'], array('money','section','st','et')) ? $param['name'] : 'created_at';
        }else{
            $name = 'created_at';
        }
        if($query){
            $data = $this->where($query)
                        ->orderBy($name,$sort)
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
        }else{
            $data = $this->orderBy($name,$sort)
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
        }
        return $data;
    }

    /**
     * 统计所有合同条数
     * @param $param
     * @return int
     */
    public function countLists($param){
        $query = [];
        if(!empty($param['st'])){
            $query[] = ['st', '>=', strtotime($param['st'])];
        }
        if(!empty($param['et'])){
            $query[] = ['et', '<=', strtotime($param['et'])];
        }
        if(!empty($param['type'])){
            $query[] = ['type',(int)$param['type']];
        }
        if(!empty($param['section'])){
            $op = $param['sop'] == 'lt' ? '<' : ($param['op'] == 'gt' ?  '>' : '=');
            $query[] = ['section', $op, (int)$param['section']];
        }
        if(!empty($param['money'])){
            $op = $param['mop'] == 'lt' ? '<' : '>';
            $query[] = ['money', $op, (float)$param['money']];
        }
        if(!empty($param['sort'])){
            $sort = $param['sort'] == 'desc' ? 'desc' : 'asc';
        }else{
            $sort = 'desc';
        }
        if(!empty($param['name'])){
            $name = in_array($param['name'], array('money','section','st','et')) ? $param['name'] : 'created_at';
        }else{
            $name = 'created_at';
        }
        if($query){
            $data = $this->where($query)
                ->orderBy($name,$sort)
                ->count('id');
        }else{
            $data = $this->orderBy($name,$sort)
                ->count('id');
        }
        return $data;
    }
}
