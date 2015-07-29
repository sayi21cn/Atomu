<?php
namespace Org\Util;
class Directory{
	/*创建路径*/
	public static function create($path){
		if (!file_exists($path)){ 
			Directory::create(dirname($path)); 
			mkdir($path, 0777); 
		} 
	}
	/*删除文件夹及文件*/
	public static function unlink($path){
		if($handle = opendir($path)){ 
			while(false !==($item = readdir($handle))){ 
				if($item != "." && $item != ".."){ 
					if(is_dir("{$path}/$item")){ 
						Directory::unlink("{$path}/$item"); 
					}else { 
						unlink("{$path}/$item");
					}
				} 
			} 
			closedir($handle); 
			rmdir($path);
		} 
	}
}
?>