<?php
/***************************************************************************
 * 
 * Copyright (c) 2015 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file Xhporf.php
 * @author suqian(com@baidu.com)
 * @date 2015/12/31 10:35:47
 * @brief 
 *  
 **/

namespace Vega\Xhprof;

class Xhprof
{
	static $started = false;
	static $stopped = false;
	static $source  = 'xhprof';
	public static function start($source='xhprof') {
		if (!extension_loaded('xhprof') || self::$started === true) {
			return;
		}
		xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
		xhprof_enable(XHPROF_FLAGS_NO_BUILTINS); 
		self::$started = true;
		self::$source = $source;
		register_shutdown_function(array(__CLASS__,'stop'));
	}

	public static function stop() {
		if(self::$stopped || self::$started === false) {
			return;
		}
		$xhprofData = xhprof_disable();
		$tmpDir     = sys_get_temp_dir();
		$xhprofDir  = $tmpDir.DIRECTORY_SEPARATOR.'xhprof';
		if (!is_dir($xhprofDir)) {
			mkdir($xhprofDir);
		}
		file_put_contents($xhprofDir.DIRECTORY_SEPARATOR.uniqid().'.'.self::$source, serialize($xhprofData));
		self::$stopped = true;
	}
}
