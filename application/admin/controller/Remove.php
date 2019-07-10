<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Log;

class Remove extends Common
{
    protected $domain = '';

    public function _initialize(){
        
    }

    public function index(){
       return view();
    }
    //清除应用缓存
    public function removeCache(){
        if(request()->isPost()){
           $dir = TEMP_PATH;
		   $handle = opendir($dir);
    	   while (($file = readdir($handle)) !== false) {
          		if ($file != "." && $file != "..") {
            		@unlink("$dir/$file");
        		}
   		  }
		  if (readdir($handle) == false) {
			  closedir($handle);
		  }
        }
            return success('缓存清除成功！');
    }
    //清除应用日志
    public function removeLog(){
        if(request()->isPost()){
		   $path = LOG_PATH;
		   $this->del_dir($path);
			 Log::clear();
        }
        return success('日志清除成功！');
    }

  public function del_dir($dir) {
    if (!is_dir($dir)) {
        return false;
    }
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != "..") {
            is_dir("$dir/$file") ? $this->del_dir("$dir/$file") : @unlink("$dir/$file");
        }
    }
    if (readdir($handle) == false) {
        closedir($handle);
        @rmdir($dir);
    }
  }
  
  
}
