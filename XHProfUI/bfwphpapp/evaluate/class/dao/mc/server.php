<?php
class Dao_Mc_Server extends Dao_Mc {
	protected $_daoName = 'server';
	private static $_single = null;

	public static function getInstance() {
		if (!self::$_single) self::$_single = new self;
		return self::$_single;
	}
}
