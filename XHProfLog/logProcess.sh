#!/bin/bash
#crontab
# 50 */1 * * * sh logProcess.sh

#todo 修改phpbin,mysqlbin目录
phpBin='/home/users/tongzhen/bdp/php/bin/php'
mysqlBin='/home/users/tongzhen/mysql/bin/mysql'

#临时目录
tempDir=$PWD/temp
if [ ! -d $tempDir ];then
	mkdir -p $tempDir
fi
#时间
lastDate="`date '+%Y%m%d' --date="1 hour ago"`"
lastYear="`date '+%Y' --date="1 hour ago"`"
lastMonth="`date '+%m' --date="1 hour ago"`"
lastDay="`date '+%d' --date="1 hour ago"`"
lastHour="`date '+%H' --date="1 hour ago"`"
lastMinute="`date '+%M' --date="1 hour ago"`"
lastTime="$lastDate-$lastHour:00:00"

#结果目录
resultDir=$PWD/result/$lastDate;
if [ ! -d $resultDir ];then
	mkdir -p $resultDir
fi

#源文件目录 todo 修改日志目录
sourceLog='/home/users/tongzhen/log'
logFileName="$sourceLog/$lastYear/$lastMonth/$lastDay/interface_$lastHour.log"
if [ -f "$logFileName" ];then
	#大文件切割
	split -l 1000000 $logFileName $tempDir/sourceLog

	#awk处理得到含有xhprofdata结果
	num=0
	fileNameList=`ls -l|grep 'sourceLog*'`
	for fileName in $fileNameList;
	do
		if [ -f $fileName ]; then
		    num=`expr $num + 1`
		    cat $fileName |awk -F'`' '{if(NF==9 && $NF!="") print $0;}' > "$tempDir/xhprofData$num"
		fi
	done

	#删除切割后的文件
	rm -rf "$tempDir/sourceLog*"

	#转换为MySQL样式
	resultFileName="$resultDir/result_$lastHour.txt"

	xhprofFileList=`ls -l|grep 'xhprofData*'`
	for xhprofFileName in $xhprofFileList;do
		$phpBin $PWD/logProcess.php $xhprofFileName >> "$resultFileName"
	done

	#删除源文件
	rm -rf "$tempDir/xhprofData*"
	
	#处理后的文件写入MySQL
	if [ -f "$resultFileName" ]; then
		chmod 0777 "$resultFileName"

		#todo 修改数据库连接地址
		$mysqlBin -h127.0.0.1 -P3306 -uroot -p123456 -D xhprofui --local-infile -e "load data local infile \"$resultFileName\" into table xhprofui_detail(url, xhprof_id, xhprof_data, xhprof_time, ct, wt, mu, pmu, cpu);"
	fi
fi

#删除12个小时前的数据
oneDay="`date '+%Y%m%d' --date="12 hour ago"`"
rm -rf "$PWD/result/$oneDay"