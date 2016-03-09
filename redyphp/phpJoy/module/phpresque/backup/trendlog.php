<?php
/**
 * Worker 方法：将redque队列数据读取后写入到mysql
 *
 */
include dirname(dirname(__DIR__)).'/dao/chart.php';

class trendlog{
	
	public function perform(){

		error_reporting(0);
		ini_set('display_errors', 0);	
			
		$instance =	dao_chart::getInstance();
		$instance->setDBName('trends');
		$instance->setTableName('trends.trend_log_detail');
		$instance->setTablePrimaryKey('id');
		
		$redisData = $this->args['array']['data'];
		//print_r($redisData);

		$traceInfo = $redisData['trace_info'];
		$traceInfo_arr = explode("_",$traceInfo);
		$businessType = substr($traceInfo_arr[1],5);
		$businessType = isset($businessType)?intval($businessType):0;
		$businessUid = substr($traceInfo_arr[0],4);
		if(isset($businessUid)){
			$businessUid = (string)$businessUid;
		}else {
			$businessUid = 0;
		}
		
		$xhprofData = unserialize($redisData['xhprof_data']);
		if(isset($xhprofData['main()']) && $xhprofData['main()']){
			$ct = $xhprofData['main()']['ct'];
			$wt = $xhprofData['main()']['wt'];
			$cpu = $xhprofData['main()']['cpu'];
			$mu = $xhprofData['main()']['mu'];
			$pmu = $xhprofData['main()']['pmu'];	
		}
		
		if(mb_strpos($redisData['url'],'obile.trend.recom.i.weibo.com') != false){
			$dataType = 1;
		}else{
			$dataType = 2;
		}

		$result = array();
		$result['url'] = "'".$redisData['url']."'";
		//$result['c_url'] = '';
		//$result['server name'] = '';
		$result['xhprof_id'] = "'".$redisData['xhprof_id']."'";
		$result['xhprof_data'] = "'".$redisData['xhprof_data']."'";
		//$result['type'] = '';
		$result['business_type'] = $businessType;
		//$result['business_data'] = '';
		$result['business_trace'] = "'".$traceInfo."'";
		$result['business_time'] = "'".$redisData['timestamp']."'";
		//$result['get'] = '';
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
}
