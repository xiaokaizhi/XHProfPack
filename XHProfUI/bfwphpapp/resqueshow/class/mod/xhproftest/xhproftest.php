<?php
/**
 * xhprof测试程序
 * @author	tongzhen <tongzhen@live.com>
 * @date	2014-03-21 08:44:21
 * http://localhost/githubredy/bfwphpapp/resqueshow/app.php?target=mod_xhproftest
 */
class Mod_xhproftest extends Mod {
	public function run() {
		//echo __METHOD__;
		Obj_xhprof::xhprofEnable();//是否开启xhprof调试
		Obj_xhprof::xhprofStart();//调试参数设置

		/**
		 * 执行业务
		 *
		 */
		
		
		//[1] xhprof data 存入php-resque队列(redis)
		$runId = Obj_xhprof::xhprofSaveDataRedis();
		echo $runId;

		
		//[2] xhprof data存入本地缓存文件
		/*
		$fileName = 'xhprof_foo';
		$run_id = Obj_xhprof::xhprofSaveData($fileName);

		$host = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'localhost';
		$uri = "http://$host/bfwphp/evaluate/include/xhprof/xhprof_html/index.php";
		$param = array('run'=>$run_id,'source'=>$fileName);

		$url = $uri.'?'.http_build_query($param);
		echo "<a href='".$url."'>统计页面</a>";
		 */
	}
}
