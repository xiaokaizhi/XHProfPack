<?php
/**
 * Autoload
 * @author baojunbo <baojunbo@gmail.com>
 */

class lib_Autoload {
  private static $_classes = array();
  private static $_configFileExists = true;

  public static function load($class){
    $dirSeparator = DIRECTORY_SEPARATOR;
    $dir = str_replace('_', $dirSeparator, strtolower($class));
    $classPrefix = "bfw{$dirSeparator}";
 	  if (strpos($dir, $classPrefix) !== false) {
     	$dir = PATH_LIB . $dirSeparator . str_replace($classPrefix, '', $dir);
     	$file = $dir . '.php';
    } else {
      if (!self::$_classes && self::$_configFileExists) {
     	  if (file_exists(PATH_CONFIG . "{$dirSeparator}class.conf.php")) {
          self::$_classes = require_once PATH_CONFIG . "{$dirSeparator}class.conf.php";
     		} else {
     			self::$_configFileExists = false;
     		}
     	}

     	if (isset(self::$_classes[$class])) {
     		$file = self::$_classes[$class];
     	} else {
       	$position = strrpos($dir, $dirSeparator);
  	   	if ($position) $position += 1;
     		$endDir = substr($dir, $position);
     		$dir = PATH_CLASS . "{$dirSeparator}{$dir}";
    	 	$file = "{$dir}{$dirSeparator}{$endDir}.php";
     		if (!file_exists($file)) $file = "{$dir}.php";
     	}
  	}

    if (!file_exists($file)) {
     	throw new ErrorException("class '{$class}' not exists!", 10001);
      return;
    }
    require_once $file;
  }
}

spl_autoload_register(array('lib_Autoload', 'load'));
