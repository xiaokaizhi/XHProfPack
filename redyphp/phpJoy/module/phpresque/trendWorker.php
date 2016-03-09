<?php
/**
 * php-resque worker 脚本
 *
 */
date_default_timezone_set('GMT');

$dir = __DIR__;
require $dir.'/trendjob.php';

$path = dirname(dirname(__DIR__));
require $path.'/include/php-resque/resque.php';
