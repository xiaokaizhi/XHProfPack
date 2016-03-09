<?php
/**
 * File
 * @author baojunbo <baojunbo@gmail.com>
 */

class BFW_File {
    public static function write($file, $content, $type = 'w'){
        $dir = dirname($file);
		if (!is_dir($dir)){
			$bool = mkdir($dir, 0755, true);
			if(!$bool){
				echo "{$dir}:create folder false, please check the permission of this folder or modify the location of the log documents!";
			}
		}
        if ($type == 'w') file_put_contents($file, $content);
        if ($type == 'a') file_put_contents($file, $content, FILE_APPEND);
    }
}
