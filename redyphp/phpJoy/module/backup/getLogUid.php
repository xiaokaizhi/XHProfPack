<?php
require_once dirname(dirname(__FILE__))."/bootstrap.php";

/**
 * 处理包含LOGUID的日志，提取出uid
 */

$logFileName = $argv[1];
//$logFileName = '/tmp/2014/02/25/recommend_interface_uid_14.log';
$fp = fopen($logFileName, "r");
if (empty($fp)){
	echo "file {$logFileName} not exist!";
	exit();
}

while(!feof($fp)) {
        $line = fgets($fp);
        $line = trim($line);
        if(empty($line)) {
             continue;
        }
 
        $parts = array();
        $parts = explode('`', $line); 
        //$time = $parts[0];
        //$request = $parts[1];
        //$output = $parts[2];
        $debugs = $parts[3];
 
        //[0] time
        //echo $time."\n"; 
        //[1] request
        //echo $request."\n";
        
        //[2]output
        //echo $output."\n";
        //$interfaceResult = array();
        //$interfaceResult = json_decode($output, true);
        //echo '<pre>';print_r($interfaceResult);exit();
        
        //[3]debug
        if ($debugs){
       		$debug_arr = array();
        	$debug_arr = explode('^', $debugs);        
        	foreach($debug_arr as $key => $value) {
        		$detail = array();
                $detail = explode('~', $value);
                //echo '<pre>';print_r($detail);//exit();
                if ($detail[0]){
                	echo mb_substr($detail[0], 6);echo "\n";
                }
        	}        	
        }else {
        	continue;
        }
}
