<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 生成应用公共文件
    '__file__' => ['common.php', 'config.php', 'database.php'],

    // 定义admin模块的自动生成 （按照实际定义的文件名生成）
    'admin'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Index', 'User','Config','Category','Menu','Common','Models','Content','Test'],
        'model'      => ['Models', 'ModelsField','Config','Category','Menu','Content','Test'],
        'view'       => ['index/index','config/index','category/index','Menu/index','Models/index','Content/index','Test/index'],
    ],

	// 定义pluges模块的自动生成 （按照实际定义的文件名生成）
    'pluges'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Test'],
        'model'      => ['Test'],
        'view'       => ['Test/index','Test/image','Test/images'],
    ],
	
	// 其他更多的模块定义
];
