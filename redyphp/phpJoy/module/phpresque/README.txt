README:

(1)mysql数据库及配置
$ROOT/conf/mysql.conf.php
mysql.xhprofui //xhprofui数据库

mysql数据库、表、主键设置在$ROOT/module/phpresque/trendlog.php

新建数据库xhprofui,创建表xhprofui_detail(./sqlScript/xhprofui_detail.sql)

(2)待处理php-resque队列redis配置
$ROOT/conf/redis.conf.php
redis.resque


(3)运行脚本
$ROOT/module/phpresque/trendWorker.php


INTERVAL=1 REDIS_BACKEND='127.0.0.1:6379' QUEUE=trend php trendWorker.php > 1.log 2>&1 &
refer to:
VVERBOSE=1 INTERVAL=1 REDIS_BACKEND='127.0.0.1:6379' QUEUE=trend /path/to/bin/php path/to/trendWorker.php > 1.log 2>&1 &
说明：
VVERBOSE=1 详细运行日志
INTERVAL=1 查询resque队列时间，默认5秒
REDIS_BACKEND='127.0.0.1:6379' PHP-resque写入后台的redis配置
QUEUE=trend  队列名称trend (*表示全部)
/path/to/bin/php trendWorker.php php路径和worker脚本完整路径名称

		
(4)说明
trendlog.php中包含了文件bootstrap.php,根文件中定义了魔术方法__autoload()会去class目录下查找类trendlog，所以在config目录的class.conf.php中配置了一行：'trendlog'	=> 'module/phpresque/trendlog.php',
