<?php

if(empty($argv[1])) {
	die('Specify the name of a job to add. e.g, php queue.php PHP_Job');
}

require dirname(dirname(dirname(__DIR__))) . '/include/php-resque/lib/Resque.php';

date_default_timezone_set('GMT');

$dsn = '127.0.0.1:6379';
Resque::setBackend($dsn);

$args = array(
	'time' => time(),
	'array' => array(
		'test' => 'test',
	),
);

$jobId = Resque::enqueue('default', $argv[1], $args, true);

echo "Queued job ".$jobId."\n\n";
?>
