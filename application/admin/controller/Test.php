<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Test extends Controller
{
	public function check(){
		$sql = "show tables";
		$ret = Db::query($sql);
		dump($ret);
	}
	
	public function rename()
	{
		rename(ROOT_PATH.'public/uploads/20190406\a23117200778bd0984f330ee2c6d7088.ico',ROOT_PATH.'favicon.ico');
	}
	
	public function replace(){
		$savename = str_replace('\\','/','20190406\45aec8962d51c179f182776304beb057.png');
		echo $savename;
	}
}