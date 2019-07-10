<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"D:\Apache24\htdocs\starcms./application/admin\view\config\index.html";i:1554550682;}*/ ?>
<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/tabs_panels.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:19:53 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>H+ 后台主题UI框架 - 选项卡 &amp; 面板</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">
    <link rel="shortcut icon" href="favicon.ico"> <link href="/public/static/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/public/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/public/static/admin/js/ajaxfileupload.js"></script>
    <script src="/public/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/public/static/admin/js/content.min.js?v=1.0.0"></script>
    <script src="/public/static/admin/js/plugins/iCheck/icheck.min.js"></script>
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="<?php if(input('tab',1) == 1): ?>active<?php endif; ?>"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> 站点配置</a>
                        </li>
                        <li class="<?php if(input('tab',1) == 2): ?>active<?php endif; ?>"><a data-toggle="tab" href="#tab-2" aria-expanded="false">附件配置</a>
                        </li>
                         <li class="<?php if(input('tab',1) == 3): ?>active<?php endif; ?>"><a data-toggle="tab" href="#tab-3" aria-expanded="false">邮箱配置</a>
                        </li>
                        <li class="<?php if(input('tab',1) == 4): ?>active<?php endif; ?>"><a data-toggle="tab" href="#tab-4" aria-expanded="false">七牛配置</a>
                        </li>
                        <li class="<?php if(input('tab',1) == 5): ?>active<?php endif; ?>"><a data-toggle="tab" href="#tab-5" aria-expanded="false">微信配置</a>
                        </li>
                        <li class="<?php if(input('tab',1) == 6): ?>active<?php endif; ?>"><a data-toggle="tab" href="#tab-6" aria-expanded="false">支付配置</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane <?php if(input('tab',1) == 1): ?>active<?php endif; ?>">
                            <div class="panel-body">
                                 <form method="post" class="form-horizontal" action="<?php echo url('config/edit'); ?>" data-type="ajax">
                                 <input type="hidden" name="tab" value="1"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">站点名称</label>

                                <div class="col-sm-10">
                                 <input type="text" name="sitename" class="form-control" value="<?php echo $configlist['sitename']; ?>">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                             <div class="form-group">
                                <label class="col-sm-2 control-label">关键字</label>

                                <div class="col-sm-10">
                                    <input type="text" name="sitekeywords" class="form-control" value="<?php echo $configlist['sitekeywords']; ?>">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                             <div class="form-group">
                                <label class="col-sm-2 control-label">描述</label>

                                <div class="col-sm-10">
                                   <textarea type="text" name="siteinfo" rows="5" class="form-control"><?php echo $configlist['siteinfo']; ?></textarea>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">模板风格</label>
                                         <div class="col-sm-10">
                                             <select class="form-control m-b" name="template">
                                                 <option value="" selected>≡ 请选择模板 ≡</option>
                                                 <?php if(is_array($filename) || $filename instanceof \think\Collection || $filename instanceof \think\Paginator): $i = 0; $__LIST__ = $filename;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                                 <option value="<?php echo $vo['name']; ?>" <?php echo $vo['name']==$configlist['template']?'selected' : ''; ?>><?php echo $vo['name']; ?></option>
                                                 <?php endforeach; endif; else: echo "" ;endif; ?>
                                             </select>
                                         </div>
                                     </div>
                                     <div class="hr-line-dashed"></div>
                                     <div class="form-group">
                 <label class="col-sm-2 control-label">站点LOGO</label>
                <div class="col-sm-10"><div id="file-pretty"><div>
                <input type="file" id="file_thumb1" name="thumb1" class="form-control" style="display: none;">
                <div class="input-append input-group">
                 <span class="input-group-btn"><button id="btn_thumb1" class="btn btn-white" type="button">选择图片</button></span>
                 <input id="info_thumb1" name="sitelogo" class="input-large form-control" type="text" value="<?php echo $configlist['sitelogo']; ?>">
                 </div>
                 </div></div></div>
                 </div>                  
                                  
                                 
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                         <?php if($configlist['sitelogo']): ?>
                                          <img id="edit_thumb" src="/public/uploads/<?php echo $configlist['sitelogo']; ?>" width="150"/>
                                          <?php else: ?>
                                          <img id="edit_thumb" src="/public/static/admin/img/nopic.jpg" width="150"/>
                                          <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="hr-line-dashed"></div>
                                   
        <script>
        $(document).ready(function(){
			 $("#btn_thumb1").click(function(){
	                    $("#file_thumb1").click();
             });
			 //异步上传
                $("body").delegate('#file_thumb1', 'change', function(){
                    var filepath = $("input[name='thumb1']").val();
                    var arr1 = filepath.split('.');
                    var ext1 = arr1[arr1.length-1];
                    var allowext1 = new Array("jpg","png","gif");
                    if(allowext1.indexOf(ext1)>=0){
                        $.ajaxFileUpload({
                          url: "<?php echo url('Uploads/upload_image'); ?>",
                          secureurl: false,
                          fileElementId: 'file_thumb1', //file标签ID
                          dataType: 'json', //返回数据类型
                          data:{name:'thumb1'},
                          success:function (data,status){
                              $("#info_thumb1").val(data);
							  $("#edit_thumb").attr('src','/public/uploads/'+ data);
                              $("#info_thumb1").focus();
                          },
                          complete:function (XMLHttpRequest){

                          },
                          error:function (data,status,e){
                              layer.alert('上传失败!');
                          },
                      });
                    } else {
                        //清空file
                        $("#file_thumb1").val("");
                        layer.alert('请上传合适的图片类型!');
                    }

                });
			
			
		})
		</script>
                             <div class="hr-line-dashed"></div>
                                     <div class="form-group">
                 <label class="col-sm-2 control-label">站点ico</label>
                <div class="col-sm-10"><div id="file-pretty"><div>
                <input type="file" id="file_thumb2" name="thumb2" class="form-control" style="display: none;">
                <div class="input-append input-group">
                 <span class="input-group-btn"><button id="btn_thumb2" class="btn btn-white" type="button">选择ico</button></span>
                 <input id="info_thumb2" name="siteico" class="input-large form-control" type="text" value="<?php echo $configlist['siteico']; ?>">
                 </div>
                 </div></div></div>
                 </div>                  
                                    
                                     <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                         <?php if($configlist['siteico']): ?>
                                          <img id="edit_thumb2" src="/public/uploads/<?php echo $configlist['siteico']; ?>" width="50"/>
                                          <?php else: ?>
                                          <img id="edit_thumb2" src="/public/static/admin/img/nopic.jpg" width="50"/>
                                          <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                   
        <script>
        $(document).ready(function(){
			 $("#btn_thumb2").click(function(){
	                    $("#file_thumb2").click();
             });
			 //异步上传
                $("body").delegate('#file_thumb2', 'change', function(){
                    var filepath = $("input[name='thumb2']").val();
                    var arr1 = filepath.split('.');
                    var ext1 = arr1[arr1.length-1];
                    var allowext1 = new Array("ico");
                    if(allowext1.indexOf(ext1)>=0){
                        $.ajaxFileUpload({
                          url: "<?php echo url('Uploads/upload_ico'); ?>",
                          secureurl: false,
                          fileElementId: 'file_thumb2', //file标签ID
                          dataType: 'json', //返回数据类型
                          data:{name:'thumb2'},
                          success:function (data,status){
                              $("#info_thumb2").val(data);
							  $("#edit_thumb2").attr('src','/public/uploads/'+ data);
                              $("#info_thumb2").focus();
                          },
                          complete:function (XMLHttpRequest){

                          },
                          error:function (data,status,e){
                              layer.alert('上传失败!');
                          },
                      });
                    } else {
                        //清空file
                        $("#file_thumb2").val("");
                        layer.alert('请上传合适的图片类型!');
                    }

                });
			
			
		})
		</script>       
                                <div class="hr-line-dashed"></div>
                             <div class="form-group">
                                <label class="col-sm-2 control-label">备案号</label>

                                <div class="col-sm-10">
                                    <input type="text" name="sitebeian" class="form-control" value="<?php echo $configlist['sitebeian']; ?>">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>   
                                                            <div class="hr-line-dashed"></div>
                             <div class="form-group">
                                <label class="col-sm-2 control-label">版权</label>

                                <div class="col-sm-10">
                                    <input type="text" name="sitecopyright" class="form-control" value="<?php echo $configlist['sitecopyright']; ?>">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>  
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">提交</button>
                                        </div>
                                    </div>
                            </form>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane <?php if(input('tab',1) == 2): ?>active<?php endif; ?>">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo url('config/edit'); ?>" data-type="ajax">
                                <input type="hidden" name="tab" value="2"/>

                                 
                                                               <div class="form-group">
                                <label class="col-sm-2 control-label">列表页数据</label>

                                <div class="col-sm-10">
                                 <input type="text" name="pnums" class="form-control" value="<?php echo $configlist['pnums']; ?>" placeholder="列表页每页的数据个数，请输入整数">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">允许上传的附件大小</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="uploadmaxsize" class="form-control" value="<?php echo $configlist['uploadmaxsize']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">允许上传的附件类型</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="uploadallowext" class="form-control" value="<?php echo $configlist['uploadallowext']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">是否开启图片水印</label>
                                        <div class="col-sm-10">
                                            <div class="radio i-checks">
                                                <label>
                                            <input type="radio" value="1" name="watermarkenable" <?php if($configlist['watermarkenable'] == 1): ?>checked<?php endif; ?>> <i></i> 开启</label>
                                            </div>
                                            <div class="radio i-checks">
                                                <label><input type="radio" value="0" name="watermarkenable" <?php if($configlist['watermarkenable'] == 0): ?>checked<?php endif; ?>> <i></i> 关闭</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">提交</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        
                        
                         <div id="tab-3" class="tab-pane <?php if(input('tab',1) == 3): ?>active<?php endif; ?>">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo url('config/setMail'); ?>" data-type="ajax">
                                <input type="hidden" name="tab" value="3"/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">发件人姓名：</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email_rename" class="form-control" value="<?php echo $mail['email_rename']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">发送邮箱：</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email_name" class="form-control" value="<?php echo $mail['email_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
    <div class="form-group">
                                        <label class="col-sm-2 control-label">smtp服务器：</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email_smtpname" class="form-control" value="<?php echo $mail['email_smtpname']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
    								<div class="form-group">
                                        <label class="col-sm-2 control-label">smtp服务器端口：</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email_port" class="form-control" value="<?php echo $mail['email_port']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                     <div class="form-group">
                                        <label class="col-sm-2 control-label">smtp连接方式：</label>
                                        <div class="col-sm-10">
                                        <select name="email_smtpsecure"   class="form-control" >
								<option value="ssl" <?php if($mail['email_smtpsecure'] == 'ssl'): ?>selected<?php endif; ?>>SSL连接方式</option>
								<option value="tls" <?php if($mail['email_smtpsecure'] == 'tls'): ?>selected<?php endif; ?>>TLS连接方式</option>
							</select>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">邮箱登录名：</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email_emname" class="form-control" value="<?php echo $mail['email_emname']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">邮箱密码：</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="email_pwd" class="form-control" value="<?php echo $mail['email_pwd']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">提交</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                      <div id="tab-4" class="tab-pane <?php if(input('tab',1) == 4): ?>active<?php endif; ?>">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo url('config/setQiniu'); ?>" data-type="ajax">
                                <input type="hidden" name="tab" value="3"/>
                                 <div class="form-group">
                                        <label class="col-sm-2 control-label">七牛存储</label>
                                        <div class="col-sm-10">
                                            <div class="radio i-checks" style="display:inline-block">
                                                <label>
                                            <input type="radio" value="1" name="open" <?php if($qiniu['open'] == 1): ?>checked<?php endif; ?>> <i></i> 开启</label>
                                            </div>
                                            <div class="radio i-checks" style="display:inline-block">
                                                <label><input type="radio" value="0" name="open" <?php if($qiniu['open'] == 0): ?>checked<?php endif; ?>> <i></i> 关闭</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">AK：</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="ak" class="form-control" value="<?php echo $qiniu['ak']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">SK：</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="sk" class="form-control" value="<?php echo $qiniu['sk']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
    <div class="form-group">
                                        <label class="col-sm-2 control-label">BUCKET：</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="bucket" class="form-control" value="<?php echo $qiniu['bucket']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
    								<div class="form-group">
                                        <label class="col-sm-2 control-label">DOMAIN：</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="domain" class="form-control" value="<?php echo $qiniu['domain']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                     
                                   
                                  
                                    
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

    <script>
        $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
    </script>
    <script src="/public/static/admin/js/plugins/layer/layer.min.js"></script>
    <script src="/public/static/admin/js/layer_hplus.js"></script>
</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/tabs_panels.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:19:53 GMT -->
</html>
