<?php
/**
 * 1、趋势Feed日志格式
 * (1)日志文件命名
 * 日志目录：/data1/sinawap/var/logs/wapcommon/recommend/
 * 文件名：yyyy/mm/dd/recommend_interface_hh.log
 * 例如：2013/01/01/recommend_interface_23.log * 
 * (2)日志内容
 * 日志内容：请求时间|设备|用户ID|初始趋势feed类型|最终呈现趋势feed类型|趋势feed内容
 * 例如：2013-01-01 12:00:11|iPhone3,1__weibo__3.3.5__ios__os4.3.1|1644879743|1.2|1.2|{type:1,datatype:2,feeds:[{url:"http://www.sina.com.cn"},{url:"http://www.sina.com"}]}
 * 
 *2、日志服务器信息
 *雍和宫/dpool日志   IP:10.221.20.77 目录：/data0/wboard2/
 *雍和宫/自有服务器	 IP:111.13.53.154 目录：/data1/logs/
 */

//$log_path = $argv[1];
$log_path = '/tmp/2014/02/19/recommend_interface_18.log';

$file = fopen($log_path, "r");
if(empty($file)) {
   exit('file error');
}
 
while(! feof($file)) {
        $line = fgets($file);
        $line = trim($line);
        if(empty($line)) {
             continue;
        }
 
        $parts = explode('`', $line);
 
        $time = $parts[0];
        $request = $parts[1];
        $return = $parts[2];
        $debugs = $parts[3];
 
 
        echo "REQUEST: ".$request."\n";
        echo "RETURN: \n";
        var_dump(json_decode($return, true));
 
        if(!$debugs) {
            continue;
        }
 
        $debug_parts = explode('^', $debugs);
        echo "DEBUGS: \n";
        foreach($debug_parts as $key => $value) {
                echo "#".$key.":";
                $detail = explode('~', $value);
                $string = $detail[0].'-'.$detail[3].'-'.$detail[1].'-'.$detail[2];
                echo mb_strimwidth($string, 0, 130, '..')."\n";
        }
}

 