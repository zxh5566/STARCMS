<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use util\Tree;
use app\admin\model\Menu as MenuModel;

class Menu extends Common
{
     public function index($tab = 1, $id = 0){
        // 判断权限
        if(!checkAuth()){
            echo "<script>parent.window.location.href='/admin/index/index';</script>";
            exit;
        }
        $menuArray = MenuModel::order('listorder')->select();
        foreach ($menuArray as $key => $value) {
            $menuList[] = $value->toArray(); //对象转数组
        }
        $tree = new Tree();
        $tree->tree($menuList,'id','parentid','name');
        $menu = $tree->getArray();
        $this->assign('menu',$menu);

        // 编辑菜单，默认加载
        if( 3 == $tab ){
            // 获取所要编辑菜单的信息
            $info = Db::name('menu')->where('id',$id)->find();
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
                Db::name('menu')->where('id',$key)->update(['listorder'=>$value]);
            }
            return success('排序更新成功!',url('index',['tab'=>$tab]));
        }
    }
	
	//删除
	public function delete(){
		// 判断权限
		if(!checkAuth()){
			return error('您没有相应的操作权限!');
		}
		$id = input('id');
		$son = Db::name("menu")->where('parentid',$id)->select();
		if($son){
			return error("请先删除子菜单",url("index",array('tab'=>1)));
		}
		$ret = Db::name("menu")->where('id',$id)->delete();
		if($ret){
			return success("菜单删除成功",url("index",array('tab'=>1)));
		}else{
			return error("菜单删除失败",url("index",array('tab'=>1)));
		}
	}
	//添加
    public function add($tab = 1){
        if(request()->isPost()){
			// 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
            // 第三层菜单禁止勾选子菜单项
            $parentid = Db::name('menu')->where('id',input('post.parentid'))->value('parentid');
            if($parentid && input('post.child')){
                return error('不能勾选拥有子菜单项!');
            }
            // 检查菜单名称是否重名
            $count = Db::name('menu')->where('name',input('post.name'))->count();
            if($count){
                return error('菜单名称重复!');
            }

            $menuModel = new MenuModel;
            if($menuModel->allowField(true)->save(input('post.'))){
                return success('新菜单添加成功!',url('index',['tab'=>1]));
            }else{
                return error('菜单添加失败!',url('index',['tab'=>$tab]));
            }
        }
    }
	//编辑
	    public function edit($tab = 1, $id = 0){
        if(request()->isPost()){
			// 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
            // 第三层菜单禁止勾选子菜单项
            $parentid = Db::name('menu')->where('id',input('post.parentid'))->value('parentid');
            if($parentid && input('post.child')){
                return error('不能勾选拥有子菜单项!');
            }
            // 检查菜单名称是否重名
            $count = Db::name('menu')->where('id','<>',$id)->where('name',input('post.name'))->count();
            if($count){
                return error('菜单名称重复!');
            }
            $menu_form = input('post.');
            //判断child状态
            if(input('post.child')==0){
                $count = Db::name('menu')->where('parentid',$id)->count();
                if($count){
                    return error('该菜单拥有子菜单项，无法取消勾选!');
                }
            }
            // 编辑菜单
            $menuModel = new MenuModel;
            if($menuModel->allowField(true)->isUpdate()->save($menu_form)){
                return success('菜单编辑成功!',url('index',array('tab'=>1)));
            }else{
                return error('菜单信息未修改或编辑失败!');
            }
        }
    }
}
