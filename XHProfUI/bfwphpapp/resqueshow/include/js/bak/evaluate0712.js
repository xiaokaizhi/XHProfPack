/**
 * Created with JetBrains WebStorm.
 * User: tongzhen
 * Date: 13-7-10
 * Time: 下午3:52
 * To change this template use File | Settings | File Templates.
 */

$(function(){
    //[1]日期
    $('#dp1').datepicker({
        format: 'yyyy-mm-dd'
    });
    //日期设置初始值
    var today = new Date();
    var day = today.getDate();
    var month = today.getMonth() + 1;
    var year = today.getFullYear();
    if (month < 10){
        var date =  year + "-0" + month + "-" + day;
    }else {
        var date =  year + "-" + month + "-" + day;
    }
    $('#dp1').val(date);

    //[2]
    //2-1图书
    $("#btnbook").click(function(){
        $("#result").removeClass("resultshow");
        $("#result").addClass("resulthide");

        $("#posthead").replaceWith('<p id="posthead">图书数据质量</p>');
        $("#objecttype").val(11);
    });
    $("#btnmusic").click(function(){
        $("#result").removeClass("resultshow");
        $("#result").addClass("resulthide");

        $("#posthead").replaceWith('<p id="posthead">音乐数据质量</p>');
        $("#objecttype").val(12);
    });
    $("#btnprofile").click(function(){
        $("#result").removeClass("resultshow");
        $("#result").addClass("resulthide");

        $("#posthead").replaceWith('<p id="posthead">profile数据质量</p>');
        $("#objecttype").val(13);
    });
    $("#btnpicture").click(function(){
        $("#result").removeClass("resultshow");
        $("#result").addClass("resulthide");

        $("#posthead").replaceWith('<p id="posthead">图片数据质量</p>');
        $("#objecttype").val(14);
    });
    $("#btnlbs").click(function(){
        $("#result").removeClass("resultshow");
        $("#result").addClass("resulthide");

        $("#posthead").replaceWith('<p id="posthead">LBS数据质量</p>');
        $("#objecttype").val(15);
    });

    //[3]
    $("#btnsearch").click(function(){
        $("#result").removeClass("resulthide");
        $("#result").addClass("resultshow");

        var date = $("#dp1").val();
        var objecttype = $("#objecttype").val();
        var link;
        if (objecttype == '11'){
            $("#posthead").replaceWith('<p id="posthead">图书数据质量</p>');
            link = 'evaluate?type=bookresulttest';
        }else if(objecttype == '12'){
            $("#posthead").replaceWith('<p id="posthead">音乐数据质量</p>');
            link = 'evaluate?type=music';
        }else if(objecttype == '13'){
            $("#posthead").replaceWith('<p id="posthead">profile数据质量</p>');
            link = 'evaluate?type=profile';
        }else if(objecttype == '14'){
            $("#posthead").replaceWith('<p id="posthead">图片数据质量</p>');
            link = 'evaluate?type=picture';
        }else if(objecttype == '15'){
            $("#posthead").replaceWith('<p id="posthead">LBS数据质量</p>');
            link = 'evaluate?type=lbs';
        }

        $.ajax({
            type: "GET",
            url: link,
            dataType: "json",
            data: {"date":date,"objecttype":objecttype,"r":Math.random()},
            success: function(string){
                if(string != ""){
                    var result = new Array();
                    result=eval(string);
                    if (result.length > 0){
                        /* 0 顶端环形图 */
                        var data0 = result[0];
                        if (data0.length >0){
                            var titledount = data0[0];
                            var datadonut = data0[1];
                            var chartdonut = new iChart.Donut2D({
                                render : 'chartDiv',
                                donutwidth : 0.4,
                                center:{
                                    text:titledount,
                                    color:'#6f6f6f',
                                    font:'Microsoft YaHei',
                                    fontsize:24
                                },
                                data: datadonut,
                                offsetx:-60,
                                shadow:true,
                                background_color:'#f4f4f4',
                                separate_angle:10,//分离角度
                                tip:{
                                    enable:true,
                                    showType:'fixed'
                                },
                                legend : {
                                    enable : true,
                                    //shadow:true,
                                    background_color:null,
                                    border:false,
                                    legend_space:25,//图例间距
                                    line_height:20,//设置行高
                                    sign_space:15,//小图标与文本间距
                                    sign_size:15,//小图标大小
                                    color:'#6f6f6f',
                                    fontsize:14//文本大小
                                },
                                sub_option:{
                                    label : false,
                                    color_factor : 0.3
                                },
                                showpercent:true,
                                decimalsnum:2,
                                width : 700,
                                height : 300,
                                radius:140
                            });
                            chartdonut.draw();
                        }else {
                            $("#chartDiv").empty();
                        }

                        if (result[1].length > 0){
                            //1
                            var data1 = result[1][0];
                            if (data1.length > 0){
                                var data11 = data1[0]; //11
                                var data12 = data1[1]; //12
                                var data13 = data1[2]; //13

                                //11曲线 +柱状图
                                var dataline11 = data11[0];
                                var datachart11 = data11[1];
                                var datalinecnt11 = dataline11.length;
                                var datachartcnt11 = datachart11.length;
                                if ((datalinecnt11 == 0) && (datachartcnt11 == 0)){
                                    $("#integrityresult11").empty();
                                    $("#integrityresult11").append('<div id="collapseresult110">抱歉，查无此组下数据 :(</div>');
                                }else if ((datalinecnt11 == 0) && (datachartcnt11 > 0)){
                                    var charttitle11 = datachart11[0];
                                    var chartdivid11 = datachart11[1];
                                    var chartdata11 = datachart11[2];

                                    $("#integrityresult11").empty();
                                    $("#integrityresult11").append('<div style="margin-top: 20px;" id="' + chartdivid11 +'"></div>');

                                    var chart11 = new iChart.Column2D({
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
                                            color : '#666666',
                                            rotate : -45,
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
                                                    fontsize:11,
                                                    color : '#666666'
                                                }
                                            }]
                                        }
                                    });
                                    chart11.draw();
                                }else if ((datalinecnt11 > 0) && (datachartcnt11 == 0)){
                                    $("#integrityresult11").empty();
                                    for(i = 0; i < datalinecnt11 ;i++){
                                        var linetitle11 = dataline11[i][0];
                                        var linedivid11 = dataline11[i][1];
                                        var lineflow11 = dataline11[i][2];
                                        var linelabels11 = dataline11[i][3];

                                        $("#integrityresult11").append('<div style="margin-top: 20px;" id="' + linedivid11 +'"></div>');

                                        var linedata11 = [
                                            {
                                                name : '数量',
                                                value:lineflow11,
                                                color:'#0d8ecf',
                                                line_width:2
                                            }
                                        ];

                                        var seq11 = 111 + i;
                                        var linename11 = "line"+seq11;
                                        linename11 = new iChart.LineBasic2D({
                                            render : linedivid11,
                                            data: linedata11,
                                            align:'center',
                                            title : linetitle11,
                                            subtitle : '',
                                            footnote : '数据来源：weibo.com',
                                            width : 600,
                                            height : 400,
                                            sub_option:{
                                                smooth : true,//平滑曲线
                                                point_size:10
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
                                                    start_scale:0,
                                                    end_scale:100,
                                                    scale_space:10,
                                                    scale_size:2,
                                                    scale_color:'#9f9f9f'
                                                },{
                                                    position:'bottom',
                                                    labels:linelabels11
                                                }]
                                            }
                                        });
                                        linename11.draw();
                                    }
                                }else if ((datalinecnt11 > 0) && (datachartcnt11 > 0)){
                                    $("#integrityresult11").empty();
                                    for(i = 0; i < datalinecnt11 ;i++){
                                        var linetitle11 = dataline11[i][0];
                                        var linedivid11 = dataline11[i][1];
                                        var lineflow11 = dataline11[i][2];
                                        var linelabels11 = dataline11[i][3];

                                        $("#integrityresult11").append('<div style="margin-top: 20px;" id="' + linedivid11 +'"></div>');

                                        var linedata11 = [
                                            {
                                                name : '数量',
                                                value:lineflow11,
                                                color:'#0d8ecf',
                                                line_width:2
                                            }
                                        ];

                                        var seq11 = 111 + i;
                                        var linename11 = "line"+seq11;
                                        linename11 = new iChart.LineBasic2D({
                                            render : linedivid11,
                                            data: linedata11,
                                            align:'center',
                                            title : linetitle11,
                                            subtitle : '',
                                            footnote : '数据来源：weibo.com',
                                            width : 600,
                                            height : 400,
                                            sub_option:{
                                                smooth : true,//平滑曲线
                                                point_size:10
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
                                                    start_scale:0,
                                                    end_scale:100,
                                                    scale_space:10,
                                                    scale_size:2,
                                                    scale_color:'#9f9f9f'
                                                },{
                                                    position:'bottom',
                                                    labels:linelabels11
                                                }]
                                            }
                                        });
                                        linename11.draw();
                                    }

                                    var charttitle11 = datachart11[0];
                                    var chartdivid11 = datachart11[1];
                                    var chartdata11 = datachart11[2];

                                    $("#integrityresult11").append('<div style="margin-top: 20px;" id="' + chartdivid11 +'"></div>');

                                    var chart11 = new iChart.Column2D({
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
                                            color : '#666666',
                                            rotate : -45,
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
                                                    fontsize:11,
                                                    color : '#666666'
                                                }
                                            }]
                                        }
                                    });
                                    chart11.draw();
                                }


                                //12
                                var dataline12 = data12[0];
                                var datachart12 = data12[1];
                                var datalinecnt12 = dataline12.length;
                                var datachartcnt12 = datachart12.length;
                                if ((datalinecnt12 == 0) && (datachartcnt12 == 0)){
                                    $("#integrityresult12").empty();
                                    $("#integrityresult12").append('<div id="collapseresult120">抱歉，查无此组下数据 :(</div>');
                                }else if ((datalinecnt12 == 0) && (datachartcnt12 > 0)){
                                    var charttitle12 = datachart12[0];
                                    var chartdivid12 = datachart12[1];
                                    var chartdata12 = datachart12[2];

                                    $("#integrityresult12").empty();
                                    $("#integrityresult12").append('<div style="margin-top: 20px;" id="' + chartdivid12 +'"></div>');

                                    var chart12 = new iChart.Column2D({
                                        render : chartdivid12,
                                        data : chartdata12,
                                        title : {
                                            text : charttitle12,
                                            color : '#3e576f'
                                        },
                                        footnote : ' ',
                                        width : 600,
                                        height : 400,
                                        label : {
                                            fontsize:11,
                                            color : '#666666',
                                            rotate : -45,
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
                                                    fontsize:11,
                                                    color : '#666666'
                                                }
                                            }]
                                        }
                                    });
                                    chart12.draw();
                                }else if ((datalinecnt12 > 0) && (datachartcnt12 == 0)){
                                    $("#integrityresult12").empty();
                                    for(i = 0; i < datalinecnt12 ;i++){
                                        var linetitle12 = dataline12[i][0];
                                        var linedivid12 = dataline12[i][1];
                                        var lineflow12 = dataline12[i][2];
                                        var linelabels12 = dataline12[i][3];

                                        $("#integrityresult12").append('<div style="margin-top: 20px;" id="' + linedivid12 +'"></div>');

                                        var linedata12 = [
                                            {
                                                name : '数量',
                                                value:lineflow12,
                                                color:'#0d8ecf',
                                                line_width:2
                                            }
                                        ];

                                        var seq12 = 111 + i;
                                        var linename12 = "line"+seq12;
                                        linename12 = new iChart.LineBasic2D({
                                            render : linedivid12,
                                            data: linedata12,
                                            align:'center',
                                            title : linetitle12,
                                            subtitle : '',
                                            footnote : '数据来源：weibo.com',
                                            width : 600,
                                            height : 400,
                                            sub_option:{
                                                smooth : true,//平滑曲线
                                                point_size:10
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
                                                    start_scale:0,
                                                    end_scale:100,
                                                    scale_space:10,
                                                    scale_size:2,
                                                    scale_color:'#9f9f9f'
                                                },{
                                                    position:'bottom',
                                                    labels:linelabels12
                                                }]
                                            }
                                        });
                                        linename12.draw();
                                    }
                                }else if ((datalinecnt12 > 0) && (datachartcnt12 > 0)){
                                    $("#integrityresult12").empty();
                                    for(i = 0; i < datalinecnt12 ;i++){
                                        var linetitle12 = dataline12[i][0];
                                        var linedivid12 = dataline12[i][1];
                                        var lineflow12 = dataline12[i][2];
                                        var linelabels12 = dataline12[i][3];

                                        $("#integrityresult12").append('<div style="margin-top: 20px;" id="' + linedivid12 +'"></div>');

                                        var linedata12 = [
                                            {
                                                name : '数量',
                                                value:lineflow12,
                                                color:'#0d8ecf',
                                                line_width:2
                                            }
                                        ];

                                        var seq12 = 111 + i;
                                        var linename12 = "line"+seq12;
                                        linename12 = new iChart.LineBasic2D({
                                            render : linedivid12,
                                            data: linedata12,
                                            align:'center',
                                            title : linetitle12,
                                            subtitle : '',
                                            footnote : '数据来源：weibo.com',
                                            width : 600,
                                            height : 400,
                                            sub_option:{
                                                smooth : true,//平滑曲线
                                                point_size:10
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
                                                    start_scale:0,
                                                    end_scale:100,
                                                    scale_space:10,
                                                    scale_size:2,
                                                    scale_color:'#9f9f9f'
                                                },{
                                                    position:'bottom',
                                                    labels:linelabels12
                                                }]
                                            }
                                        });
                                        linename12.draw();
                                    }

                                    var charttitle12 = datachart12[0];
                                    var chartdivid12 = datachart12[1];
                                    var chartdata12 = datachart12[2];

                                    $("#integrityresult12").append('<div style="margin-top: 20px;" id="' + chartdivid12 +'"></div>');

                                    var chart12 = new iChart.Column2D({
                                        render : chartdivid12,
                                        data : chartdata12,
                                        title : {
                                            text : charttitle12,
                                            color : '#3e576f'
                                        },
                                        footnote : ' ',
                                        width : 600,
                                        height : 400,
                                        label : {
                                            fontsize:11,
                                            color : '#666666',
                                            rotate : -45,
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
                                                    fontsize:11,
                                                    color : '#666666'
                                                }
                                            }]
                                        }
                                    });
                                    chart12.draw();
                                }

                                //13
                                var dataline13 = data13[0];
                                var datachart13 = data13[1];
                                var datalinecnt13 = dataline13.length;
                                var datachartcnt13 = datachart13.length;

                                if ((datalinecnt13 == 0) && (datachartcnt13 == 0)){
                                    $("#integrityresult13").empty();
                                    $("#integrityresult13").append('<div id="collapseresult130">抱歉，查无此组下数据 :(</div>');
                                }else if ((datalinecnt13 == 0) && (datachartcnt13 > 0)){
                                    var charttitle13 = datachart13[0];
                                    var chartdivid13 = datachart13[1];
                                    var chartdata13 = datachart13[2];

                                    $("#integrityresult13").empty();
                                    $("#integrityresult13").append('<div style="margin-top: 20px;" id="' + chartdivid13 +'"></div>');

                                    var chart13 = new iChart.Column2D({
                                        render : chartdivid13,
                                        data : chartdata13,
                                        title : {
                                            text : charttitle13,
                                            color : '#3e576f'
                                        },
                                        footnote : ' ',
                                        width : 600,
                                        height : 400,
                                        label : {
                                            fontsize:11,
                                            color : '#666666',
                                            rotate : -45,
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
                                                    fontsize:11,
                                                    color : '#666666'
                                                }
                                            }]
                                        }
                                    });
                                    chart13.draw();
                                }else if ((datalinecnt13 > 0) && (datachartcnt13 == 0)){
                                    $("#integrityresult13").empty();
                                    for(i = 0; i < datalinecnt13 ;i++){
                                        var linetitle13 = dataline13[i][0];
                                        var linedivid13 = dataline13[i][1];
                                        var lineflow13 = dataline13[i][2];
                                        var linelabels13 = dataline13[i][3];

                                        $("#integrityresult13").append('<div style="margin-top: 20px;" id="' + linedivid13 +'"></div>');

                                        var linedata13 = [
                                            {
                                                name : '数量',
                                                value:lineflow13,
                                                color:'#0d8ecf',
                                                line_width:2
                                            }
                                        ];

                                        var seq13 = 111 + i;
                                        var linename13 = "line"+seq13;
                                        linename13 = new iChart.LineBasic2D({
                                            render : linedivid13,
                                            data: linedata13,
                                            align:'center',
                                            title : linetitle13,
                                            subtitle : '',
                                            footnote : '数据来源：weibo.com',
                                            width : 600,
                                            height : 400,
                                            sub_option:{
                                                smooth : true,//平滑曲线
                                                point_size:10
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
                                                    start_scale:0,
                                                    end_scale:100,
                                                    scale_space:10,
                                                    scale_size:2,
                                                    scale_color:'#9f9f9f'
                                                },{
                                                    position:'bottom',
                                                    labels:linelabels13
                                                }]
                                            }
                                        });
                                        linename13.draw();
                                    }
                                }else if ((datalinecnt13 > 0) && (datachartcnt13 > 0)){
                                    $("#integrityresult13").empty();
                                    for(i = 0; i < datalinecnt13 ;i++){
                                        var linetitle13 = dataline13[i][0];
                                        var linedivid13 = dataline13[i][1];
                                        var lineflow13 = dataline13[i][2];
                                        var linelabels13 = dataline13[i][3];

                                        $("#integrityresult13").append('<div style="margin-top: 20px;" id="' + linedivid13 +'"></div>');

                                        var linedata13 = [
                                            {
                                                name : '数量',
                                                value:lineflow13,
                                                color:'#0d8ecf',
                                                line_width:2
                                            }
                                        ];

                                        var seq13 = 111 + i;
                                        var linename13 = "line"+seq13;
                                        linename13 = new iChart.LineBasic2D({
                                            render : linedivid13,
                                            data: linedata13,
                                            align:'center',
                                            title : linetitle13,
                                            subtitle : '',
                                            footnote : '数据来源：weibo.com',
                                            width : 600,
                                            height : 400,
                                            sub_option:{
                                                smooth : true,//平滑曲线
                                                point_size:10
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
                                                    start_scale:0,
                                                    end_scale:100,
                                                    scale_space:10,
                                                    scale_size:2,
                                                    scale_color:'#9f9f9f'
                                                },{
                                                    position:'bottom',
                                                    labels:linelabels13
                                                }]
                                            }
                                        });
                                        linename13.draw();
                                    }

                                    var charttitle13 = datachart13[0];
                                    var chartdivid13 = datachart13[1];
                                    var chartdata13 = datachart13[2];

                                    $("#integrityresult13").append('<div style="margin-top: 20px;" id="' + chartdivid13 +'"></div>');

                                    var chart13 = new iChart.Column2D({
                                        render : chartdivid13,
                                        data : chartdata13,
                                        title : {
                                            text : charttitle13,
                                            color : '#3e576f'
                                        },
                                        footnote : ' ',
                                        width : 600,
                                        height : 400,
                                        label : {
                                            fontsize:11,
                                            color : '#666666',
                                            rotate : -45,
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
                                                    fontsize:11,
                                                    color : '#666666'
                                                }
                                            }]
                                        }
                                    });
                                    chart13.draw();
                                }

                            }

                            $('#collapse11').collapse('show');//默认展开一个组

                            //2
                            var data2 = result[1][1];
                            if (data2.length > 0){
                                var data21 = data2[0];
                                var dataline21 = data21[0];
                                var datachart21 = data21[1];


                            }

                            //3
                            var data3 = result[1][2];
                            if (data3.length > 0){
                                var data31 = data3[0];
                                var data32 = data3[1];
                                if (data31.length > 0){
                                    var dataline31 = data31[0];
                                    var datachart31 = data31[1];

                                }

                                if (date32.length > 0){
                                    var dataline32 = data32[0];
                                    var datchart32 = data32[1];

                                }
                            }
                            //4
                            var data4 = result[1][3];
                            if (data4.length > 0){
                                var data41 = data4[0];
                                var data42 = data4[1];
                                if (data41.length > 0){
                                    var dataline41 = data41[0];
                                    var datachart41 = data41[1];

                                }

                                if (data42.length > 0){
                                    var dataline42 = data42[0];
                                    var datchart42 = data42[1];

                                }

                            }

                            //5
                            var data5 = result[1][4];
                            if (data5.length > 0){
                                var data51 = data5[0];
                                if (data51.length > 0){
                                    var dataline51 = data51[0];
                                    var datachart51 = data51[1];

                                }
                            }
                        }else {
                            $("#integrityresult11").empty();
                            $("#integrityresult11").append('<div id="collapseresult110">抱歉，查无此组下数据 :(</div>');
                            $("#integrityresult12").empty();
                            $("#integrityresult12").append('<div id="collapseresult120">抱歉，查无此组下数据 :(</div>');
                            $("#integrityresult13").empty();
                            $("#integrityresult13").append('<div id="collapseresult130">抱歉，查无此组下数据 :(</div>');


                        }

                    }
                }else {
                    $("#result").removeClass("resultshow");
                    $("#result").addClass("resulthide");
                    alert("查无此组下的质量数据信息");
                }
            }
        });

    });
});

