<?php
use think\Db;

//格式化时间
function formattime($time){
	return date('Y-m-d',strtotime($time));
}

//获取分类信息
function getCatInfo($catid,$name=''){
	if($name){
		return Db::name('category')->where('id',$catid)->value($name);
	}else{
		$result = Db::name('category')->where('id',$catid)->find();
		return $result;
	}
}

//获取子孙信息,type=0只获取id,type=1获取所有信息
function getChildrenIds($id,$type=0)
	{
	    $arr = Db::name('category')->order('listorder desc')->select();	
		return getSort($id,$arr,$type);
	}
function getSort($pid=0,$arr=array(),$type=0)
	{
		static $ret = array();
		static $aret = array();
		foreach ($arr as $k=>$v) {
			if ($pid==$v['parentid']) {
				$ret[] = $v['id'];
				$aret[] = $v;
				getSort($v['id'],$arr);
			}
		}
		if($type){
	    return $aret;
		}else{
			return $ret;
		}
	}
	
//获取祖先分类id
function getPa($id=0){
static $arr = array();
$info = Db::name('category')->where('id',$id)->find();
$arr[] = $info['id'];
if($info['parentid']>0){
	getPa($info['parentid']);
}
return $arr;
}



//获取某分类的族谱
function getCatFamily($id=0,$arr=array()){
  $_arr = getPa($id); //获取长辈分类数组
  $length = count($_arr);
  $fcid = $_arr[$length-1];//祖先分类id(parent_id=0)
  $categoryArray = array();	//族系数组
  foreach($arr as $k=>$v){
	  if($v['id']==$fcid){
		  $categoryArray[0] = $v;
	  }
  }
  return $categoryArray;
}


//当前位置
function position($id=0){
	$arr = bredArr($id);
	$arr = array_reverse($arr);
	array_unshift($arr,"<a href='/'>首页</a>");
	$str = implode(' / ',$arr);
	return $str;
}

function bredArr($id=0){
	static $arr = array();
	$info = Db::name('category')->where('id',$id)->find();
	if($info['isend']==1){
		$str = $info['catname'];
	}else{
		$str = "<a href='".url('index/category',array('id'=>$info['id']))."'>".$info['catname']."</a>";
	}
	$arr[] = $str;
	if($info['parentid']>0){
		bredArr($info['parentid']);
	}
	return $arr;
}