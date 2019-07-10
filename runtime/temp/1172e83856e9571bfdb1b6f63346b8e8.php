<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:55:"./application/index/view/default/Index\about_index.html";i:1554465399;s:73:"D:\Apache24\htdocs\starcms\application\index\view\default\index\head.html";i:1552315864;s:73:"D:\Apache24\htdocs\starcms\application\index\view\default\index\foot.html";i:1552222519;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="keywords" content="雪狐CMS内容管理系统">
  <meta name="description" content="雪狐CMS内容管理系统">
  <title>雪狐CMS内容管理系统</title>
  <link rel="shortcut icon" href="./favicon.ico">
  <link rel="apple-touch-icon" href="/public/static/index/default/images/favicon.png" sizes="114x114">
  <!--[if lt IE 9]>
    <script type='text/javascript' src='/public/static/index/default/js/html5-css3.js'></script>
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="/public/static/index/default/css/autoptimize.css" />
  <link rel="stylesheet" type="text/css" href="/public/static/index/default/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/public/static/index/default/css/layui.css" />
  <style>
  .leftmenu{ width:80%; margin:10px auto;}
  .leftmenu h4{ height:30px; line-height:30px;  text-indent:20px;}
  .leftmenu h4 a{ font-weight:bold;}
  .leftmenu .second li{text-indent:20px;}
  .leftmenu .third li a{padding-left:10px; font-size:13px;}
  </style>
  <script type='text/javascript' src='/public/static/index/default/js/push.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/jquery/jquery.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/jquery/jquery-migrate.min.js'></script>
  <script type='text/javascript' src='/public/static/index/default/plugins/nix-gravatar-cache/js/main.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/jquery.min.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/scrollmonitor.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/slides.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/echo.min.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/script.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/flexisel.js'></script>
</head>

<body>
  <div id="page" class="hfeed site">
    <header id="masthead" class="site-header">

      <nav id="top-header">
        <div class="top-nav">
          <div id="user-profile">欢迎访问STARCMS系统！
            <span class="nav-set nav-login">
              <i class="fa fa-user"></i> <a href="#">请登录</a>
              <i class="fa fa-plus-square"></i> <a href="#">我要注册</a>
            </span>
          </div>
        </div>
      </nav>

      <div id="menu-box">
        <div id="top-menu">
          <hgroup class="logo-site">
            <h1 class="site-title">
              <a href="/"> <img src="/public/uploads/<?php
