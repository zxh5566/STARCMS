<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Url;
use app\admin\model\Menu;
use app\admin\model\Config as ConfigModel;

class Index extends Controller
{
    
	public $controller = '';
	public $menu = array();
	public $debris = array();
	public $_config = array();
	public $domain = '';
	public $template = '';
	
	public function __construct(){
		$this->_config = $configlist = ConfigModel::column('varname,value');
		$this->template = './application/index/view/'.$this->_config['template'].'/';
		config('template.view_path',$this->template);
		parent::__construct();
		url::root('/index.php'); 
		$this->domain = "http://" . input('server.HTTP_HOST');
		$categoryArray = Db::name('category')->order('listorder')->select();
		foreach($categoryArray as $k=>$v){
			if($v['seturl'] && $v['cattype']==4){
				$categoryArray[$k]['url'] = $v['seturl'];
			}else{
				$categoryArray[$k]['url'] = url('index/category',array('id'=>$v['id']));
			}
		}
		$this->menu = Menu::tree($categoryArray);
		$debris = Db::name('debris')->select();
		$arr = array();
		foreach($debris as $k=>$v){
			if($v['type']==2){
				$debris[$k]['content'] = htmlspecialchars_decode($v['content']);
			}
			$arr[$v['varname']] = $debris[$k]['content'];
		}
		$this->debris = $arr;
		$this->controller = request()->controller();
		$this->assign('menu',$this->menu);
		$this->assign('debris',$this->debris);
		$this->assign('config',$this->_config);
		$this->assign('template',$this->template);
	}
	
	//首页
	public function index()
    {
		
		if(is_file(ROOT_PATH.'/public/index.html')){
			$domain = request()->domain();
		    header("location:".$domain.'/public/index.html');
			exit;
		}
		// 分类文章
        $category = Db::name('category')->where('modelid',1)->order('listorder')->select();
        foreach ($category as $key => $value) {
            $category[$key]['article'] = Db::name('article')->where('catid',$value['id'])->field('id,title,description,thumb,inputtime')->order('listorder desc')->limit(6)->select();
			$category[$key]['rec'] = Db::name('article')->where('catid',$value['id'])->where('recommended',1)->field('id,title,description,thumb,inputtime')->order('listorder desc')->limit(1)->select();
        }   
        $this->assign('category',$category);
		//return view($this->template.'index.html');
		return view();
    }

	//列表页
    public function category(){
        $id = input('id'); //分类ID
		$curCat = getCatInfoById($id); //当前分类信息
        $categoryArray = getCatFamily($id,$this->menu);//当前分类族谱
		//print_r($categoryArray);
		$table = Db::name('models')->where('id',$curCat['modelid'])->value('tablename'); //数据表名称
		$ids = getChildrenIds($id,0);
		$ids[] = $id;
		$ids = implode(',',$ids);
		$pagenums = $this->_config['pnums'];
		if($table){
        $data = Db::name($table)->where('catid','in',$ids)->order('listorder desc')->paginate($pagenums);//分类文章列表
		}
        //echo Db::name('article')->getLastSql();exit;
		
		$cattype = $curCat['cattype']; //列表页类型 1文章列表 2 图片列表 3 栏目介绍
		switch($cattype){
			case 1:
			$template = getModInfoById($id,'list_template');
			break;
			case 2:
			$template = getModInfoById($id,'image_template');
			break;
			case 3:
			$template = getModInfoById($id,'category_template');
			break;
			default:
			$template = getModInfoById($id,'category_template');
		}
		
		$this->assign('id',$id);//分类ID
		$this->assign('info',$curCat);//当前分类信息
		$this->assign('data',$data); //分类文章列表
		$this->assign('category',$categoryArray);//当前分类族谱
        //echo $this->template . $this->controller . DIRECTORY_SEPARATOR . $template;
        return view($this->template . $this->controller . DIRECTORY_SEPARATOR . $template);
    }
	
	//详情页
	public function info(){
		$id = input('id',0);//ID
		$catid = input('catid',0);//分类ID
	    $categoryArray = getCatFamily($catid,$this->menu);
		$modelInfo = getModInfoById($catid);
		$template = $modelInfo['show_template'];
		$info = Db::name($modelInfo['tablename'])->where('id',$id)->find();
		$catinfo = getCatInfoById($catid);
		$p_catname = getCatInfoById($catinfo['parentid'],'catname');
		$this->assign('info',$info);
		$this->assign('catid',$catid);
		$this->assign('catname',$catinfo['catname']);
		$this->assign('p_catname',$p_catname);
		$this->assign('category',$categoryArray);

		return view($this->template. $this->controller . DIRECTORY_SEPARATOR . $template);
    }
	

 
	
}
