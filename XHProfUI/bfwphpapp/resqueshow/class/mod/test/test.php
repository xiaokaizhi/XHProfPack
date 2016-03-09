<?php
/**
 * here is introduce
 * @author	yourname <yourname@mail.com>
 * @date	2014-05-25 13:42:47
 */
class Mod_test extends Mod {
	public function run() {
		//echo __METHOD__;
		BFW_View::setTplDir(PATH_TPL);

		BFW_View::set('test', 'tongzhen echart');
		
		//$string = BFW_View::get('test');
		//echo $string;

		BFW_View::display('test.php'); // 直接显示模板
	}
}