$ret = think\Db::name('config')->where("varname='sitelogo'")->value("value");
?><?php echo $ret; ?>"  width="200" alt="starcms"></a>
            </h1>
          </hgroup>

          <span class="nav-search"><i class="fa fa-search"> </i></span>

          <div id="site-nav-wrap">
            <div id="sidr-close"><a href="#sidr-close" class="toggle-sidr-close">×</a></div>
            <nav id="site-nav" class="main-nav">
              <a href="#" id="navigation-toggle" class="bars"><i class="fa fa-bars"> </i></a>
              <div>
                <ul class="down-menu nav-menu">
                  <li class="current-menu-item"><a rel="nofollow" href="/"><i class="fa fa-home"></i> 首页</a></li>
                  <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <li>
                  <?php if($vo['isend'] == 1): ?>
                    <a href="<?php echo $vo['url']; ?>"> <?php echo $vo['catname']; ?></a>
                   <?php else: ?>
                   <a href="#"> <?php echo $vo['catname']; ?></a>
                   <?php endif; ?>
                    <ul class="sub-menu">
                      <?php if(is_array($vo['son']) || $vo['son'] instanceof \think\Collection || $vo['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?>
                      <li><a href="<?php echo $v1['url']; ?>"> <?php echo $v1['catname']; ?></a></li>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                  </li>
                 <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </header>

    <div id="main-search">
      <div id="searchbar">
        <form action="" id="searchform" name="searchform" method="post">
          <input type="text" id="s" name="keyboard" value="" placeholder="输入搜索内容" required />
          <button id="searchsubmit" type="submit" name="submit">搜索</button>
        </form>
      </div>
      <div class="clear"></div>
    </div>
  </div>



<nav class="breadcrumb">
    <?php echo position($info['id']); ?>
</nav>

  <div id="content" class="site-content">
    <div id="primary" class="content-area">
      <main id="main" class="site-main">
   <article class="post type-post status-publish format-standard hentry category-ality-original tag-ality-original tag-wordpress">
    <header class="entry-header"><h1><?php echo $info['catname']; ?></h1></header>
    <div class="entry-content">
        <div class="single-content"><?php echo $info['catinfo']; ?></div>
        <div class="clear"></div>
        <footer class="single-footer">
            <ul class="single-meta">
                <li class="comment"><a href="#">查看评论</a></li>
                <li class="views">阅读 <?php echo $info['views']; ?></li>
                <li class="r-hide"><a href="javascript:pr()" onclick="javascript:this.innerHTML=(this.innerHTML=='隐藏边栏'?'显示边栏':'隐藏边栏');">隐藏边栏</a></li>
            </ul>
        </footer>
        <div class="clear"></div>
    </div>
</article>
      </main>
    </div>




    <div id="sidebar" class="widget-area">
    
    
          <aside class="widget">
        <h3 class="widget-title"><i class="fa-bars fa"></i>分类目录</h3>
        <div class="leftmenu">
        <?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
          <h4><a href="<?php if($vo['isend'] == 1): ?><?php echo url('category',array('id'=>$vo['id'])); else: ?>#<?php endif; ?>"><?php echo $vo['catname']; ?></a></h4>
          <ul class="second">
          <?php if(is_array($vo['son']) || $vo['son'] instanceof \think\Collection || $vo['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?>
          <li><a href="<?php if($v1['isend'] == 1): ?><?php echo url('category',array('id'=>$v1['id'])); else: ?>#<?php endif; ?>">|--- <?php echo $v1['catname']; ?></a>
          <?php endforeach; endif; else: echo "" ;endif; ?>
          <ul class="third">
          <?php if(is_array($v1['son']) || $v1['son'] instanceof \think\Collection || $v1['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v1['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?>
          <li><a href="<?php if($v2['isend'] == 1): ?><?php echo url('category',array('id'=>$v2['id'])); else: ?>#<?php endif; ?>">|-- <?php echo $v2['catname']; ?></a></li>
          <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          </li>
          </ul>
         <?php endforeach; endif; else: echo "" ;endif; ?>
          </div>
          <div class="clear"></div>
      </aside>
    
    
      <aside class="widget widget_hot_commend">
        <h3 class="widget-title"><i class="fa-bars fa"></i>本类推荐</h3>
        <div id="hot" class="hot_commend">
          <ul>
            {Article:article catid="$id" row="3" flag="r"}
            <li>
              <figure class="thumbnail"><a href="#"><img src="/public/uploads/<?php echo $vo['thumb']; ?>" alt=""></a></figure>
              <div class="hot-title"><a href="#"><?php echo mb_substr($vo['title'],0,10,utf8); ?></a></div>
              <div class="views">阅读 <?php echo $vo['views']; ?></div>
              <i class="fa-thumbs-o-up fa"> 0</i>
            </li>
           {/Article:article}
          </ul>
          <div class="clear"></div>
        </div>
        
      </aside>

      <aside class="widget widget_hot_post">
        <h3 class="widget-title"><i class="fa-bars fa"></i>热门文章</h3>
        <div id="hot_post_widget">
          <ul>
            {Article:article catid="$id" row="5" orderby="views"}
            <li><span class="li-icon li-icon-<?php echo $key+1; ?>"><?php echo $key+1; ?></span><a href="#"><?php echo mb_substr($vo['title'],0,10,utf8); ?></a></li>
            {/Article:article}
          </ul>
        </div>
      </aside>


    </div>

    <div class="clear"></div>


    </div>

  </div>

  <div id="footer-widget-box">
    <div class="footer-widget">

    <aside class="widget widget_nav_menu">
      <div>
        <ul class="menu">
          <li class="menu-item"><a href="#"><i class="fa-indent fa"></i><span class="font-text">测试1</span></a></li>
          <li class="menu-item"><a href="#"><i class="fa-wrench fa"></i><span class="font-text">测试1</span></a></li>
          <li class="menu-item"><a href="#"><i class="fa-file-code-o fa"></i><span class="font-text">测试1</span></a></li>
          <li class="menu-item"><a href="#"><i class="fa-database fa"></i><span class="font-text">测试1</span></a></li>
          <li class="menu-item"><a href="#"><i class="fa-leaf fa"></i><span class="font-text">测试1</span></a></li>
          <li class="menu-item"><a href="#"><i class="fa-desktop fa"></i><span class="font-text">测试1</span></a></li>
          <li class="menu-item"><a href="#"><i class="fa-star-half-o fa"></i><span class="font-text">测试1</span></a></li>
          <li class="menu-item"><a href="#"><i class="fa-envelope-o fa"></i><span class="font-text">测试1</span></a></li>
          <li class="menu-item"><a href="#"><i class="fa-pencil-square-o fa"></i><span class="font-text">测试1</span></a></li>
        </ul>
      </div>
      <div class="clear"></div>
    </aside>
    <div class="clear"></div>
    </div>
  </div>

  <footer id="colophon" class="site-footer">
    <div class="site-info"><?php
$ret = think\Db::name('debris')->where("varname='copyright'")->value("content");
?><?php echo $ret; ?></div>
  </footer>

  <ul id="scroll">
    <li><a class="scroll-t" title="返回顶部"><i class="fa-angle-up fa"></i></a></li>
    <li><a class="scroll-b" title="返回底部"><i class="fa-angle-down fa"></i></a></li>
    <li><a class="qr" title="二维码"><i class="fa-qrcode fa"></i></a></li>
  </ul>
  <span class="qr-img"><img src="/public/static/index/default/images/weixin.png" alt="雪狐网"></span>

  <script type='text/javascript' src='/public/static/index/default/js/superfish.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/infinite-scroll.js'></script>
  <script type='text/javascript' src='/public/static/index/default/js/3dtag.js'></script>
</body>
</html>
