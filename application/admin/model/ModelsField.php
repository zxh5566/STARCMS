<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class ModelsField extends Model
{
    //添加字段
    public function addField($data){
        //对字段参数进行序列化
        $setting = $data['setting'];
        $data['setting'] = serialize($setting);

        if(isset($setting['defaultvalue'])){
            $defaultvalue = $setting['defaultvalue'];
        }
        //模型ID
        $modelid = $data['modelid'];
        //根据模型ID获取模型名
        $modelname = Db::name('models')->where('id',$modelid)->value('tablename');
        //获取数据表前缀
        $dbPrefix = config('database.prefix');
        //获取副表名
        $tablename = $dbPrefix.$modelname;
        //字段名
        $fieldname = $data['field'];

        //检测当前模型下字段名是否重复
        $count = Db::name('models_field')->where('field',$fieldname)->where('modelid',$modelid)->count();
        if($count){
            return -1;
        }else{
            //添加新字段
            $modelsfield = new ModelsField;
            if($modelsfield->allowField(true)->save($data)){
                //添加副表字段
                switch($data['formtype']){
                    case "text":
                        $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` VARCHAR(255) NOT NULL DEFAULT '{$defaultvalue}' ";
                        Db::execute($sql);
                        break;
                    case "textarea":
                        $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` TEXT";
                        Db::execute($sql);
                        break;
                    case "editor":
                        $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` TEXT";
                        Db::execute($sql);
                        break;
                    case "box":
                        if($setting[fieldtype]=='varchar'){
                            $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` VARCHAR(100) NOT NULL DEFAULT '{$defaultvalue}' ";
                        }elseif($setting[fieldtype]=='int'){
                            $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` TINYINT(1) NOT NULL DEFAULT '{$defaultvalue}' ";
                        }
                        Db::execute($sql);
                        break;
                    case "image":
                        $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` VARCHAR(255) NOT NULL DEFAULT '' ";
                        Db::execute($sql);
                        break;
                    case "images":
                        $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` TEXT";
                        Db::execute($sql);
                        break;
                    case "number":
                        $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` INT";
                        Db::execute($sql);
                        break;
                    case "datetime":
                        if($setting[fieldtype]=='date'){
                            $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` DATE";
                        }elseif($setting[fieldtype]=='datetime'){
                            $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` DATETIME";
                        }
                        Db::execute($sql);
                        break;
                    case "downfile":
                        $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` VARCHAR(255) NOT NULL DEFAULT '' ";
                        Db::execute($sql);
                        break;
                    case "downfiles":
                        $sql = "ALTER TABLE `{$tablename}` ADD `{$fieldname}` TEXT";
                        Db::execute($sql);
                        break;
                }
                return 1;
            }else{
                return -2;
            }
        }
    }
	
	/**
     * [deleteField 删除字段，需删除models_field表中记录以及副表相应字段]
     * @param  [int] $fieldid [字段ID]
     * @return [int]          [状态码]
     */
    public function deleteField($fieldid){
        $info = Db::name('models_field')->where('id',$fieldid)->find();
        if(empty($info)){
            return -1; //该字段不存在
            exit;
        }
        //判断副表是否存在
        $modelid = $info['modelid'];
        $modelname = Db::name('models')->where('id',$modelid)->value('tablename');
        if(!table_exists($modelname)){
            return -2; //副表不存在
            exit;
        }

        //判断是否允许删除
        if(1 == $info['issystem']){
            return -3; //该字段不允许被删除
            exit;
        }else{
            //判断副表字段是否存在
            if(field_exists($modelname,$info['field'])){
                //删除models_field表中记录
                Db::name('models_field')->where('id',$fieldid)->delete();
                //删除副表中相应字段
                $dbPrefix = config('database.prefix');
                Db::execute("ALTER TABLE `{$dbPrefix}{$modelname}` DROP COLUMN `{$info['field']}` ;");
            }else {
                return -1; //该字段不存在
                exit;
            }
        }

    }

  /**
     * [editField 编辑字段实现]
     * @param  [array] $data [提交的表单信息]
     * @return [type]       [成功返回true，失败返回false]
     */
    public function editField($data){
        //对字段参数进行序列化
        $setting = $data['setting'];
        $data['setting'] = serialize($setting);

        if(isset($setting['defaultvalue'])){
            $defaultvalue = $setting['defaultvalue'];
        }
        //模型ID
        $modelid = $data['modelid'];
        //根据模型ID获取模型名
        $modelname = Db::name('models')->where('id',$modelid)->value('tablename');
        //获取数据表前缀
        $dbPrefix = config('database.prefix');
        //获取副表名
        $tablename = $dbPrefix.$modelname;
        //字段名
        $fieldname = $data['field'];

        //获取原字段名称
        $oldFieldname = Db::name('models_field')->where('id',$data['id'])->value('field');
        $modelsfield = new ModelsField;
        if($modelsfield->allowField(true)->isUpdate()->save($data)){
            //判断字段名有无修改，修改则需要改副表中相应字段名
            if($oldFieldname!=$fieldname){
                //修改副表字段名
                switch($data['formtype']){
                    case "text":
                        $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` VARCHAR(255) NOT NULL DEFAULT '{$defaultvalue}' ";
                        Db::execute($sql);
                        break;
                    case "textarea":
                        $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` TEXT";
                        Db::execute($sql);
                        break;
                    case "editor":
                        $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` TEXT";
                        Db::execute($sql);
                        break;
                    case "box":
                        if($setting[fieldtype]=='varchar'){
                            $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` VARCHAR(100) NOT NULL DEFAULT '{$defaultvalue}' ";
                        }elseif($setting[fieldtype]=='int'){
                            $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` TINYINT(1) NOT NULL DEFAULT '{$defaultvalue}' ";
                        }
                        Db::execute($sql);
                        break;
                    case "image":
                        $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` VARCHAR(255) NOT NULL DEFAULT '' ";
                        Db::execute($sql);
                        break;
                    case "images":
                        $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` TEXT";
                        Db::execute($sql);
                        break;
                    case "number":
                        $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` INT";
                        Db::execute($sql);
                        break;
                    case "datetime":
                        if($setting[fieldtype]=='date'){
                            $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` DATE";
                        }elseif($setting[fieldtype]=='datetime'){
                            $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` DATETIME";
                        }
                        Db::execute($sql);
                        break;
                    case "downfile":
                        $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` VARCHAR(255) NOT NULL DEFAULT '' ";
                        Db::execute($sql);
                        break;
                    case "downfiles":
                        $sql = "ALTER TABLE `{$tablename}` CHANGE `{$oldFieldname}` `{$fieldname}` TEXT";
                        Db::execute($sql);
                        break;
                }
                return true;
            }
            return true;
        }else{
            return false; //编辑失败
        }
    }

}