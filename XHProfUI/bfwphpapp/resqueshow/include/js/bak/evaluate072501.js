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
     * 【3】默认执行
     */
    var $json = $("#txthide").val();
    if ($json != '' && typeof ($json) !== 'undefined' && $json != null){
        $('body').data('string',$json);
        var $result = eval($('body').data('string'));
        console.log('导入json：',$result);

        if($result[0] != '' && $result[0] != null && typeof($result[0] != 'undefined')){
            var $data0 = $result[0];
            //console.log('length0',$data0.length);
            if ($data0.length > 0){
                console.log("环形图",$data0);
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
                        width : 700,
                        height : 300,
                        radius:150
                    });
                    chart.draw();

                if($result[1] != '' && $result[1] != null && typeof($result[1] != 'undefined')){
                        //[2]分组图
                        var $data1 = $result[1];
                        var $length1 = $data1.length;
                        console.log('length1',$length1);
                        if ($length1 > 0){
                            for(var i = 0; i < $length1; i++){
                                var data = $result[1][i];
                                console.warn('第'+i+'分组数组',data);
                                if(data.length > 0){
                                    for(var j = 0; j<data.length;j++){
                                        var data1 = data[j];
                                        console.log('data1',data1);
                                        var name = data1[0];
                                        var divname = '#'+name;
                                        var dataline11 = data1[1];//曲线
                                        var datachart11 = data1[2];//柱状
                                        var datalinecnt11 = dataline11.length;
                                        var datachartcnt11 = datachart11.length;
                                        console.log(divname+'曲线:',datalinecnt11,'柱状',datachartcnt11);
                                        if((datalinecnt11 > 0) && (datachartcnt11 >0)){
                                            $(divname).empty();
                                            for(var m = 0; m < datalinecnt11 ;m++){
                                                //(1)line
                                                //console.log(m+'dataline11[m]',dataline11[m]);
                                                var linetitle11 = dataline11[m][0];
                                                var linedivid11 = dataline11[m][1];
                                                var lineflow11 = dataline11[m][2];
                                                var linelabels11 = dataline11[m][3];
                                                var startscale = Number(dataline11[m][4]);//纵坐标最大最小值和分隔刻度
                                                var endscale = Number(dataline11[m][5]);
                                                var scalespace = Number(dataline11[m][6]);
                                                console.log('第'+m+'个曲线最小值:',startscale,'第'+m+'个曲线最大值:',endscale,'第'+m+'个曲线分隔刻度:',scalespace);
                                                $(divname).append('<div style="margin-top: 20px;" id="' + linedivid11 +'"></div>');

                                                var linedata11 = [{
                                                    name : '数量',
                                                    value:lineflow11,
                                                    color:'#0d8ecf',
                                                    line_width:2
                                                }];
                                                var linename11 = "line"+m;
                                                linename11 = new iChart.LineBasic2D({
                                                    render : linedivid11,
                                                    data: linedata11,
                                                    align:'center',
                                                    title : {
                                                        text : linetitle11,
                                                        color : '#3e576f'
                                                    },
                                                    footnote : ' ',
                                                    width : 600,
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
                                                        scale:[{
                                                            position:'left',
                                                            start_scale:startscale,//startscale,//0,
                                                            end_scale:endscale,//1,
                                                            scale_space:scalespace,//0.1,
                                                            scale_size:2,
                                                            scale_color:'#9f9f9f'
                                                        },{
                                                            position:'bottom',
                                                            labels:linelabels11,
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
                                                linename11.draw();
                                            }
                                            //chart
                                            var charttitle11 = datachart11[0];
                                            var chartdivid11 = datachart11[1];
                                            var chartdata11 = datachart11[2];
                                            $(divname).append('<div style="margin-top: 20px;" id="' + chartdivid11 +'"></div>');

                                            var chartname = "chart"+name;
                                            chartname = new iChart.Column2D({
                                                render : chartdivid11,
                                                data : chartdata11,
                                                title : {
                                                    text : charttitle11,
                                                    color : '#3e576f'
                                                },
                                                footnote : ' ',
                                                width : 600,
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
                                                    width : 680,
                                                    axis : {
                                                        color : '#c0d0e0',
                                                        width : [0, 0, 1, 0]
                                                    },
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
                                        }else if((datalinecnt11 > 0) && (datachartcnt11 == 0)){
                                            $(divname).empty();
                                            for(var n = 0; n < datalinecnt11 ;n++){
                                                var linetitle11 = dataline11[n][0];
                                                var linedivid11 = dataline11[n][1];
                                                var lineflow11 = dataline11[n][2];
                                                var linelabels11 = dataline11[n][3];
                                                var startscale = Number(dataline11[n][4]);//纵坐标最大最小值和分隔刻度
                                                var endscale = Number(dataline11[n][5]);
                                                var scalespace = Number(dataline11[n][6]);
                                                $(divname).append('<div style="margin-top: 20px;" id="' + linedivid11 +'"></div>');

                                                var linedata11 = [{
                                                    name : '数量',
                                                    value:lineflow11,
                                                    color:'#0d8ecf',
                                                    line_width:2
                                                }];
                                                var linename11 = "line"+n;
                                                linename11 = new iChart.LineBasic2D({
                                                    render : linedivid11,
                                                    data: linedata11,
                                                    align:'center',
                                                    title : {
                                                        text : linetitle11,
                                                        color : '#3e576f'
                                                    },
                                                    footnote : ' ',
                                                    width : 600,
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
                                                        scale:[{
                                                            position:'left',
                                                            start_scale:startscale,
                                                            end_scale:endscale,
                                                            scale_space:scalespace,
                                                            scale_size:2,
                                                            scale_color:'#9f9f9f'
                                                        },{
                                                            position:'bottom',
                                                            labels:linelabels11,
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
                                                linename11.draw();
                                            }
                                        }else if((datalinecnt11 == 0) && (datachartcnt11 > 0)){
                                            $(divname).empty();

                                            var charttitle11 = datachart11[0];
                                            var chartdivid11 = datachart11[1];
                                            var chartdata11 = datachart11[2];
                                            $(divname).append('<div style="margin-top: 20px;" id="' + chartdivid11 +'"></div>');
                                            var chartname = "chart"+name;
                                            chartname = new iChart.Column2D({
                                                render : chartdivid11,
                                                data : chartdata11,
                                                title : {
                                                    text : charttitle11,
                                                    color : '#3e576f'
                                                },
                                                footnote : ' ',
                                                width : 600,
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
                                                    width : 680,
                                                    axis : {
                                                        color : '#c0d0e0',
                                                        width : [0, 0, 1, 0]
                                                    },
                                                    scale : [{
                                                        position : 'left',
                                                        start_scale : 0,
                                                        end_scale : 100,
                                                        scale_space : 10,
                                                        scale_enable : false,
                                                        label : {
                                                            fontsize:11
                                                            //color : '#6f6f6f'
                                                        }
                                                    }]
                                                }
                                            });
                                            chartname.draw();
                                        }else {
                                            $(divname).empty();
                                            $(divname).append('<div id="result120">抱歉，查无此组下数据 :(</div>');
                                        }
                                    }
                                }
                            }
                        }
                    }else {
                        $("#chartDiv").empty();
                        var $text = $('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<h4>Warning!</h4>抱歉，查无此分组下数据，请尝试查看其它分组。</div>');
                        $("#chartDiv").append($text);
                    }
                    $('body').removeData('string');

                }else {
                    $("#chartDiv").empty();
                    var $text = $('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<h4>Warning!</h4>1抱歉，查无此分组下'+$date+'日数据，请尝试查看其它分组。</div>');
                    $("#chartDiv").append($text);
                }
            }else {
                $("#chartDiv").empty();
                var $text = $('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<h4>Warning!</h4>2抱歉，查无此分组下'+$date+'日数据，请尝试查看其它分组。</div>');
                $("#chartDiv").append($text);
            }
        }else {
            $("#result").empty();
            var $chartdiv = $('<div id="chartDiv"></div>');
            $("#result").append($chartdiv);
            var $text = $('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<h4>Warning!</h4>抱歉，查无此分组下'+$date+'日数据，请尝试查看其它分组。</div>');
            $("#chartDiv").append($text);
        }
    }else {
        $("#chartDiv").empty();
        var $text = $('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<h4>Warning!</h4>4抱歉，查无此分组下5   '+$date+'日数据，请尝试查看其它分组。</div>');
        $("#chartDiv").append($text);
    }

    /**
     * 【4】查询按钮点击 增加form的action事件
     */
    $("#btnsearch").click(function(){
        var date = $("#dp1").val();
        var type = $("#objtype").val();
        $("#searchform").attr('action','evaluate?type='+type+'&date='+date);
    });
});
