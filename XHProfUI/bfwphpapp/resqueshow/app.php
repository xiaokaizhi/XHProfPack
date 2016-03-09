<?php
/**
 * here is introduce
 * @date	2014-05-22 00:33:28
 */

$dir = __DIR__;
$libDir = dirname(__DIR__);
define('PATH_LIB', "{$libDir}/lib");
define('PATH_CONFIG', "{$dir}/config");
define('PATH_CLASS', "{$dir}/class");
define('PATH_INCLUDE', "{$dir}/include");
define('PATH_LOG', "{$dir}/log");//保证此目录有其他用户写入权限
define('PATH_TPL', "{$dir}/tpl");//设置tpl目录

require_once PATH_LIB . '/autoload.php';

$app = new BFW_App;
$app->setUserError(); // 使用自定义错误类收集错误信息
$app->setDebug(); // // 开启调试
$app->run();
