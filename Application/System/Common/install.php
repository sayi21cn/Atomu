<?php
/**
 * 模块配置类
 */
class ModuleInstaller{
	/**
	 * 模块基本信息配置
	 */
	public $config=[
		"name"=>"Content",
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
	/**
	 * 自定义安装脚本
	 */
	public function install(){
		echo "这是自定义安装脚本";
	}
	/**
	 * 自定义卸载脚本
	 */
	public function uninstall(){
		echo "这是自定义卸载脚本";
	}
}
?>