<?php
/**
 * App
 * @author baojunbo <baojunbo@gmail.com>
 */

class lib_app {
	private $_target = 'target'; // target标识
	private $_userError = false; // 使用自定义错误类
	private $_debug = true; // 调试信息

	public function __construct($target = null) {
		if ($target) $this->_target = $target;
	}

    public function run($classMethod = null){
    	try {
    		if ($this->_userError) set_error_handler(array('lib_Error', 'setError'));
    		lib_Debug::$debug = $this->_debug;

			$debugKey = __METHOD__;
			lib_Debug::start($debugKey);

			$this->_checkDefined();

			if (!$classMethod) $classMethod = lib_Request::request($this->_target);
			if (!$classMethod) {
				$argv = lib_Request::server('argv');
				if (!empty($argv[1])) {
					$classMethod = $argv[1];
					unset($argv[1]);
				}
				unset($argv[0]);
			}
			if (!$classMethod && PHP_SAPI != 'cli') $classMethod = "view_index";
			if (!$classMethod) throw new ErrorException("target is null! " . __FILE__ . " " . __LINE__, 1);

			$res = lib_Controller::get($classMethod, $argv);
			if ($res) {
				print_r($res);
			}

			lib_Debug::end($debugKey);
		} catch (Exception $e) {
			$code  = $e->getCode();
			$msg   = $e->getMessage();
			$trace = json_encode($e->getTrace());
			header("Content-type: application/json;charset=utf-8");
			die('{"code": ' . $code . ', "msg": "' . $msg . '", "trace": ' . $trace . '}');
		}
    }

    public function __destruct() {
    	try {
    		lib_Debug::writeDebugInfo();// 将调试信息写入文件，在程序结束时调用
    		lib_Log::write();// 写入日志，在程序结束时调用
    	} catch (Exception $e) {
    		$code= $e->getCode();
			$msg = $e->getMessage();
			$trace = $e->getTraceAsString();
			die('{"code" => ' . $code . ', "msg" => "' . $msg . '", "trace" => "' . $trace . '"}');
    	}
    }

    public function setUserError($userError = true) {
    	$this->_userError = $userError;
    }

    public function setDebug($onOff = true) {
    	$this->_debug = $onOff;
    }

    private function _checkDefined() {
    	if (!defined('PATH_LIB')) throw new ErrorException("PATH_LIB is not defined!", 101);
    	if (!defined('PATH_CONFIG')) throw new ErrorException("PATH_CONFIG is not defined!", 102);
    	if (!defined('PATH_CLASS')) throw new ErrorException("PATH_CLASS is not defined!", 103);
    	if (!defined('PATH_INCLUDE')) throw new ErrorException("PATH_INCLUDE is not defined!", 104);
    	if (!defined('PATH_LOG')) throw new ErrorException("PATH_LOG is not defined!", 105);
    }
}
