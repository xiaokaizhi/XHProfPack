<?php
/**
 * here is introduce
 * @date	2014-03-21 03:46:18
 */

$dir = __DIR__;
$libDir = dirname($dir);
define('PATH_LIB', "{$libDir}/lib");
define('PATH_CONFIG', "{$dir}/config");
define('PATH_CLASS', "{$dir}/class");
define('PATH_INCLUDE', "{$dir}/include");
define('PATH_LOG', "{$dir}/log");

require_once PATH_LIB . '/autoload.php';

$app = new BFW_App;
$app->setUserError(); // 使用自定义错误类收集错误信息
$app->setDebug(); // // 开启调试
$app->run();
