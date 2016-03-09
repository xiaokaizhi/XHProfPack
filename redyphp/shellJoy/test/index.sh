#!/bin/bash
#每小时第10分钟处理上个小时日志
#10 */1 * * * sh 
sourceLogDir="/data0/logs"

path="/data0/tongzhen1/trendInterfaceLog"
phpDir="$path/phpScript"
logDir="$path/logProcess"
resultDir="$path/result"

whiteListFile="./whiteList.txt"

#2小时前
resDate="`date '+%Y%m%d' --date="2 hours ago"`"
resYear="`date '+%Y' --date="2 hours ago"`"
resMonth="`date '+%m' --date="2 hours ago"`"
resDay="`date '+%d' --date="2 hours ago"`"
resHour="`date '+%H' --date="2 hours ago"`"
resMin="`date '+%M' --date="2 hours ago"`"

resTime="$resDate $resHour:00:00"

#(1)处理实时日志
sourceLogDirFileName="$sourceLogDir/$resYear/$resMonth/$resDay/$resHour/recommend_interface_$resHour.log"
if [ -f $sourceLogDirFileName ];
then
	logFileDir="$logDir/$resDate/$resHour"
	test -d $logFileDir
        if [ $? -ne 0 ];
        then
           mkdir -p $logFileDir
        fi
	#原始日志处理
	#(1）含LOGUID
	logFileUidName="$logFileDir/recommend_interface_uid.log"
	cat $sourceLogDirFileName | grep "LOGUID"  > $logFileUidName
	
	#原始文件删除LOGUID的行
        sed -i "/LOGUID/d" $sourceLogDirFileName
	
	#(2) 不含LOGUID
	#logFileResultName="$logFileDir/recommend_interface_result.log"
	#cat $sourceLogDirFileName | grep -v "LOGUID"  > $logFileResultName
	
	#(3) 遍历白名单，保留日志一周
	logFileWhiteListDir="$logDir/$resDate/whitelist"
	test -d $logFileWhiteListDir
	if [ $? -ne 0 ]
	then
		mkdir -p $logFileWhiteListDir
	fi

	for line in `cat $whiteListFile`
	do
		logFileWhiteListDirFile="$logFileWhiteListDir/recommend_interface_$line.log"
		cat $sourceLogDirFileName | grep "uid=$line" >>$logFileWhiteListDirFile
	done

	#(1)@todo 计算一个小时内访问最多的uid  awk
	if [ -f "$logFileUidName" ];
        then
		logFileUidNameTmp="$logFileDir/recommend_interface_uid_only.log"
		php "$phpDir/getLogUid.php" "$logFileUidName" >> "$logFileUidNameTmp"
		
		logFileUidNameTmpResult="$logFileDir/recommend_interface_uid_only_result.log"
		cat "$logFileUidNameTmp" | awk '{a[$1]++}END{for (j in a) print j","a[j]}'|awk -F"," '{if($2>10) print $1":"$2}' > $logFileUidNameTmpResult
		#删除uid_only
		#rm -rf $logFileUidNameTmp;

		#处理完成后删除结果日志
		#rm -rf "$logFileUidName"
		
		#发送异常结果
		for content in `cat $logFileUidNameTmpResult`
		do
			php "$phpDir/sendEmail.php" "趋势访问异常uid大于10次" "the top request more than 10 times: $content"
		done
        fi


	#(2)计算一个小时内各个模块和模块内外部接口的访问耗时
	#if [ -f "$logFileResultName" ];
	#then
		resultFileDir=$resultDir/$resDate
                test -d $resultFileDir
                if [ $? -ne 0 ];
                then
                        mkdir -p $resultFileDir
                fi

                resultFileName="$resultFileDir/result$resHour.txt"
		#php脚本处理写入监控系统@todo 增加php全路径
		#php "$phpDir/index.php" "$logFileResultName" "$resTime" >> $resultFileName
		php "$phpDir/index.php" "$sourceLogDirFileName" "$resTime" >> $resultFileName
		
		#删除结果日志
		#rm -rf "$logFileResultName" 
	#fi
fi


