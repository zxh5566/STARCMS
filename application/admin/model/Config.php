<?php
namespace app\admin\model;
use think\Model;

class Config extends Model
{
    public function saveConfig($data){
        if(empty($data) && !is_array($data)){
            return false;
        }
        foreach($data as $k=>$v){
            if(empty($k)){
                continue;
            }
			if($k=='siteico'){
			copy(ROOT_PATH.'public/uploads/'.$v,ROOT_PATH.'favicon.ico');
			}
            config::where('varname',$k)->update(['value'=>trim($v)]);
            //$this->save(['value'=>trim($v)],['varname'=>$k]); value值重复的时候，只执行一次
        }
        return true;
    }
}