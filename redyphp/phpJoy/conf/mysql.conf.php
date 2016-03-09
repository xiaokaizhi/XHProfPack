<?php

$mysqlConfig = array(
	'xhprofui' => array('dsn' => 'mysql:host=127.0.0.1', 'user' => 'root', 'pass' => 'tongzhen', 'params' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true)),
);

return $mysqlConfig;
