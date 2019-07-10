<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Menu;
use app\admin\model\Content as ContentModel;

class Content extends Common
{
    public function index($id=0)
    {
       // 判断权限
        if(!checkAuth()){
            echo "<script>parent.window.location.href='/admin/index/index';</script>";
            exit;
        }
		if(!$id){
		   $ids = Db::name('category')->field('id')->where('cattype',['<>',3],['<>',4],'and')->where('isend',1)->order('listorder')->select();
		   foreach($ids as $k=>$v){
			    $_table = getModInfoById($v['id'], 'tablename');
				$datas = Db::name($_table)->where('catid',$v['id'])->select();
				if($datas){
					$id = $v['id'];
					break;
				}
		   }
		   //dump($ids);exit;
		}
		//获取分类树
        $categoryArray = Db::name('category')->where('cattype',['<>',3],['<>',4],'and')->order('listorder')->select();
        $categoryList = Menu::tree($categoryArray);
        $this->assign('categoryList',$categoryList);
		$this->assign('id',$id);
        return view();
    }

    public function content($id = 0)
    {
        
		// 判断权限
		if(!checkAuth()){
			$id = 0;
			echo "<script src='/static/admin/js/jquery.min.js?v=2.1.4'></script>".
				"<script>$(document).ready(function(){ layer.open({content: '您没有相应的操作权限!',btn: ['确定'],icon: 2,shade: 0.1}); });</script>";
		}
		if(!$id){
		   $ids = Db::name('category')->field('id')->where('cattype',['<>',3],['<>',4],'and')->where('isend',1)->order('listorder')->select();
		   foreach($ids as $k=>$v){
			    $_table = getModInfoById($v['id'], 'tablename');
				$datas = Db::name($_table)->where('catid',$v['id'])->select();
				if($datas){
					$id = $v['id'];
					break;
				}
		   }
		   //dump($ids);exit;
		}
 		// 获取表名
		$tablename = getModInfoById($id, 'tablename');
		$infoList = Db::name($tablename)->where('catid',$id)->paginate(12);
		//$infoList = Db::name($tablename)->where('catid',$id)->select();

		$catname = getCatInfoById($id, 'catname');
		$this->assign('catname',$catname);
		$this->assign('infoList',$infoList);
        return view();
    }

    public function delete($catid = 0, $id = 0){
        // 判断权限
        if(!checkAuth()){
            return error('您没有相应的操作权限!');
        }
        // 获取表名
        $tablename = getModInfoById($catid, 'tablename');
        if(Db::name($tablename)->where('id',$id)->delete()){
            return success('删除成功!',url('content',['id'=>$catid]));
        }else{
            return error('删除失败!');
        }
    }

    // 批量删除
    public function deleteAll(){
        // 判断权限
        if(!checkAuth()){
            return error('您没有相应的操作权限!');
        }
        $catid = input('post.catid');
        // 获取表名
        $tablename = getModInfoById($catid, 'tablename');
		$data = input('post.ids/a');
        if (empty($data)) {
            return error('请选中需要删除的数据!');
        }
        foreach ($data as $id => $value) {
            Db::name($tablename)->where('id',$id)->delete();
        }
        return success('删除成功!',url('content',['id'=>$catid]));
    }

