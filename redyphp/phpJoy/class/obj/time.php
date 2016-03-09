<?php
/**
 * 
 * 时间计算
 * @author tongzhen1
 *
 */
class obj_time extends obj_Abstract{
	private static $_singleton; // 单例
	
	private function __construct() {}
	
	public static function getInstance() {
		if (!self::$_singleton) self::$_singleton = new self;
		return self::$_singleton;
	}
	
	/**
	 * 
	 * 获取当前天的时间和所属时间段
	 * @param unknown_type $date
	 */
	public function getTimeSpot($date){
		$date_arr = array();
		$date_arr = explode(' ', $date);
		$day = $date_arr[0];
		
		//统一下日期格式
		$dayStart = "{$day} 00:00:00";
		$dayStartStamp = strtotime($dayStart);		
		$currentDay = date("Y-m-d",$dayStartStamp);
		
		$currentTimeStamp = strtotime($date);		
		$timeSpan = self::_getTimeSpan();
		
		$result = array();
		foreach ($timeSpan as $key=>$val){
			$stTime = "{$day} {$val[0]}";
			$endTime = "{$day} {$val[1]}";
			
			$result[$key][] = strtotime($stTime);
			$result[$key][] = strtotime($endTime);
		}
		
		$timeSpot = 0;
		foreach ($result as $key=>$val){
			if ($currentTimeStamp >= $val[0] && $currentTimeStamp <= $val[1]){
				$timeSpot = $key;
			}
		}
		return "{$currentDay} {$timeSpot}";
	} 
	
	/**
	 * 
	 * 一天内每个时间段的起始时间
	 */
	private static function _getTimeSpan(){
		$timeSpan = array(
				array('00:00:00','00:59:59'),array('01:00:00','01:59:59'),array('02:00:00','02:59:59'),
				array('03:00:00','03:59:59'),array('04:00:00','04:59:59'),array('05:00:00','05:59:59'),
				array('06:00:00','06:59:59'),array('07:00:00','07:59:59'),array('08:00:00','08:59:59'),
				array('09:00:00','09:59:59'),array('10:00:00','10:59:59'),array('11:00:00','11:59:59'),
				array('12:00:00','12:59:59'),array('13:00:00','13:59:59'),array('14:00:00','14:59:59'),
				array('15:00:00','15:59:59'),array('16:00:00','16:59:59'),array('17:00:00','17:59:59'),
				array('18:00:00','18:59:59'),array('19:00:00','19:59:59'),array('20:00:00','20:59:59'),
				array('21:00:00','21:59:59'),array('22:00:00','22:59:59'),array('23:00:00','23:59:59')				
				);
		return $timeSpan;
	}
	
}
