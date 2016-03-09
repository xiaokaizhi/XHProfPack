<?php
/**
 * xhprofdata 直接写入mysql示例
 *
 * http://localhost/githubredy/redyphp/phpJoy/module/xhprofmysql/exampleMysql.php
 */
date_default_timezone_set ( 'Asia/Chongqing' );

//包含/lib/xhprof.php 类文件
$dir = __DIR__;
include $dir.'/xhprof.php';

lib_xhprof::xhprofEnable();
lib_xhprof::xhprofStart();


$result = array();
for($i = 0; $i < 100000; $i++){
	$result[] = $i;
}
//echo json_encode($result);


//xhprof 结果数据
$redisData = lib_xhprof::getXhprofData();
//print_r($redisData);


//以下配置mysql，读取提取数据写入mysql
include dirname(dirname(__DIR__)).'/bootstrap.php';

$instance =	dao_chart::getInstance();
$instance->setDBName('xhprofui');
$instance->setTableName('xhprofui.xhprofui_detail');
$instance->setTablePrimaryKey('id');
		

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
//print_r($result);exit();	
		
//insert into db
$line = $instance->set($result);
echo $line;
