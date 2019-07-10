<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Advclass extends Common
{
    public function index( $id = 0, $tab = 0 ){
        $infoList = Db::name('advclass')->order('id')->select();
        $this->assign('infoList',$infoList);
        // 编辑
        if( 3 == $tab ) {
            $info = db('advclass')->where('id',$id)->find();
            $this->assign('info',$info);
        }

        return view();
    }


    //添加
    public function add() {
        if(request()->isPost()) {
            $data = input('post.');
            if(trim($data['title']=='')){
                 return error('分类名称不能为空!');
            }
            $id = Db::name('advclass')->strict(false)->insertGetId($data);       

            return success('添加成功!',url('index',['tab'=>1]));
        }
    }

    //删除
    public function delete($id = 0) {
		
        if(Db::name('advclass')->where('id',$id)->delete()){
            return success('删除成功!',url('index',['tab'=>1]));
        }else{
            return error('删除失败!');
        }
    }

    // 编辑
    public function edit( $id = 0) {
        if(request()->isPost()) {
            $data = input('post.');
            if(trim($data['title']=='')){
                 return error('分类名称不能为空!');
            }
            $result = db('advclass')->where('id',$id)->strict(false)->update($data);
            if($result !== false){
                return success('编辑成功!',url('index'));
            }else{
                return error('编辑失败!');
            }
        }
    }
	//单文件异步上传
    public function upload_image(){
        //图片上传
        $file = request()->file(input('name'));
        $info = $file->move(ROOT_PATH . 'public/uploads');
        if($info) {
            return json_encode($info->getSaveName());
        }
    }
}
