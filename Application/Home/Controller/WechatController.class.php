<?php
namespace Home\Controller;
use Common\Controller\RestActionController;
use Org\Tencent\Wechat;
class WechatController extends RestActionController {

	public function spread(){
		$this->rest(array(
			"get"=>function($res){
				//获取会员信息
				$res["response"]["member"] = D("Member/Account")->where(array("id"=>session("member.id")))->find();
				//获取二维码
				$qrcode=D("Member/Wechat")->where(array("uid"=>session("member.id")))->find();
				//获取统计
				$res["response"]["qrcode"]=$qrcode["qrcode"];

				return $res;
			}
		));
	}
}