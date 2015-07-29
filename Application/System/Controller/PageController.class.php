<?php
namespace System\Controller;
use Think\Controller;
class PageController extends Controller {
	public function user(){
		$res=[
			"name"=>"Jin Lei"
		];
		//赋值给View
		$this->assign($res);
		//渲染模板
		$this->display();
	}
}