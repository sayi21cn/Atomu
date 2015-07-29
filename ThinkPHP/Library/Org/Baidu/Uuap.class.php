<?php
namespace Org\Baidu;

vendor("CAS.CAS",'','.php');
class Uuap{
	public $username=null;
	public function __construct() {
		\phpCAS::setDebug();
		\phpCAS::client(CAS_VERSION_2_0, "itebeta.baidu.com", 443, "");
		\phpCAS::setNoCasServerValidation();
		\phpCAS::forceAuthentication();
		$this->username=\phpCAS::getUser();
	}
}