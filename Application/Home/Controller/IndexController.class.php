<?php
namespace Home\Controller;
use Common\Controller\RestActionController;
use Org\Baidu\Uuap;

class IndexController extends RestActionController {
    /**
     * desc: 首页页面
     * author: jinlei
     */
    public function index(){
        //session("user.id","3");
        if(session("user.id")){
            //转向到前台页面
            header("location:".C("URL").C("ENTERTILE_DIRECTORY")."platform");
        }else{
            header("location:".C("URL").C("ENTERTILE_DIRECTORY")."platform/login.html");
            exit;
        }
    }
    /**
     * desc: 验证用户登录
     * author: jinlei 
    */
    public function login(){
        $this->rest(array(
            "model"=>"System/AuthenticationUser",
            "get"=>function($res){
                $res["request"]=array("email"=>$res["request"]["email"],"password"=>\Org\Util\Password::encrypt($res["request"]["password"]));
                $res=parent::get($res);
                if($res["response"]){
                    session("user.id",$res["response"]["id"]);
                    session("user.name",$res["response"]["name"]);
                    unset($res["response"]["password"]);
                }
                unset($res["request"]["password"]);
                return $res;
            }
        ));
    }
    /**
     * desc: 退出登录
     * author: jinlei
    */
    public function logout(){
        //移除登陆session
        session('user.id',null);
        //转向到首页
        header("location:/");
    }

    public function user(){
        //验证是否登陆
        if(null==session("user.id")){
            E("未登录系统",401);
            exit;
        }

        $this->rest(array(
            "get"=>function($res){
                $res["response"]=array(
                    "id"=>session("user.id"),
                    "name"=>session("user.name")
                );
                return $res;
            }
        ));
    }

    public function menu(){
        //验证是否登陆
        if(null==session("user.id")){
            E("未登录系统",401);
            exit;
        }
        
        function buildMenuTree($tree){
            $result=array();
            foreach($tree as $key=>$value){
                $t=array(
                    "icon"=>"send",
                    "text"=>$key
                );
                if(is_array($value)){
                    $t["children"]=buildMenuTree($value);
                }else{
                    $t["url"]="/".C("ENTERTILE_DIRECTORY").$value;
                }
                $result[]=$t;
            }
            return $result;
        }
        $this->rest(array(
            "batch"=>function($res){
                $menu=array();$mod=new \Think\Model();
                $rs=$mod->query("select * from think_system_module_menu where find_in_set(id, (select group_concat(menu_ids) from think_system_authentication_group where find_in_set(id, (SELECT group_concat(group_ids) FROM think_system_authentication_user where id = %d))))",session("user.id"));
                for($i=0,$l=count($rs);$i<$l;$i++){
                    $obj=&$menu;
                    $arr=explode("-",$rs[$i]["title"]);
                    for($j=0,$c=count($arr);$j<$c;$j++){
                        if(null==$obj[$arr[$j]])
                            $obj[$arr[$j]]=array();
                        $obj=&$obj[$arr[$j]];
                    }
                    $obj=$rs[$i]["page"];
                }
                $res["response"]=buildMenuTree($menu);
                return $res;
            }
        ));
    }
}