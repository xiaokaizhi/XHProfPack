<?php
/**
 * Config
 * @author baojunbo <baojunbo@gmail.com>
 */

class BFW_Config {
	private static $_data = array();

    public static function get($key, $default = null){
        if (strpos($key, '.') !== false) {
        	$keyArr = explode('.', $key);
        	$dir = str_replace('_', DIRECTORY_SEPARATOR, $keyArr[0]);
        	$key = str_replace("{$keyArr[0]}.", '', $key);
        } else {
        	$dir = str_replace('_', DIRECTORY_SEPARATOR, $key);
        	$key = null;
        }

        if (!isset(self::$_data[$dir])) {
        	$file = PATH_CONFIG . DIRECTORY_SEPARATOR . "{$dir}.conf.php";
        	if (!file_exists($file)) throw new ErrorException("{$file} not exists!", 10002);
        	self::$_data[$dir] = require $file;
        }

        $value = self::_get(self::$_data[$dir], $key);
        return $value;
    }

    private static function _get($data, $key) {
    	if ($key) {
    		if (strpos($key, '.') !== false) {
    			$val = null;
    			$keyArr = explode('.', $key);
    			$data = $data[$keyArr[0]];
    			$newKey = str_replace("{$keyArr[0]}.", '', $key);
    			if (strpos($newKey, '.') === false) {
    				$data = $data[$newKey];
    			} else {
    				$data = self::_get($data, $newKey);
    			}
       		} else {
    			if (empty($data[$key])) {
    				$data = null;
    			} else {
    				$data = $data[$key];
    			}
    		}
    	}
    	return $data;
    }
}