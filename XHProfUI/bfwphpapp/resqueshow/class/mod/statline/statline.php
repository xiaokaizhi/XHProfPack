<?php
/**
 * here is introduce
 * @author	yourname <yourname@mail.com>
 * @date	2014-05-26 00:22:00
 */
class Mod_statline extends Mod {
	public function run() {
		$instance = Dao_Mysql_Chart::getInstance();
		$instance->setDBName('xhprofui');
		$instance->setTableName('xhprofui.xhprofui_detail');
		$instance->setTablePrimaryKey('id');

		//distinct host
		$host_arr = $instance->mget('id > 0','distinct(host)');
		$host = array();
		$host[] = '全部';
		foreach($host_arr as $key=>$value){
			$host[] = $value['host'];
		}
		BFW_View::set('host', $host);
		
		$search = BFW_Request::get('search', 'tone');
		$objtype = BFW_Request::get('objtype', 0);
		if(empty($objtype)){
			$objtype = 0;
		}
		BFW_View::set('objtype', $objtype);

		$currentDate = date('Y-m-d H:i:s');
		$currentHour = date('H');
		$currentStamp = time();
		
		//[1]1小时
		$lastHourStamp = strtotime("-1 hour",time());
		$where1 = "xhprof_time >= {$lastHourStamp} and xhprof_time <= {$currentStamp}";
		if($search == 1){
			if($objtype && $host[$objtype]){
				$where1 = "host = '{$host[$objtype]}' and xhprof_time >= {$lastHourStamp} and xhprof_time <= {$currentStamp}";
			}
		}
		$data1 = $instance->mget($where1);
		//echo json_encode($data1);exit();
		if($data1 && !empty($data1[0]['id'])){
			BFW_View::set('resultFlag1', true);
			$id_arr = $wt_arr = $mu_arr = $pmu_arr = $cpu_arr = array();
			foreach($data1 as $value){
				$id_arr[] = '"'.$value['id'].'"';
				$wt_arr[] = '"'.$value['wt'].'"';
				$mu_arr[] = '"'.$value['mu'].'"';
				$pmu_arr[]= '"'.$value['pmu'].'"';
				$cpu_arr[]= '"'.$value['cpu'].'"';
			}
			$id_str = '['.implode(",",$id_arr).']';
			$wt_str = '['.implode(",",$wt_arr).']';
			$mu_str = '['.implode(",",$mu_arr).']';
			$pmu_str = '['.implode(",",$pmu_arr).']';
			$cpu_str = '['.implode(",",$cpu_arr).']';
			BFW_View::set('echartdatas_ids', $id_str);
			BFW_View::set('echartdatas_wts', $wt_str);
			BFW_View::set('echartdatas_mus', $mu_str);
			BFW_View::set('echartdatas_pmus', $pmu_str);
			BFW_View::set('echartdatas_cpus', $cpu_str);
		}else {
			BFW_View::set('resultFlag1', false);
		}

		
		//[2]6小时
		$lastSixHourStamp = strtotime("-6 hour",time());
		$where2 = "xhprof_time >= {$lastSixHourStamp} and xhprof_time <= {$currentStamp}";
		if($search == 1){
			if($objtype && $host[$objtype]){
				$where2 = "host = '{$host[$objtype]}' and xhprof_time >= {$lastSixHourStamp} and xhprof_time <= {$currentStamp}";
			}
		}
		$data2 = $instance->mget($where2);
		//echo json_encode($data2);exit();
		if($data2 && !empty($data2[0]['id'])){
			BFW_View::set('resultFlag2', true);
			$id_arr = $wt_arr = $mu_arr = $pmu_arr = $cpu_arr = array();
			foreach($data2 as $value){
				$id_arr[] = '"'.$value['id'].'"';
				$wt_arr[] = '"'.$value['wt'].'"';
				$mu_arr[] = '"'.$value['mu'].'"';
				$pmu_arr[]= '"'.$value['pmu'].'"';
				$cpu_arr[]= '"'.$value['cpu'].'"';
			}
			$id_str2 = '['.implode(",",$id_arr).']';
			$wt_str2 = '['.implode(",",$wt_arr).']';
			$mu_str2 = '['.implode(",",$mu_arr).']';
			$pmu_str2 = '['.implode(",",$pmu_arr).']';
			$cpu_str2 = '['.implode(",",$cpu_arr).']';
			BFW_View::set('echartdatas_ids2', $id_str2);
			BFW_View::set('echartdatas_wts2', $wt_str2);
			BFW_View::set('echartdatas_mus2', $mu_str2);
			BFW_View::set('echartdatas_pmus2', $pmu_str2);
			BFW_View::set('echartdatas_cpus2', $cpu_str2);
		}else {
			BFW_View::set('resultFlag2', false);
		}

		//[3]24小时
		$timeInstance = obj_time::getInstance();
		$resDate = $timeInstance->getHourSpan(24);
		//echo '<pre>';print_r($resDate);exit();
		$data3 = array();
		foreach($resDate as $key=>$value){
			$where3 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]}";
			if($search == 1 && $objtype && $host[$objtype]){
				$where3 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]} and host = '{$host[$objtype]}'";
			}
			
			$tmpData = $tmpData1 = array();
			$tmpData = $instance->mget($where3);		
			//echo json_encode($tmpData);
			if($tmpData){
				$tmpData1 = obj_caculate::process($tmpData); 
			}else {
				$tmpData1 = array('wt'=>0,'mu'=>0,'pmu'=>0,'cpu'=>0);
			}
			
			$data3[$key] = $tmpData1;		
		}
		//echo json_encode($data3);exit();
		if($data3){
			BFW_View::set('resultFlag3', true);
			$id_arr = $wt_arr = $mu_arr = $pmu_arr = $cpu_arr = array();
			foreach($data3 as $key=>$value){
				$id_arr[] = '"'.$key.'"';
				$wt_arr[] = '"'.$value['wt'].'"';
				$mu_arr[] = '"'.$value['mu'].'"';
				$pmu_arr[]= '"'.$value['pmu'].'"';
				$cpu_arr[]= '"'.$value['cpu'].'"';
			}
			$id_str3 = '['.implode(",",$id_arr).']';
			$wt_str3 = '['.implode(",",$wt_arr).']';
			$mu_str3 = '['.implode(",",$mu_arr).']';
			$pmu_str3 = '['.implode(",",$pmu_arr).']';
			$cpu_str3 = '['.implode(",",$cpu_arr).']';
			BFW_View::set('echartdatas_ids3', $id_str3);
			BFW_View::set('echartdatas_wts3', $wt_str3);
			BFW_View::set('echartdatas_mus3', $mu_str3);
			BFW_View::set('echartdatas_pmus3', $pmu_str3);
			BFW_View::set('echartdatas_cpus3', $cpu_str3);
		}else {
			BFW_View::set('resultFlag3', false);
		}

		//[4]2天
		$resDate4 = $timeInstance->getHourSpan(48);
		//echo '<pre>';print_r($resDate4);exit();
		$data4 = array();
		foreach($resDate4 as $key=>$value){
			$where4 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]}";
			if($search == 1 && $objtype && $host[$objtype]){
				$where4 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]} and host = '{$host[$objtype]}'";
			}
			
			$tmpData = $tmpData1 = array();
			$tmpData = $instance->mget($where4);		
			//echo json_encode($tmpData);
			if($tmpData){
				$tmpData1 = obj_caculate::process($tmpData); 
			}else {
				$tmpData1 = array('wt'=>0,'mu'=>0,'pmu'=>0,'cpu'=>0);
			}
			
			$data4[$key] = $tmpData1;		
		}
		//echo json_encode($data4);exit();
		if($data4){
			BFW_View::set('resultFlag4', true);
			$id_arr = $wt_arr = $mu_arr = $pmu_arr = $cpu_arr = array();
			foreach($data4 as $key=>$value){
				$id_arr[] = '"'.$key.'"';
				$wt_arr[] = '"'.$value['wt'].'"';
				$mu_arr[] = '"'.$value['mu'].'"';
				$pmu_arr[]= '"'.$value['pmu'].'"';
				$cpu_arr[]= '"'.$value['cpu'].'"';
			}
			$id_str4 = '['.implode(",",$id_arr).']';
			$wt_str4 = '['.implode(",",$wt_arr).']';
			$mu_str4 = '['.implode(",",$mu_arr).']';
			$pmu_str4 = '['.implode(",",$pmu_arr).']';
			$cpu_str4 = '['.implode(",",$cpu_arr).']';
			BFW_View::set('echartdatas_ids4', $id_str4);
			BFW_View::set('echartdatas_wts4', $wt_str4);
			BFW_View::set('echartdatas_mus4', $mu_str4);
			BFW_View::set('echartdatas_pmus4', $pmu_str4);
			BFW_View::set('echartdatas_cpus4', $cpu_str4);
		}else {
			BFW_View::set('resultFlag4', false);
		}
		
		//[5]1周
		$resDate5 = $timeInstance->getHourSpan(168);//7*24
		//echo '<pre>';print_r($resDate5);exit();
		$data5 = array();
		foreach($resDate5 as $key=>$value){
			$where5 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]}";
			if($search == 1 && $objtype && $host[$objtype]){
				$where5 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]} and host = '{$host[$objtype]}'";
			}
			
			$tmpData = $tmpData1 = array();
			$tmpData = $instance->mget($where5);		
			//echo json_encode($tmpData);
			if($tmpData){
				$tmpData1 = obj_caculate::process($tmpData); 
			}else {
				$tmpData1 = array('wt'=>0,'mu'=>0,'pmu'=>0,'cpu'=>0);
			}
			
			$data5[$key] = $tmpData1;		
		}
		//echo json_encode($data5);exit();
		if($data5){
			BFW_View::set('resultFlag5', true);
			$id_arr = $wt_arr = $mu_arr = $pmu_arr = $cpu_arr = array();
			foreach($data5 as $key=>$value){
				$id_arr[] = '"'.$key.'"';
				$wt_arr[] = '"'.$value['wt'].'"';
				$mu_arr[] = '"'.$value['mu'].'"';
				$pmu_arr[]= '"'.$value['pmu'].'"';
				$cpu_arr[]= '"'.$value['cpu'].'"';
			}
			$id_str5 = '['.implode(",",$id_arr).']';
			$wt_str5 = '['.implode(",",$wt_arr).']';
			$mu_str5 = '['.implode(",",$mu_arr).']';
			$pmu_str5 = '['.implode(",",$pmu_arr).']';
			$cpu_str5 = '['.implode(",",$cpu_arr).']';
			BFW_View::set('echartdatas_ids5', $id_str5);
			BFW_View::set('echartdatas_wts5', $wt_str5);
			BFW_View::set('echartdatas_mus5', $mu_str5);
			BFW_View::set('echartdatas_pmus5', $pmu_str5);
			BFW_View::set('echartdatas_cpus5', $cpu_str5);
		}else {
			BFW_View::set('resultFlag5', false);
		}
		
		//[6]今天
		$hour = date('H',time());
		$resDate6 = $timeInstance->getHourSpan($hour);//7*24
		//echo '<pre>';print_r($resDate6);exit();
		$data6 = array();
		foreach($resDate6 as $key=>$value){
			$where6 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]}";
			if($search == 1 && $objtype && $host[$objtype]){
				$where6 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]} and host = '{$host[$objtype]}'";
			}
			
			$tmpData = $tmpData1 = array();
			$tmpData = $instance->mget($where6);		
			//echo json_encode($tmpData);
			if($tmpData){
				$tmpData1 = obj_caculate::process($tmpData); 
			}else {
				$tmpData1 = array('wt'=>0,'mu'=>0,'pmu'=>0,'cpu'=>0);
			}
			
			$data6[$key] = $tmpData1;		
		}
		//echo json_encode($data6);exit();
		if($data6){
			BFW_View::set('resultFlag6', true);
			$id_arr = $wt_arr = $mu_arr = $pmu_arr = $cpu_arr = array();
			foreach($data6 as $key=>$value){
				$id_arr[] = '"'.$key.'"';
				$wt_arr[] = '"'.$value['wt'].'"';
				$mu_arr[] = '"'.$value['mu'].'"';
				$pmu_arr[]= '"'.$value['pmu'].'"';
				$cpu_arr[]= '"'.$value['cpu'].'"';
			}
			$id_str6 = '['.implode(",",$id_arr).']';
			$wt_str6 = '['.implode(",",$wt_arr).']';
			$mu_str6 = '['.implode(",",$mu_arr).']';
			$pmu_str6 = '['.implode(",",$pmu_arr).']';
			$cpu_str6 = '['.implode(",",$cpu_arr).']';
			BFW_View::set('echartdatas_ids6', $id_str6);
			BFW_View::set('echartdatas_wts6', $wt_str6);
			BFW_View::set('echartdatas_mus6', $mu_str6);
			BFW_View::set('echartdatas_pmus6', $pmu_str6);
			BFW_View::set('echartdatas_cpus6', $cpu_str6);

			//昨天对比
			$count = count($data6);
			$wt_arr76 = $mu_arr76 = $pmu_arr76 = $cpu_arr76 = array();
			if($count < 24){
				$wt_arr76 = $wt_arr;
				$mu_arr76 = $mu_arr;
				$pmu_arr76 = $pmu_arr;
				$cpu_arr76 = $cpu_arr;

				for($i = 0; $i<(24-$count); $i++){
					$wt_arr76[] = '"0"';
					$mu_arr76[] = '"0"';
					$pmu_arr76[] = '"0"';
					$cpu_arr76[] = '"0"';
				}
				//echo json_encode($wt_arr76);exit();
				$wt_str76 = '['.implode(",",$wt_arr76).']';
				$mu_str76 = '['.implode(",",$mu_arr76).']';
				$pmu_str76 = '['.implode(",",$pmu_arr76).']';
				$cpu_str76 = '['.implode(",",$cpu_arr76).']';
				BFW_View::set('echartdatas_wts76', $wt_str76);
				BFW_View::set('echartdatas_mus76', $mu_str76);
				BFW_View::set('echartdatas_pmus76', $pmu_str76);
				BFW_View::set('echartdatas_cpus76', $cpu_str76);

			}
			
		}else {
			BFW_View::set('resultFlag6', false);
		}
		
		//[7]昨天对比
		//昨天数据
		$resDate7 = $timeInstance->getHourSpan($hour+24);
		$resDate7 = array_slice($resDate7, 0 ,24);
		//echo '<pre>';print_r($resDate7);exit();
		$data7 = array();
		foreach($resDate7 as $key=>$value){
			$where7 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]}";
			if($search == 1 && $objtype && $host[$objtype]){
				$where7 = "xhprof_time >= {$value[0]} and xhprof_time <= {$value[1]} and host = '{$host[$objtype]}'";
			}
			
			$tmpData = $tmpData1 = array();
			$tmpData = $instance->mget($where7);		
			//echo json_encode($tmpData);
			if($tmpData){
				$tmpData1 = obj_caculate::process($tmpData); 
			}else {
				$tmpData1 = array('wt'=>0,'mu'=>0,'pmu'=>0,'cpu'=>0);
			}
			
			$data7[$key] = $tmpData1;		
		}
		//echo json_encode($data6);exit();
		if($data7){
			BFW_View::set('resultFlag7', true);
			$id_arr = $wt_arr = $mu_arr = $pmu_arr = $cpu_arr = array();

			foreach($data7 as $key=>$value){
				$id_arr[] = '"'.substr($key,5).'"';
				$wt_arr[] = '"'.$value['wt'].'"';
				$mu_arr[] = '"'.$value['mu'].'"';
				$pmu_arr[]= '"'.$value['pmu'].'"';
				$cpu_arr[]= '"'.$value['cpu'].'"';
			}
			$id_str7 = '['.implode(",",$id_arr).']';
			$wt_str7 = '['.implode(",",$wt_arr).']';
			$mu_str7 = '['.implode(",",$mu_arr).']';
			$pmu_str7 = '['.implode(",",$pmu_arr).']';
			$cpu_str7 = '['.implode(",",$cpu_arr).']';
			BFW_View::set('echartdatas_ids7', $id_str7);
			BFW_View::set('echartdatas_wts7', $wt_str7);
			BFW_View::set('echartdatas_mus7', $mu_str7);
			BFW_View::set('echartdatas_pmus7', $pmu_str7);
			BFW_View::set('echartdatas_cpus7', $cpu_str7);
		}else {
			BFW_View::set('resultFlag7', false);
		}


		
		BFW_View::setTplDir(PATH_TPL.'/statline');
		BFW_View::display('index.php'); // 直接显示模板
	}
}
