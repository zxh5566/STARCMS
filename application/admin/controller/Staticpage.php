<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Staticpage extends Common
{
    protected $domain = '';

    public function _initialize(){
        $this->domain = "http://" . input('server.HTTP_HOST'); // 获取域名
    }

   //关闭静态（删除index.html)
   public function delIndex(){

   		if(request()->isPost()){
            if(is_file(ROOT_PATH.'/public/index.html')){
				@unlink(ROOT_PATH.'/public/index.html');
			}elseif(is_file(ROOT_PATH.'/index.html')){
				@unlink(ROOT_PATH.'/index.html');
			}
            return success('静态已关闭！');
        }else{
            return view();
        }
   
   }

 //生成首页
    public function index(){
        if(request()->isPost()){
            $visitUrl = 'index';
            $createName = 'index.html';
			if(is_file(ROOT_PATH.'/public/index.html')){
				@unlink(ROOT_PATH.'/public/index.html');
			}elseif(is_file(ROOT_PATH.'/index.html')){
				@unlink(ROOT_PATH.'/index.html');
			}
            $this->createHtml($visitUrl, $createName);
            return success('首页生成成功！');
        }else{
            return view();
        }
    }
//生成列表页
    public function createCategory(){
        if(request()->isPost()){
            // http://studyfoxcms.studyfox.cn/category_28_1.shtml
            $ids = Db::name('category')->where('modelid','neq',0)->where('cattype','<>',4)->column('id');
            foreach ($ids as $id) {
                // 根据分类ID获取相应数据表名
                $tablename = getModInfoById($id, 'tablename');
                // 获取数据表中相应分类记录数，再计算出页数
                $count = Db::name($tablename)->where('catid', $id)->count();
                if($count){
                    $num = ceil($count/2); //进一取整函数
                    for($i = 1; $i<$num+1; $i++){
                        $visitUrl = 'category/id/'.$id.'?page='.$i;
                        $createName = 'category_'.$id.'_'.$i.'.shtml';
                        $this->createHtml($visitUrl, $createName, true, $id);
                    }
                }else{
					$visitUrl = 'category/id/'.$id;
					$createName = 'category_'.$id.'_1.shtml';
					$this->createHtml($visitUrl, $createName);
				}
            }
            return success('分类页生成成功！');
        }
    }
//生成详情页
    public function createInfo(){
        if(request()->isPost()){
            // 获取模型中所有的tablename
            $models = Db::name('models')->column('tablename');
            foreach ($models as $name) {
                $lists = Db::name($name)->field('id,catid')->select();
                if(count($lists)){
                    foreach ($lists as $value) {
                        $visitUrl = 'info/id/'.$value['id'].'/catid/'.$value['catid'];
                        $createName = 'show_'.$value['catid'].'_'.$value['id'].'.shtml';
                        $this->createHtml($visitUrl, $createName);
                    }
                }
            }
            return success('内容页生成成功！');
        }
    }

    public function createHtml($visitUrl, $createName, $hasPage = false, $catid = 0){
        $url = $this->domain . '/index.php/index/index/' . $visitUrl; //动态页面地址
		//echo $url;exit;
		if($visitUrl=='index'){
       		 $fn = ROOT_PATH . 'public/' . $createName; //生成文件名
		}else{
			 $fn = ROOT_PATH . 'public/html/' . $createName; //生成文件名
		}
        $content = $this->getFile($url);

			$regex = '/index\.php\/index\/index\/info\/catid\/(\d+)\/id\/(\d+)\.html/iU';
			$replacement = 'public/html/show_$1_$2.shtml';
			$content = preg_replace($regex,$replacement,$content);
			$regex = '/index\.php\/index\/index\/category\/id\/(\d+)\.html/iU';
			$replacement = 'public/html/category_$1_1.shtml';
			$content = preg_replace($regex,$replacement,$content);

        if($hasPage){
            $content = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='category_".$catid."_$1.shtml'>$2</a>", $content);
        }
        $fs = fopen($fn, 'w');
        fwrite($fs, $content);
    }
	
	public function getFile($url=''){
		$ch = curl_init();
		$timeout = 10; // set to zero for no timeout
		curl_setopt ($ch, CURLOPT_URL,$url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$str = curl_exec($ch);
		return $str;
	}
}
