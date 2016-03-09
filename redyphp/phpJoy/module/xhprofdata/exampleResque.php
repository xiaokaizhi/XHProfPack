<?php
/**
 * xhprofdata 写入resque队列示例
 *
 * http://localhost/githubredy/redyphp/phpJoy/module/xhprofdata/exampleResque.php
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

//[1]方法一:写到程序执行最后
$runId = lib_xhprof::xhprofSaveDataRedis();
echo $runId;
//[2]方法二：程序完成后回调，写到xhprofStart()函数后即可
//register_shutdown_function(array('lib_xhprof', 'xhprofSaveDataRedis'));
