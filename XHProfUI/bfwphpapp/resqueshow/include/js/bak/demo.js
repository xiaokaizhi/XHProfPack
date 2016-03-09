/**
 * Created with JetBrains WebStorm.
 * User: tongzhen
 * Date: 13-7-3
 * Time: 下午2:03
 * To change this template use File | Settings | File Templates.
 */
//[1]日期
$(function(){
    $('#dp1').datepicker({
        format: 'yyyy-mm-dd'
    });
})
/* 示例图--环状图 */
/*
$(function(){
    var data = [
        {name : '完整性-99分（权重50%）',value : 20,color:'#fedd74'},
        {name : '准确性-0分（权重0%）',value : 20,color:'#82d8ef'},
        {name : '时效性-90分（权重30%）',value : 20,color:'#f76864'},
        {name : '一致性-0分（权重0%）',value : 20,color:'#80bd91'},
        {name : '唯一性-100分（权重20%）',value : 20,color:'#7da0c1'}
    ];
    var chart = new iChart.Donut2D({
        render : 'chartDiv',
        donutwidth : 0.4,
        center:{
            text:'质量-95分',
            color:'#6f6f6f',
            font:'Microsoft YaHei',
            fontsize:24
        },
        data: data,
        animation:true, //启用过渡动画
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
    chart.draw();
});
*/

/* 曲线图*/
//[11]以此为准 @tongzhen
$(function(){
    var flow = [78,65,43,88,70,33,78,89,22,35,67,89,35,67];
    var labels11 = ["0630","0701","0702","0703","0704","0705","0706","0707","0708","0709","0710","0711","0712","0713"];
    var data11 = [
        {
            name : '数量',
            value:flow,
            color:'#0d8ecf',
            line_width:2
        }
    ];
    var line11 = new iChart.LineBasic2D({
        render : 'collapseresult111',
        data: data11,
        align:'center',
        title : '整体完整性-图书数量波动',
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
                labels:labels11
            }]
        }
    });
    line11.draw();
});
/*
//[12]
$(function(){
    var flow=[];
    for(var i=0;i<21;i++){
        flow.push(Math.floor(Math.random()*(30+((i%12)*5)))+10);
    }
    var data12 = [
        {
            name : 'PV',
            value:flow,
            color:'#0d8ecf',
            line_width:2
        }
    ];
    var labels12 = ["指标1","指标2","指标3","指标4","指标5","指标6"];
    var line12 = new iChart.LineBasic2D({
        render : 'collapseresult121',
        data: data12,
        align:'center',
        title : '属性完整性-数据波动',
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
                labels:labels12
            }]
        }
    });
//开始画图
    line12.draw();
});
//[13]
$(function(){
    var flow=[];
    for(var i=0;i<21;i++){
        flow.push(Math.floor(Math.random()*(30+((i%12)*5)))+10);
    }
    var data13 = [
        {
            name : 'PV',
            value:flow,
            color:'#0d8ecf',
            line_width:2
        }
    ];
    var labels13 = ["指标1","指标2","指标3","指标4","指标5","指标6"];
    var line13 = new iChart.LineBasic2D({
        render : 'collapseresult131',
        data: data13,
        align:'center',
        title : '边属性完整性-边数量波动',
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
                labels:labels13
            }]
        }
    });
//开始画图
    line13.draw();
});
*/

