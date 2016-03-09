<?php
/**
 * View
 * @author	baojunbo <baojunbo@gmail.com>
 */

class BFW_View {
	private static $_tplDir = '';
	private static $_data = array();

	public static function set($key, $value = null){
		if ($key) {
			if (!is_array($key) && $value) {
				self::$_data[$key] = $value;
			} else {
				foreach ($key as $k => $v) {
					if ($v) self::set($k, $v);
				}
			}
		}
    }

    public static function get($key) {
    	$val = '';
    	if (strpos($key, '.') !== false) {
    		$val = self::_get(self::$_data, $key);
    	} else {
    		if (isset(self::$_data[$key])) $val = self::$_data[$key];
    	}
    	return $val;
    }

    public static function setTplDir($dir) {
    	self::$_tplDir = $dir;
    }

    public static function display($tpl) {
    	if (self::$_tplDir) $tpl = self::$_tplDir . DIRECTORY_SEPARATOR .  "{$tpl}";
    	require $tpl;
    }

    public static function fetch($tpl) {
    	ob_start();
    	ob_clean();
    	if (self::$_tplDir) $tpl = self::$_tplDir . DIRECTORY_SEPARATOR . "{$tpl}";
    	require $tpl;
    	$content = ob_get_contents();
    	ob_end_clean();
    	return $content;
    }

    private static function _get($value, $key) {
    	if ($key) {
    		if (strpos($key, '.') !== false) {
    			$newVal = nul;
    			$keyArr = explode('.', $key);
    			foreach ($keyArr as $val) {
    				if (isset($value[$val])) {
    					if (is_array($value[$val])) {
    						$newKey = str_replace("{$val}.", '', $key);
    						$newVal = self::_get($value[$val], $newKey);
    					}
    				}
    				return $newVal;
    			}
    		} else {

    		}
    	}
    	return $value;
    }
}
