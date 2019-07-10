<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:49:"./application/index/view/default/index\index.html";i:1554462988;s:73:"D:\Apache24\htdocs\starcms\application\index\view\default\index\head.html";i:1552315864;s:73:"D:\Apache24\htdocs\starcms\application\index\view\default\index\foot.html";i:1552222519;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php
$ret = think\Db::name('config')->where("varname='sitename'")->value("value");
?><?php echo $ret; ?></title>
  <meta name="keywords" content="<?php
$ret = think\Db::name('config')->where("varname='sitekeywords'")->value("value");
?><?php echo $ret; ?>">
  <meta name="description" content="<?php
$ret = think\Db::name('config')->where("varname='siteinfo'")->value("value");
?><?php echo $ret; ?>">
  <link rel="shortcut icon" href="../favicon.ico">
  <link rel="apple-touch-icon" href="/public/static/index/<?php echo $config['template']; ?>/images/favicon.png" sizes="114x114">
  <!--[if lt IE 9]>
    <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/html5-css3.js'></script>
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="/public/static/index/<?php echo $config['template']; ?>/css/autoptimize.css" />
  <link rel="stylesheet" type="text/css" href="/public/static/index/<?php echo $config['template']; ?>/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/push.js'></script>
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/jquery/jquery.js'></script>
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/jquery/jquery-migrate.min.js'></script>
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/plugins/nix-gravatar-cache/js/main.js'></script>
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/jquery.min.js'></script>
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/scrollmonitor.js'></script>
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/slides.js'></script>
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/echo.min.js'></script>
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/script.js'></script>
  <script type='text/javascript' src='/public/static/index/<?php echo $config['template']; ?>/js/flexisel.js'></script>
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
    <div class="bull"><i class="fa fa-volume-up"> </i></div>
    <div id="scrolldiv">
      <div class="scrolltext">
        <ul>
          <li class="scrolltext-title"><a href="#" rel="bookmark">公告：欢迎大家好！</a></li>
          <li class="scrolltext-title"><a href="#" rel="bookmark">公告：欢迎</a></li>
        </ul>
      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#scrolldiv").textSlider({line:1, speed:300, timer:5000});
      });
    </script>
  </nav>

  <div id="content" class="site-content">
    <div id="primary" class="content-area">
      <main id="main" class="site-main">

        <div id="slideshow">
          <ul class="rslides" id="slider">
          <?php
$advs = think\Db::name('adv')->where("catid=1")->limit(4)->order("listorder asc")->select();
$__LIST__ = $advs;
if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li><a href="#" rel="bookmark"> <img src="/public/uploads/<?php echo $vo['thumb']; ?>" alt="焦点图"></a>
              <p class="slider-caption">图片</p>
            </li>
          <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <?php
$article = think\Db::name('article')->alias('a')->where(" headlines=1")->field('a.id,catid,title,description,inputtime,a.listorder,thumb,views,catname')->join('sfox_category b','a.catid = b.id','left')->limit(2)->order("id asc")->select();
$__LIST__ = $article;
if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <article class="post type-post status-publish format-standard hentry">
          <figure class="thumbnail">
            <a href="#"> <img src="/public/uploads/<?php echo $vo['thumb']; ?>" alt="" style="width:100%"></a>
            <span class="cat"> <a href="#"><?php echo $vo['catname']; ?></a></span>
          </figure>
          <header class="entry-header">
            <h2 class="entry-title"><a href="#" rel="bookmark"><?php echo $vo['title']; ?></a></h2>
          </header>
          <div class="entry-content">
            <div class="archive-content"><?php echo mb_substr($vo['description'],0,100,utf8); ?></div>
            <br/>
            <span class="title-l"></span>
            <span class="entry-meta">
              <span class="date"><?php echo $vo['inputtime']; ?>&nbsp;</span>
              <span class="views"> 阅读 <?php echo $vo['views']; ?>&nbsp;</span>
              <span class="comment"><a href="#"> <i class="fa fa-comment-o"></i> 查看评论</a></span>
            </span>
            <div class="clear"></div>
          </div>
          <span class="entry-more"> <a href="#" rel="bookmark">阅读全文</a></span>
        </article>
		<?php endforeach; endif; else: echo "" ;endif; ?>


        <div class="line-four">
        <?php if(is_array($imagelist) || $imagelist instanceof \think\Collection || $imagelist instanceof \think\Paginator): $i = 0; $__LIST__ = $imagelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
          <div class="xl4 xm4">
            <div class="picture-h">
              <figure class="picture-h-img"><a href="#"><img src="/public/uploads/<?php echo $vo['thumb']; ?>" alt=""></a></figure>
              <h3 class="picture-h-title"><a href="#" rel="bookmark"><?php echo mb_substr($vo['title'],0,6,utf8); ?></a></h3>
            </div>
          </div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
          <div class="clear"></div>
        </div>

      </main>
    </div>

    <div id="sidebar" class="widget-area">
      <aside class="widget widget_hot_commend">
        <h3 class="widget-title"><i class="fa-bars fa"></i>本站推荐</h3>
        <div id="hot" class="hot_commend">
          <ul>
            <?php
