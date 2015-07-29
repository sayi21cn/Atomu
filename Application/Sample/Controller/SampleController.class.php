<?php
namespace Content\Controller;
use Common\Controller\RestActionController;

class SampleController extends RestActionController {

	public function Action(){
		$this->rest(array(
			"model"=>"ContentArticleCategory",
			"post"=>function($res){
				/**
				 * 此处添加自定义创建逻辑
				 */
				return $res;
			},
			"delete"=>function($res){
				/**
				 * 此处添加自定义删除逻辑
				 */
				return $res;
			},
			"put"=>function($res){
				/**
				 * 此处添加自定义修改逻辑
				 */
				return $res;
			},
			"get"=>function($res){
				/**
				 * 此处添加自定义获取单条记录逻辑
				 */
				return $res;
			},
			"batch"=>function($res){
				/**
				 * 此处添加自定义获取列表逻辑
				 */
				return $res;
			}
		));
	}
}