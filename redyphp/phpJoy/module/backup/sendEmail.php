<?php

/**
 * 发送电子邮件
 *
 */

require_once dirname(dirname(__FILE__))."/bootstrap.php";
date_default_timezone_set ( 'Asia/Chongqing' );

$mailBox_arr = array('elitetongzhen@126.com',);

$title = $argv[1];
$content = $argv[2];
if ($title && $content){
	obj_mail::sendMail($mailBox_arr,$title,$content);
}
