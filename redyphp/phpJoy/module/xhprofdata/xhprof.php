<?php
/**
 * xhprof 调试类
 * @author	tongzhen <elitetongzhen@126.com>
 * @date	2014-03-21 07:12:29
 */
define ('PATH_INCLUDE',dirname(dirname(__DIR__)).'/include');

class lib_xhprof{

	private static $_dsn = NULL;

	/**
	 * 设置写入队列的redis地址host:port
	 */
	public static function setDSN($dsn){
		self::$_dsn = $dsn;
	}

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
	 *
	 * 方法一：保存结果到php-resque队列
	 * 
	 * 
	 */
	public static function xhprofSaveDataRedis(){
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

		$jobId = self::addResqueQueue($data);
		return $jobId;
	}

	/**
	 * 将数据写入到resque队列
	 * @param $data
	 */
	private static function addResqueQueue($data){		
		include_once(PATH_INCLUDE.'/php-resque/lib/Resque.php');

		//读取Redis配置
		$dsn = self::$_dsn;
		if(empty($dsn)){
			$dsn = '127.0.0.1:6379';
		}

		Resque::setBackend($dsn);

		$args = array(
				'time' => time(),
				'array' => array('data' => $data),
			);

		$jobId = Resque::enqueue('trend', 'trendjob', $args, true);//队列名称trend，job名称trendjob
		return $jobId;
	}

	/**
	 * 方法二：保存数据到本地进行查看（利用xhprof/html程序进行查看）
	 * @param  string $fileName 临时文件名称
	 * @return string $run_id  返回文件id
	 */
	public static function xhprofSaveData($fileName){
		if(self::$_enable){
			$data = xhprof_disable();
			//数据保存
			//[1]存储到redis，唯一关键字  hSet存储
			//(1)设置unique id （2）存储json_encode($data)


			//[2]文件存储 php.ini  配置中xhprof.output_dir=""目录
			include PATH_INCLUDE . "/xhprof/xhprof_lib/utils/xhprof_lib.php";
			include PATH_INCLUDE . "/xhprof/xhprof_lib/utils/xhprof_runs.php";
			
			$xhprofRuns = new XHProfRuns_Default();
			$run_id = $xhprofRuns->save_run($data, $fileName);
			return $run_id;
		}
	}
}
