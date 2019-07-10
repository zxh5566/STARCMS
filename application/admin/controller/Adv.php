<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Adv extends Common
{
    public function index( $id = 0, $tab = 0 ){
		$category = Db::name('advclass')->select();
        $infoList = Db::name('adv')->field('a.*,w.title')->alias('a')->join('sfox_advclass w','a.catid = w.id')->order('listorder,id')->select();
        $this->assign('infoList',$infoList);
		$this->assign('category',$category);
        // 编辑
        if( 3 == $tab ) {
            $info = db('adv')->where('id',$id)->find();
            $this->assign('info',$info);
        }

        return view();
    }
	//排序
    public function sort() {
        if(request()->isPost()){
            foreach (input('post.listorder/a') as $key => $value) {
                Db::name('adv')->where('id',$key)->update(['listorder'=>$value]);
            }
            return success('排序更新成功!',url('index',['tab'=>$tab]));
        }
    }
    //添加
    public function add() {
        if(request()->isPost()) {
            $data = input('post.');
			if($data['catid']==0){
		   	return error('请选择广告分类!');
		   }
            $id = Db::name('adv')->strict(false)->insertGetId($data);       
            return success('添加成功!',url('index',['tab'=>1]));
        }
    }

    //删除
    public function delete($id = 0) {
		$thumb = Db::name('adv')->where('id',$id)->value('thumb');
		$thumb = ROOT_PATH."public/uploads/".$thumb;
 		if(file_exists($thumb)){
			@unlink($thumb);
		}
		
        if(Db::name('adv')->where('id',$id)->delete()){
            return success('信息删除成功!',url('index',['tab'=>1]));
        }else{
            return error('删除失败!');
        }
    }

    // 编辑
    public function edit( $id = 0) {
        if(request()->isPost()) {
            $data = input('post.');
			if($data['catid']==0){
		   	return error('请选择广告分类!');
		   }
            $result = db('adv')->where('id',$id)->strict(false)->update($data);
            if($result !== false){
                return success('编辑成功!',url('index'));
            }else{
                return error('编辑失败!');
            }
        }
    }

}
