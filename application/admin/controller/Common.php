<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use util\Auth;

class Common extends Controller
{
    public function _initialize() {
        // 用户未登录则跳转前台登录页面
        if(session('uid') == null){
            session(null);
            $this->redirect('admin/login/index');
        }
    }


}
