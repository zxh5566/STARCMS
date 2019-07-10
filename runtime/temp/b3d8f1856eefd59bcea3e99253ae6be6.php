<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\Apache24\htdocs\starcms./application/admin\view\content\add.html";i:1562425556;}*/ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>H+ 后台主题UI框架 - 信息发布</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/public/static/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/public/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/public/static/admin/plugins/webuploader-0.1.5/webuploader.css" rel="stylesheet">
    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/public/static/admin/js/ajaxfileupload.js"></script>
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
              <div class="tabs-container">
                  <ul class="nav nav-tabs">
                      <li><a href="<?php echo url('content/index',['id'=>input('id')]); ?>"><i class="fa fa-mail-reply text-navy"></i>返回内容管理</a></li>
                      <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">信息发布</a>
                      </li>
                  </ul>
                  <div class="tab-content">
                      <div id="tab-1" class="tab-pane active">
                          <div class="panel-body">
                            <form method="post" class="form-horizontal" action="<?php echo url('add'); ?>" enctype="multipart/form-data" data-type="">
                                <input type="hidden" name="catid" value="<?php echo input('id'); ?>" />

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">分类</label>
                                    <div class="col-sm-10 control-label" style="text-align:left">
                                        <?php echo $catname; ?>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <?php if(is_array($forminfos) || $forminfos instanceof \think\Collection || $forminfos instanceof \think\Paginator): $i = 0; $__LIST__ = $forminfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <div class="form-group" <?php if($vo['formtype'] == 'datetime'): ?>id="data_1"<?php endif; ?>>
                                        <label class="col-sm-2 control-label"><?php echo $vo['name']; ?></label>
                                        <div class="col-sm-10">
                                            <?php echo $vo['form']; ?>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                <?php endforeach; endif; else: echo "" ;endif; ?>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary" type="submit">提交</button>
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

    <script src="/public/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/public/static/admin/js/content.min.js?v=1.0.0"></script>
    <script src="/public/static/admin/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/public/static/admin/js/plugins/layer/layer.min.js"></script>
    <script src="/public/static/admin/js/layer_hplus.js"></script>
    <script src="/public/static/admin/js/plugins/layer/layer.min.js"></script>
    <script src="/public/static/admin/js/plugins/prettyfile/bootstrap-prettyfile.js"></script>
    <script src="/public/static/admin/js/plugins/cropper/cropper.min.js"></script>
    <script src="/public/static/admin/js/demo/form-advanced-demo.min.js"></script>
    <script src="/public/static/admin/js/plugins/layer/laydate/laydate.js"></script>

</body>

</html>
