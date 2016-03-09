<?php
class obj_log {
	private static $_type = 0;
	private static $_oriType = 0;
	private static $_hasData = 0;
	private static $_startTime = 0;
	private static $_endTime = 0;
	private static $_exeDetail = array();
	private static $_output = array();
	private static $_debutData = array();
	private static $_xhprofData = array();
	private static $_requestUrl = '';
	 
	public static function setType($type) {
		self::$_type = $type;
	}
	
	public static function setOriType($type) {
		self::$_oriType = $type;
	}
	
	public static function setDataFlag($flag) {
		self::$_hasData = $flag;
	}
	
	public static function setStartTime($time) {
		self::$_startTime = $time;
	}
	
	public static function setEndTime($time) {
		self::$_endTime = $time;
	}
	
	public static function setExeDetail($key, $value) {
		self::$_exeDetail[$key] = $value;
	}
	
	public static function setOutput($output) {
		self::$_output = $output;
	}
	
	public static function setDebugData($key, $value) {
		self::$_debutData[$key] = $value;
	}
	
	public static function setXhprofData($data) {
		self::$_xhprofData = $data;
	}
	
	public static function setRequestUrl($requestUrl)
	{
		if (!empty(self::$_requestUrl)) {
			return false;
		}
		
		self::$_requestUrl = $requestUrl;
	}
		
	/**
	 * 保存日志
	 * 日志格式
	 * 时间`请求URL`最终type`原始type`是否有数据`接口响应时间`接口详情`输出结果`debug信息`其他
	 */
	public static function saveLog() {
		$time = date('Y-m-d H:i:s');
		$requestUrl = self::$_requestUrl;
		$exeTime = (self::$_endTime - self::$_startTime) * 1000;
		$logStr = $time.'`'.$requestUrl.'`'.self::$_type.'`'.self::$_oriType.'`'.self::$_hasData.'`'.$exeTime;
		$logStr .= empty(self::$_exeDetail) ? '`' : '`'.json_encode(self::$_exeDetail);
		$logStr .= empty(self::$_output) ? '`' : '`'.json_encode(self::$_output);
		$logStr .= empty(self::$_debutData) ? '`' : '`'.json_encode(self::$_debutData);
		$logStr .= empty(self::$_xhprofData) ? '`' : '`'.json_encode(self::$_xhprofData);
		
		$date = date('Y/m/d/');
		$hour = date('H');
		$logFile = RUNTIME_LOG_PATH . $date . 'recommend_interface_' . $hour . '.log';
		$dir = dirname($logFile);
		if (!is_dir($dir)) {
			mkdir($dir, 0755, true);
		}
		file_put_contents($logFile, $logStr."\n", FILE_APPEND);
	}

}
