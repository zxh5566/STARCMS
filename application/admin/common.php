<?php
$value = is_null($fieldinfo['realvalue']) ? $setting['defaultvalue'] : $fieldinfo['realvalue'];
function text($fieldinfo){
    //字段名
    $field = $fieldinfo['field'];
    //反序列化设置项
    $setting = unserialize($fieldinfo['setting']);
    //默认值
    $value = is_null($fieldinfo['realvalue']) ? $setting['defaultvalue'] : $fieldinfo['realvalue'];
    //是否密码框
    $type = "text";
    if( $setting['ispassword'] ) {
        $type = "password";
    }

    $str = <<<EOF
            <input id="info_$field" name="info[$field]" type="$type" class="form-control" value="$value" />
EOF;
    return $str;
}

function textarea($fieldinfo){
    //字段名
    $field = $fieldinfo['field'];
    //反序列化设置项
    $setting = unserialize($fieldinfo['setting']);
    //默认值
    $value = is_null($fieldinfo['realvalue']) ? $setting['defaultvalue'] : $fieldinfo['realvalue'];
    //高度
    $height = $setting['height'].'px';

    $str = <<<EOF
            <textarea type="text" id="info_$field" name="info[$field]" class="form-control" style="height:$height">$value</textarea>
EOF;
    return $str;
}

function number($fieldinfo){
    //字段名
    $field = $fieldinfo['field'];
    //反序列化设置项
    $setting = unserialize($fieldinfo['setting']);
    //默认值
    $value = is_null($fieldinfo['realvalue']) ? $setting['defaultvalue'] : $fieldinfo['realvalue'];

    $str = <<<EOF
            <input id="info_$field" name="info[$field]" type="type" class="form-control" value="$value" />
EOF;
    return $str;
}

function datetime($fieldinfo){
    //字段名
    $field = $fieldinfo['field'];
    //反序列化设置项
    $setting = unserialize($fieldinfo['setting']);
    //默认值
    $value = $setting['defaultvalue'];
    //字段类型
    $fieldtype = $setting['fieldtype'];
    $date = is_null($fieldinfo['realvalue']) ? date('Y-m-d') : $fieldinfo['realvalue'];
    $datetime = is_null($fieldinfo['realvalue']) ? date('Y-m-d H:i:s') : $fieldinfo['realvalue'];

    if( $fieldtype=='date' ) {
      $str = <<<EOF
          <label class="laydate-icon"></label>
          <input class="form-control layer-date" name="info[$field]" value="$date" onclick="laydate({format: 'YYYY-MM-DD'})">
EOF;
    }elseif( $fieldtype=='datetime' ) {
        $str = <<<EOF
            <label class="laydate-icon"></label>
            <input class="form-control layer-date" name="info[$field]" value="$datetime" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
EOF;
    }

    return $str;
}

function image($fieldinfo){
    //字段名
    $field = $fieldinfo['field'];
    $url = url('Uploads/upload_image');
    //反序列化设置项
    $setting = unserialize($fieldinfo['setting']);
    $allowext = $setting['allowext'];
    $value = is_null($fieldinfo['realvalue']) ? '' : $fieldinfo['realvalue'];

    $str = <<<EOF
            <div id="file-pretty">
                <div>
                    <input type="file" id="file_$field" name="$field" class="form-control" style="display: none;">
                    <div class="input-append input-group">
                        <span class="input-group-btn">
                            <button id="btn_$field" class="btn btn-white" type="button">选择图片</button>
                        </span>
                        <input id="info_$field" name="info[$field]" class="input-large form-control" type="text" value="$value">
                    </div>
                </div>
            </div>

            <script type="text/javascript">
            $(function(){
                $("#btn_$field").click(function(){
                    $("#file_$field").click();
                });

                //异步上传
                $("body").delegate('#file_$field', 'change', function(){
                    var filepath = $("input[name='$field']").val();
                    var arr = filepath.split('.');
                    var ext = arr[arr.length-1];

                    if('$allowext'.indexOf(ext)>=0){
                        $.ajaxFileUpload({
                          url: '$url',
                          secureurl: false,
                          fileElementId: 'file_$field', //file标签ID
                          dataType: 'json', //返回数据类型
                          data:{name:'$field'},
                          success:function (data,status){
                              $("#info_$field").val(data);
                              $("#info_$field").focus();
                          },
                          complete:function (XMLHttpRequest){

                          },
                          error:function (data,status,e){
                              layer.alert('上传失败!');
                          },
                      });
                    } else {
                        //清空file
                        $("#file_$field").val("");
                        layer.alert('请上传合适的图片类型!');
                    }
                });
            });
            </script>
EOF;
    return $str;
}

