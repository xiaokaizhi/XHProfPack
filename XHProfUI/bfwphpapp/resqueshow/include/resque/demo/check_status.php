<?php

/**
 * php check_status.php jobId 'redisIP:port'  
 *
 * eg.  php check_status.php 0c2ee71f5075dce5320b8985414804ab '172.16.89.199:6601'
 */
if(empty($argv[1])) {
	die('Specify the ID of a job to monitor the status of.');
}

$path =  dirname(__DIR__);
require $path.'/lib/Resque/Job/Status.php';
require $path.'/lib/Resque.php';

date_default_timezone_set('GMT');


$dsn = '127.0.0.1:6379';//默认
if(!empty($argv[2])){
	$dsn = $argv[2];
}
Resque::setBackend($dsn);

$status = new Resque_Job_Status($argv[1]);
if(!$status->isTracking()) {
	die("Resque is not tracking the status of this job.\n");
}

echo "Tracking status of ".$argv[1].". Press [break] to stop.\n\n";
while(true) {
	fwrite(STDOUT, "Status of ".$argv[1]." is: ".$status->get()."\n");
	sleep(1);
}
?>
