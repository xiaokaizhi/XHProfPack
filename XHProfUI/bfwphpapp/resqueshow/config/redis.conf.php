<?php
//[1]resque 队列
$redisConfig = array(
			'resque' => array('host'=>'127.0.0.1', 'port'=>6379, 'timeout'=>0.1), 

);

return $redisConfig;