function images($fieldinfo){
    //字段名
    $field = $fieldinfo['field'];
    $url = url('Uploads/upload_images');
    $delete_url = url('Uploads/delete_file');
    //反序列化设置项
    $setting = unserialize($fieldinfo['setting']);
    $allowext = $setting['allowext'];
    $maxnumber = $setting['maxnumber'];
    $value = is_null($fieldinfo['realvalue']) ? '' : $fieldinfo['realvalue'];
    if($value!='') {
        $values = explode(',',$value);
        $str = '';
        foreach ($values as $key => $v) {
            $num = rand(1000,9999);
            $v = str_replace("\/","\\",$v);
            $str .= <<<EOF
              <li id="WU_FILE_$num" class="state-complete" studyfox_img="$v">
                  <p class="imgWrap"><img src="__UPLOAD__/$v" width="110" height="110"></p>
                  <div class="file-panel" style="height: 0px;"><span class="cancel">删除</span></div>
                  <span class="success"></span>
              </li>
EOF;
        }

        $values = <<<EOF
          <div id="uploader-list-container" class="uploader-list-container">
              <div class="queueListSuccess" style="margin:20px">
                  <ul class="filelist">
                      $str
                  </ul>
              </div>
          </div>
EOF;
    }else{
        $values = '';
    }

    $str = <<<EOF
        <input type="text" id="info_$field" name="info[$field]" class="input-large form-control" value="$value">

        $values

        <div class="uploader-list-container">
            <div class="queueList">
                <div id="dndArea" class="placeholder">
                    <div id="filePicker-2"></div>
                    <p>或将图片拖到这里，单次最多可选 $maxnumber 张</p>
                </div>
            </div>
            <div class="statusBar" style="display:none;">
                <div class="progress"> <span class="text">0%</span> <span class="percentage"></span> </div>
                <div class="info"></div>
                <div class="btns">
                    <div id="filePicker2"></div>
                    <div class="uploadBtn">开始上传</div>
                </div>
            </div>
        </div>

        <script src="/public/static/admin/plugins/webuploader-0.1.5/webuploader.min.js"></script>
        <script type="text/javascript" >
        (function( $ ){
            // 当domReady的时候开始初始化
            $(function() {
                var wrap = $('.uploader-list-container'),

                // 图片容器
                queue = $( '<ul class="filelist"></ul>' )
                    .appendTo( wrap.find( '.queueList' ) ),

                // 状态栏，包括进度和控制按钮
                statusBar = wrap.find( '.statusBar' ),

                // 文件总体选择信息。
                info = statusBar.find( '.info' ),

                // 上传按钮
                upload = wrap.find( '.uploadBtn' ),

                // 没选择文件之前的内容。
                placeHolder = wrap.find( '.placeholder' ),

                progress = statusBar.find( '.progress' ).hide(),

                // 添加的文件数量
                fileCount = 0,

                // 添加的文件总大小
                fileSize = 0,

                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,

                // 缩略图大小
                thumbnailWidth = 110 * ratio,
                thumbnailHeight = 110 * ratio,

                // 可能有pedding, ready, uploading, confirm, done.
                state = 'pedding',

                // 所有文件的进度信息，key为file id
                percentages = {},
                // 判断浏览器是否支持图片的base64
                isSupportBase64 = ( function() {
                    var data = new Image();
                    var support = true;
                    data.onload = data.onerror = function() {
                        if( this.width != 1 || this.height != 1 ) {
                            support = false;
                        }
                    }
                    data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                    return support;
                } )(),

                // 检测是否已经安装flash，检测flash的版本
                flashVersion = ( function() {
                    var version;

                    try {
                        version = navigator.plugins[ 'Shockwave Flash' ];
                        version = version.description;
                    } catch ( ex ) {
                        try {
                            version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                                    .GetVariable('version');
                        } catch ( ex2 ) {
                            version = '0.0';
                        }
                    }
                    version = version.match( /\d+/g );
                    return parseFloat( version[ 0 ] + '.' + version[ 1 ], 10 );
                } )(),

                supportTransition = (function(){
                    var s = document.createElement('p').style,
                        r = 'transition' in s ||
                                'WebkitTransition' in s ||
                                'MozTransition' in s ||
                                'msTransition' in s ||
                                'OTransition' in s;
                    s = null;
                    return r;
                })(),

                // WebUploader实例
                uploader;

                // 实例化
                uploader = WebUploader.create({
                    pick: {
                        id: '#filePicker-2',
                        label: '点击选择图片'
                    },
                    formData: {
                        uid: 123
                    },
                    dnd: '#dndArea',
                    paste: '#uploader',
                    swf: '/public/static/admin/plugins/webuploader-0.1.5/Uploader.swf',
                    chunked: false,
                    chunkSize: 512 * 1024,
                    server: '$url',
                    // runtimeOrder: 'flash',

                    accept: {
                        title: 'Images',
                        extensions: '$allowext',
                        mimeTypes: 'image/*'
                    },

                    // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
                    disableGlobalDnd: true,
                    fileNumLimit: $maxnumber,
                    fileSizeLimit: 200 * 1024 * 1024,    // 200 M
                    fileSingleSizeLimit: 50 * 1024 * 1024    // 50 M
                });

                // 拖拽时不接受 js, txt 文件。
                uploader.on( 'dndAccept', function( items ) {
                    var denied = false,
                        len = items.length,
                        i = 0,
                        // 修改js类型
                        unAllowed = 'text/plain;application/javascript ';

                    for ( ; i < len; i++ ) {
                        // 如果在列表里面
                        if ( ~unAllowed.indexOf( items[ i ].type ) ) {
                            denied = true;
                            break;
                        }
                    }

                    return !denied;
                });

                uploader.on('dialogOpen', function() {
                    console.log('here');
                });

                // uploader.on('filesQueued', function() {
                //     uploader.sort(function( a, b ) {
                //         if ( a.name < b.name )
                //           return -1;
                //         if ( a.name > b.name )
                //           return 1;
                //         return 0;
                //     });
                // });

                // 添加“添加文件”的按钮，
                uploader.addButton({
                    id: '#filePicker2',
                    label: '继续添加'
                });

                uploader.on('ready', function() {
                    window.uploader = uploader;
                });

                // 当有文件添加进来时执行，负责view的创建
                function addFile( file ) {
                    var li = $( '<li id="' + file.id + '">' +
                            '<p class="title">' + file.name + '</p>' +
                            '<p class="imgWrap"></p>'+
                            '<p class="progress"><span></span></p>' +
                            '</li>' ),

                        btns = $('<div class="file-panel">' +
                            '<span class="cancel">删除</span>' +
                            '<span class="rotateRight">向右旋转</span>' +
                            '<span class="rotateLeft">向左旋转</span></div>').appendTo( li ),
                        prgress = li.find('p.progress span'),
                        wrap = li.find( 'p.imgWrap' ),
                        info = $('<p class="error"></p>'),

                        showError = function( code ) {
                            switch( code ) {
                                case 'exceed_size':
                                    text = '文件大小超出';
                                    break;

                                case 'interrupt':
                                    text = '上传暂停';
                                    break;

                                default:
                                    text = '上传失败，请重试';
                                    break;
                            }

                            info.text( text ).appendTo( li );
                        };

                    if ( file.getStatus() === 'invalid' ) {
                        showError( file.statusText );
                    } else {
                        // @todo lazyload
                        wrap.text( '预览中' );
                        uploader.makeThumb( file, function( error, src ) {
                            var img;

                            if ( error ) {
                                wrap.text( '不能预览' );
                                return;
                            }

                            if( isSupportBase64 ) {
                                img = $('<img src="'+src+'">');
                                wrap.empty().append( img );
                            } else {
                                $.ajax('../server/preview.php', {
                                    method: 'POST',
                                    data: src,
                                    dataType:'json'
                                }).done(function( response ) {
                                    if (response.result) {
                                        img = $('<img src="'+response.result+'">');
                                        wrap.empty().append( img );
                                    } else {
                                        wrap.text("预览出错");
                                    }
                                });
                            }
                        }, thumbnailWidth, thumbnailHeight );

                        percentages[ file.id ] = [ file.size, 0 ];
                        file.rotation = 0;
                    }

                    file.on('statuschange', function( cur, prev ) {
                        if ( prev === 'progress' ) {
                            prgress.hide().width(0);
                        } else if ( prev === 'queued' ) {
                            //li.off( 'mouseenter mouseleave' ); //解除事件监听
                            //btns.remove();
                            li.find( 'span.rotateLeft' ).remove(); //移除左旋转按钮
                            li.find( 'span.rotateRight' ).remove(); //移除右旋转按钮
                        }

                        // 成功
                        if ( cur === 'error' || cur === 'invalid' ) {
                            console.log( file.statusText );
                            showError( file.statusText );
                            percentages[ file.id ][ 1 ] = 1;
                        } else if ( cur === 'interrupt' ) {
                            showError( 'interrupt' );
                        } else if ( cur === 'queued' ) {
                            percentages[ file.id ][ 1 ] = 0;
                        } else if ( cur === 'progress' ) {
                            info.remove();
                            prgress.css('display', 'block');
                        } else if ( cur === 'complete' ) {
                            li.append( '<span class="success"></span>' );
                        }

                        li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
                    });

                    li.on( 'mouseenter', function() {
                        btns.stop().animate({height: 30});
                    });

                    li.on( 'mouseleave', function() {
                        btns.stop().animate({height: 0});
                    });

                    btns.on( 'click', 'span', function() {
                        var index = $(this).index(),
                            deg;

                        switch ( index ) {
                            case 0:
                                uploader.removeFile( file );
                                return;

                            case 1:
                                file.rotation += 90;
                                break;

                            case 2:
                                file.rotation -= 90;
                                break;
                        }

                        if ( supportTransition ) {
                            deg = 'rotate(' + file.rotation + 'deg)';
                            wrap.css({
                                '-webkit-transform': deg,
                                '-mos-transform': deg,
                                '-o-transform': deg,
                                'transform': deg
                            });
                        } else {
                            wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                            // use jquery animate to rotation
                            // $({
                            //     rotation: rotation
                            // }).animate({
                            //     rotation: file.rotation
                            // }, {
                            //     easing: 'linear',
                            //     step: function( now ) {
                            //         now = now * Math.PI / 180;

                            //         var cos = Math.cos( now ),
                            //             sin = Math.sin( now );

                            //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                            //     }
                            // });
                        }


                    });

                    li.appendTo( queue );
                }

                // 负责view的销毁
                function removeFile( file ) {
                    var li = $('#'+file.id);
                    var img_src = li.attr('studyfox_img');

                    delete percentages[ file.id ];
                    updateTotalProgress();
                    li.off().find('.file-panel').off().end().remove();

                    //后台删除图片
                    $.ajax({
                        url: '$delete_url',
                        type: 'POST',
                        data: {'img': img_src},
                        success: function(result, textStatus){
                            //图片删除成功后移除文本框图片信息，三种情况 ,号位置在前 后 或没有,号
                            var images_value = $('#info_$field').val();//隐藏文本框的值
                            images_value = images_value.replace(img_src+',', '').replace(','+img_src, '').replace(img_src, ''); //替换,号在右边;左边;直接替换
                            //重新赋值
                            $('#info_$field').val(images_value);
                        },
                        error: function(XMLHttpRequest, textStatus){
                            layer.alert('删除失败!', {icon:2});
                        }
                    });
                }

                //删除原图片
                $(".cancel").click(function(){
                    var img_src = $(this).parent().parent().attr('studyfox_img');
                    var id = $(this).parent().parent().attr('id');
                    //后台删除图片
                    $.ajax({
                        url: '$delete_url',
                        type: 'POST',
                        data: {'img': img_src},
                        success: function(result, textStatus){
                            //图片删除成功后移除文本框图片信息，三种情况 ,号位置在前 后 或没有,号
                            var images_value = $('#info_$field').val();//隐藏文本框的值
                            images_value = images_value.replace(img_src+',', '').replace(','+img_src, '').replace(img_src, ''); //替换,号在右边;左边;直接替换
                            //重新赋值
                            $('#info_$field').val(images_value);

                            //view的销毁
                            var li = $('#'+id);
                            delete percentages[ id ];
                            updateTotalProgress();
                            li.off().find('.file-panel').off().end().remove();

                            //删除所有图片之后销毁外框
                            if(images_value==''){
                              $("#uploader-list-container").remove();
                            }
                        },
                        error: function(XMLHttpRequest, textStatus){
                            layer.alert('删除失败!', {icon:2});
                        }
                    });
                });

                //淡入淡出
                var topli = $(".cancel").parent().parent();
                topli.on( 'mouseenter', function() {
                    $(this).children('.file-panel').stop().animate({height: 30});
                });

                topli.on( 'mouseleave', function() {
                    $(this).children('.file-panel').stop().animate({height: 0});
                });

                //上传成功返回文件名
                uploader.on('uploadSuccess', function(file,response){
                    var images_value = $('#info_$field').val()=='' ? '' : $('#info_$field').val() + ',';
                    $('#info_$field').val( images_value + response);
                    //在当前图片LI里添加图片地址
                    $('#'+file.id).attr('studyfox_img',response);
                });

                function updateTotalProgress() {
                    var loaded = 0,
                        total = 0,
                        spans = progress.children(),
                        percent;

                    $.each( percentages, function( k, v ) {
                        total += v[ 0 ];
                        loaded += v[ 0 ] * v[ 1 ];
                    } );

                    percent = total ? loaded / total : 0;


                    spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
                    spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
                    updateStatus();
                }

                function updateStatus() {
                    var text = '', stats;

                    if ( state === 'ready' ) {
                        text = '选中' + fileCount + '张图片，共' +
                                WebUploader.formatSize( fileSize ) + '。';
                    } else if ( state === 'confirm' ) {
                        stats = uploader.getStats();
                        if ( stats.uploadFailNum ) {
                            text = '已成功上传' + stats.successNum+ '张图片至服务器，'+
                                stats.uploadFailNum + '张图片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
                        }

                    } else {
                        stats = uploader.getStats();
                        text = '共' + fileCount + '张（' +
                                WebUploader.formatSize( fileSize )  +
                                '），已上传' + stats.successNum + '张';

                        if ( stats.uploadFailNum ) {
                            text += '，失败' + stats.uploadFailNum + '张';
                        }
                    }

                    info.html( text );
                }

                function setState( val ) {
                    var file, stats;

                    if ( val === state ) {
                        return;
                    }

                    upload.removeClass( 'state-' + state );
                    upload.addClass( 'state-' + val );
                    state = val;

                    switch ( state ) {
                        case 'pedding':
                            placeHolder.removeClass( 'element-invisible' );
                            queue.hide();
                            statusBar.addClass( 'element-invisible' );
                            uploader.refresh();
                            break;

                        case 'ready':
                            placeHolder.addClass( 'element-invisible' );
                            $( '#filePicker2' ).removeClass( 'element-invisible');
                            queue.show();
                            statusBar.removeClass('element-invisible');
                            uploader.refresh();
                            break;

                        case 'uploading':
                            $( '#filePicker2' ).addClass( 'element-invisible' );
                            progress.show();
                            upload.text( '暂停上传' );
                            break;

                        case 'paused':
                            progress.show();
                            upload.text( '继续上传' );
                            break;

                        case 'confirm':
                            progress.hide();
                            $( '#filePicker2' ).removeClass( 'element-invisible' );
                            upload.text( '开始上传' );

                            stats = uploader.getStats();
                            if ( stats.successNum && !stats.uploadFailNum ) {
                                setState( 'finish' );
                                return;
                            }
                            break;
                        case 'finish':
                            stats = uploader.getStats();
                            if ( stats.successNum ) {
                                //layer.alert( '上传成功' );
                            } else {
                                // 没有成功的图片，重设
                                state = 'done';
                                location.reload();
                            }
                            break;
                    }

                    updateStatus();
                }

                uploader.onUploadProgress = function( file, percentage ) {
                    var li = $('#'+file.id),
                        percent = li.find('.progress span');

                    percent.css( 'width', percentage * 100 + '%' );
                    percentages[ file.id ][ 1 ] = percentage;
                    updateTotalProgress();
                };

                uploader.onFileQueued = function( file ) {
                    fileCount++;
                    fileSize += file.size;

                    if ( fileCount === 1 ) {
                        placeHolder.addClass( 'element-invisible' );
                        statusBar.show();
                    }

                    addFile( file );
                    setState( 'ready' );
                    updateTotalProgress();
                };

                uploader.onFileDequeued = function( file ) {
                    fileCount--;
                    fileSize -= file.size;

                    if ( !fileCount ) {
                        setState( 'pedding' );
                    }

                    removeFile( file );
                    updateTotalProgress();

                };

                uploader.on( 'all', function( type ) {
                    var stats;
                    switch( type ) {
                        case 'uploadFinished':
                            setState( 'confirm' );
                            break;

                        case 'startUpload':
                            setState( 'uploading' );
                            break;

                        case 'stopUpload':
                            setState( 'paused' );
                            break;

                    }
                });

                uploader.onError = function( code ) {
                    if(code == "Q_EXCEED_NUM_LIMIT") {
                       layer.alert("只能上传 $maxnumber 张图片");
                    } else if(code == "F_DUPLICATE") {
                       layer.alert("重复上传");
                    } else {
                        layer.alert("错误代码：" + code);
                    }
                };

                upload.on('click', function() {
                    if ( $(this).hasClass( 'disabled' ) ) {
                        return false;
                    }

                    if ( state === 'ready' ) {
                        uploader.upload();
                    } else if ( state === 'paused' ) {
                        uploader.upload();
                    } else if ( state === 'uploading' ) {
                        uploader.stop();
                    }
                });

                info.on( 'click', '.retry', function() {
                    uploader.retry();
                } );

                info.on( 'click', '.ignore', function() {
                    alert( 'todo' );
                } );

                upload.addClass( 'state-' + state );
                updateTotalProgress();
            });

        })( jQuery );
        </script>


EOF;
    return $str;
}

