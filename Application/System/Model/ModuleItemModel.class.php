<?php
namespace System\Model;
use Think\Model;
class ModuleItemModel extends Model {
    protected $tableName = 'system_module_item';
    protected $_validate = array(
    	array('name','','当前模块已经存在！请先卸载再进行安装',0,'unique',1)
    );
}