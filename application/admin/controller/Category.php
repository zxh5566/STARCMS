<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use util\Tree;
use app\admin\model\Category as CategoryModel;

class Category extends Common
{
	public function index()
	{
        // 判断权限
        if(!checkAuth()){
            echo "<script>parent.window.location.href='/admin/index/index';</script>";
            exit;
        }
		//echo ROOT_PATH . 'public/uploads';exit;

			$category = Db::name('category')->field("a.*,b.name")->alias('a')->join('models b ','a.modelid= b.id','LEFT')->order('listorder')->select();
			$tree = new Tree();
			$tree->tree($category,'id','parentid','catname');
			$categoryArray = $tree->getArray();
			$this->assign('category',$categoryArray);
			//添加分类中的模型列表
			$models = Db::name("models")->field("id,name")->order("sort")->select();
			$this->assign('models',$models);
			//编辑数据
			$id = input('id');
			$category_info = Db::name('category')->where("id",$id)->find();
			$this->assign('category_info',$category_info);

		return view();
	}
	
    public function sort() {
        if(request()->isPost()){
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
            foreach (input('post.listorder/a') as $key => $value) {
                Db::name('category')->where('id',$key)->update(['listorder'=>$value]);
            }
            return success('排序更新成功!',url('index'));
        }
    }
	
	//删除
	public function delete(){
		// 判断权限
		if(!checkAuth()){
			return error('您没有相应的操作权限!');
		}
		$id = input('id');
		$son = Db::name("category")->where('parentid',$id)->select();
		if($son){
			return error("请先删除子分类",url("index",array('tab'=>1))); //有子分类的不能删除
		}
		$isend = Db::name("category")->where('id',$id)->value('isend');
		if($isend){ //分类下有内容的不能删除
			$data = Db::name('article')->where('catid',$id)->count();
			if($data){
				return error("请先删除该分类下文章",url("index",array('tab'=>1)));
			}
		}
		$thumb = Db::name("category")->where('id',$id)->value('catthumb');
		if($thumb){
			@unlink(ROOT_PATH.'public/uploads/'.$thumb);
		}
		$banner = Db::name("category")->where('id',$id)->value('catbanner');
		if($banner){
			@unlink(ROOT_PATH.'public/uploads/'.$banner);
		}
		$ret = Db::name("category")->where('id',$id)->delete();
		if($ret){
			return success("分类删除成功",url("index",array('tab'=>1)));
		}else{
			return error("分类删除失败",url("index",array('tab'=>1)));
		}
	}
	
	//添加
	public function add($tab = 1)
	{
		if(request()->isPost()){
			
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
			$_data = input('post.');
			if(input('post.modelid')==0){
				return error("请选择模型！");
			}
			if(input('post.cattype')==0 && input('post.isend')==1){
				return error("请选择分类类型！");
			}
			if(input('post.catname')==''){
				return error("分类名称不能为空！");
			}
			if(input('post.catdir')==''){
				return error("分类目录不能为空！");
			}
			$catcount = Db::name('category')->where('catname',input('post.catname'))->where('parentid',$_data['parentid'])->count();
			if($catcount){
				return error("分类名称已存在！");
			}
			$dircount = Db::name('category')->where('catdir',input('post.catdir'))->count();
			if($dircount){
				return error("分类目录已存在！");
			}
			//设置分类level，用来设置几级分类
			if($_data['parentid']==0){
				$_data['level'] = 1;
			}else{
				$_levle = Db::name('category')->where(array('id'=>$_data['parentid']))->value('level');
				$_data['level'] = $_levle + 1;
				if($_data['level'] == 4 ){ //如果级别为4，就设置终极分类
					$_data['isend'] = 1;
				}
			}
			if(input('post.isend')!=1){
				$_data['cattype'] = 0;
			}
			$categoryModel = new CategoryModel($_data);
			// 过滤$_data数组中的非数据表字段数据
            if($categoryModel->allowField(true)->save()){
                return success('分类添加成功!',url('index',array('tab'=>1)));
            }else{
                return error('分类添加失败!',url('index',array('tab'=>$tab)));
            }
		}
	}
	//修改    
	public function edit($tab = 1, $id = 0){
        if(request()->isPost()){
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
			$_data = input('post.');
			$_pid = $_data['parentid'];
			if(input('post.modelid')==0){
				return error("请选择模型！");
			}
			if(input('post.cattype')==0 && input('post.isend')==1){
				return error("请选择分类类型！");
			}
			if(input('post.catname')==''){
				return error("分类名称不能为空！");
			}
			if(input('post.catdir')==''){
				return error("分类目录不能为空！");
			}
            // 检查分类名称和分类目录是否重名
            $count_one = Db::name('category')->where([
			'catname'=>input('post.catname'),
			'id'=>['<>',$id],
			'parentid'=>$_pid
			])->count();
            $count_two = Db::name('category')->where('id','<>',$id)->where('catdir',input('post.catdir'))->count();
            if($count_one){
                return error('分类名称重名!');
            }else if($count_two){
                return error('分类目录重名!');
            }
			
			//设置分类leve
			if($_data['parentid']==0){
				$_data['level'] = 1;
			}else{
				$_levle = Db::name('category')->where(array('id'=>$_data['parentid']))->value('level');
				$_data['level'] = $_levle + 1;
				if($_data['level'] == 4 ){//如果级别为4，就设置终极分类
					$_data['isend'] = 1;
				}
			}
			if(input('post.isend')!=1){
				$_data['cattype'] = 0;
			}
            // 编辑分类
            $categoryModel = new CategoryModel;
            if($categoryModel->allowField(true)->isUpdate()->save($_data)){
                return success('分类编辑成功!',url('index',array('tab'=>1)));
            }else{
                return error('分类信息未修改或编辑失败!');
            }
        }
    }

}