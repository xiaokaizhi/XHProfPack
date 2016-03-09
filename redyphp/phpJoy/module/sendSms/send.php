<?php
require_once dirname(dirname(__DIR__))."/bootstrap.php";

date_default_timezone_set ( 'Asia/Chongqing' );

$phoneNo = '18911852420';

$message3 = '乐不思蜀Tone';

$message2 = '乐不思蜀';//OK
$message = 'tongzhen';//OK

$message = mb_substr($message, 0, 80, 'utf-8');
obj_sms::send($message, $phoneNo);
