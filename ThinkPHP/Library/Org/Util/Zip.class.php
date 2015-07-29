<?php
namespace Org\Util;
class Zip{
	public static function extract($zipFile, $targetFolder){
		$zip = new \ZipArchive(); 
		$res = $zip->open($zipFile);
		if ($res === TRUE) { 
			$zip->extractTo($targetFolder); 
			$zip->close(); 
		}
	}
}
?>