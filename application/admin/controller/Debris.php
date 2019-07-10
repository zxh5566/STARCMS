<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Debris extends Common
{
	public function index()
	{

        // 判断权限
        if(!checkAuth()){
            echo "<script>parent.window.location.href='/admin/index/index';</script>";
            exit;
        }
			$debris = Db::name('debris')->select();
			foreach($debris as $k=>$v){
				if($v['type']==1){
					$debris[$k]['type'] = '文本'; 
				}elseif($v['type']==2){
					$debris[$k]['type'] = '编辑器'; 
				}elseif($v['type']==3){
					$debris[$k]['type'] = '图片'; 
				}
			}
			$this->assign('debris',$debris);
			
			//编辑数据
			$id = input('id');
			$debris_info = Db::name('debris')->where("id",$id)->find();
			$this->assign('debris_info',$debris_info);
		
		return view();
	}
	//删除
	public function delete(){
		
		// 判断权限
		if(!checkAuth()){
			return error('您没有相应的操作权限!');
		}
		
		$id = input('id');
		$ret = Db::name("debris")->where('id',$id)->delete();
		if($ret){
			return success("删除成功",url("index",array('tab'=>1)));
		}else{
			return error("删除失败",url("index",array('tab'=>1)));
		}
	}
	
	//添加
	public function add($tab = 1)
	{
		if(request()->isPost()){
		// 判断权限
		if(!checkAuth()){
			return error('您没有相应的操作权限!');
		}
			//print_r(input('post.'));exit;
			$data = array();
			if(input('post.varname')==''){
				return error("变量名称不能为空！");
			}
			if(input('post.title')==''){
				return error("名称不能为空！");
			}
			if(input('post.content')==''){
				return error("值不能为空！");
			}
			$data['varname'] = input('post.varname');
			$data['title'] = input('post.title');
			$data['content'] = input('post.content');
			$data['type'] = input('post.type');
            if(Db::name('debris')->strict(true)->insert($data)){
                return success('碎片添加成功!',url('index',array('tab'=>1)));
            }else{
                return error('碎片添加失败!',url('index',array('tab'=>$tab)));
            }
		}
	}
	//修改    
	public function edit($tab = 1, $id = 0){
        if(request()->isPost()){
		// 判断权限
		if(!checkAuth()){
			return error('您没有相应的操作权限!');
		}
            // 编辑分类
            $data = array();
			$data['varname'] = input('post.varname');
			$data['title'] = input('post.title');
			$data['content'] = input('post.content');
            if(Db::name('debris')->where('id', $id)->update($data)){
                return success('杂项编辑成功!',url('index',array('tab'=>1)));
            }else{
                return error('杂项未修改或编辑失败!');
            }
        }
    }
	
	   
}