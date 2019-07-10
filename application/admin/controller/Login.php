<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Login extends  Controller
{
    public function index()
    {
		if(request()->isPost()){
			$user = input('post.username');
			$pwd = input('post.password');
			$info = Db::name('user')->where('username',$user)->find();
			if($info){
				if($info['password']==md5($pwd)){
					session('uid',$info['id']);
					return success("登录成功",url("index/index"));
				}else{
					return error("密码错误！",url("login/index"));
				}
			}else{
				return error("用户不存在！",url("login/index"));
			}
			
		}
		return view();
    }

    public function loginout()
	{
		session(null);
		$this->redirect('login/index');
	}
}
