<?php
/**
 * xhprof 调试类
 * @author	tongzhen <elitetongzhen@126.com>
 * @date	2014-03-21 07:12:29
 */
class lib_xhprof{
	
	private static $_enable = false;

	/**
	 * 是否开启xhprof
	 * @param bool $flag
	 *
	 */
	public static function xhprofEnable($flag = true){
		self::$_enable = $flag;

		if (!extension_loaded('xhprof')) {
			self::$_enable = false;
		}
	}

	/**
	 * 启动xhprof
	 *
	 */
	public static function xhprofStart(){
		if(self::$_enable){
			//record the CPU & MEMORY TIME
			xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

			// 不记录内置的函数
			xhprof_enable(XHPROF_FLAGS_NO_BUILTINS);
		}
	}

	/**
	 * 需要保存的xhprof 数据
	 * 
	 */
	public static function getXhprofData(){
		$xhprofData = '';
		if(function_exists("xhprof_disable")){
			$xhprofData = xhprof_disable();
		}

		$runId = uniqid();
		$data = array(
					'timestamp' => time(),
					'host'	=> $_SERVER['HTTP_HOST'],
					'uri'	=> $_SERVER['REQUEST_URI'],
					'xhprofid' => $runId.".xhprof",
					'xhprofdata' =>  serialize($xhprofData),
				);

		return $data;
	}
}
