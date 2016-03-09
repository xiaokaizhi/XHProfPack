<?php
//include dirname(__FILE__).'/mysql.php';

class dao_chart extends dao_mysql {
	private static $_single = null;

	public static function getInstance() {
		if (!self::$_single) self::$_single = new self;
		return self::$_single;
	}

	private function __construct() {
		//$this->_dbName = 'trends';
		//$this->_table  = 'trends.trend_log_detail';
		//$this->_primary= 'id';
	}

	protected $_dbName = '';
	protected $_table = '';
	protected $_primary = '';

	/**
	 * 设置数据库名称
	 * $param $dbName
	 */
	public function setDBName($dbName){
		$this->_dbName = $dbName;
	}
	/**
	 * 设置操作的表名
	 * @param $tableName
	 */
	public function setTableName($tableName){
		$this->_table = $tableName;
	}

	/**
	 * 设置操作表的主键名
	 * @param $primary  
	 */
	public function setTablePrimaryKey($keyName){
		$this->_primary = $keyName;
	}

	

}
