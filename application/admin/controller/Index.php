<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Menu;

class Index extends  Common
{
    public function index()
    {
		$menuArray = db('menu')->order('listorder')->select();
        $menuTree = Menu::tree($menuArray);
        // dump($menuTree);
        $this->assign('menu',$menuTree);
		return view();
    }

    public function content(){
          // 判断权限
        if(!checkAuth()){
            session(null);
            $this->redirect('admin/login/index');
        }
        return view();
    }
}