    // datatables插件请求地址
    public function getDataTables($id = 0) {
        // 请求数据
        // draw:1 请求次数
        // columns[0][data]:0 设置列的数据源，即如何从整个Table的数据源(object / array)中获得
        // columns[0][name]: 为列设定一个别名，用不到
        // columns[0][searchable]:true 在该列上允许或者禁止过滤搜索记录
        // columns[0][orderable]:true 在该列上允许或者禁止排序功能
        // columns[0][search][value]: 该列的搜索条件
        // columns[0][search][regex]:false 允许或者禁止对在搜索字符串中出现的正则表达式字符强制编码，用不到
        // listorder[0][column]:0 指定排序的列
        // listorder[0][dir]:asc 指定排序列的方式：升序或降序
        // start:0 起始下标
        // length:10 每页记录数
        // search[value]: 全局搜索条件
        // search[regex]:false 允许或者禁止对在搜索字符串中出现的正则表达式字符强制编码

        // 返回数据
        // "draw": 请求次数
        // "recordsTotal": 数据总数
        // "recordsFiltered": 过滤之后的记录总数
        // "data": 返回数据

        if($id){
            //获取请求过来的数据
            $getParam = request()->param();

            $draw = $getParam['draw'];

            //排序
            $orderSql = $getParam['listorder'][0]['dir'];

            //自定义查询参数
            $extra_search = $getParam['extra_search'];

            // 获取表名
            $tablename = getModInfoById($id, 'tablename');
            // 总记录数
            $recordsTotal = Db::name($tablename)->where('catid',$id)->count();
            //过滤条件后的总记录数
            $search = $getParam['search']['value'];
            $recordsFiltered = strlen($search) ?  Db::name($tablename)->where('catid',$id)->where($extra_search,'like','%'.$search.'%')->count() : $recordsTotal;

            //分页
            $start = $getParam['start']; //起始下标
            $length = $getParam['length']; //每页显示记录数

            //根据开始下标计算出当前页
            $page = intval($start/$length) + 1;
            $config = ['page'=>$page, 'list_rows'=>$length];
            $list = Db::name($tablename)->where('catid',$id)->where($extra_search,'like','%'.$search.'%')->order($orderSql)->paginate(null,false,$config);
            $lists = [];
            if(!empty($list)){
                foreach ($list as $key => $value) {
                    $lists[$key] = $value;
                    $lists[$key]['operate'] = "<a href='". url('edit',['id'=>$value['id'], 'catid'=>$value['catid']]) ."' title='编辑' target='_parent'><i class='fa fa-edit text-navy'></i></a>&nbsp;&nbsp;
                    <a name='delete' href='". url('delete',['id'=>$value['id'], 'catid'=>$value['catid']]) ."' title='删除'><i class='fa fa-trash-o text-navy'></i></a>";
                }
            }
        } else{
            $draw = 1;
            $recordsTotal = 0;
            $recordsFiltered = 0;
            $lists = [];
        }

        $data = array(
            "draw"=>$draw,
            "recordsTotal"=>$recordsTotal, //数据总数
            "recordsFiltered"=>$recordsFiltered, //过滤之后的记录总数
            "data"=>$lists
        );

        echo json_encode($data);
    }

    //信息发布
    public function add($id=0) {
        if(request()->isPost()) {
           $content = new ContentModel;
           if($content->addContent(input('post.'))) {
             return success('信息发布成功!',url('index',['id'=>input('post.catid')]));
           } else {
             return error('信息发布失败!');
           }
        }elseif($id == 0){
           return $this->error ('请选择左侧分类！');
        } else {
          //根据分类ID获取模型ID
          $modelid = getModInfoById($id,'id');
          $modelsFieldArray = Db::name('models_field')->where('modelid',$modelid)->order('sort')->select();
          foreach ($modelsFieldArray as $value) {
              //字段名
              $field = $value['field'];
              //字段类型
              $func = $value['formtype'];

              //判断函数是否存在
              if(function_exists($func)){
                  //获取表单HTML代码
                  $form = $func($value);

                  if($form != ''){
                      $info[$field] = array(
                          'name' => $value['name'],
                          'form' => $form,
                          'formtype' => $value['formtype']
                      );
                  }
              }
          }
          $this->assign('forminfos',$info);
          $catname = getCatInfoById($id,'catname');//分类名称
          $this->assign('catname',$catname);
          return view();
        }
    }

    //编辑功能
    public function edit( $catid= 0, $id = 0) {
        if(request()->isPost()) {
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }
           $content = new ContentModel;
           if($content->editContent(input('post.'))) {
             return success('信息编辑成功!',url('index',['id'=>input('post.catid')]));
           } else {
             return error('信息编辑失败!');
           }
        }else {
          //获取数据
          $tablename = getModInfoById($catid,'tablename');
          $article = Db::name($tablename)->where('id',$id)->find();

          //根据分类ID获取模型ID
          $modelid = getModInfoById($catid,'id');
          $modelsFieldArray = Db::name('models_field')->where('modelid',$modelid)->order('sort')->select();
          foreach ($modelsFieldArray as $value) {
              //字段名
              $field = $value['field'];
              //字段类型
              $func = $value['formtype'];

              $value['realvalue'] = $article[$field];

              //判断函数是否存在
              if(function_exists($func)){
                  //获取表单HTML代码
                  $form = $func($value);

                  if($form != ''){
                      $info[$field] = array(
                          'name' => $value['name'],
                          'form' => $form,
                          'formtype' => $value['formtype']
                      );
                  }
              }
          }
          $this->assign('forminfos',$info);
          //分类名称
          $catname = getCatInfoById($catid,'catname');
          $this->assign('catname',$catname);
          return view();
        }
    }


   

}
