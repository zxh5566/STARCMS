<?php
namespace app\index\taglib;
use think\template\TagLib;

class PC extends Taglib{
	
// 标签定义
protected $tags = array(
	'article' => array('attr' => 'catid,row,flag,orderby,orderway','close' => 1),
	'focus' => array('attr' => 'catid,row,orderby,orderway','close' => 1),
	'sys'=>array('attr'=>'key','close'=>0),
	'debris' => array('attr' => 'key','close' => 0),

);

//系统标签
public function tagSys($tag){
$key = $tag['key'];
$where = "varname='".$key."'";
	$php = <<<php
<?php
\$ret = think\Db::name('config')->where("$where")->value("value");
?>
php;
$parse .=$php;
$parse .='{$ret}';

return $parse;
}

//焦点图标签
public function tagFocus($tag, $content){
	$where = "catid=" . $tag['catid'];
	$row = empty($tag['row'])? 5 : $tag['row'];
	$orderby = empty($tag['orderby']) ? 'id' : $tag['orderby'];
	$orderway = empty($tag['orderway']) ? 'asc' : $tag['orderway'];
	$php = <<<php
<?php
\$advs = think\Db::name('adv')->where("$where")->limit($row)->order("$orderby $orderway")->select();
\$__LIST__ = \$advs;
?>
php;
	$parse .=$php;
	$parse .='{volist name="__LIST__" id="vo"}';
	$parse .= $content;
	$parse .= '{/volist}';
	return $parse;
}

//杂项标签
	public function tagDebris($tag){
		$key = $tag['key'];
		$where = "varname='".$key."'";
		$php = <<<php
<?php
\$ret = think\Db::name('debris')->where("$where")->value("content");
?>
php;
		$parse .=$php;
		$parse .='{$ret}';

		return $parse;
	}

//文章标签
public function tagArticle($tag, $content){
	if($tag['catid']=='0'){
		$where = '';
	}else{
		$where = "catid=" . $tag['catid'];
	}
	$row = empty($tag['row'])? 5 : $tag['row']; 
	$flag = empty($tag['flag'])? '' : $tag['flag'];
	if($flag){
		if($flag=='r'){
			if($tag['catid']=='0'){
				$where = " recommended = 1 ";
			}else{
				$where .= " and recommended = 1";
			}
		}elseif($flag=='p'){
			if($tag['catid']=='0'){
				$where = " thumb <> '' ";
			}else{
				$where .= " and thumb <> ''";
			}
		}elseif($flag=='h'){
			if($tag['catid']=='0'){
				$where = " headlines=1";
			}else{
				$where .= " and headlines=1";
			}
		}
	}
	$orderby = empty($tag['orderby']) ? 'id' : $tag['orderby'];
	$orderway = empty($tag['orderway']) ? 'asc' : $tag['orderway'];
	$php = <<<php
<?php
\$article = think\Db::name('article')->alias('a')->where("$where")->field('a.id,catid,title,description,inputtime,a.listorder,thumb,views,catname')->join('sfox_category b','a.catid = b.id','left')->limit($row)->order("$orderby $orderway")->select();
\$__LIST__ = \$article;
?>
php;
    $parse .=$php;
    $parse .='{volist name="__LIST__" id="vo"}';
  	$parse .= $content;
    $parse .= '{/volist}';
    return $parse;
	
}




}