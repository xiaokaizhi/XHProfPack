<?php
class Dao_Mysql extends BFW_Mysql {
	protected $_dbName = ''; // 数据库

	protected function _getServer($rw) {
		if (!$this->_dbName) throw new ErrorException("$_dbName is empty!", 30001);
		$server = BFW_Config::get('mysql.' . $this->_dbName); // 获取配置
		//$server = array('dsn' => 'mysql:host=localhost', 'user' => 'userName', 'pass' => 'password', 'params' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
		return $server;
	}
}
