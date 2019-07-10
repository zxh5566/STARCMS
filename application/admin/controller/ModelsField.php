<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\ModelsField as ModelsFieldModel;

class ModelsField extends Common
{
    public function index($tab=1, $id=0, $fid=0){
		
        // 判断权限
        if(!checkAuth()){
            echo "<script>parent.window.location.href='/admin/index/index';</script>";
            exit;
        }
		
        //$id模型ID $fid字段ID

            $modelsFieldArray = Db::name('models_field')->where('modelid',$id)->order('sort')->select();
			$modelName = Db::name('models')->where('id',$id)->value('name');
            $this->assign('modelsfield',$modelsFieldArray);
			$this->assign('modelName',$modelName);
			
			 //编辑字段
            if($fid){
                //获取当前字段信息
                $fieldinfo = Db::name('models_field')->where('id',$fid)->find();
                $setting = unserialize($fieldinfo['setting']);
                $this->assign('setting',$setting);

                //打开缓冲区
                ob_start();
                //引入字段编辑模板文件
                include APP_PATH . 'admin/view/models_field/setting/' . $fieldinfo['formtype'] . '/field_edit.html';
                $data_setting = ob_get_contents();
                //清空缓冲区并关闭输出缓冲
                ob_end_clean();

                $fieldinfo['setting'] = $data_setting;
                $this->assign('fieldinfo',$fieldinfo);
            }
			 
            $this->assign('total_num',count($info));
            $this->assign('forminfos',$info);

        return view();
    }
    public function sort($tab=1, $id=0) {
        //$id模型ID
        if(request()->isPost()){
            // 判断权限
            if(!checkAuth()){
                return error('您没有相应的操作权限!');
            }

            foreach (input('post.sort/a') as $key => $value) {
                Db::name('models_field')->where('id',$key)->update(['sort'=>$value]);
            }
            return success('排序更新成功！',url('index',array('tab'=>$tab,'id'=>$id)));
        }
    }
	
	//添加新字段
    public function add(){
		
		// 判断权限
		if(!checkAuth()){
			return error('您没有相应的操作权限!');
		}
		
        $data = input('post.');
        //模型ID
        $modelid = $data['modelid'];
        //实例化字段模型
        $modelsfieldModel = new ModelsFieldModel;
        if(request()->isPost()){
            $resultId = $modelsfieldModel->addField($data);
            switch ($resultId) {
                case -1:
                    return error('字段名已存在！');
                    break;
                case -2:
                    return error('新字段添加失败！');
                    break;

                default:
                    return success('新字段添加成功！',url('index',array('id'=>$modelid,'tab'=>1)));
                    break;
            }
        }
    }
	 /**
     * [delete 删除字段]
     * @param  integer $id [字段ID]
     * @return [type]      [提示信息]
     */
    public function delete($id=0, $modelid=0){
        if(0 == $id){
            return error('该字段不存在');
        }
        //实例化字段模型
        $modelsfield = new ModelsFieldModel;
        $resultId = $modelsfield->deleteField($id);//返回状态码
        switch ($resultId) {
            case -1:
                return error('该字段不存在!');
                break;
            case -2:
                return error('数据表不存在!');
                break;
            case -3:
                return error('该字段不允许被删除!');
                break;

            default:
                return success('字段删除成功',url('index',array('id'=>$modelid,'tab'=>1)));
                break;
        }
    }
	 /**
     * [edit 编辑字段]
     * @return [type]       [提示信息]
     */
    public function edit($tab=1,$id=0){
        $data = input('post.');
        if(trim($data['field'])==''){
            return error('字段名不能为空!');
            exit;
        }

        //实例化字段模型
        $modelsfield = new ModelsFieldModel;

        //判断字段名和别名是否存在，采用字段串条件查询，配合预处理机制
        if($modelsfield::where("id!=:id AND (field=:field OR name=:name)")->bind(['id'=>$id,'field'=>$data['field'],'name'=>$data['name']])->count()){
            return error('字段名已经存在!');
            exit;
        }

        if(request()->isPost()){
            if($modelsfield->editField($data)){
                return success('字段编辑成功!',url('index',array('id'=>input('post.modelid'),'tab'=>1)));
            }else{
                return error('字段修改失败!');
            }
        }
    }
	 // 参数设置，返回json格式，需调取不同字段模板文件
    public function field_setting($fieldtype=''){
        //打开缓冲区
        ob_start();

        //引入字段模板文件
        include APP_PATH . 'admin/view/models_field/setting/' . $fieldtype . '/field_add.html';
        $data_setting = ob_get_contents();

        //清空缓冲区并关闭输出缓冲
        ob_end_clean();

        //转数组格式
        $settings = array('setting'=>$data_setting);

        echo json_encode($settings);
    }
}
