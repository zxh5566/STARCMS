<?php
//配置文件
return [
    'paginate'  => [
        'type'  => 'layui',
        'var_page'  => 'page',
        'list_rows'  => '5',
        'newstyle'  => true,
    ],
    'template'               => [
        // 模板路径
        'view_path'    => 'application/index/view/default/',
        'taglib_pre_load' => 'app\index\taglib\PC',
    ],
];
