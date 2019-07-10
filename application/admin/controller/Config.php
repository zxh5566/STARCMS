<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Config as ConfigModel;
use think\Db;
class Config extends  Common
{
    public function index()
    {
        // 判断权限
        if(!checkAuth()){
            echo "<script>parent.window.location.href='/admin/index/index';</script>";
            exit;
        }
		$tab = input('tab'); //提交表单中包含的隐藏字段tab，用来辨别是哪个选项卡
		$configlist = ConfigModel::column('varname,value');
		$mail = Db::name('options')->where('id',1)->value('option_val');
		if($mail){
			$mail = json_decode($mail,true);
		}else{
			$mail = array();
		}
		$handler = opendir("./application/index/view/");
		while($file = readdir($handler)){
			if($file!='.' && $file!='..'){
				$files[]['name'] = $file;
			}
		}
		$this->assign("filename",$files);
		$this->assign('mail',$mail);
        $this->assign('configlist',$configlist);
        return view();
    }
	
   public function edit($tab = "1") {
        if(request()->isPost()){
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
            $config = new ConfigModel;
            if($config->saveConfig(input('post.'))){
                return success('配置更新成功!',url('index',['tab'=>$tab]));
            }else{
                return error('配置更新失败!',url('index',['tab'=>$tab]));
            }
        }
    }
	//邮箱配置
	public function setMail(){
		$tab = input('tab');
		if(request()->isPost()){
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
		   $data = input('post.');
           unset($data['tab']);
           if(Db::name('options')->where('id',1)->setField('option_val',json_encode($data))){
				return success("邮箱配置更新成功",url("index",array('tab'=>$tab)));
            }else{
				return error("邮箱配置更新失败",url("index",array('tab'=>tab)));
            }

        }
	}
	//七牛配置
	public function setQiniu(){
		$tab = input('tab');
		if(request()->isPost()){
			// 判断权限
			if(!checkAuth()){
				return error('您没有相应的操作权限!');
			}
		   $data = input('post.');
		   unset($data['tab']);
		   if(Db::name('options')->where('id',2)->setField('option_val',json_encode($data))){
				return success("七牛配置更新成功",url("index",array('tab'=>$tab)));
			}else{
				return error("七牛配置更新失败",url("index",array('tab'=>tab)));
			}
	
		}
	}
	
	//阿里短信配置
	
	
	
	
	
	//单文件异步上传
    public function upload_image(){
        //图片上传
        $file = request()->file(input('name'));
        $info = $file->move(ROOT_PATH . 'public/uploads');
        if($info) {
            return json_encode($info->getSaveName());
			//return $info->getSaveName();
        }
    }
	
}