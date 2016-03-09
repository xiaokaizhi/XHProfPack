#!/bin/bash
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
        
        #
        resultFileDir=$resultDir/$resDate
        test -d $resultFileDir
        if [ $? -ne 0 ];
        then
            mkdir -p $resultFileDir
        fi
        
        

        logFileResultName="$logFileDir/recommend_interface_result.log"
        cat $sourceLogDirFileName | grep -v "UIDFLAG" > $logFileResultName
 
        resultFileName="$resultFileDir/result$resHour.txt"
        /usr/local/sinawap/php/bin/php  "$phpDir/index.php" $logFileResultName "$resTime" >> $resultFileName

        #(5)统计好友圈数据 pc端grep "gid=friend"
        friendsCircleFileName="$logDir/$resDate/friendsCircleCount.log"
        cat $logFileResultName | grep "list_id=10009" | wc -l >> $friendsCircleFileName
        
        rm -rf $logFileResultName

        #(3) 遍历白名单，保留
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


        #(1)UIDFLAG 计算一个
        logFileUidFlagName="$logFileDir/recommend_interface_uidflag.log"
	logFileUidName="$logFileDir/recommend_interface_uid.log"
        cat $sourceLogDirFileName | grep "UIDFLAG" > $logFileUidFlagName
	cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $2;}'|awk -F":" '{if($1=="UIDFLAG") print $2;}' > $logFileUidName      

	if [ -f "$logFileUidName" ];
        then
            logFileUidNameResult="$logFileDir/recommend_interface_uid_result.log"
            cat $logFileUidName | awk '{a[$1]++}END{for (j in a) print j","a[j]}'|awk -F"," '{if($2>500) print $1":"$2}' > $logFileUidNameResult
            
            #mail @tongzhen1
            /usr/local/sinawap/php/bin/php  "$phpDir/sendEmail.php" $logFileUidNameResult
            
            rm -rf $logFileUidName
            
            logFileErrorUid="$logFileDir/recommend_interface_error_uid.log"
            cat $logFileUidNameResult | awk -F":" '{print $1;}' > $logFileErrorUid
            
            logFileErrorUidDir="$logFileDir/topRequestResult"
            test -d $logFileErrorUidDir
            if [ $? -ne 0 ];
            then
                mkdir -p $logFileErrorUidDir
            fi
            
            for uid in `cat $logFileErrorUid`
            do
                cat $sourceLogDirFileName | grep "uid=$uid" >> "$logFileErrorUidDir/$uid.log"
            done
            
        fi
	
	#[4]caculate all module  
	# beixian:PC  11:topic 14:normal 15:yellowv 16:bluev 19:weibo 24:missedweibo 26:picture 30:fans 31:contacts
	moduleFileDir="$logDir/$resDate/module"
	test -d $moduleFileDir
	if [ $? -ne 0 ];
	then 
		mkdir -p $moduleFileDir
	fi
	
	if [ -f $logFileUidFlagName ];
	then
		totalCnt=`cat $logFileUidFlagName|wc -l|awk -F" " '{print $1;}'`
                #[5]统计             
                sed -i "$ a PV:$totalCnt,$resTime\n" $friendsCircleFileName
	fi
	##[41]11:topic
	moduleTopicFile="$moduleFileDir/topicCnt.log"
	moduleTopicFileTmp="$moduleFileDir/topicCntTmp.log"
	cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="11") print $2;}' > $moduleTopicFileTmp
	topicCnt=`cat $moduleTopicFileTmp|wc -l|awk -F" " '{print $1;}'`	
	/usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $moduleTopicFileTmp $totalCnt $topicCnt $resTime 75 >> $moduleTopicFile
	rm -rf $moduleTopicFileTmp
	
	##[42]14:normal
	normalFile="$moduleFileDir/normalCnt.log"
	normalFileTmp="$moduleFileDir/normalCntTmp.log"
	cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="14") print $2;}' > $normalFileTmp
	normalCnt=`cat $normalFileTmp|wc -l|awk -F" " '{print $1;}'`
	/usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $normalFileTmp $totalCnt $normalCnt $resTime 60 >> $normalFile
	rm -rf $normalFileTmp	

	##[43]15:yewllowv
	yewllowvFile="$moduleFileDir/yewllowvCnt.log"
        yewllowvFileTmp="$moduleFileDir/yewllowvCntTmp.log"
        cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="15") print $2;}' > $yewllowvFileTmp
        yewllowvCnt=`cat $yewllowvFileTmp|wc -l|awk -F" " '{print $1;}'`     
        /usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $yewllowvFileTmp $totalCnt $yewllowvCnt $resTime 60 >> $yewllowvFile
        rm -rf $yewllowvFileTmp

	##[44]16:bluev
	bluevFile="$moduleFileDir/bluevCnt.log"
        bluevFileTmp="$moduleFileDir/bluevCntTmp.log"
        cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="16") print $2;}' > $bluevFileTmp
        bluevCnt=`cat $bluevFileTmp|wc -l|awk -F" " '{print $1;}'`
        /usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $bluevFileTmp $totalCnt $bluevCnt $resTime 60 >> $bluevFile
        rm -rf $bluevFileTmp

	##[45]19:weibo
	weiboFile="$moduleFileDir/weiboCnt.log"
        weiboFileTmp="$moduleFileDir/weiboCntTmp.log"
        cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="19") print $2;}' > $weiboFileTmp
        weiboCnt=`cat $weiboFileTmp|wc -l|awk -F" " '{print $1;}'`
        /usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $weiboFileTmp $totalCnt $weiboCnt $resTime 95 >> $weiboFile
        rm -rf $weiboFileTmp	

	##[46]24:missedweibo
	missedWeiboFile="$moduleFileDir/missedWeiboCnt.log"
	missedWeiboFileTmp="$moduleFileDir/missedWeiboCntTmp.log"
	cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="24") print $2;}' > $missedWeiboFileTmp
	missedWeiboCnt=`cat $missedWeiboFileTmp|wc -l|awk -F" " '{print $1;}'`
	/usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $missedWeiboFileTmp $totalCnt $missedWeiboCnt $resTime 85 >> $missedWeiboFile
	rm -rf $missedWeiboFileTmp

	##[47]26:picture
	pictureFile="$moduleFileDir/pictureCnt.log"
        pictureFileTmp="$moduleFileDir/pictureCntTmp.log"
        cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="26") print $2;}' > $pictureFileTmp
        pictureCnt=`cat $pictureFileTmp|wc -l|awk -F" " '{print $1;}'`
        /usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $pictureFileTmp $totalCnt $pictureCnt $resTime 70 >> $pictureFile
        rm -rf $pictureFileTmp
	
	##[]30:fans
	fansFile="$moduleFileDir/fansCnt.log"
        fansFileTmp="$moduleFileDir/fansCntTmp.log"
        cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="30") print $2;}' > $fansFileTmp
        fansCnt=`cat $fansFileTmp|wc -l|awk -F" " '{print $1;}'`
        /usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $fansFileTmp $totalCnt $fansCnt $resTime 40 >> $fansFile
        rm -rf $fansFileTmp
	
	##[]31:contacts
        
        ##[]27:video
        videoFile="$moduleFileDir/videoCnt.log"
        videoFileTmp="$moduleFileDir/videoCntTmp.log"
        cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="27") print $2;}' > $videoFileTmp
        videoCnt=`cat $videoFileTmp|wc -l|awk -F" " '{print $1;}'`
        /usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $videoFileTmp $totalCnt $videoCnt $resTime 65 >> $videoFile
        rm -rf $videoFileTmp

        ##[]28:missedweibobygroup
        groupFile="$moduleFileDir/groupCnt.log"
        groupFileTmp="$moduleFileDir/groupCntTmp.log"
        cat $logFileUidFlagName | awk -F"*" '{if(NF==3) print $1":"$3;}'|awk -F":" '{if($1=="28") print $2;}' > $groupFileTmp
        groupCnt=`cat $groupFileTmp|wc -l|awk -F" " '{print $1;}'`
        /usr/local/sinawap/php/bin/php "$phpDir/module/public.php" $groupFileTmp $totalCnt $groupCnt $resTime 120 >> $groupFile
        rm -rf $groupFileTmp
        
        rm -rf $logFileUidFlagName

	##end
fi
