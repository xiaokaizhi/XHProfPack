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
require_once(dirname(__FILE__) . '/../src/psr4/Xhprof/Xhprof.php');

use Vega\Xhprof\Xhprof;

Xhprof::start($source='xhprof');
//source可以认为是文件/列表后缀 不添加的话默认是xhprof

echo 'hello world';
//the code your want to test

Xhprof::stop();
// is you not use stop(), it will auto run it when the code shutdown;
// show url : http://host:port/vegadir/Xhprof/src/xhprof/xhprof_html;