function downfile($fieldinfo){
  //字段名
  $field = $fieldinfo['field'];
  $url = url('uploads/upload_file');
  //反序列化设置项
  $setting = unserialize($fieldinfo['setting']);
  $allowext = $setting['allowext'];
  $value = is_null($fieldinfo['realvalue']) ? '' : $fieldinfo['realvalue'];

  $str = <<<EOF
          <div id="file-pretty">
              <div>
                  <input type="file" id="file_$field" name="$field" class="form-control" style="display: none;">
                  <div class="input-append input-group">
                      <span class="input-group-btn">
                          <button id="btn_$field" class="btn btn-white" type="button">选择文件</button>
                      </span>
                      <input id="info_$field" name="info[$field]" class="input-large form-control" type="text" value="$value">
                  </div>
              </div>
          </div>

          <script type="text/javascript">
          $(function(){
              $("#btn_$field").click(function(){
                  $("#file_$field").click();
              });

              //异步上传
              $("body").delegate('#file_$field', 'change', function(){
                  var filepath = $("input[name='$field']").val();
                  var arr = filepath.split('.');
                  var ext = arr[arr.length-1];

                  if('$allowext'.indexOf(ext)>=0){
                      $.ajaxFileUpload({
                        url: '$url',
                        secureurl: false,
                        fileElementId: 'file_$field', //file标签ID
                        dataType: 'json', //返回数据类型
                        data:{name:'$field'},
                        success:function (data,status){
                            $("#info_$field").val(data);
                            $("#info_$field").focus();
                        },
                        complete:function (XMLHttpRequest){

                        },
                        error:function (data,status,e){
                            layer.alert('上传失败!');
                        },
                    });
                  } else {
                      //清空file
                      $("#file_$field").val("");
                      layer.alert('请上传合适的文件类型!');
                  }

              });
          });
          </script>
EOF;
  return $str;
}

