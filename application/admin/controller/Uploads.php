<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Uploads extends Common
{
    
	//站点ico上传
    public function upload_ico(){
        //图片上传
        $file = request()->file(input('name'));
        $info = $file->validate(['ext'=>'ico'])->move(ROOT_PATH . 'public/uploads');
        if($info) {
			$savename = str_replace('\\','/',$info->getSaveName());
            return json_encode($savename);
        }
    }

	//单图片异步上传
    public function upload_image(){
        //图片上传
        $file = request()->file(input('name'));
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public/uploads');
        if($info) {
			$savename = str_replace('\\','/',$info->getSaveName());
            return json_encode($savename);
        }
    }
	 //单文件异步上传
    public function upload_file(){
        //图片上传
        $file = request()->file(input('name'));
        $info = $file->validate(['ext'=>'zip,rar,pdf,jpg,png'])->move(ROOT_PATH . 'public/uploads');
        if($info) {
			$savename = str_replace('\\','/',$info->getSaveName());
            return json_encode($savename);
        }
    }
    //多图片上传
    public function upload_images(){
        $file = request()->file('file');
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public/uploads');
        if($info) {
			$savename = str_replace('\\','/',$info->getSaveName());
            return json_encode($savename);
        }
    }

    //多文件上传
    public function upload_downfiles(){
        $files = request()->file('file');
        foreach ($files as $file) {
            $info = $file->validate(['ext'=>'zip,rar,pdf,jpg,png'])->move(ROOT_PATH . 'public/uploads');
            if($info) {
				$savename = str_replace('\\','/',$info->getSaveName());
                return $savename;
            }
        }
    }

    //删除文件或图片
    public function delete_file(){
        $delete_url = input('img');
        try {
          unlink(ROOT_PATH . 'public/uploads/' . $delete_url);  //删除成功返回1
        } catch (Exception $e) { }
    }
}
