<?php
/**
 * 模块配置类
 */
class ModuleInstaller{
	
	public $config=[
		/**
		 * 模块基本信息配置
		 */
		"name"=>"System",
		"title"=>"EnterTile核心组件",
		"abstract"=>"EnterTile核心组件，无法删除",
		"menus"=>[
			[
				"menu"=>"控制面板-模块管理-已安装模块",
				"page"=>"/system/page/installed",
				"permits"=>[
					[
						"path"=>"/system/module/item",
						"methods"=>["POST","DELETE","PUT","GET","BATCH"]
					]
				]
			],
			[
				"menu"=>"控制面板-模块管理-模块市场",
				"page"=>"/system/page/store",
				"permits"=>[
					[
						"path"=>"/system/module/store",
						"methods"=>["POST","DELETE","PUT","GET","BATCH"]
					]
				]
			],
			[
				"menu"=>"控制面板-用户与用户组-用户账号",
				"page"=>"/system/page/user",
				"permits"=>[
					[
						"path"=>"/system/authentication/user",
						"methods"=>["POST","DELETE","PUT","GET","BATCH"]
					],
					[
						"path"=>"/system/authentication/group",
						"methods"=>["BATCH"]
					]
				]
			],
			[
				"menu"=>"控制面板-用户与用户组-用户组",
				"page"=>"/system/page/group",
				"permits"=>[
					[
						"path"=>"/system/authentication/group",
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