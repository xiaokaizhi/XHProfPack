#!/bin/bash
#crontab
# 50 */1 * * * sh /data1/tongzhen1/trendXhprofLog/shellScript/logProcess.sh
#/usr/local/sinawap/php/bin/php
sourceLogDir="/data1/logs"

path="/data1/tongzhen1/trendXhprofLog"
phpDir="$path/phpScript"
logDir="$path/tmpData"
resultDir="$path/result"

resDate="`date '+%Y%m%d' --date="1 hour ago"`"
resYear="`date '+%Y' --date="1 hour ago"`"
resMonth="`date '+%m' --date="1 hour ago"`"
resDay="`date '+%d' --date="1 hour ago"`"
resHour="`date '+%H' --date="1 hour ago"`"
resMin="`date '+%M' --date="1 hour ago"`"

resTime="$resDate-$resHour:00:00"

resHour=12
sourceLogFileName="$sourceLogDir/$resYear/$resMonth/$resDay/$resHour/recommend_interface_$resHour.log"
if [ -f $sourceLogDirFileName ];
then
    #[1]切割大文件100W行一个
    split -l 1000000 $sourceLogFileName sourceLog 
    
    #awk处理得到含有xhprofdata的结果
    num=0
    fileList=`ls -l|grep 'sourceLog*'`
    for fileName in $fileList;do
        if [ -f $fileName ];then
            num=`expr $num + 1`
            cat $fileName |awk -F'`' '{if(NF==10 && $NF!="") print $0;}' >"xhprofData$num"     
        fi;
    done
    
    rm -rf sourceLog*
    
    #存储成mysql样式
    resultFileDir=$resultDir/$resDate
    test -d $resultFileDir
    if [ $? -ne 0 ];
    then
        mkdir -p $resultFileDir
    fi
    resultFileName="$resultFileDir/result$resHour.txt"

    #php 脚本处理成mysql DB样式 
    xhprofDataList=`ls -l|grep 'xhprofData*'`
    for xhprofFileName in $xhprofDataList;do
        if [ -f $xhprofFileName ];then
            /usr/local/sinawap/php/bin/php $phpDir/module/logProcess.php $xhprofFileName >> $resultFileName 
        fi;
    done

    rm -rf xhprofData*


    #处理后的文件写入mysql
    if [ -f $resultFileName ];then
        tmpFileName="/tmp/result$resHour.txt"
        cp $resultFileName "$tmpFileName"
        chmod 0777 "$tmpFileName"

       /usr/local/sinawap/mysql/bin/mysql -h127.0.0.1 -usearchqa -psearchqa -P3306 -D trends --local-infile -e "load data local infile \"$tmpFileName\" into table trend_log_detail_test(url, xhprof_id, xhprof_data, business_type, business_trace, business_time, ct, wt, mu, pmu, cpu, data_type, appid, business_uid);"

        rm -rf $tmpFileName
    fi
         
fi
