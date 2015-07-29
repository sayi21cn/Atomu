<?php
/**
 * 模块配置类
 */
class ModuleInstaller{
	
	public $config=[
		/**
		 * 模块基本信息配置
		 */
		"name"=>"Sample",
		"title"=>"内容管理模块",
		"abstract"=>"提供文章管理、网站管理功能",
		"menus"=>[
			[
				"menu"=>"内容与站点-内容中心-文章管理",
				"page"=>"/content/article/page",
				"permits"=>[
					[
						"path"=>"/content/article/item",
						"methods"=>["POST","DELETE","PUT","GET","BATCH"]
					]
				]
			]
		]
	];
	
	public function install(){
		/**
		 * 自定义安装脚本
		 * 此处填写模块安装相关数据库SQL、自定义PHP脚本等
		 */
	}
	
	public function uninstall(){
		/**
		 * 自定义卸载脚本
		 * 此处填写模块卸载相关数据库SQL、自定义PHP脚本等
		 */
	}
}
?>