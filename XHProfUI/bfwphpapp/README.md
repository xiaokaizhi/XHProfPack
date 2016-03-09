BFWPHP_APP
==========
本项目是在[BFWPHP](https://github.com/baojunbo/BFWPHP)建立起来的一个应用。集成了（1）xhprof性能分析工具；（2）邮件功能

主要实现了对xhprof性能分析数据的展示功能


目录结构
=========
``` php
| //项目根目录
|___evaluate //测试项目目录
|___lib //项目共用类
|___resqueshow //xhprof性能分析数据展示功能目录
	|___class //业务类
	|___config //配置文件
	|___include //第三方插件/工具
	|___log //日志文件夹
	|___tpl //模板文件
	|___app.php
	|___bootstrap.php //入口文件
|___bfw.php
```

展示页面样式
============

单次调用统计
------------
访问连接示例[http://localhost/githubredy/bfwphpapp/resqueshow/app.php?target=mod_statrequest](http://localhost/githubredy/bfwphpapp/resqueshow/app.php?target=mod_statrequest)
页面示例图：
![image](https://github.com/tongzhenredy/bfwphpapp/blob/master/image/example1.png)

分时调用统计
------------
访问连接示例[http://localhost/githubredy/bfwphpapp/resqueshow/app.php?target=mod_statline](http://localhost/githubredy/bfwphpapp/resqueshow/app.php?target=mod_statline)
页面示例图：
![image](https://github.com/tongzhenredy/bfwphpapp/blob/master/image/example2.png)



others
=========
在BFWPHP框架中集成xhprof性能分析工具，增加发邮件mail功能

1、xhprof性能分析工具数据提取和显示
（1）抽样日志：多台前端机结果写入php-resque队列，后台守护进程读取队列结果（xhprof_data）,写入Mysql表；（2）前端用开源图像库EChart做统计查询展示；
（2）全量日志：采用写入本地文件的方式，用splite Shell指令分割大文件，启动多进程PHP脚本分别处理，结果处理成MySQL表的结构样式，从而导入到MySQL中
ps：xhprof Data需要全字段保存到MySQL中，可以通过xhprof自带的统计图展示




