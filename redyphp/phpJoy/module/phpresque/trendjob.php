<?php
/**
 * Worker 方法：将redque队列数据读取后写入到mysql
 *
 */
include dirname(dirname(__DIR__)).'/bootstrap.php';
require PATH_INCLUDE.'/php-resque/lib/Resque/Job/Status.php';
require PATH_INCLUDE.'/php-resque/lib/Resque.php';

class trendjob{
	
	public function perform(){

		error_reporting(0);
		ini_set('display_errors', 0);	
			
		$instance =	dao_chart::getInstance();
		$instance->setDBName('xhprofui');
		$instance->setTableName('xhprofui.xhprofui_detail');
		$instance->setTablePrimaryKey('id');
		
		$redisData = $this->args['array']['data'];
		//print_r($redisData);
		
		$xhprofData = unserialize($redisData['xhprofdata']);
		if(isset($xhprofData['main()']) && $xhprofData['main()']){
			$ct = $xhprofData['main()']['ct'];
			$wt = $xhprofData['main()']['wt'];
			$cpu = $xhprofData['main()']['cpu'];
			$mu = $xhprofData['main()']['mu'];
			$pmu = $xhprofData['main()']['pmu'];	
		}
		
		$result = array();
		$result['url'] = "'".$redisData['host'] . $redisData['uri']."'";
		$result['host'] = "'".$redisData['host']."'";
		$result['uri'] = "'".$redisData['uri']."'";
		$result['xhprof_id'] = "'".$redisData['xhprofid']."'";
		$result['xhprof_data'] = "'".$redisData['xhprofdata']."'";
		$result['xhprof_time'] = "'".$redisData['timestamp']."'";
		
		$result['ct'] = isset($ct)?$ct:0;
		$result['wt'] = isset($wt)?$wt:0;
		$result['mu'] = isset($mu)?$mu:0;
		$result['pmu'] = isset($pmu)?$pmu:0;
		$result['cpu'] = isset($cpu)?$cpu:0;
		//print_r($result);	
		
		//insert into db
		$line = $instance->set($result);
		//echo $line;
	}

	//run after perform()
	//清除以及处理完的redis队列数据
	public function tearDown(){
		//获取当前处理的jobId
		$id = $this->job->payload['id'];
		//fwrite(STDOUT, "id: ".$id."\n");
		
		$redisConf = lib_config::get('redis.resque');
		$ip = $redisConf['ip'];
		$port = $redisConf['port'];
		if(!$ip || !$port){
			$dsn = '127.0.0.1:6379';//redis-queue
		}else {
			$dsn = "{$ip}:{$port}";
		}
		Resque::setBackend($dsn);

		$status = new Resque_Job_Status($id);
		if(!$status->isTracking()) {
			die("Resque is not tracking the status of this job.\n");
		}
		//echo $id.':status:'.$status->get()."\n";
		$status->stop();//处理完成后清除
	}

}
