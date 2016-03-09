<?php
date_default_timezone_set ( 'Asia/Chongqing' );

$logFileName = $argv[1];
//$logFileName = "/data1/tongzhen1/trendXhprofLog/tmpData/1720148342.log";
$fp = fopen($logFileName, "r");
if (empty($fp)){
    echo "file {$logFileName} not exist!";
    exit();
}

$count = 0;

while(!feof($fp)){
    $string = fgets($fp);
    $string = trim($string);
    if(empty($string)) {
	continue;
    }
    
    $result = array();
    $result = explode("`", $string);
    if (empty($result)){
	continue;
    }
//    print_r($result);
    //写入mysql样式
    

    $date = $result[0];
    $date_arr = explode(' ', $date);
    $date_str = substr($date_arr[0],2);

    $url = $result[1];//url
    if($pos = mb_strpos($string,'uid')){
        $subString = mb_substr($string, $pos+4);
        if($pos1 = mb_strpos($subString,'&')){
            $uid = mb_substr($subString, 0,$pos1);
        }else {
            $uid = $subString;
        }
    }else {
        $uid = '';
    }
    
    if(mb_strpos($url, 'obile.trend.recom.i.weibo.com')){
        $data_type = 1;//data_type
        $sourceId = 'trendmobile';
    }else{
        $data_type = 2;
        $sourceId = 'trendpc';
    }

    $business_type = $result[2];//business_type

    $runId = uniqid();
    $xhprof_id = "{$runId}.{$sourceId}.uid:{$uid}_type:{$business_type}_time:{$date_str}.xhprof";//xhprof_id
    
	$xhprof_data_str = serialize($result[9]);
        $xhprof_data = json_decode($result[9], true);
	if(isset($xhprof_data['main()']) && $xhprof_data['main()']){
		$ct = $xhprof_data['main()']['ct']; //ct
		$wt = $xhprof_data['main()']['wt']; //wt
		$cpu = $xhprof_data['main()']['cpu'];//cpu
		$mu = $xhprof_data['main()']['mu']; //mu
		$pmu = $xhprof_data['main()']['pmu']; //pmu
	}

	$business_trace = "uid:{$uid}_type:{$business}_time:{$date_str}";//business_trace

	$business_time = strtotime($date);//business_time

	$appid = 2;
	$business_uid = $uid;

//	(url, xhprof_id, xhprof_data, business_type, business_trace, business_time, ct, wt, mu, pmu, cpu, data_type, appid, business_uid)
	$lines = $url."\t".$xhprof_id."\t".$xhprof_data_str."\t".$business_type."\t".$business_trace."\t".$business_time."\t".$ct."\t".$wt."\t".$mu."\t".$pmu."\t".$cpu."\t".$data_type."\t".$appid."\t".$business_uid;

	echo $lines."\n";

}
