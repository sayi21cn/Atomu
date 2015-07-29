<?php
namespace Org\Util;
class Downloader{
	public static function transfer($url, $target){
		$fp_output = fopen($target, 'w');
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FILE, $fp_output);
		curl_exec($ch);
		curl_close($ch);
	}
}