$article = think\Db::name('article')->alias('a')->where(" recommended = 1 ")->field('a.id,catid,title,description,inputtime,a.listorder,thumb,views,catname')->join('sfox_category b','a.catid = b.id','left')->limit(3)->order("id desc")->select();
$__LIST__ = $article;
if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li>
              <figure class="thumbnail"><a href="#"><img src="/public/uploads/<?php echo $vo['thumb']; ?>" alt=""></a></figure>
              <div class="hot-title"><a href="<?php echo url('info',['catid'=>$vo['catid'],'id'=>$vo['id']]); ?>"><?php echo mb_substr($vo['title'],0,10,utf8); ?></a></div>
              <div class="views">阅读 <?php echo $vo['views']; ?></div>
              <i class="fa-thumbs-o-up fa"> 0</i>
            </li>
           <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          <div class="clear"></div>
        </div>
        
      </aside>

      <aside class="widget widget_hot_post">
        <h3 class="widget-title"><i class="fa-bars fa"></i>热门文章</h3>
        <div id="hot_post_widget">
          <ul>
            <?php
$article = think\Db::name('article')->alias('a')->where("")->field('a.id,catid,title,description,inputtime,a.listorder,thumb,views,catname')->join('sfox_category b','a.catid = b.id','left')->limit(5)->order("views desc")->select();
$__LIST__ = $article;
if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li><span class="li-icon li-icon-<?php echo $key+1; ?>"><?php echo $key+1; ?></span><a href="#"><?php echo mb_substr($vo['title'],0,10,utf8); ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
      </aside>

      <aside class="widget widget_categories">
        <h3 class="widget-title"><i class="fa-bars fa"></i>分类目录</h3>
          <ul>
       	<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li class="cat-item"> <a href="<?php echo url('category',['id'=>$vo['id']]); ?>"><?php echo $vo['catname']; ?></a></li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          <div class="clear"></div>
      </aside>
    </div>

    <div class="clear"></div>
    <div class="line-big">
    <?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      <div class="xl3 xm3">
        <div class="cat-box" style="height:380px;">
          <h3 class="cat-title"><i class="fa-bars fa"></i><a href="#"><?php echo $vo['catname']; ?></a></h3>
          <div class="clear"></div>
          
          <div class="cat-site">
          <?php if(is_array($vo['rec']) || $vo['rec'] instanceof \think\Collection || $vo['rec'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['rec'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?>
            <h2 class="entry-title"><a href="#" rel="bookmark"><?php echo mb_substr($v2['title'],0,12,utf8); ?></a></h2>
            <figure class="thumbnail"><a href="#"><img src="/public/uploads/<?php echo $v2['thumb']; ?>" alt=""></a></figure>
            <div class="cat-main"><?php echo mb_substr($v2['description'],0,50,utf8); ?></div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="clear"></div>
            <ul class="cat-list">
             <?php if(is_array($vo['article']) || $vo['article'] instanceof \think\Collection || $vo['article'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['article'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?>
              <span class="list-date"><?php echo formattime($v1['inputtime']); ?></span>
              <li class="list-title"><a href="#" rel="bookmark"><?php echo $v1['title']; ?></a></li>
              <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
        </div>
      </div>
	<?php endforeach; endif; else: echo "" ;endif; ?>
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
