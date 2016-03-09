<?php
/**
 * Request
 * @author baojunbo <baojunbo@gmail.com>
 */

class lib_Request {

    public static function get($key, $default = null){
        return self::_get('get', $key, $default);
    }

    public static function getx() {
    	$keys = func_get_args();
    	return self::_getx('get', $keys);
    }

	public static function post($key, $default = null){
        return self::_get('post', $key, $default);
    }

    public static function postx() {
    	$keys = func_get_args();
    	return self::_getx('post', $keys);
    }

    public static function request($key, $default = null){
        return self::_get('request', $key, $default);
    }

    public static function requestx() {
    	$keys = func_get_args();
    	return self::_getx('request', $keys);
    }

    public static function server($key, $default = null){
        return self::_get('server', $key, $default);
    }

    public static function serverx() {
    	$keys = func_get_args();
    	return self::_getx('server', $keys);
    }

    public static function cookie($key, $default = null){
        return self::_get('cookie', $key, $default);
    }

    public static function cookiex() {
    	$keys = func_get_args();
    	return self::_getx('cookie', $keys);
    }

    public static function session($key, $default = null){
        return self::_get('session', $key, $default);
    }

    public static function sessionx() {
    	$keys = func_get_args();
    	return self::_getx('session', $keys);
    }

    private static function _get($type, $key, $default) {
    	$data = self::_getValue($type);
    	if (empty($data[$key]) && $default) return $default;
    	if (!empty($data[$key])) return $data[$key];
    }

    private static function _getx($type, $keys) {
    	$data = self::_getValue($type);
    	$values = array();
    	if ($keys && is_array($keys)) {
    		foreach ($keys as $key) {
    			if (!empty($data[$key])) $values[$key] = &$data[$key];
    		}
    	}
    	return $values;
    }

    private static function _getValue($type) {
    	if ($type == 'get') return $_GET;
    	if ($type == 'post') return $_POST;
        if ($type == 'request') return $_REQUEST;
    	if ($type == 'server') return $_SERVER;
    	if ($type == 'cookie') return $_COOKIE;
    	if ($type == 'session') return $_SESSION;
    }
}
