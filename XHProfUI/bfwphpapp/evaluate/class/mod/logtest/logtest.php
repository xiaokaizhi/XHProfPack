<?php
/**
 * here is introduce
 * @author	yourname <yourname@mail.com>
 * @date	2014-04-23 00:04:18
 *
 * http://localhost/githubelite/bfwphpapp/evaluate/app.php?target=Mod_logtest
 *
 */
class Mod_Logtest extends Mod {
	public function run() {
		//echo __METHOD__;

		//[1]debug类型日志
		$debugKey = __METHOD__;
		BFW_Debug::start($debugKey);

		$result = 0;
		for($i = 0; $i <= 100; $i++){
			$result += $i;
		}
		echo $result;
		BFW_Debug::setDebugInfo($debugKey,'result',$result);
		BFW_Debug::end($debugKey);

		//[2]五种类型日志（debug日志属于其中）
		BFW_Log::error('error log'); // error
		BFW_Log::notice('notice log'); // notice
		BFW_Log::warning('warning log'); // warning
		BFW_Log::fatal('fatal log'); // fatal
		BFW_Log::debug('debug log'); // debug
	}
}
