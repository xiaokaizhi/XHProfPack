<?php
/**
 * Worker 方法：将redque队列数据读取后写入到mysql
 *
 */
include dirname(dirname(dirname(__DIR__))).'/bootstrap.php';

$instance =	dao_chart::getInstance();
$instance->setDBName('trends');
//[1]get data
$instance->setTableName('trends.trend_detail');
$instance->setTablePrimaryKey('id');

//$result = $instance->get("id = :id", "*", array(':id' => 151));
//print_r($result);
//echo "\n";

//[2]set data
$instance->setTableName('trends.sample');
$instance->setTablePrimaryKey('sample_id');

//$res = $instance->set(array('content'=>'"tongzhen2"'));
//echo $res;
