<?php
class Dao_Redis extends BFW_Redis {
	protected $_daoName;

	public function __construct() {
		if (!$this->_daoName) throw new Exception('dao name is null!', 1);

		$server = $this->_getServer();
		$this->_connect($server);
	}

	// 子类可以重载该方法
	protected function _getServer() {
		// $server = BFW_Config::get('redis.'.$this->_daoName);
		$server = array('host' => '127.0.0.1', 'port' => 4396, 'timeout' => 0.1);
		return $server;
	}
}
