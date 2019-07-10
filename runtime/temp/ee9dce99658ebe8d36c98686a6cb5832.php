<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\Apache24\htdocs\starcms./application/admin\view\content\content.html";i:1534658485;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H+ 后台主题UI框架 - 树形视图</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/public/static/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/public/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/public/static/admin/css/admin.css" rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo !empty($catname)?$catname : '暂无'; ?>列表</h5>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="<?php echo url('deleteAll'); ?>" data-type="ajax">
                <input type="hidden" name="catid" value="<?php echo $infoList[0]['catid']; ?>" />
                <div class='m-b-xs'><div class='btn-group' id='exampleTableEventsToolbar' role='group'>
                    <a class='btn btn-sm btn-outline btn-default' title='添加' target='_parent' href='<?php echo url('add',['id'=>input('id',0)]); ?>'>
                        <i class='glyphicon glyphicon-plus' aria-hidden='true'></i></a>
                        <button type='submit' class='btn btn-sm btn-outline btn-default' title='删除'>
                        <i class='glyphicon glyphicon-trash' aria-hidden='true'></i></button>
                        </div></div>
                <div class="table-responsive">
                    <table id="dataTables-example" class="table table-striped">
                        <thead>
                            <tr>
                                <th><input id="isCheckAll" type="checkbox" class="i-checks"></th>
                                <th>ID</th>
                                <th>标题</th>
                                <th>发布人</th>
                                <th>发布时间</th>
                                <th>浏览量</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                         <?php if(is_array($infoList) || $infoList instanceof \think\Collection || $infoList instanceof \think\Paginator): $i = 0; $__LIST__ = $infoList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr>
                    <td><input type="checkbox" class="i-checks" name="ids[<?php echo $vo['id']; ?>]"></td>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php echo mb_substr($vo['title'],0,20,utf8); ?></td>
                    <td><?php echo $vo['username']; ?></td>
                    <td><?php echo $vo['inputtime']; ?></td>
                    <td><?php echo $vo['views']; ?></td>
                    <td>
                    <a href="<?php echo url('edit',['id'=>$vo['id'],'catid'=>$vo['catid']]); ?>" title='编辑' target='_parent'><i class='fa fa-edit text-navy'></i></a>&nbsp;&nbsp;
                    <a name='delete' href="<?php echo url('delete',['id'=>$vo['id']]); ?>" title='删除'><i class='fa fa-trash-o text-navy'></i></a>
                    </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                </div>
            </form>
             <?php if($infoList): ?> <?php echo $infoList->render(); endif; ?>
        </div>
    </div>

    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/public/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/public/static/admin/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/public/static/admin/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="/public/static/admin/js/content.min.js?v=1.0.0"></script>
    <script src="/public/static/admin/js/plugins/iCheck/icheck.min.js"></script>
    <script>
       /* $(document).ready(function() {
            $("#dataTables-example").dataTable({
                "serverSide": true, //从服务器端获取数据
                "ajax": {
                    "url": "<?php echo url('getDataTables',['id'=>input('id')]); ?>",
                    "data": function(d) {
                        d.extra_search = "title|username";
                    }
                },
                "ordering": false, //禁用全局排序
                "order": [0, '`listorder` desc'],
                "lengthMenu": [20, 50, 100],
                // "dom": '<l <"#normalToos">f>t<ip>',
                "dom": "<'row'<'#normalToos.col-xs-4'><'col-xs-8'f>>" +
                    "<'row'<'col-xs-12't>>" +
                    "<'row'<'col-xs-6'li><'col-xs-6'p>>",
                "language": {
                    "zeroRecords": "没有检索到数据",
                    "lengthMenu": "每页 _MENU_ 条记录&nbsp;&nbsp;",
                    "search": "搜索 ",
                    "info": "共 _PAGES_ 页，_TOTAL_ 条记录，当前显示 _START_ 到 _END_ 条",
                    "paginate": {
                        "previous": "上一页",
                        "next": "下一页",
                    }
                },
                "columns": [{
                    render: function(data, type, row, meta) {
                        return '<input type="checkbox" class="i-checks" name="ids[' + row.id + ']">';
                    }
                }, {
                    data: "id"
                }, {
                    data: "title"
                }, {
                    data: "username"
                }, {
                    data: "inputtime"
                }, {
                    data: "views"
                }, {
                    data: "operate"
                }, ],
                "drawCallback": function() {
                    normal_init();
                },
                "initComplete": function() {
                    $("#normalToos").append("<div class='m-b-xs'>" +
                        "<div class='btn-group' id='exampleTableEventsToolbar' role='group'>" +
                        "<a class='btn btn-sm btn-outline btn-default' title='添加' target='_parent' href='<?php echo url('add',['id'=>input('id',0)]); ?>'>" +
                        "<i class='glyphicon glyphicon-plus' aria-hidden='true'></i></a>" +
                        "<button type='submit' class='btn btn-sm btn-outline btn-default' title='删除'>" +
                        "<i class='glyphicon glyphicon-trash' aria-hidden='true'></i></button></div></div>");
                }
            });

        });*/
    </script>
    <script src="/public/static/admin/js/plugins/layer/layer.min.js"></script>
    <script src="/public/static/admin/js/layer_hplus.js"></script>
</body>

</html>
