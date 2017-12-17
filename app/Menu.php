<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $hidden = [
        'created_user_id','updated_user_id','created_at','updated_at'
    ];

    public function roleMenus($role){
        if(!$role)
            return array();
        $menus = $this
                    ->whereIn('id',explode(',',$role))
                    ->where('flag','=','1')
                    ->get()
                    ->toArray();
        $tree = self::makePMenu($menus);
        if($tree){
            foreach ($tree as &$item){
                $item['children'] = self::makeCMenu($menus,(int)$item['id']);
            }
            unset($item);
        }
        return $tree;
    }

    /**
     * 构建一级菜单
     * @param $tree
     * @return array
     */
    private function makePMenu($tree){
        if (!$tree)
            return array();
        $return = array();
        foreach ($tree as &$item){
            if($item['pid'] == 0){
                $return[(int)$item['id']] = $item;
                $item['children'] = array();
            }
        }
        unset($item);
        return $return;
    }

    private function makeCMenu($tree,$pid){
        if (!$tree)
            return array();
        $return = array();
        foreach ($tree as &$item){
            if($item['pid'] == $pid){
                $return[] = $item;
            }
        }
        unset($item);
        return $return;
    }

}
