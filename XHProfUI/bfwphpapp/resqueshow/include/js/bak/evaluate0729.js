/**
 * Created with JetBrains WebStorm.
 * User: tongzhen
 * Date: 13-7-12
 * Time: 下午8:44
 * To change this template use File | Settings | File Templates.
 */
$(function(){
    /**
     * [1]设置日期格式
     */
    $('#dp1').datepicker({
        format: 'yyyy-mm-dd'
    });
    var $date = $('#dp1').val();
    /**
     *【2】修改标题名称
     */
    $("#objtype").change(function(){
        var selectname = $("#objtype").find("option:selected").text();
        var $reshtml = $('<p id="posthead">'+selectname+'数据质量</p>');
        $("#posthead").replaceWith($reshtml);
    });

    /**
     * 【3】查询按钮点击 增加form的action事件
     */
    $("#btnsearch").click(function(){
        var date = $("#dp1").val();
        var type = $("#objtype").val();
        $("#searchform").attr('action','evaluate?type='+type+'&date='+date);
    });

    /**
     * 【4】默认执行  页面画图
     */
    var $json = $("#txthide").val();
    console.log('传入的值#txthide',$json);
    if ($json != '' && typeof ($json) !== 'undefined' && $json != null){
        $('body').data('string',$json);
        var $result = eval($('body').data('string'));
        console.warn('导入json：',$result);

        if($result[0] != '' && $result[0] != null && typeof($result[0] != 'undefined')){
            if($result[0].length == 0 ){
                $("#result").empty();
                var $text = $('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<h4>Warning!</h4>抱歉，查无此分组下'+$date+'日数据，请尝试查看其它分组。</div>');
                $("#result").append($text);
            }else {
                //(1)存在环形图
                var $data0 = $result[0];
                console.warn("环形图",$data0);
                $("#chartDiv").empty();
                var $titledount = $data0[0];
                var $datadonut = $data0[1];
                if ($datadonut.length > 0){
                    var chart = new iChart.Donut2D({
                        render : 'chartDiv',
                        data: $datadonut,
                        center:{
                            text:$titledount,
                            color:'#6f6f6f',
                            font:'Microsoft YaHei',
                            fontsize:24
                        },
                        tip:{
                            enable:true,
                            showType:'fixed'
                        },
                        sub_option : {
                            border : false,
                            label:false,
                            color_factor : 0.3
                        },
                        legend : {
                            enable : true,
                            background_color:null,
                            border:false,
                            legend_space:25,//图例间距
                            line_height:20,//设置行高
                            sign_space:15,//小图标与文本间距
                            sign_size:15,//小图标大小
                            //color:'#6f6f6f',
                            background_color : null,//透明背景
                            font:'Microsoft YaHei',
                            fontsize:15//文本大小
                        },
                        align:'left',
                        showpercent:true,
                        offsetx:140,
                        shadow : true,
                        shadow_blur : 2,
                        shadow_color : '#aaaaaa',
                        shadow_offsetx : 0,
                        shadow_offsety : 0,
                        background_color:'#f3f3f3',
                        width : 780,
                        height : 300,
                        radius:150
                    });
                    chart.draw();
                }

                //(2)分组信息
                if($result[1] != '' && $result[1] != null && typeof($result[1] != 'undefined')){
                   if($result[1].length > 0){
                       $length1 = $result[1].length;
                       for(var i = 0; i < $length1; i++){
                           var $groupdata = Array();
                           $groupdata = $result[1][i];
                           console.warn('第'+i+'组数组',$groupdata);
                           if($groupdata != '' && $groupdata.length > 0){
                               for(var j = 0; j<$groupdata.length;j++){
                                   var $subgroupdata = Array();
                                   $subgroupdata = $groupdata[j];
                                   if ($subgroupdata != '' && $subgroupdata !=null && typeof($subgroupdata) != 'undefined'){
                                       var $groupname =  '#'+$subgroupdata[0];
                                       var $dataline = $subgroupdata[1];
                                       var $datachart = $subgroupdata[2];

                                       $($groupname).empty();//清空结果

                                       //折线图
                                       if($dataline != '' && $dataline !=null && typeof($dataline) != 'undefined'){
                                           console.log('第'+i+'组'+j+'分组line数据：',$dataline);
                                           if($dataline.length > 0){
                                               for (var m=0; m<$dataline.length; m++){
                                                   var $itemdata = Array();
                                                   $itemdata = $dataline[m];
                                                   if($itemdata != '' && $itemdata.length >0){
                                                       var linetitle = $itemdata[0];
                                                       var linedivid = $itemdata[1];
                                                       var lineflowdata = $itemdata[2];
                                                       var linelabels = $itemdata[3];
                                                       var startscale = Number($itemdata[4]);//纵坐标最大最小值和分隔刻度
                                                       var endscale = Number($itemdata[5]);
                                                       var scalespace = Number($itemdata[6]);

                                                       $($groupname).append('<div style="margin-top: 20px;" id="' + linedivid +'"></div>');

                                                       var linedata = [{
                                                           name : '数量',
                                                           value:lineflowdata,
                                                           color:'#0d8ecf',
                                                           line_width:2
                                                       }];
                                                       var linename = "line"+m;
                                                       linename = new iChart.LineBasic2D({
                                                           render : linedivid,
                                                           data: linedata,
                                                           align:'center',
                                                           title : {
                                                               text : linetitle,
                                                               color : '#3e576f'
                                                           },
                                                           footnote : ' ',
                                                           width : 760,
                                                           height : 400,
                                                           sub_option:{
                                                               smooth : true,//平滑曲线
                                                               point_size:10,
                                                               label: {
                                                                   fontsize:11,
                                                                   rotate : -25,
                                                                   textAlign : 'left',
                                                                   shadow:false
                                                               }
                                                           },
                                                           tip:{
                                                               enable:true,
                                                               shadow:true
                                                           },
                                                           legend : {
                                                               enable : false
                                                           },
                                                           crosshair:{
                                                               enable:true,
                                                               line_color:'#62bce9'
                                                           },
                                                           coordinate:{
                                                               width:600,
                                                               valid_width:500,
                                                               height:260,
                                                               axis:{
                                                                   color:'#9f9f9f',
                                                                   width:[0,0,2,2]
                                                               },
                                                               grids:{
                                                                   vertical:{
                                                                       way:'share_alike',
                                                                       value:12
                                                                   }
                                                               },
                                                               offsetx:50,
                                                               scale:[{
                                                                   position:'left',
                                                                   start_scale:startscale,//startscale,//0,
                                                                   end_scale:endscale,//1,
                                                                   scale_space:scalespace,//0.1,
                                                                   scale_size:2,
                                                                   scale_color:'#9f9f9f'
                                                               },{
                                                                   position:'bottom',
                                                                   labels:linelabels,
                                                                   label : {
                                                                       fontsize:11,
                                                                       //color : '#6f6f6f',
                                                                       rotate : -25,
                                                                       textAlign : 'right',
                                                                       shadow:false
                                                                   }
                                                               }]
                                                           }
                                                       });
                                                       linename.draw();
                                                   }
                                               }
                                           }
                                       }

                                       //柱状图
                                       if($datachart != '' && $datachart !=null && typeof($datachart) != 'undefined'){
                                           console.log('第'+i+'组'+j+'分组chart数据：',$datachart);
                                           var charttitle = $datachart[0];
                                           var chartdivid = $datachart[1];
                                           var chartdata = $datachart[2];
                                           $($groupname).append('<div style="margin-top: 20px;" id="' + chartdivid +'"></div>');

                                           var chartname = "chart"+name;
                                           chartname = new iChart.Column2D({
                                               render : chartdivid,
                                               data : chartdata,
                                               title : {
                                                   text : charttitle,
                                                   color : '#3e576f'
                                               },
                                               footnote : ' ',
                                               width : 760,
                                               height : 400,
                                               label : {
                                                   fontsize:11,
                                                   //color : '#6f6f6f',
                                                   rotate : -25,
                                                   textAlign : 'right',
                                                   shadow:false
                                               },
                                               shadow : false,
                                               column_width : 62,
                                               sub_option : {
                                                   listeners : {
                                                       parseText : function(r, t) {
                                                           return t + "%";
                                                       }
                                                   },
                                                   label : false,
                                                   tip:{
                                                       enable:true,
                                                       shadow:true
                                                   },
                                                   border : {
                                                       width : 2,
                                                       color : '#ffffff'
                                                   }
                                               },
                                               coordinate : {
                                                   background_color : null,
                                                   grid_color : '#c0c0c0',
                                                   width : 700,
                                                   axis : {
                                                       color : '#c0d0e0',
                                                       width : [0, 0, 1, 0]
                                                   },
                                                   offsetx:25,
                                                   scale : [{
                                                       position : 'left',
                                                       start_scale : 0,
                                                       end_scale : 100,
                                                       scale_space :10,
                                                       scale_enable : false,
                                                       label : {
                                                           fontsize:11
                                                           //color : '#6f6f6f'
                                                       }
                                                   }]
                                               }
                                           });
                                           chartname.draw();
                                       }
                                   }
                               }
                           }else {
                               $('#tonegroup'+i).empty();
                           }
                       }
                   }
                }else{
                    $("#result").empty();
                    var $text = $('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<h4>Warning!</h4>抱歉，查无此分组下'+$date+'日数据，请尝试查看其它分组。</div>');
                    $("#result").append($text);
                }
            }
        }else {
            $("#result").empty();
            var $text = $('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<h4>Warning!</h4>抱歉，查无此分组下'+$date+'日数据，请尝试查看其它分组。</div>');
            $("#result").append($text);
        }
    }else {
        $("#result").empty();
        var $text = $('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<h4>Warning!</h4>抱歉，查无此分组下'+$date+'日数据，请尝试查看其它分组。</div>');
        $("#result").append($text);
    }



});
