<?php
namespace Common\Behavior;

class CheckAuthenticationBehavior {
     // 行为扩展的执行入口必须是run
     public function run(&$params){
          //Home模块、Index控制器、DEBUG模式下不执行权限验证
          if(CONTROLLER_NAME!="Index" && !APP_DEBUG){
               //判断是否登陆
               if(null==session("user.id")){
                    E("未登录系统",401);
               }else{
                    //判断当前用户权限
                    $auth=new \Think\Auth();
                    if($auth->check(strtolower(MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME."/".$_SERVER["REQUEST_METHOD"]),session("user.id"))){
                    }else{
                         E("无权限的操作",403);
                    }
               }
          }
     }
}