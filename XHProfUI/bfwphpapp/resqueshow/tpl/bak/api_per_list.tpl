<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!--- START 以上内容不需更改，保证该TPL页内的标签匹配即可 --->

<script src="../../../../assets/echarts/js/esl/esl.js"></script>
<script src="../../../../assets/echarts/js/javascript.js"></script>

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div style="border:0px;padding-bottom:5px;height:auto">
	<form action="" method="GET" style="margin-bottom:0px">
		<div style="float:left;margin-right:5px">
			<label>请选择业务类型</label>
			<{html_options name=business_type id="DropDownTimezone"  options=$business_types selected=$_GET.business_type}> 
		</div>
		
		<!--留待后续优化为可选择时分秒的时间控件
		<div style="float:left;margin-right:5px">
			<label> 选择起始时间 </label>
			<input type="text" id="start_date" name="start_date" value="<{$_GET.start_date}>" placeholder="起始时间" >
		</div>
		<div style="float:left;margin-right:5px">
			<label>选择结束时间</label>	
			<input type="text" id="end_date" name="end_date" value="<{$_GET.end_date}>" placeholder="结束时间" > 
		</div>
		-->
		
		<div style="float:left;margin-right:5px">
			<label> 起始时间(如20140410223344) </label>
			<input type="text" name="start_date" value="<{$_GET.start_date}>" placeholder="起始时间">
		</div>
		<div style="float:left;margin-right:5px">
			<label>结束时间(如20140411223344)</label>	
			<input type="text" name="end_date" value="<{$_GET.end_date}>" placeholder="结束时间"> 
		</div>
		
		<div style="float:left;margin-right:5px">
			<label>uid</label>
			<input type="text" name="uid" value="<{$_GET.uid}>" placeholder="输入uid" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label>请选性能择指标类型</label>
			<{html_options name=indicator_type id="DropDownTimezone"  options=$indicator_types selected=$_GET.indicator_type}> 
		</div>
		<div style="float:left;margin-right:5px">
			<label> 性能指标最小值 </label>
			<input type="text" name="min_date" value="<{$_GET.min_date}>" placeholder="性能指标最小值">
		</div>
		<div style="float:left;margin-right:5px">
			<label> 性能指标最大值 </label>	
			<input type="text" name="max_date" value="<{$_GET.max_date}>" placeholder="性能指标最大值"> 
		</div>
		<div style="float:left;margin-right:5px">
			<label>id</label>
			<input type="text" name="id" value="<{$_GET.id}>" placeholder="输入id"> 
		</div>
		<div style="float:left;margin-right:5px">
			<label>请选数据来源</label>
			<{html_options name=data_type id="DropDownTimezone"  options=$data_types selected=$_GET.data_type}> 
		</div>
		<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">
			<button type="submit" class="btn btn-primary"><strong>检索</strong></button>
		</div>
		<!--<div style="clear:both;"></div>-->
	</form>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div id="graphic" class="span12">
            <div id="main" class="main"style="height:400px;border:1px solid #ccc;padding:10px;"></div>
            <!--<div>
                <button onclick="refresh(true)">Refresh ~</button>
                <span id='wrong-message' style="color:red"></span>
            </div>-->
        </div><!--/span-->
    </div><!--/row-->
</div>

<div class="block">
    <a href="#page-stats" class="block-heading" data-toggle="collapse">接口调用信息列表</a>
    <div id="page-stats" class="block-body collapse in">
           <table class="table table-striped">
          <thead>
            <tr>
				<th style="width:10%">id</th>
				<th style="width:10%">业务类型</th>
				<th style="width:15%">uid</th>
				<th style="width:20%">时间</th>
				<th style="width:10%">总耗时</th>
				<th style="width:10%">内存</th>
				<th style="width:10%">cpu</th>
				<th style="width:5%">来源</th>
				<th style="width:10%">操作</th>
            </tr>
          </thead>
          <tbody>							  
            <{foreach name=api_info from=$api_infos item=api_info}>
				<tr>
				<td><{$api_info.id}></td>
				<td><{$api_info.business_type}></td>
				<td><{$api_info.business_uid}></td>
				<td><{$api_info.timestamp}></td>
				<td><{$api_info.wt}></td>
				<td><{$api_info.mu}></td>
				<td><{$api_info.cpu}></td>
				<td><{$api_info.data_type}></td>
				<td>
					<a href="/vendor/xhprof-0.9.4/xhprof_html/index.php?id=<{$api_info.id}>" target="_blank" title= "修改"><i class="icon-pencil"></i>查看</a>
				</td>
				</tr>
			<{/foreach}>
          </tbody>
        </table>
			<!--- START 分页模板 --->
           <{$page_html}>
		   <!--- END --->
    </div>
