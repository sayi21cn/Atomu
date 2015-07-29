<?php
/**
	公共密码加密算法
*/
namespace Org\Util;
class Password{
	public static function encrypt($pwd) {
		return md5(md5($pwd.C("SYSTEM_AUTHENTICATION_PASSWORD_TOKEN")));
	}
}