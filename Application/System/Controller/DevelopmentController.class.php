<?php
namespace System\Controller;
use Common\Controller\RestActionController;
class DevelopmentController extends RestActionController {
    public function api(){
        $this->rest(array(
        	"model"=>"System/Api"
        ));
    }
}