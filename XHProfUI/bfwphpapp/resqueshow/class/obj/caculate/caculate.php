<?php
/**
 * here is introduce
 * @author	yourname <yourname@mail.com>
 * @date	2014-06-09 09:31:48
 */
class obj_caculate extends obj {


	/**
	 *
	 *
	 */
	public static function process($data){
		if($data){
			$count = 1;
			$wt = $pmu = $mu = $cpu = 0;
			foreach($data as $value){
				$wt += $value['wt'];
				$pmu += $value['pmu'];
				$mu += $value['mu'];
				$cmu += $value['cpu'];

				$count++;
			}
			
			$resWt = self::getMutiData($wt, $count);
			$resPmu = self::getMutiData($pmu, $count);
			$resMu = self::getMutiData($mu, $count);
			$resCpu = self::getMutiData($cpu, $count);

			return array('wt' => $resWt,'pmu'=>$resPmu, 'mu'=>$resMu,'cpu'=>$resCpu);
		}else {
			return false;
		}

	}
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
   		
   		$num = $num1/$num2;
   		$result = round($num);
   		return $result;
   	}
}
