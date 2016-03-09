<?php
/**
 * echart 主页面
 * @author	yourname <yourname@mail.com>
 * @date	2014-05-22 00:41:27
 */
class Mod_index extends Mod {
	public function run() {


		BFW_View::set('test', 'tongzhen echart');
		//$string = BFW_View::get('test');
		//echo $string;

		BFW_View::setTplDir(PATH_TPL.'/statindex');
		BFW_View::display('index.php'); // 直接显示模板

	}
}
