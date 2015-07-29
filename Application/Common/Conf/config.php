<?php
return array(
	/*网站基本信息*/
	"URL"=>"http://localhost/",		 					//网站URL地址
	/*运行环境配置*/
	"ENTERTILE_DIRECTORY"=>"entertile/",				//EnterTile 主模块文件夹
	'STORAGE_ROOT'=>'./content/',						//文件存储路径
	/*数据库配置*/
	'DB_TYPE'=>'mysql',	 								// 数据库类型
	'DB_HOST'=>'127.0.0.1',	 							// 服务器地址
	'DB_NAME'=>'edashboard',	 						// 数据库名
	'DB_USER'=>'root',	 	 							// 用户名
	'DB_PWD'=>'123456',	 	 							// 密码
	'DB_PORT'=>'3306',	 	 							// 端口
	'DB_PREFIX' => 'think_', 	 						// 数据库表前缀 
	'DB_CHARSET'=> 'utf8', 	 							// 字符集
	'DB_DEBUG'  =>  TRUE, 	 							// 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
	/*出错信息配置*/
	'SHOW_ERROR_MSG'=>TRUE,								//配置系统出错信息
	/*权限验证配置*/
	'AUTH_ON'=>false,
	'AUTH_CONFIG'=>array(
		'AUTH_GROUP'=>'think_authentication_group',		// 用户组数据表名
		'AUTH_GROUP_ACCESS'=>'think_authentication_group_access', // 用户-用户组关系表
		'AUTH_RULE'=>'think_authentication_rule',		// 权限规则表
		'AUTH_USER'=>'think_authentication_user' 
	),
	"SYSTEM_AUTHENTICATION_PASSWORD_TOKEN"=>"token",	//用户登录密码TOKEN字符串
	/*EnterTile官方配置*/
	"ENTERTILE"=>"http://entertile.jinlei.me/",			//EnterTile官网地址
	"ENTERTILE_STORE_PATH"=>"content/modules/",			//模块商店路径
	/*程序默认配置*/
	"TMPL_L_DELIM"=>"{%",
	"TMPL_R_DELIM"=>"%}"
);