<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Authrole extends Common
{
    public function index($id=0, $tab=1){
        //获取角色信息
        $authrolelist = Db::name('auth_group')->order('id')->select();
        $this->assign('authrolelist',$authrolelist);

        // 编辑角色
        if(3==$tab){
            $info = Db::name('auth_group')->where('id',$id)->find();
            if($info!=null && is_array($info)){
                $this->assign('info',$info);
            }
        }

        return view();
    }

    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            if(trim($data['title']=='')){
                return error('角色名称不能为空！');
                exit();
            }
            //添加新角色
            Db::name('auth_group')->strict(false)->insert($data);
            return success('新角色添加成功!',url('index',['tab'=>1]));
        }
    }

    public function edit(){
        if(request()->isPost()){
            $data = input('post.');
            if(trim($data['title']=='')){
                return error('角色名称不能为空！');
                exit();
            }
            //编辑新角色
            Db::name('auth_group')->strict(false)->update($data);
            return success('角色编辑成功!',url('index',['tab'=>1]));
        }
    }

    public function delete($id = 0){
        if(Db::name('auth_group')->where('id', $id)->delete()){
            return success('删除成功!',url('index',['tab'=>1]));
        }else{
            return error('删除失败!',url('index',['tab'=>1]));
        }
    }
	public function authset($id = 0) {
	if(request()->isPost()){
		$data = input('post.');
		Db::name('auth_group')->strict(false)->update($data);
		return successIframe('权限设置成功!');
	}else{
		// 获取当前角色所有规则
		$rules =Db::name('auth_group')->where('id',$id)->value('rules');
		//规则转数组
		$rules = explode(',',$rules);
		// 获取规则
		$result = Db::name('auth_rule')->order('listorder')->select();
		$json = array();
		foreach ($result as $value) {
			$data = array(
				'id' => $value['id'],
				'parent' => $value['pid']==0 ? '#' : $value['pid'],
				'text' => $value['title'],
				'state' => ['opened' => true, 'selected' => in_array($value['id'],$rules)? true : false]
			);
			$json[] = $data;
		}
		$this->assign('json', json_encode($json));

		return view();
	}
}
}