/* 柱状图*/
/*
// [11]
$(function() {
    var data11 = [
        {name : 'ID',value : 99.99,color : '#4572a7'},
        {name : '列',value : 99.95,color : '#aa4643'}
    ];
    var chart11 = new iChart.Column2D({
        render : 'collapseresult112',
        data : data11,
        title : {
            text : '整体完整性',
            color : '#3e576f'
        },
        subtitle : {
            text : ' ',
            color : '#6d869f'
        },
        footnote : {
            text : 'weibo.com',
            color : '#909090',
            fontsize : 11,
            padding : '0 38'
        },
        width : 600,
        height : 400,
        label : {
            fontsize:11,
            color : '#666666'
        },
        shadow : true,
        shadow_blur : 2,
        shadow_color : '#aaaaaa',
        shadow_offsetx : 1,
        shadow_offsety : 0,
        column_width : 62,
        sub_option : {
            listeners : {
                parseText : function(r, t) {
                    return t + "%";
                }
            },
            label : {
                fontsize:11,
                fontweight:600,
                color : '#4572a7'
            },
            border : {
                width : 2,
//radius : '5 5 0 0',//上圆角设置
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
});
*/
//[12]以此为准 @tongzhen
$(function() {
    var data12 = [
        {name : '书名',value : 29.84,color : '#aa4643'},
        {name : '作者',value : 24.88,color : '#89a54e'},
        {name : '作者ID',value : 86.77,color : '#80699b'},
        {name : '状态',value : 82.02,color : '#3d82ae'},
        {name : '简介',value : 99.02,color : '#3d9699'},
        {name : '状态',value : 95.02,color : '#3596ae'},
        {name : '分类ID',value : 97.02,color : '#6d96ae'},
        {name : '分类',value : 98.02,color : '#ad08ae'},
        {name : '创建时间',value : 99.02,color : '#da96fe'},
        {name : 'ISBN',value : 100,color : '#8700ae'},
        {name : '出版社',value : 88.98,color : '#9096a9'},
        {name : '出版价格',value : 76.20,color : '#fd961e'},
        {name : '关键字',value : 99.99,color : '#1d86ae'},
        {name : '收费标识',value : 90.02,color : '#2d96ae'},
        {name : '作者简介',value : 99.08,color : '#7dd6ae'},
        {name : '短标题',value : 99.01,color : '#ad96ae'},
        {name : '封面地址',value : 69.76,color : '#6e96ae'}
    ];

    var chart12 = new iChart.Column2D({
        render : 'collapseresult122',
        data : data12,
        title : {
            text : '点属性完整性',
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
});
/*
//[13]
$(function() {
    var data13 = [
        {name : '指标1',value : 25.00,color : '#4572a7'},
        {name : '指标2',value : 23.56,color : '#aa4643'},
        {name : '指标3',value : 10.56,color : '#89a54e'},
        {name : '指标4',value : 59.00,color : '#80699b'},
        {name : '指标5',value : 65.51,color : '#3d96ae'}
    ];
    var chart13 = new iChart.Column2D({
        render : 'collapseresult132',
        data : data13,
        title : {
            text : '边属性完整性--数据值指标显示',
            color : '#3e576f'
        },
        subtitle : {
            text : '副标题',
            color : '#6d869f'
        },
        footnote : {
            text : 'weibo.com',
            color : '#909090',
            fontsize : 11,
            padding : '0 38'
        },
        width : 600,
        height : 400,
        label : {
            fontsize:11,
            color : '#666666'
        },
        shadow : true,
        shadow_blur : 2,
        shadow_color : '#aaaaaa',
        shadow_offsetx : 1,
        shadow_offsety : 0,
        column_width : 62,
        sub_option : {
            listeners : {
                parseText : function(r, t) {
                    return t + "%";
                }
            },
            label : {
                fontsize:11,
                fontweight:600,
                color : '#4572a7'
            },
            border : {
                width : 2,
//radius : '5 5 0 0',//上圆角设置
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
});
//[2]
$(function() {
    var data2 = [
        {name : '指标1',value : 25.00,color : '#4572a7'},
        {name : '指标2',value : 23.56,color : '#aa4643'},
        {name : '指标3',value : 10.56,color : '#89a54e'},
        {name : '指标4',value : 59.00,color : '#80699b'},
        {name : '指标5',value : 65.51,color : '#3d96ae'}
    ];
    var chart2 = new iChart.Column2D({
        render : 'collapseresult2',
        data : data2,
        title : {
            text : '准确性--数据值指标显示',
            color : '#3e576f'
        },
        subtitle : {
            text : '副标题',
            color : '#6d869f'
        },
        footnote : {
            text : 'weibo.com',
            color : '#909090',
            fontsize : 11,
            padding : '0 38'
        },
        width : 600,
        height : 400,
        label : {
            fontsize:11,
            color : '#666666'
        },
        shadow : true,
        shadow_blur : 2,
        shadow_color : '#aaaaaa',
        shadow_offsetx : 1,
        shadow_offsety : 0,
        column_width : 62,
        sub_option : {
            listeners : {
                parseText : function(r, t) {
                    return t + "%";
                }
            },
            label : {
                fontsize:11,
                fontweight:600,
                color : '#4572a7'
            },
            border : {
                width : 2,
//radius : '5 5 0 0',//上圆角设置
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
    chart2.draw();
});

//[31]
$(function() {
    var data31 = [
        {name : '指标1',value : 25.00,color : '#4572a7'},
        {name : '指标2',value : 23.56,color : '#aa4643'},
        {name : '指标3',value : 10.56,color : '#89a54e'},
        {name : '指标4',value : 59.00,color : '#80699b'},
        {name : '指标5',value : 65.51,color : '#3d96ae'}
    ];
    var chart31 = new iChart.Column2D({
        render : 'collapseresult31',
        data : data31,
        title : {
            text : '数据生成时效性--数据值指标显示',
            color : '#3e576f'
        },
        subtitle : {
            text : '副标题',
            color : '#6d869f'
        },
        footnote : {
            text : 'weibo.com',
            color : '#909090',
            fontsize : 11,
            padding : '0 38'
        },
        width : 600,
        height : 400,
        label : {
            fontsize:11,
            color : '#666666'
        },
        shadow : true,
        shadow_blur : 2,
        shadow_color : '#aaaaaa',
        shadow_offsetx : 1,
        shadow_offsety : 0,
        column_width : 62,
        sub_option : {
            listeners : {
                parseText : function(r, t) {
                    return t + "%";
                }
            },
            label : {
                fontsize:11,
                fontweight:600,
                color : '#4572a7'
            },
            border : {
                width : 2,
//radius : '5 5 0 0',//上圆角设置
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
    chart31.draw();
});
//[32]
$(function() {
    var data32 = [
        {name : '指标1',value : 25.00,color : '#4572a7'},
        {name : '指标2',value : 23.56,color : '#aa4643'},
        {name : '指标3',value : 10.56,color : '#89a54e'},
        {name : '指标4',value : 59.00,color : '#80699b'},
        {name : '指标5',value : 65.51,color : '#3d96ae'}
    ];
    var chart32 = new iChart.Column2D({
        render : 'collapseresult32',
        data : data32,
        title : {
            text : '数据推送时效性--数据值指标显示',
            color : '#3e576f'
        },
        subtitle : {
            text : '副标题',
            color : '#6d869f'
        },
        footnote : {
            text : 'weibo.com',
            color : '#909090',
            fontsize : 11,
            padding : '0 38'
        },
        width : 600,
        height : 400,
        label : {
            fontsize:11,
            color : '#666666'
        },
        shadow : true,
        shadow_blur : 2,
        shadow_color : '#aaaaaa',
        shadow_offsetx : 1,
        shadow_offsety : 0,
        column_width : 62,
        sub_option : {
            listeners : {
                parseText : function(r, t) {
                    return t + "%";
                }
            },
            label : {
                fontsize:11,
                fontweight:600,
                color : '#4572a7'
            },
            border : {
                width : 2,
//radius : '5 5 0 0',//上圆角设置
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
    chart32.draw();
});

//[41]
$(function() {
    var data41 = [
        {name : '指标1',value : 25.00,color : '#4572a7'},
        {name : '指标2',value : 23.56,color : '#aa4643'},
        {name : '指标3',value : 10.56,color : '#89a54e'},
        {name : '指标4',value : 59.00,color : '#80699b'},
        {name : '指标5',value : 65.51,color : '#3d96ae'}
    ];
    var chart41 = new iChart.Column2D({
        render : 'collapseresult41',
        data : data41,
        title : {
            text : '点属性完整性--数据值指标显示',
            color : '#3e576f'
        },
        subtitle : {
            text : '副标题',
            color : '#6d869f'
        },
        footnote : {
            text : 'weibo.com',
            color : '#909090',
            fontsize : 11,
            padding : '0 38'
        },
        width : 600,
        height : 400,
        label : {
            fontsize:11,
            color : '#666666'
        },
        shadow : true,
        shadow_blur : 2,
        shadow_color : '#aaaaaa',
        shadow_offsetx : 1,
        shadow_offsety : 0,
        column_width : 62,
        sub_option : {
            listeners : {
                parseText : function(r, t) {
                    return t + "%";
                }
            },
            label : {
                fontsize:11,
                fontweight:600,
                color : '#4572a7'
            },
            border : {
                width : 2,
//radius : '5 5 0 0',//上圆角设置
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
    chart41.draw();
});
//[42]
$(function() {
    var data42 = [
        {name : '指标1',value : 25.00,color : '#4572a7'},
        {name : '指标2',value : 23.56,color : '#aa4643'},
        {name : '指标3',value : 10.56,color : '#89a54e'},
        {name : '指标4',value : 59.00,color : '#80699b'},
        {name : '指标5',value : 65.51,color : '#3d96ae'}
    ];
    var chart42 = new iChart.Column2D({
        render : 'collapseresult42',
        data : data42,
        title : {
            text : '边属性完整性--数据值指标显示',
            color : '#3e576f'
        },
        subtitle : {
            text : '副标题',
            color : '#6d869f'
        },
        footnote : {
            text : 'weibo.com',
            color : '#909090',
            fontsize : 11,
            padding : '0 38'
        },
        width : 600,
        height : 400,
        label : {
            fontsize:11,
            color : '#666666'
        },
        shadow : true,
        shadow_blur : 2,
        shadow_color : '#aaaaaa',
        shadow_offsetx : 1,
        shadow_offsety : 0,
        column_width : 62,
        sub_option : {
            listeners : {
                parseText : function(r, t) {
                    return t + "%";
                }
            },
            label : {
                fontsize:11,
                fontweight:600,
                color : '#4572a7'
            },
            border : {
                width : 2,
//radius : '5 5 0 0',//上圆角设置
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
    chart42.draw();
});

//[5]
$(function() {
    var data5 = [
        {name : '指标1',value : 25.00,color : '#4572a7'},
        {name : '指标2',value : 23.56,color : '#aa4643'},
        {name : '指标3',value : 10.56,color : '#89a54e'},
        {name : '指标4',value : 59.00,color : '#80699b'},
        {name : '指标5',value : 65.51,color : '#3d96ae'}
    ];
    var chart5 = new iChart.Column2D({
        render : 'collapseresult5',
        data : data5,
        title : {
            text : '唯一性--数据值指标显示',
            color : '#3e576f'
        },
        subtitle : {
            text : '副标题',
            color : '#6d869f'
        },
        footnote : {
            text : 'weibo.com',
            color : '#909090',
            fontsize : 11,
            padding : '0 38'
        },
        width : 600,
        height : 400,
        label : {
            fontsize:11,
            color : '#666666'
        },
        shadow : true,
        shadow_blur : 2,
        shadow_color : '#aaaaaa',
        shadow_offsetx : 1,
        shadow_offsety : 0,
        column_width : 62,
        sub_option : {
            listeners : {
                parseText : function(r, t) {
                    return t + "%";
                }
            },
            label : {
                fontsize:11,
                fontweight:600,
                color : '#4572a7'
            },
            border : {
                width : 2,
//radius : '5 5 0 0',//上圆角设置
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
    chart5.draw();
});
   */