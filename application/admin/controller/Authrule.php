<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use util\Tree;
use app\admin\model\Authrule as AuthruleModel;

class Authrule extends Common
{
    public function index($tab = 1, $id = 0){
        if(request()->isPost()){
            foreach (input('post.listorder/a') as $key => $value) {
                Db::name('auth_rule')->where('id',$key)->update(['listorder'=>$value]);
            }
            return success('排序更新成功!',url('index',['tab'=>$tab]));
        }else{
            $authruleArray = AuthruleModel::order('listorder')->select();
            foreach ($authruleArray as $key => $value) {
                $authruleList[] = $value->toArray(); //对象转数组
            }
            $tree = new Tree();
            $tree->tree($authruleList,'id','pid','title');
            $authrule = $tree->getArray();
            $this->assign('authrule',$authrule);

            // 编辑规则
            if( 3 == $tab ){
                // 获取所要编辑菜单的信息
                $info = Db::name('auth_rule')->where('id',$id)->find();
                if($info!=null && is_array($info)){
                    $this->assign('info',$info);
                }
            }
        }
        return view();
    }

    public function add($tab = 1){
        if(request()->isPost()){
            $authruleModel = new AuthruleModel;
            if($authruleModel->allowField(true)->save(input('post.'))){
                return success('新规则添加成功!',url('index',['tab'=>1]));
            }else{
                return error('规则添加失败!',url('index',['tab'=>$tab]));
            }
        }
    }

    public function delete($id = 0){
        if(Db::name('auth_rule')->where('id', $id)->delete()){
            return success('删除成功!',url('index',['tab'=>1]));
        }else{
            return error('删除失败!',url('index',['tab'=>1]));
        }
    }

    public function edit($tab = 1, $id = 0){
        if(request()->isPost()){
            $authrule_form = input('post.');
            //判断child状态
            if(input('post.child')==null){
                $authrule_form['child'] = 0;
                $count = Db::name('auth_rule')->where('pid',$id)->count();
                if($count){
                    return error('该规则拥有子项，无法取消勾选!');
                }
            }
            // 编辑规则
            $authruleModel = new AuthruleModel;
            if($authruleModel->allowField(true)->isUpdate()->save($authrule_form)){
                return success('规则编辑成功!',url('index',['tab'=>1]));
            }else{
                return error('规则信息未修改或编辑失败!');
            }
        }
    }
}
