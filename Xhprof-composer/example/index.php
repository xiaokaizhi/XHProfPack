<?php
/***************************************************************************
 * 
 * Copyright (c) 2015 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file XhprofTest.php
 * @author suqian(com@baidu.com)
 * @date 2015/12/30 17:59:02
 * @brief 
 *  
 **/

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once(dirname(__FILE__) . '/../src/psr4/Xhprof/Xhprof.php');

Vega\Xhprof\Xhprof::start();
echo 'hello world';
//the code your want to test
Vega\Xhprof\Xhprof::stop();
// is you not use stop(), it will auto run it when the code shutdown;