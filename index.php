<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

//RUNTIME目录路径
define( 'RUNTIME_PATH' , '../content/runtime/' );  

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);

// 当前模式
//define('APP_STATUS','rdtt10');

// 禁止自动生成index.html文件
define('BUILD_DIR_SECURE', false);

//自动生成模块
//define('BIND_MODULE','System');
//define('BUILD_CONTROLLER_LIST','Development');

// 定义应用目录
define('APP_PATH','./Application/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';
// 亲^_^ 后面不需要任何代码了 就是如此简单