<?php
namespace Common\Controller;

abstract class RestActionController extends \Think\Controller\RestController {
	public $model="";
	public $allowMethod=array('get','batch','post','put','delete');

	public function rest($args){
		//获取请求参数
		$data = [
    		"request" => array_merge(I("request.","","htmlspecialchars_decode"), I("put.","","htmlspecialchars_decode")),
    		"response" => []
    	];
    	//处理Model设置
		$this->model = null!==$args["model"] ? $args["model"] : $this->model;
    	//调用相关处理逻辑
    	if(null!==$args[$this->_method]){
    		$data=$args[$this->_method]($data);
    	}
    	else{
    		$data=call_user_func_array([
                $this,$this->_method
            ],[
                $data
            ]);
    	}
    	//返回相应数据格式
    	$this->response($data,"json");
	}

    public function callback($res){

    }

	public function post($res){
        $mod=D($this->model);
        $mod->create($res["request"]);
        $res["response"]=array(
            "id"=>$mod->add()
        );
        return $res;
    }

    public function delete($res){
        $res["response"]=array(
            "id"=>D($this->model)->where($res["request"])->delete()
        );
        return $res;
    }

    public function put($res){
        $res["response"]=D($this->model)->save($res["request"]);
        return $res;
    }

    //获取单条记录的
    public function get($res){
        $res["response"]=D($this->model)->where($res["request"])->find();
        return $res;
    }

    public function batch($res){
        /*准备数据*/
        $args=array();
        /*准备filter字段数据*/
        //获取URL中的数据
        $filter=null !== $res["request"]["filter"]?json_decode($res["request"]["filter"],true):[];
        unset($res["request"]["filter"]);
        //默认filter数据
        $p=array(
            array(
                "name"=>"page",
                "value"=>""
            ),
            array(
                "name"=>"size",
                "value"=>""
            ),
            array(
                "name"=>"order",
                "value"=>"id desc"
            ),
            array(
                "name"=>"fields",
                "value"=>"*"
            ),
            array(
                "name"=>"search",
                "value"=>""
            )
        );
        //merge请求与默认数据
        foreach($p as $key=>$value){
            if($filter[$value["name"]]){
                $args[$value["name"]]=$filter[$value["name"]];
            }else{
                $args[$value["name"]]=$value["value"];
            }
        }
        /*准备各项过滤条件*/
        $find=D($this->model)->where($res["request"]);

        if($args["fields"]){

            $find=$find->field(explode(",",$args["fields"]));
        }

        if($args["search"]){
            $kv=explode(":",$args["search"]);
            $find=$find->where("{$kv[0]} like '%{$kv[1]}%'");
        }

        if($args["page"] && $args["size"]){
            $find=$find->limit(($args["page"]-1)*$args["size"],$args["size"]);
        }

        if($args["order"])
            $find=$find->order($args["order"]);

        $res["response"]=$find->select();
        return $res;
    }
    //
    public function batch1($res){
        $args=array();
        $p=array(
            array(
                "name"=>"page",
                "value"=>""
            ),
            array(
                "name"=>"size",
                "value"=>""
            ),
            array(
                "name"=>"order",
                "value"=>"id desc"
            ),
            array(
                "name"=>"field",
                "value"=>"*"
            ),
            array(
                "name"=>"search",
                "value"=>""
            )
        );
        foreach($p as $key=>$value){
            if($res["request"][$value["name"]]){
                $args[$value["name"]]=$res["request"][$value["name"]];
                unset($res["request"][$value["name"]]);
            }else{
                $args[$value["name"]]=$value["value"];
            }
        }

        $find=D($this->model)->where($res["request"]);

        if($args["field"]){

            $find=$find->field(explode(",",$args["field"]));
        }

        if($args["search"]){
            $kv=explode(":",$args["search"]);
            $find=$find->where("{$kv[0]} like '%{$kv[1]}%'");
        }

        if($args["page"] && $args["size"]){
            $find=$find->limit(($args["page"]-1)*$args["size"],$args["size"]);
        }

        if($args["order"])
            $find=$find->order($args["order"]);

        $res["response"]=$find->select();
        return $res;
    }
}