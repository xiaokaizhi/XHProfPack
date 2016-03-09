<?php
require_once dirname(dirname(__DIR__))."/bootstrap.php";

date_default_timezone_set ( 'Asia/Chongqing' );

define('TIMEOUT_PERCENTAGE', 10);
define('KEYNAME', 'log:daily:trendinterfacelogtest:');//@todo

$logFileName = $argv[1];
//$logFileName = '/tmp/2014/02/25/result/26pctest.txt';
$fp = fopen($logFileName, "r");
if (empty($fp)){
	echo "file {$logFileName} not exist!";
	exit();
}

$time = $argv[2];//20140224 16:46:25
//$time = "20140225 14:00:00";
$timeStamp = strtotime($time);

while(!feof($fp)) {
        $line = fgets($fp);
        $line = trim($line);
        if(empty($line)) {
             continue;
        }
 
        $parts = array();
        $parts = explode('`', $line); 
        $time = $parts[0];
        $request = $parts[1];
        $output = $parts[2];
        $debugs = $parts[3];
 
        //[0] time
        //echo $time."\n"; 
        //[1] request
        //echo $request."\n";
        
        //[2]output
        //echo $output."\n";
        $interfaceResult = array();
        $interfaceResult = json_decode($output, true);
        //echo '<pre>';print_r($interfaceResult);exit();
        if (isset($interfaceResult['type'])){
        	$type = $interfaceResult['type'];
        	$typeName = obj_config::getTypeName($type);
        	$className = "mod_{$typeName}";        	
        }else {
        	continue;
        } 
 
        //[3]debug
        if ($debugs){
       		$debug_arr = array();
        	$debug_arr = explode('^', $debugs);        
        	foreach($debug_arr as $key => $value) {
        		$detail = array();
                $detail = explode('~', $value);
                //echo '<pre>';print_r($detail);//exit();                
                if ($detail[3] == 'info' && $detail[0]){
                	$className::setData($detail);
                }                
        	}        	
        }else {
        	continue;
        }
}

//$keyNamePrefix = KEYNAME."picture:";
//mod_picture::addData($keyNamePrefix, $timeStamp);


$type_arr = obj_config::getTypeName();
foreach ($type_arr as $type=>$name){
	$className = "mod_{$name}";		
	$keyNamePrefix = KEYNAME.$name.":";
	$className::addData($keyNamePrefix, $timeStamp);
}
