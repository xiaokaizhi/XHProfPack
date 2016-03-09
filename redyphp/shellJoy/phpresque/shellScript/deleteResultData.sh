#!/bin/bash
#/usr/local/sinawap/php/bin/php
sourceLogDir="/data1/logs"

path="/data1/tongzhen1/trendXhprofLog"
phpDir="$path/phpScript"
logDir="$path/tmpData"
resultDir="$path/result"

#定时删除两小时前的result文件
#crontab
#10 */1 * * * sh /data1/tongzhen1/trendXhprofLog/shellScript/deleteResultData.sh

twoHourDate="`date '+%Y%m%d' --date="2 hour ago"`"
twoHourHour="`date '+%H' --date="2 hour ago"`"

resultFileName="$resultDir/$twoHourDate/result$twoHourHour"
if [ -f $resultFileName ];then
    rm -rf $resultFileName;
fi
