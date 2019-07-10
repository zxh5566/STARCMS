<?php
namespace app\admin\model;
use think\Db;
use think\Model;


class Content extends Model
{
    //添加
	public function addContent($data) {
        //dump($data);
        if(empty($data) || !is_array($data)) {
            return false;
        }

        $tablename = getModInfoById($data['catid'], 'tablename');//表名
        $data['info']['catid'] = $data['catid'];

        //checkbox和multiple处理
        foreach ($data['info'] as $key => $value) {
            if(is_array($value)){
                $data['info'][$key] = implode(',',$value);  //2,3
            }
        }

        if(Db::name($tablename)->insert($data['info'])) {			
			$id = Db::name($tablename)->getLastInsID();
			createInfo($id,$data['catid']);
			createCategory($tablename,$data['catid']);
            return true;
        }else {
            return false;
        }
    }
	//编辑
	public function editContent($data) {
        //dump($data);
        if(empty($data) || !is_array($data)) {
            return false;
        }

        $tablename = getModInfoById($data['catid'], 'tablename');//表名
        $data['info']['catid'] = $data['catid'];
        $data['info']['id'] = $data['id'];

        //checkbox和multiple处理
        foreach ($data['info'] as $key => $value) {
            if(is_array($value)){
                $data['info'][$key] = implode(',',$value);  //2,3
            }
        }

        if(Db::name($tablename)->update($data['info'])) {
            return true;
        }else {
            return false;
        }
    }
}