</div>

<script>

var echartdatas_ids = [];
var echartdatas_wts = [];
var echartdatas_mus = [];
var echartdatas_pmus = [];
var echartdatas_cpus = [];

echartdatas_ids =<{$echartdatas_ids}>;
echartdatas_wts =<{$echartdatas_wts}>;
echartdatas_mus =<{$echartdatas_mus}>;
echartdatas_pmus =<{$echartdatas_pmus}>;
echartdatas_cpus =<{$echartdatas_cpus}>;

var echarts;
var myChart;
require.config({
        packages: [
            {
                name: 'echarts',
                location: '../../../../assets/echarts/src',
                main: 'echarts'
            },
            {
                name: 'zrender',
                location: '../../../../assets/zrender/src',
                main: 'zrender'
            }
        ]
    });

// 按需加载
require(
    [
        'echarts',
        'echarts/chart/line',
        'echarts/chart/bar',
        'echarts/chart/scatter',
        'echarts/chart/k',
        'echarts/chart/pie',
        'echarts/chart/radar',
        'echarts/chart/force',
        'echarts/chart/chord',
    ],
    requireCallback
);

var option = {
	tooltip : {
			        trigger: 'axis'
			    },
			    
			    legend: {
			        data:['总时间','内存','cpu']
			    },
			    
			    toolbox: {
			        show : true,
			        feature : {
			            mark : {show: true},
			            dataZoom : {show: true},
			            dataView : {show: true},
			            magicType : {show: true, type: ['line', 'bar']},
			            restore : {show: true},
			            saveAsImage : {show: true}
			        }
			    },
			    calculable : true,
			    dataZoom : {
			        show : true,
			        realtime : true,
			        //orient: 'vertical',   // 'horizontal'
			        //x: 0,
			        y: 36,
			        //width: 400,
			        height: 20,
			        backgroundColor: 'rgba(221,160,221,0.5)',
			        dataBackgroundColor: 'rgba(138,43,226,0.5)',
			        fillerColor: 'rgba(38,143,26,0.6)',
			        handleColor: 'rgba(128,43,16,0.8)',
			        //xAxisIndex:[],
			        //yAxisIndex:[],
			        start : 0,
			        end : 100
			    },
			    xAxis : [
			        {
			            type : 'category',
			            boundaryGap : false,
			            data : echartdatas_ids
			        }
			    ],
			    yAxis : [
			        {
			            type : 'value',
			            splitArea : {show : true}
			        }
			    ],
			    series : [
			        /*{
			            name:'pmu',
			            type:'line',
			            data:echartdatas_pmus
			        },*/
					{
			            name:'总时间',
			            type:'line',
			            data:echartdatas_wts
			        },
					{
			            name:'内存',
			            type:'line',
			            data:echartdatas_mus
			        },
					{
			            name:'cpu',
			            type:'line',
			            data:echartdatas_cpus
			        }
			    ],
			    calculable:false
}

function requireCallback (ec) {
    echarts = ec;
    if (myChart && myChart.dispose) {
        myChart.dispose();
    }
    myChart = echarts.init(document.getElementById('main'));
    myChart.setOption(option);
    //refresh();
    //window.onresize = myChart.resize;
}

function refresh(isBtnRefresh){
    if (isBtnRefresh) {
        needRefresh = true;
        focusGraphic();
        return;
    }
    needRefresh = false;
    if (myChart && myChart.dispose) {
        myChart.dispose();
    }
    myChart = echarts.init(domMain);
    window.onresize = myChart.resize;
    (new Function(editor.doc.getValue()))();
    myChart.setOption(option, true);
    domMessage.innerHTML = '';
}

$(function() {
	 
	var date=$( "#start_date" );
	date.datepicker({ dateFormat: "yy-mm-dd" });
	date.datepicker( "option", "firstDay", 1 );
});
$(function() {
	var date=$( "#end_date" );
	date.datepicker({ dateFormat: "yy-mm-dd" });
	date.datepicker( "option", "firstDay", 1 );
});

</script>
	
<!--- END 以下内容不需更改，请保证该TPL页内的标签匹配即可 --->
<{include file="footer.tpl" }>