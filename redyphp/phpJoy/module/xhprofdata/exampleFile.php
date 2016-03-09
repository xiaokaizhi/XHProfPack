<?php
/**
 * xhprofdata 写入本地文件示例(xhprof原始用法)
 *
 * 本地存储目录是安装xhprof扩展时配置的dir(php.ini中)
 *
 * http://localhost/githubredy/redyphp/phpJoy/module/xhprofdata/exampleFile.php
 */
date_default_timezone_set ( 'Asia/Chongqing' );

//包含/lib/xhprof.php 类文件
$dir = __DIR__;
include $dir.'/xhprof.php';

//设置dsn
$dsn = '127.0.0.1:6379';
lib_xhprof::setDSN($dsn);

lib_xhprof::xhprofEnable();
lib_xhprof::xhprofStart();


$result = array();
for($i = 0; $i < 100000; $i++){
	$result[] = $i;
}
//echo json_encode($result);

//写入本地缓存文件
$fileName = 'xhprof_foo';
$run_id = lib_xhprof::xhprofSaveData($fileName);

$host = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'localhost';
$uri = "http://$host/githubredy/redyphp/phpJoy/include/xhprof/xhprof_html/index.php";

$param = array('run'=>$run_id,'source'=>$fileName);
$url = $uri.'?'.http_build_query($param);

echo "<a href='".$url."'>统计页面</a>";

