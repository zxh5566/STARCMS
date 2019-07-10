<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class User extends Common
{
    public function index( $id = 0, $tab = 0 ){
        $infoList = Db::name('user')->order('id desc')->select();
        $auth_group = Db::name('auth_group')->column('id,title');

        $this->assign('infoList',$infoList);
        $this->assign('auth_group',$auth_group);

        // 编辑
        if( 3 == $tab ) {
            $info = db('user')->where('id',$id)->find();
            $this->assign('info',$info);
        }

        return view();
    }

    // datatables插件请求地址
    public function getDataTables() {
        // 请求数据
        // draw:1 请求次数
        // columns[0][data]:0 设置列的数据源，即如何从整个Table的数据源(object / array)中获得
        // columns[0][name]: 为列设定一个别名
        // columns[0][searchable]:true 在该列上允许或者禁止过滤搜索记录
        // columns[0][orderable]:true 在该列上允许或者禁止排序功能
        // columns[0][search][value]: 该列的搜索条件
        // columns[0][search][regex]:false 允许或者禁止对在搜索字符串中出现的正则表达式字符强制编码
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

        //获取请求过来的数据
        $getParam = request()->param();

        $draw = $getParam['draw'];

        //排序
        $orderSql = 'id desc';

        //自定义查询参数
        $extra_search = $getParam['extra_search'];

        // 获取表名
        $tablename = 'user';
        // 总记录数
        $recordsTotal = Db::name($tablename)->count();
        //过滤条件后的总记录数
        $search = $getParam['search']['value'];
        $recordsFiltered = strlen($search) ?  Db::name($tablename)->where($extra_search,'like','%'.$search.'%')->count() : $recordsTotal;

        //分页
        $start = $getParam['start']; //起始下标
        $length = $getParam['length']; //每页显示记录数

        //根据开始下标计算出当前页
        $page = intval($start/$length) + 1;
        $config = ['page'=>$page, 'list_rows'=>$length];
        $list = Db::name($tablename)->where($extra_search,'like','%'.$search.'%')->order($orderSql)->paginate(null,false,$config);
        $lists = [];
        if(!empty($list)){
            foreach ($list as $key => $value) {
                $lists[$key] = $value;
                $lists[$key]['status'] = $value['status'] ? '√' : '×';
                $lists[$key]['auth_group_title'] = Db::name('auth_group')->cache(true)->where('id',$value['auth_group_id'])->value('title');
                $lists[$key]['operate'] = "<a href='". url('index',['id'=>$value['id'],'tab'=>3]) ."' title='编辑'><i class='fa fa-edit text-navy'></i></a>&nbsp;&nbsp;
                <a name='delete' href='". url('delete',['id'=>$value['id']]) ."' title='删除'><i class='fa fa-trash-o text-navy'></i></a>";
            }
        }

        $data = array(
            "draw"=>$draw,
            "recordsTotal"=>$recordsTotal, //数据总数
            "recordsFiltered"=>$recordsFiltered, //过滤之后的记录总数
            "data"=>$lists
        );
        echo json_encode($data);
    }

    // 批量删除
    public function deleteAll(){
		$ids = input('post.ids/a');
        if (empty($ids)) {
            return error('请选中需要删除的数据!');
        }
        foreach (input('post.ids/a') as $id => $value) {
            Db::name('user')->where('id',$id)->delete();
            db('auth_group_access')->where('uid',$id)->delete();
        }
        return success('删除成功!',url('index'));
    }

    //添加新用户
    public function add() {
        if(request()->isPost()) {
            $data = input('post.');
			$data['password'] = md5($data['password']);
			$data['register_time'] = date("Y-m-d H:i:s",time());
            $id = Db::name('user')->strict(false)->insertGetId($data);

            //添加角色
            $group_access = ['uid' => $id, 'group_id' => $data['auth_group_id']];
            Db::name('auth_group_access')->insert($group_access);

            return success('新用户添加成功!',url('index',['tab'=>1]));
        }
    }

    //删除单用户
    public function delete($id = 0) {
        if(Db::name('user')->where('id',$id)->delete()){
            // 删除相应角色
            db('auth_group_access')->where('uid',$id)->delete();
            return success('用户删除成功!',url('index',['tab'=>1]));
        }else{
            return error('删除失败!');
        }
    }

    // 编辑用户
    public function edit( $id = 0) {
        if(request()->isPost()) {
            $data = input('post.');
            // 判断密码是否为空
            if(trim($data['password']=='')){
                unset($data['password']);
            }else{
                $data['password']=md5($data['password']);
            }
            $result = db('user')->where('id',$id)->strict(false)->update($data);
            if($result !== false){
                // 如果用户角色有变化做相应修改
                if($data['authGroupId'] != $data['auth_group_id']){
                    db('auth_group_access')->where('uid',$id)->setField('group_id',$data['auth_group_id']);
                }
                return success('用户信息编辑成功!',url('index'));
            }else{
                return error('用户信息编辑失败!');
            }
        }
    }
}
