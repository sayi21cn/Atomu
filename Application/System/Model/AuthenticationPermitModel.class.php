<?php
namespace System\Model;
use Think\Model;
class AuthenticationPermitModel extends Model {
    protected $tableName = 'system_authentication_permit'; 
    protected $_validate = array(
    	array('name','','帐号名称已经存在！',0,'unique',1) // 在新增的时候验证name字段是否唯一
    );
}