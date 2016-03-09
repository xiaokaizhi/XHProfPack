<?php
/**
 * Obj
 * @author baojunbo <baojunbo@gmail.com>
 */

abstract class BFW_Obj {
	private static $_class = array();

    public function __call($method, $params){
        $class = get_class($this);
        $class .= "_{$method}";

        if (empty(self::$_class[$class])) self::$_class[$class] = new $class;
        return call_user_func_array(array(self::$_class[$class], "run"), $params);
    }

    public static function __callStatic($method, $params) {
    	$class = get_called_class();
    	$class .= "_{$method}";
    	return call_user_func_array(array($class, 'run'), $params);
    }
}