function downfiles($fieldinfo){
  //字段名
  $field = $fieldinfo['field'];
  $url = url('uploads/upload_downfiles');
  $delete_url = url('delete_file');
  //反序列化设置项
  $setting = unserialize($fieldinfo['setting']);
  $allowext = $setting['allowext']; //zip|rar
  //字符串格式调整
  $allowext = str_replace("|","','",$allowext);
  $allowext = "'" . $allowext . "'";
  $maxnumber = $setting['maxnumber'];
  $value = is_null($fieldinfo['realvalue']) ? '' : $fieldinfo['realvalue'];

  if($value!='') {
      $values = explode(',',$value);
      $str = '';
      foreach ($values as $key => $v) {
          $num = rand(1000,9999);
          $v = str_replace("\/","\\",$v);
          $str .= <<<EOF
            <div class="file-preview-frame krajee-default  kv-preview-thumb file-preview-success" id="uploaded-$num" data-fileindex="-1" data-template="rar" title="" studyfox_img="$v">
              <div class="kv-file-content" style="height:130px">
                <div class="kv-preview-data file-preview-other-frame">
                  <div class="file-preview-other"> <span class="file-other-icon"><i class="glyphicon glyphicon-file"></i></span> </div>
                </div>
              </div>
              <div class="file-thumbnail-footer" style="height:0">
                <div class="file-upload-indicator" title="上传" style="margin-left: 0px; bottom:-26px;"><i class="glyphicon glyphicon-ok-sign text-success"></i></div>
                <div class="file-actions">
                  <div class="file-footer-buttons">
                    <button type="button" class="kv-file-upload btn btn-xs btn-default" title="上传文件" style="display: none;"><i class="glyphicon glyphicon-upload text-info"></i></button>
                    <button type="button" class="kv-file-remove btn btn-xs btn-default" title="删除文件"><i class="glyphicon glyphicon-trash text-danger"></i></button>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
EOF;
      }

      $values = <<<EOF
        <div id="file-input" class="file-input">
          <div class="file-preview">
            <div class=" file-drop-zone">
              <div class="file-preview-thumbnails">

                $str

              </div>
              <div class="clearfix"></div>
              <div class="file-preview-status text-center text-success"></div>
              <div class="kv-fileinput-error file-error-message" style="display: none;"></div>
            </div>
          </div>
        </div>
EOF;
  }else{
      $values = '';
  }

  $str = <<<EOF
      <input type="text" id="info_$field" name="info[$field]" class="input-large form-control" value="$value">

      $values

      <input id="file-zh" name="file[]" type="file" multiple>

      <link href="/public/static/admin/plugins/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
      <script src="/public/static/admin/plugins/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
      <script src="/public/static/admin/plugins/bootstrap-fileinput/js/locales/zh.js" type="text/javascript"></script>
      <script type="text/javascript" >
          $('#file-zh').fileinput({
              language: 'zh',
              uploadUrl: '$url',
              allowedFileExtensions: [$allowext],
              uploadAsync: true, //异步上传
              maxFileCount: $maxnumber
          });

          $('#file-zh').on("fileuploaded", function(event, data, previewId, index){
              var images_value = $('#info_$field').val()=='' ? '' : $('#info_$field').val() + ',';
              $('#info_$field').val( images_value + data.response);
              $('#file-zh').val('');
              //在当前图片DIV里添加图片地址
              $('#'+previewId).attr('studyfox_img',data.response);
          });

          //删除文件
          $('#file-zh').on("filesuccessremove", function(event, id){
              var img_src = $('#'+id).attr('studyfox_img');
              //后台删除文件
              $.ajax({
                  url: '$delete_url',
                  type: 'POST',
                  data: {'img': img_src},
                  success: function(result, textStatus){
                      //图片删除成功后移除文本框图片信息，三种情况 ,号位置在前 后 或没有,号
                      var images_value = $('#info_$field').val();//隐藏文本框的值
                      images_value = images_value.replace(img_src+',', '').replace(','+img_src, '').replace(img_src, ''); //替换,号在右边;左边;直接替换
                      //重新赋值
                      $('#info_$field').val(images_value);
                  },
                  error: function(XMLHttpRequest, textStatus){
                      layer.alert('删除失败!', {icon:2});
                  }
              });
          });

          $('button.kv-file-remove').click(function(){
              var par = $(this).parent().parent().parent().parent();
              var img_src = par.attr('studyfox_img');
              var id = par.attr('id');
              //后台删除文件
              $.ajax({
                  url: '$delete_url',
                  type: 'POST',
                  data: {'img': img_src},
                  success: function(result, textStatus){
                      //图片删除成功后移除文本框图片信息，三种情况 ,号位置在前 后 或没有,号
                      var images_value = $('#info_$field').val();//隐藏文本框的值
                      images_value = images_value.replace(img_src+',', '').replace(','+img_src, '').replace(img_src, ''); //替换,号在右边;左边;直接替换
                      //重新赋值
                      $('#info_$field').val(images_value);

                      //view的销毁
                      par.remove();

                      //删除所有文件之后销毁外框
                      if(images_value==''){
                        $("#file-input").remove();
                      }
                  },
                  error: function(XMLHttpRequest, textStatus){
                      layer.alert('删除失败!', {icon:2});
                  }
              });
          });

      </script>

EOF;
  return $str;
}

