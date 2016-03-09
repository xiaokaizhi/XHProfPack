<?php
$dir = dirname(dirname(__DIR__));
define('PATH_LIB', '/var/www/bfwphp/lib');
define('PATH_CONFIG', "{$dir}/config");
define('PATH_CLASS', "{$dir}/class");
define('PATH_INCLUDE', "{$dir}/include");
define('PATH_LOG', "{$dir}/log");

require_once PATH_LIB . '/autoload.php';

class daemon_test extends BFW_Daemon {
	protected $_maxWorks = 5;
	protected $_daemonName = 'test';

	protected function _run() {
		// your code
	}
}

$cmds = array('start', 'stop', 'restart');
$cmd = isset($argv[1]) ? $argv[1] : '';
if (!$cmd) die("command last!\n");
if (!in_array($cmd, $cmds)) die("{$cmd} not exists!\n");
$test = new daemon_test;
$test->$cmd();