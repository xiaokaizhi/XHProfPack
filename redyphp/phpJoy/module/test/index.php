<?php
require_once dirname(dirname(__DIR__))."/bootstrap.php";

date_default_timezone_set ( 'Asia/Chongqing' );

$redisConf = lib_config::get('redis.resque');
var_dump($redisConf);
