<?php
class Dao_Mc extends BFW_Memcache {
	protected $_daoName;

	public function __construct() {
		if (!$this->_daoName) throw new Exception('dao name is null!', 1);

		$server = $this->_getServer();
		$this->_connect($server);
	}

	// 子类可以重载该方法
	protected function _getServer() {
		// $server = BFW_Config::get('memcache.'.$this->_daoName);
		$server = array(array('127.0.0.1', 12012, 1), array('127.0.0.1', 12012, 1));
		return $server;
	}
}
