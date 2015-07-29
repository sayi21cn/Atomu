<?php
namespace System\Controller;
use Common\Controller\RestActionController;
class AuthenticationController extends RestActionController {

	public function User(){
        $this->rest(array(
        	"model"=>"System/AuthenticationUser",
        	"post"=>function($res){
        		//加密用户密码
				$res["request"]["password"]=md5(md5($res["request"]["password"].C("SYSTEM_AUTHENTICATION_PASSWORD_TOKEN")));
				//存储当前用户
				$res=parent::post($res);
				//返回
				return $res;
			},
        	"put"=>function($res){
        		//加密用户密码
				if(!empty($res["request"]["password"]))
					$res["request"]["password"]=\Org\Util\Password::encrypt($res["request"]["password"]);
				else
					unset($res["request"]["password"]);
				//保存用户信息
				$res=parent::put($res);
				
				$mod=D("System/AuthenticationUserGroup");
				$uid=$res["response"]["id"];
				//删除用户组信息
				$mod->where(array("uid"=>$res["request"]["id"]))->delete();
				//存储用户组信息
				$group=explode(",",$res["request"]["group"]);
				for($i=0,$l=count($group);$i<$l;$i++){
					$mod->create(array(
						"uid"=>$res["request"]["id"],
						"group_id"=>$group[$i]
					));
					$mod->add();
				}
				return $res;
        	},
        	"get"=>function($res){
        		//获取用户信息
				$res=parent::get($res);
				//获取用户组信息
				$ids=array();
				$group=D("System/AuthenticationUserGroup")->where(array("uid"=>$res["request"]["id"]))->select();
				for($i=0,$l=count($group);$i<$l;$i++){
					$ids[]=$group[$i]["group_id"];
				}
				$res["response"]["group"]=join(",",$ids);
				return $res;
        	}
        ));
    }

    public function Group() {
        $this->rest(array(
        	"model" => "System/AuthenticationGroup",
        ));
    }
}