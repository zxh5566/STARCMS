<?php
namespace app\admin\model;

use think\Model;

class Menu extends Model
{
    // 无限级分类，开发使用
    public static function tree($data){
        $tree = array();
    
        //第1步，将所有菜单项的ID作为数组下标
        foreach ($data as $value) {
            $tree[$value['id']] = $value;
        }

        //利用引用的方式，将每个子菜单项添加到父类son的数组中，只需遍历一次
        foreach ($tree as $key => $value){
            $tree[$value['parentid']]['son'][] = &$tree[$key];
		}

        $tree = isset($tree[0]['son']) ? $tree[0]['son'] :array();
        //print_r($tree);exit;
		    
        return $tree;
    }
}