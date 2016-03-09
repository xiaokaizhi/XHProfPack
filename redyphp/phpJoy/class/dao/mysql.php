<?php

//include PATH_LIB.'/mysql.php';

class dao_mysql extends lib_mysql {
	protected $_dbName = ''; // 数据库

	protected function _getServer($rw) {
		if (!$this->_dbName) throw new ErrorException("$_dbName is empty!", 30001);
		//$server = array('dsn' => 'mysql:host=localhost', 'user' => 'root', 'pass' => 'tongzhen', 'params' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
		$server = lib_config::get('mysql.' . $this->_dbName); // 获取配置
		return $server;
	}
}
