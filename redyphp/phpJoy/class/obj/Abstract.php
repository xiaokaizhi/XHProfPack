<?php
/**
 * 
 * 抽象类
 * @author tongzhen1
 *
 */
abstract class obj_Abstract {
	
	
	/**
	 * 
	 * 计算百分率
	 * @param unknown_type $num1
	 * @param unknown_type $num2
	 */
	public function percentCalculator($num1, $num2) {
       	if (intval($num2) == 0) {
            		return '0%';
       	}
       	$num = intval($num1) / intval($num2) * 100;
        $result = round($num, 2);
        return $result . '%';
   	 }

   	/**
   	 * 
   	 * 除法
   	 * @param unknown_type $num1
   	 * @param unknown_type $num2
   	 */ 
   	public static function getMutiData($num1, $num2){
   		if (empty($num2)){
   			return 0;
   		}
   		
   		$num = ($num1/$num2) * 1000000;
   		$result = round($num);
   		return $result;
   	}
}
