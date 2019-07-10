<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\Apache24\htdocs\starcms./application/admin\view\staticpage\index.html";i:1562077496;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>静态生成</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/public/static/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/public/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <div class="tab-content">
                        <div>
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo url('index'); ?>" data-type="ajax">
                                    <input type="hidden" name="tab" value="1" />
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">生成首页</label>
                                        <div class="col-sm-10">
                                            <button class="btn btn-primary" type="submit">生成</button>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                </form>
                                <form method="post" class="form-horizontal" action="<?php echo url('createCategory'); ?>" data-type="ajax">
                                    <input type="hidden" name="tab" value="1" />
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">生成分类页</label>
                                        <div class="col-sm-10">
                                            <button class="btn btn-primary" type="submit">生成</button>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                </form>
                                <form method="post" class="form-horizontal" action="<?php echo url('createInfo'); ?>" data-type="ajax">
                                    <input type="hidden" name="tab" value="1" />
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">生成内容页</label>
                                        <div class="col-sm-10">
                                            <button class="btn btn-primary" type="submit">生成</button>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                </form>
                                <form method="post" class="form-horizontal" action="<?php echo url('delIndex'); ?>" data-type="ajax">
                                    <input type="hidden" name="tab" value="1" />
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">关闭静态</label>
                                        <div class="col-sm-10">
                                            <button class="btn btn-primary" type="submit">关闭</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/public/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/public/static/admin/js/content.min.js?v=1.0.0"></script>
    <script src="/public/static/admin/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/public/static/admin/js/plugins/layer/layer.min.js"></script>
    <script src="/public/static/admin/js/layer_hplus.js"></script>
</body>

</html>
