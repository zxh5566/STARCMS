<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class Models extends Model
{
	
	const newModelSql = './data/sfox_newmodel.sql';
    protected $insert = array('addtime');
    //addtime修改器
    protected function setAddtimeAttr($value){
        return date('Y-m-d H:i:s');
    }
	
	//返回数组格式的全部表名
    public function list_tables(){
        $tables = array();
        $data = Db::query('SHOW TABLES');
		
        foreach ($data as $value) {
            $tables[] = $value['Tables_in_'.config('database.database')];
        }
        return $tables;
    }
	
    public function addModel($data){
        if(empty($data)){
            return false;
        }else{
            //第1步：新增models数据表记录
            if($this->allowField(true)->save($data)){
                //第2步：在models_field数据表中添加公共字段信息
                $dbPrefix = config('database.prefix');//获取表前缀
                //读取新模型公共字段的SQL文件
                $newModelSql = file_get_contents(self::newModelSql);
                //表前缀的替换
                $sqlSplit = str_replace(array('@cmsprefix@','@modelid@','@cmstablename@'),array($dbPrefix,$this->id,$data['tablename']),$newModelSql);
                //批量执行sql
                $sqlSplitArray = explode('--',$sqlSplit);
                foreach ($sqlSplitArray as $value) {
                    Db::execute($value);
                }
                return true;
            }else{
                return false;
            }
        }
    }
	
	//删除独立数据表
    public function deleteTable($tablename){
        //获取下数据表前缀
        $dbPrefix = config('database.prefix');
        Db::execute("DROP TABLE `{$dbPrefix}{$tablename}`;");
        return true;
    }
	 //编辑独立数据表名
    public function editTableName($oldTableName,$newTableName){
        //获取数据表前缀
        $dbPrefix = config('database.prefix');
        Db::execute("RENAME TABLE `{$dbPrefix}{$oldTableName}` TO `{$dbPrefix}{$newTableName}` ;");
        return true;
    }
}