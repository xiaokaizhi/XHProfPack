<?php

$dir = dirname(__FILE__);

define('PATH_ROOT', $dir);
define('PATH_CONFIG', $dir."/conf");
define('PATH_LIB', $dir."/lib");
define('PATH_CLASS', $dir."/class");
define('PATH_INCLUDE', $dir."/include");

/**
 * 
 * 自动载入类
 * @param unknown_type $class
 */
function __autoload($class) {
	static $classFiles = array();
	if (!$classFiles) $classFiles = require_once PATH_CONFIG . '/class.conf.php';
	if (isset($classFiles[$class])) {
		$file = PATH_CLASS . '/' . $classFiles[$class];
	} else {
		$classFileDir = str_replace('_', '/', $class);
		if (stripos($class, 'lib_') === false) {
			$fullPath = PATH_CLASS . '/' . $classFileDir;
			$strPosition = strrpos($classFileDir, '/');
			if ($strPosition !== false) $strPosition += 1;
			$endOne = substr($classFileDir, $strPosition);
			$file = $fullPath . '/' . $endOne . '.php';
			if (!file_exists($file)) {
				// $f = $file;
				$file = $fullPath . '.php';
			}
		} else {
			$fileName = str_replace('lib/', '', $classFileDir);
			$file = PATH_LIB . '/' . $fileName . '.php';
		}
	}
	/*
	if (!file_exists($file)) {
		if (!empty($f)) $file = $f;
		throw new Exception($file . ' not exists!');
	}
	*/
	require_once $file;
}
