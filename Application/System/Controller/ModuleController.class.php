<?php

namespace System\Controller;
use Common\Controller\RestActionController;
use System\Model;
/**
 * 系统模块管理
 */
class ModuleController extends RestActionController {
    /**
     * 系统模块管理功能，用于从商店自动部署模块、移除模块
     */
    public function Item(){
        $this->rest([
            "model"=>"System/ModuleItem",
            "post"=>function($res){
                  $zip="{$res["request"]["module"]}.zip";
                  $path=APP_PATH.$res["request"]["module"];
                  if(!APP_DEBUG){
                        /*从服务器下载模块压缩包*/
                        \Org\Util\Downloader::transfer(C("ENTERTILE").C("ENTERTILE_STORE_PATH").$zip, TEMP_PATH.$zip);
                        /*创建模块目录*/
                        \Org\Util\Directory::create($path);
                        /*解压ZIP文件*/
                        \Org\Util\Zip::extract(TEMP_PATH.$zip, $path);
                  }
                  /*加载模块配置类并初始化*/
                  include("{$path}/install.php");
                  $moduleInstaller=new \ModuleInstaller();
                  $config=$moduleInstaller->config;
                  /*准备配置数据（格式化处理）*/
                  $rules=[];
                  for($i=0,$l=count($config["menus"]);$i<$l;$i++){
                        $menu=$config["menus"][$i];
                        $menu["rules"]=[];
                        for($j=0,$m=count($menu["permits"]);$j<$m;$j++){
                              $permit=$menu["permits"][$j];
                              for($k=0,$n=count($permit["methods"]);$k<$n;$k++){
                                    $rule=strtolower("{$permit["methods"][$k]}{$permit["path"]}");
                                    $rules[]=$menu["rules"][]=$rule;
                              }
                        }
                        $config["menus"][$i]=$menu;
                  }
                  /*增加模块信息*/
                  $config["id"]=D("System/ModuleItem")->add([
                    "name"=>$config["name"],
                    "title"=>$config["title"],
                    "abstract"=>$config["abstract"]
                  ]);
                  /*增加相关权限规则（如果已存在，则不添加）*/
                  //读取当前规则信息
                  $modelPermits=D("System/AuthenticationPermit")->select();
                  //移除已经存在的权限规则
                  $rules=join($rules,";");
                  for($i=0,$l=count($modelPermits);$i<$l;$i++){
                    $rules=str_replace($modelPermits[$i]["name"],"",$rules);
                  }
                  $rules=preg_replace("/^;|;$/","",preg_replace("/;{2,}/",";",$rules));
                  //解析新增RULE并保存到数据库
                  if($rules!==""){
                    $rules='[{"name":"'.str_replace(";",'"},{"name":"',$rules).'"}]';
                  }
                  D("System/AuthenticationPermit")->addAll(json_decode($rules,true));
                  /*将规则信息与菜单相关联*/
                  //读取最新规则信息
                  $rules=[];
                  $modelPermits=D("System/AuthenticationPermit")->select();
                  for($i=0,$l=count($modelPermits);$i<$l;$i++){
                    $rules[$modelPermits[$i]["name"]]=$modelPermits[$i]["id"];
                  }
                  //关联菜单权限
                  for($i=0,$l=count($config["menus"]);$i<$l;$i++){
                    $tPermits=[];
                    $menu=$config["menus"][$i];
                    //添加菜单页面可访问权限
                    $menu["rules"][]=[
                        "path"=>$menu["page"],
                        "methods"=>["GET"]
                    ];
                    for($j=0,$m=count($menu["rules"]);$j<$m;$j++){
                        $tPermits[]=$rules[$menu["rules"][$j]];
                    }
                    //创建菜单记录
                    unset($config["menus"][$i]["permits"]);
                    unset($config["menus"][$i]["rules"]);
                        $config["menus"][$i]["title"]=$menu["menu"];
                    $config["menus"][$i]["module_id"]=$config["id"];
                    $config["menus"][$i]["rule_ids"]=join($tPermits,",");
                  }
                  D("SystemModuleMenu")->addAll($config["menus"]);
                  /*运行自定义安装脚本*/
                  $moduleInstaller->install();
                  /*返回输出*/
                  $res["response"]=$config;
                  return $res;
            },
            "delete"=>function($res){
                  $path=APP_PATH.$res["request"]["module"];
                  //执行自定义卸载脚本
                  include("{$path}/install.php");
                  $moduleInstaller=new \ModuleInstaller();
                  $moduleInstaller->uninstall();
                  /*移除模块相关文件及记录*/
                  $mod=new \Think\Model();
                  //移除对应菜单项
                  $mod->execute("delete from think_system_module_menu where module_id in(select id from think_system_module_item where name='%s')",[$res["request"]["module"]]);
                  //移除模块主体
                  $mod->execute("delete from think_system_module_item where name='%s'",[$res["request"]["module"]]);
                  if(!APP_DEBUG){
                        //移除代码
                        \Org\Util\Directory::unlink($path);
                  }
                
                /*返回输出*/
                return $res;
            }
        ]);
    }
}