function editor($fieldinfo){
    //字段名
    $field = $fieldinfo['field'];
    //反序列化设置项
    $setting = unserialize($fieldinfo['setting']);
    //默认值
    $value = is_null($fieldinfo['realvalue']) ? $setting['defaultvalue'] : $fieldinfo['realvalue'];
    //高度
    $height = $setting['height'];

    $str = <<<EOF
        <script id="container" name="info[$field]" type="text/plain">$value</script>
        <script src="/public/static/admin/plugins/ueditor1_4_3_3/ueditor.config.js"></script>
        <script src="/public/static/admin/plugins/ueditor1_4_3_3/ueditor.all.js"></script>
        <script>
            var um = UE.getEditor('container',{
                initialFrameHeight:$height,
                autoHeightEnabled:false,
                catchRemoteImageEnable:true
            });
        </script>
EOF;
    return $str;
}

function box($fieldinfo){
    //字段名
    $field = $fieldinfo['field'];
    //反序列化设置项
    $setting = unserialize($fieldinfo['setting']);
    //默认值
    $defaultvalue = is_null($fieldinfo['realvalue']) ? $setting['defaultvalue'] : $fieldinfo['realvalue']; // 考虑多值情况

    $options = explode("\n",$setting['options']);
    foreach ($options as $name_value) {
        $v = explode("|",$name_value);
        $k = trim($v['1']);
        $option[$k] = $v['0'];
    }

    switch ($setting['boxtype']) {
        case 'radio':
            $radio = '';
            $state = '';
            foreach ($option as $key => $value) {
                $state = $defaultvalue == $key ? 'checked' : '';
                $radio .="<input type='radio' name='info[$field]' value='$key' $state> <i></i> $value&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            $str = <<<EOF
                <div class="radio i-checks">
                    <label style="padding-left:0">
                        $radio
                    </label>
                </div>
EOF;
            break;

        case 'checkbox':
            $checkbox = '';
            $state = '';
            $defaultvalues = explode(",",$defaultvalue);
            foreach ($option as $key => $value) {
                $state = in_array($key,$defaultvalues) ? 'checked' : '';
                $checkbox .="<input type='checkbox' name='info[$field][]' value='$key' custom='form' $state> <i></i> $value&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            $str = <<<EOF
                <div class="checkbox i-checks">
                    <label style="padding-left:0">
                        $checkbox
                    </label>
                </div>
EOF;
            break;

        case 'select':
            $select = '';
            $state = '';
            foreach ($option as $key => $value) {
                $state = $defaultvalue == $key ? 'selected' : '';
                $select .="<option value='$key' $state>$value</option>";
            }
            $str = <<<EOF
                <select class="form-control m-b" name="info[$field]">
                    $select
                </select>
EOF;
            break;

        case 'multiple':
            $multiple = '';
            $state = '';
            $defaultvalues = explode(",",$defaultvalue);
            foreach ($option as $key => $value) {
                $state = in_array($key,$defaultvalues) ? 'selected' : '';
                $multiple .="<option value='$key' $state>$value</option>";
            }
            $str = <<<EOF
                <select class="form-control m-b" name="info[$field][]" multiple>
                    $multiple
                </select>
EOF;
            break;

    }

    return $str;
}
