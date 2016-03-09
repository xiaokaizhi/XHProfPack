redyphp
=======

[XHProf](https://github.com/facebook/xhprof)是一个分层PHP性能分析工具。它报告函数级别的请求次数和各种指标，包括阻塞时间，CPU时间和内存使用情况。
本项目的主要目标是将XHProf采集到的各性能指标保存到数据库中，以供页面工具进行查询和查看，具体内容的查看请参考项目[bfwphpapp](https://github.com/tongzhenredy/bfwphpapp)。

本项目采用mysql数据库来存储XHProf的数据
考虑到互联网产品的用户量大，对接口的性能压力大，同时一个实际项目单条访问的xhprof数据长度很大，存储到本地（受限于磁盘IO操作）或者直接传输保存到Mysql（传输字节长度大，可考虑保存在当前前端机上）。本项目提供了三种方式来实现对XHProf数据的存储，记录方式包括采样记录和全量记录。

	（1）直接连接Mysql，存储到Mysql
	（2）使用php-resque队列方式
	（3）记录本地日志方式


方案描述
---------------
（1）直接连接Mysql，存储到Mysql
由于XHProf数据量大，如果接口访问量很大，会造成与Mysql的连接数过大，同时数据在前端机间传输会占用带宽

（2）使用php-resque队列方式
引入redis队列工具 [php-resque](https://github.com/chrisboulton/php-resque),实时将数据存入redis队列，然后通过后台守护进程，几乎实时的将队列数据读出写入到Mysql数据库


（3）记录本地日志方式
记录当前访问的XHProf数据到前端机本地，每小时汇总一次前端机的日志进行处理或实时推送日志到一台前端机实时处理

评价：以上三种方式的使用都会对接口性能产生影响，特别是在多并发访问同一接口时，此外XHProf数据量比较大，网络传输和本地存储（磁盘IO操作多）都会特别耗时，对于接口性能在50-200ms级要求下，需要权衡下各种方案的利弊。

在实际的项目运用中，推荐第二种使用php-resque的方式，采用采样的方式记录XHProf数据，后台进程基本可以实时的查看当前访问结果，对于性能监控作用比较大。


项目目录结构
=============
``` redyphp
| //项目根目录
|___phpJoy
	|___class //业务类
	|___conf //配置文件
	|___include
		|___php-resque //php-resque源码
		|___xhprof //xhprof 0.9.4 源码
	|___lib //共用类
	|___module
		|___phpresque  //phpresque对列读取
		|___xhprofdata // phpresque方式写队列
		|___xhprofmysql //mysql方式
|___shellJoy //log方式
	|___phpresque
		|___phpScript //php 脚本处理写入mysql
		|___shellScript //shell脚本处理日志
```

（1）Mysql方式
--------------------
**描述：** 项目主文件[phpJoy/module/xhprofmysql/exampleMysql.php](phpJoy/module/xhprofmysql/exampleMysql.php)

（2）php-resque方式
---------------
**描述：** 项目主文件[phpJoy/module/xhprofdata/exampleResque.php](phpJoy/module/xhprofdata/exampleResque.php)

（3）本地日志方式
----------------
**描述：** 项目主文件[shellJoy/phpresque/phpScript/logProcess.php](shellJoy/phpresque/phpScript/logProcess.php)

**描述：** 项目主文件[shellJoy/phpresque/shellScript/logProcess.sh](shellJoy/phpresque/shellScript/logProcess.sh)

本地日志大文本处理可以参考[shellJoy/phpresque/phpScript/README.md](shellJoy/phpresque/phpScript/README.md)

写本地日志一个样例[shellJoy/phpresque/phpScript/log.php](shellJoy/phpresque/phpScript/log.php)



