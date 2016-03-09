<?php
/**
 * Redis
 * @author baojunbo <baojunbo@gmail.com>
 */

class BFW_Redis {
    private $_redids;

	public function __call($method, $params){
		return call_user_func_array(array($this->_redids, $method), $params);
    }

    protected function _connect($redisServer, $pconnect = false) {
    	$redis = new Redis();
    	if (!$pconnect) {
    		$redis->connect($redisServer['host'], $redisServer['port'], $redisServer['timeout']);
    	} else {
    		$redis->pconnect($redisServer['host'], $redisServer['port'], $redisServer['timeout']);
    	}
    	$this->_redids = $redis;
    }
}