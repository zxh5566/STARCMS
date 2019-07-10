<?php
namespace app\pluges\controller;
use think\Controller;
use think\Db;

class Test extends Controller
{
	public function index(){
		return view();
	}
	
	//时间插件
	public function datetime(){
		$_d = date("Y-m-d",time());
		$_dt = date("Y-m-d H:i:s",time());
		$this->assign('d',$_d);
		$this->assign('dt',$_dt);
		return view();
	}
	
	//bootstap_fileuploads
	public function fileuploads(){
		return view();
	}
    //多文件上传
    public function upload_downfiles(){
        $files = request()->file('file');
        foreach ($files as $file) {
            $info = $file->move(ROOT_PATH . 'public/uploads');
            if($info) {
                return $info->getSaveName();
            }
        }
    }	

	//单图片异步上传
	public function image(){
		return view();
	}
    //单文件异步上传
    public function upload_image(){
        //图片上传
        $file = request()->file(input('name'));
        $info = $file->move(ROOT_PATH . 'public/uploads');
        if($info) {
            return json_encode($info->getSaveName());
        }
    }
	
		

	
	//webuploader
	public function images(){
		return view();
	}
	//多图片或多文件上传
    public function upload_images(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public/uploads');
        if($info) {
            return json_encode($info->getSaveName());
        }
    }
    //删除文件或图片
    public function delete_file(){
        $delete_url = input('img');
        try {
          @unlink(ROOT_PATH . 'public/uploads/' . $delete_url);  //删除成功返回1
        } catch (Exception $e) { }
    }
	
	//百度编辑器
	public function uedit(){
		return view();
	}
	
}