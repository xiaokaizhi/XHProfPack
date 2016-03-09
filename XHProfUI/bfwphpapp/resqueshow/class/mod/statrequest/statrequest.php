<?php
/**
 * here is introduce
 * @author	yourname <yourname@mail.com>
 * @date	2014-05-29 03:54:48
 */
class mod_statrequest extends mod {
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
		
		$search = BFW_Request::request('search', 'tone');
		$stTime = BFW_Request::request('dp1', 'tone');
		$endTime = BFW_Request::request('dp2', 'tone');
		$objtype = BFW_Request::request('objtype', 'tone');

		//默认值
		if($objtype == 'tone'){
			$objtype = 0;
		}

		$currentHour = date('H');
		$lastDayTime = date('Y-m-d H:i:s',mktime($currentHour-24));
		$currentTime = date('Y-m-d H:i:s');
		if($stTime == 'tone'){
			$stTime = $lastDayTime;
		}
		if($endTime == 'tone'){
			$endTime = $currentTime;
		}
		
		$stStamp = strtotime($stTime);
		$endStamp = strtotime($endTime);
		
		$where = "xhprof_time >={$stStamp} and xhprof_time <={$endStamp} and id > 0 order by id desc";
		
		//点击查询按钮
		if(1 == $search){
			if($objtype != 0 && !empty($host[$objtype])){
				$host_str = $host[$objtype];
				$where = "xhprof_time >={$stStamp} and xhprof_time <={$endStamp} and host='{$host_str}' and id > 0 order by id desc";

			}
		}

		BFW_View::set('objtype', $objtype);
		BFW_View::set('stTime', $stTime);
		BFW_View::set('endTime', $endTime);

		$fields = 'count(*) as total';
		$total = $instance->get($where, $fields);
		$perPage = 30;
		if(!empty($total['total'])){
			if($total['total']%$perPage == 0){
				$pageCnt = floor($total['total']/$perPage);
			}else {
				$pageCnt = floor($total['total']/$perPage) + 1;
			}
			BFW_View::set('pageCnt', $pageCnt);
		}
		if(isset($_REQUEST['pageid']) && !empty($_REQUEST['pageid'])){
			$pageid = $_REQUEST['pageid'];
		}else {
			$pageid = 1;
		}
		BFW_View::set('pageid',$pageid);

		$limit = ($pageid - 1)*$perPage;
		$limit_str = "limit {$limit},{$perPage}";
		$where .= ' '.$limit_str;
		$data = $instance->mget($where);
		if($data){
			BFW_View::set('resultFlag', true);
			BFW_View::set('tableData', $data);
			//echo json_encode($data);exit();
			
			$data1 = array();
			$data1 = array_reverse($data);
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
			BFW_View::set('resultFlag', false);
		}

		BFW_View::setTplDir(PATH_TPL.'/statrequest');
		BFW_View::display('index.php'); // 直接显示模板
	}
}
