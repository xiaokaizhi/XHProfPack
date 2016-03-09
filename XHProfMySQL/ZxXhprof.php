<?php
/**
 * xhprof类
 * @author tongzhen
 * Date: 2015-3-18
 */
class ZxXhprof {
	const HOST = '127.0.0.1';
	const PORT = '8086';
	const USER = 'root';
	const PASSWORD = '123456';
	const DBNAME = 'xhprofui';

	//是否开启xhprof
	private static $_enable = true;

	public function __construct(){
		//无扩展时默认不开启
		if(!extension_loaded('xhprof')){
			self::$_enable = false;
		}
	}

	/**
	 * 启动xhprof
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
	 * @param $interface
	 */
	public static function getXhprofData($interface = ''){
		$xhprofData = '';
		if(function_exists("xhprof_disable") && self::$_enable){
			$xhprofData = xhprof_disable();

			$runId = uniqid();
			$data = array(
				'timestamp' => time(),
				'host' => !empty($interface) ? $interface : $_SERVER['HTTP_HOST'],
				'uri'	=> $_SERVER['REQUEST_URI'],
				'xhprofid' => $runId.".xhprof",
				'xhprofdata' =>  serialize($xhprofData),
			);
			//保存数据
			self::saveData($data);
		}
	}

	private static function saveData($data){
		$xhprofData = unserialize($data['xhprofdata']);
		if(isset($xhprofData['main()']) && $xhprofData['main()']){
			$ct = $xhprofData['main()']['ct'];
			$wt = $xhprofData['main()']['wt'];
			$cpu = $xhprofData['main()']['cpu'];
			$mu = $xhprofData['main()']['mu'];
			$pmu = $xhprofData['main()']['pmu'];
		}

		$result = array();
		$result['url'] = "'" . $data['host'] . $data['uri'] . "'";
		$result['host'] = "'" . $data['host'] . "'";
		$result['uri'] = "'" . $data['uri'] . "'";
		$result['xhprof_id'] = "'" . $data['xhprofid'] . "'";
		$result['xhprof_data'] = "'" . $data['xhprofdata'] . "'";
		$result['xhprof_time'] = "'" . $data['timestamp'] . "'";

		$result['ct'] = isset($ct) ? $ct : 0;
		$result['wt'] = isset($wt) ? $wt : 0;
		$result['mu'] = isset($mu) ? $mu : 0;
		$result['pmu'] = isset($pmu) ? $pmu : 0;
		$result['cpu'] = isset($cpu) ? $cpu : 0;

		$items = implode(',', $result);

		$link = mysql_connect(self::HOST . ':' . self::PORT, self::USER, self::PASSWORD);
		if(!$link){
			echo 'mysql连接错误,错误号:' . mysql_errno($link) . "错误描述:" . mysql_error($link);
		}
		mysql_select_db(self::DBNAME);
		mysql_query('SET NAMES "UTF8"');

		$sql ="INSERT INTO `xhprofui`.`xhprofui_detail`(url,host,uri,xhprof_id,xhprof_data,xhprof_time,ct,wt,mu,pmu,cpu) VALUES ($items)";
		$bool = mysql_query($sql);
		if(!$bool){
			echo mysql_error($link);
		}
		mysql_close($link);
	}
}
