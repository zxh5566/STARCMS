<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Models as ModelsModel;
use app\admin\model\Config as ConfigModel;

class Models extends Common
{
	public function index($tab=1,$id=0){
        // 判断权限
        if(!checkAuth()){
            echo "<script>parent.window.location.href='/admin/index/index';</script>";
            exit;
        }
		$modellist = Db::name("models")->order("sort")->select();
		$this->assign('modelslist',$modellist);
        $configlist = ConfigModel::column('varname,value');
        $_dir = './application/index/view/'.$configlist['template'].'/index';
		$handler = opendir($_dir);
		while($file = readdir($handler)){
			if($file!='.' && $file!='..'){
				$files[]['name'] = $file;
			}
		}
		$this->assign("filename",$files);
		 // 编辑模型
        if(3==$tab){
            $info = Db::name('models')->where('id',$id)->find();
            if($info!=null && is_array($info)){
                $this->assign('info',$info);
            }
        }
		return view();
	}
	
	    public function sort() {
        if(request()->isPost()){
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
            foreach (input('post.listorder/a') as $key => $value) {
                Db::name('models')->where('id',$key)->update(['sort'=>$value]);
            }
            return success('排序更新成功!',url('index',['tab'=>$tab]));
        }
    }
	
	public function add($tab=0){
		
		
		if(request()->isPost()){
			
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
			$data = input('post.');
			if($data['tablename']==''){
				return error('新模型表名不能为空！');
				exit();
			}
			//判断新模型是否存在
            $models = new ModelsModel;
            if($models::where('tablename',$data['tablename'])->whereOr('name',$data['name'])->count()){
                return error('模型已经存在!');
                exit();
            }
			//判断新模型数据表是否存在
            $tables = $models->list_tables();
            if(in_array(config('database.prefix').$data['tablename'],$tables)){
                return error('模型数据表已经存在!');
                exit();
            }
			 //添加新模型
            if($models->addModel($data)){
                return success('新模型添加成功!',url('index',array('tab'=>1)));
            }else{
                return error('模型添加失败!');
            }
		}
	}
    //编辑模型
    public function edit($tab=1,$id=0){
        if(request()->isPost()){
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
			
			$data = input('post.');
            if(trim($data['tablename'])==''){
                return error('模型表名不能为空!');
                exit;
            }

            $models = new ModelsModel;
            //判断模型是否存在，采用字段串条件查询，配合预处理机制
            if($models::where("id!=:id AND (tablename=:tablename OR name=:name)")->bind(['id'=>$id,'tablename'=>$data['tablename'],'name'=>$data['name']])->count()){
                return error('模型已经存在!');
                exit;
            }
            //获取原数据库表名
            $oldTableName = Db::name('models')->where('id',$id)->value('tablename');
            //当前提前新表名
            $newTableName = trim(input('post.tablename'));
            $models = new ModelsModel;
            if($models->allowField(true)->isUpdate()->save(input('post.'))){
                //判断数据库表名是否做了修改
                if($oldTableName!=$newTableName){
                    if($models->editTableName($oldTableName,$newTableName)){
                        return success('模型编辑成功!',url('index',['tab'=>1]));
                    }else{
                        return error('模型编辑失败!');
                    }
                }else{
                    return success('模型编辑成功!',url('index',['tab'=>1]));
                }
            }else{
                return error('模型信息未变动或修改失败!');
            }
        }
    }
	  public function delete($id=0,$tablename=''){
		  
        // 判断权限
        if(!checkAuth()){
            return error('您没有相应的操作权限!');
        }
        //$id为当前模型ID,$tablename为模型名

        //1.判断独立数据表是否有数据
        $count = Db::name($tablename)->count();
        if($count){
            //独立数据表有数据，无法删除
            return error('该模型下含有相关内容，无法删除!');
        }else{
            //2.无数据则判断分类表是否关联当前模型，有关联则取消关联
            $count = Db::name('category')->where('modelid',$id)->count();
            if($count){
                Db::name('category')->where('modelid',$id)->setField('modelid',0);
            }
            //最后删除该模型
            if($this->deleteModel($id,$tablename)){
                return success('模型删除成功!',url('index',['tab'=>1]));
            }else{
                return error('模型删除失败!');
            }
        }
    }

    protected function deleteModel($id=0,$tablename=''){
        //1.删除模型表models中记录
        Db::name('models')->where('id',$id)->delete();
        //2.删除models_field当前模型字段
        Db::name('models_field')->where('modelid',$id)->delete();
        //3.删除独立字段表
        $models = new ModelsModel;
        if($models->deleteTable($tablename)){
            return true;
        }else{
            return false;
        }
    }
}