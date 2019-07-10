<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\Apache24\htdocs\starcms./application/admin\view\content\index.html";i:1534658799;}*/ ?>
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
    <link href="/public/static/admin/css/plugins/jsTree/style.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <style>

	</style>
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content  animated fadeInRight">

        <div class="row">
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>分类</h5>
                    </div>
                    <div class="ibox-content">

                        <div id="jstree">
                        <?php if(is_array($categoryList) || $categoryList instanceof \think\Collection || $categoryList instanceof \think\Paginator): $i = 0; $__LIST__ = $categoryList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <ul>
                            <?php if($vo['isend'] == 1): ?>
                            <li data-jstree='{"type":"html"}'> <a class="<?php if(input('id',0) == $vo['id']): ?>jstree-clicked<?php endif; ?>" href="<?php echo url('content',['id'=>$vo['id']]); ?>"><?php echo $vo['catname']; ?></a></li>
                            <?php else: ?>
                                <li class="jstree-open"><?php echo $vo['catname']; if(is_array($vo['son']) || $vo['son'] instanceof \think\Collection || $vo['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voson): $mod = ($i % 2 );++$i;?>
                                    <ul>
                                    <?php if($voson['isend'] == 1): ?>
                            <li data-jstree='{"type":"html"}'> <a class="<?php if(input('id',0) == $voson['id']): ?>jstree-clicked<?php endif; ?>" href="<?php echo url('content',['id'=>$voson['id']]); ?>"><?php echo $voson['catname']; ?></a></li>
                            <?php else: ?>
                                        <li class="jstree-open"><?php echo $voson['catname']; if(is_array($voson['son']) || $voson['son'] instanceof \think\Collection || $voson['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $voson['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voson1): $mod = ($i % 2 );++$i;?>
                                            <ul>
                                            <?php if($voson1['isend'] == 1): ?>
                            <li data-jstree='{"type":"html"}'> <a class="<?php if(input('id',0) == $voson1['id']): ?>jstree-clicked<?php endif; ?>" href="<?php echo url('content',['id'=>$voson1['id']]); ?>"><?php echo $voson1['catname']; ?></a></li>
                                             <?php else: ?>   
                                             <li class="jstree-open"><?php echo $voson1['catname']; ?>
                                             <ul>
                                             <?php if(is_array($voson1['son']) || $voson1['son'] instanceof \think\Collection || $voson1['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $voson1['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voson2): $mod = ($i % 2 );++$i;?>
                                             <li data-jstree='{"type":"html"}'> <a class="<?php if(input('id',0) == $voson2['id']): ?>jstree-clicked<?php endif; ?>" href="<?php echo url('content',['id'=>$voson2['id']]); ?>"><?php echo $voson2['catname']; ?></a></li>
                                             <?php endforeach; endif; else: echo "" ;endif; ?>
                                             </ul>
                                             </li>
											 <?php endif; ?>
                                            </ul>
                                         <?php endforeach; endif; else: echo "" ;endif; ?> 
                                        </li>
                                         <?php endif; ?>
                                    </ul>
                                   <?php endforeach; endif; else: echo "" ;endif; ?> 
                                </li>
                                <?php endif; ?>
                            </ul>
                             <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-9">
  <iframe id="iframe_content" src="<?php echo url('content',['id'=>$id]); ?>" style="width:100%;" frameborder="0" scrolling="atuo" onload="changeFrameHeight()"></iframe>
            </div>
        </div>
    </div>
    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/public/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/public/static/admin/js/content.min.js?v=1.0.0"></script>
    <script src="/public/static/admin/js/plugins/jsTree/jstree.min.js"></script>
    <style>
        .jstree-open>.jstree-anchor>.fa-folder:before {
            content: "\f07c"
        }

        .jstree-default .jstree-icon.none {
            width: 0
        }
    </style>
    <script>
	//去除滚动条
	 function changeFrameHeight() {
            document.getElementById("iframe_content").height = document.documentElement.clientHeight - 44;
        };
        window.onresize = function() {
            changeFrameHeight();
        }
        $(document).ready(function() {
            $("#jstree")
                .on('changed.jstree', function(e, data) { //点击事件
                    var url = $('#' + data.node.id).children('a').attr('href');//通过点击的li标签的id获取链接地址
                    if (url != '#') {
                        $('#iframe_content').attr('src', url);
                    }
                })
                 .on('select_node.jstree', function(e, data) {
                    if (data.node.id == 'j1_1') {
                        if (data.instance.is_open(data.instance.get_next_dom(data.node))) {
                            var i, j;
                            for (i = 0, j = data.node.children.length; i < j; i++) {
                                data.instance.close_node(data.node.children[i]);
                            }
                        } else {
                            data.instance.open_all(data.node);
                        }
                    } else {
                        data.instance.toggle_node(data.node);
                    }
                })
                .jstree({
                    "core": {
                        "check_callback": true,
                        "dblclick_toggle": false
                    },
                    "plugins": ["types", "dnd"],
                    "types": {
                        "default": {
                            "icon": "fa fa-folder"
                        },
                        "html": {
                            "icon": "fa fa-file-code-o"
                        },
                        "svg": {
                            "icon": "fa fa-file-picture-o"
                        },
                        "css": {
                            "icon": "fa fa-file-code-o"
                        },
                        "img": {
                            "icon": "fa fa-file-image-o"
                        },
                        "js": {
                            "icon": "fa fa-file-text-o"
                        }
                    }
                });
        });
    </script>
</body>

</html>
