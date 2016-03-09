<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>xhprof性能分析系统(Echart)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="xhprof性能分析系统">
    <meta name="author" content="linzhifeng@baidu.com">
    <meta name="author" content="elitetongzhen@126.com">

    <!-- Le styles -->
    <link href="./include/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="./include/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="./include/css/echartsHome.css" rel="stylesheet">
    <link href="./include/css/styledemo.css" rel="stylesheet">
    <link href="./include/css/font-awesome.css" rel="stylesheet">
    <link href="./include/bootstrap_datetime/css/bootstrap-datetimepicker.css" rel="stylesheet">

</head>

<body>
    <!-- NAVBAR
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="./app.php?target=mod_index">xhprof性能分析</a>
          <div class="nav-collapse collapse">
              <a id="forkme_banner" href="https://github.com/tongzhenelite/bfwphpapp">View on GitHub</a>
              <ul class="nav">
                <li><a href="./app.php?target=mod_index"><i class="icon-home icon-white"></i> Home</a></li>

				<!--
				<li class="active"><a href="example.html" class="active">Example</a></li>
                <li><a href="doc.html" >API &amp; Doc</a></li>
				-->
				
				<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">性能分析图<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="./app.php?target=mod_statrequest">单次请求统计</a></li>
                    <li><a href="./app.php?target=mod_statline">分时请求统计</a></li>
                    <li class="divider"></li>
                    <li><a href="./app.php?target=mod_index">test</a></li>
                  </ul>
				</li>
				
				<!--
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Link <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="https://github.com/ecomfe" target="_blank">Ecom-FE</a></li>
                    <li><a href="http://fe.baidu.com/doc/ecom/tech/topic/dv/index.html" target="_blank">Data Visualization</a></li>
                    <li class="divider"></li>
				-->
					<!--li class="nav-header">Library</li-->
				<!--   
					<li><a href="http://ecomfe.github.io/zrender/index.html" target="_blank">ZRender</a></li>
                  </ul>
                </li>
				-->

              </ul>
           </div><!--/.nav-collapse -->
        </div><!-- /.container -->
      </div><!-- /.navbar-inner -->
    </div><!-- /.navbar-wrapper -->
<!-- /NavBar ========================================== -->

<section id="content">
	<div class="container">
		<div class="row">				
			<div class="span2">				
				<aside class="left-sidebar">										
					<div class="widget">
						<p class="widgetheading">性能分析图</p>
							<ul class="cat">
								<li><i class="icon-angle-right"></i> <a href="./app.php?target=mod_statrequest">单次请求统计</a></li>
								<li><i class="icon-angle-right"></i> <a href="./app.php?target=mod_statline">分时请求统计</a></li>
							</ul>
					</div>
				</aside>
			</div>
				
			<div class="span10">
				<article>
				<div class="row">					
					<div class="span10">
						<div class="post-image">
							<div class="post-heading">
								<p id="posthead">分时请求统计</p>						
							</div>								
						</div>

						<div>
						<?php $stTime = BFW_View::get('stTime'); $endTime = BFW_View::get('endTime');$objtype = BFW_View::get('objtype');?>
						<form class="well form-inline" name="searchtimeform" id="searchtimeform" action="./app.php?target=mod_statline&search=1" method="post">
								<div class="row-fluid">
									<label for="objtype"><strong>host来源：</strong></label>
                        			<select name="objtype" id="objtype" class="span3" style="height:30px;">
										<?php $host = BFW_View::get('host');?>
										<?php if($host){ ?>
											<?php foreach($host as $type => $value){ ?>
											<option value="<?php echo $type;?>" <?php if ($type == $objtype) echo 'selected';?>><?php echo $value;?></option>
											<?php } ?>
										<?php }else { ?>
											<option value="0" 'selected'>全部</option>
										<?php } ?>
									</select>
									&nbsp;
									<input type="submit" class="btn btn-info" id="btnsearchtime" value="查  询" />
								</div>
                        	</form>
						</div>
<?php $resultFlag = BFW_View::get('resultFlag');?>
<?php if(true){ ?>

	<div class="btn-toolbar">
		<div class="btn-group">
			<div class="btn" id="btn1">1小时</div>
			<div class="btn" id="btn2">6小时</div>
			<div class="btn" id="btn3">24小时</div>
		</div>
		<div class="btn-group">
			<div class="btn" id="btn4">2天</div>
			<div class="btn" id="btn5">1周</div>
			<div class="btn" id="btn6">今天</div>
		</div>
		<div class="btn-group">
			<div class="btn" id="btn7">昨天对比</div>
		</div>
	</div>
	<div>
        <div id="tab1" class="tab-pane active">
			<?php if(BFW_View::get('resultFlag1')){ ?>
			<div id="main" class="main"  style="height:400px;border:1px solid #ccc;padding:10px;"></div>
			<div>
				<strong>说明：</strong>
			</div>
			<div>
				<p>（1）X轴：当前时间段内每次访问存储的id;</p>
				<p>（2）Y轴（单位）：总时间(μm) cpu时间(μm) 内存使用(bytes) 峰值内存使用(bytes)</p>
			</div>
			<?php }else{ ?>
			<p><strong>暂无此组下数据！</strong></p>
			<?php }?>
        </div>
    
        <div id="tab2" class="tab-pane">
			<?php if(BFW_View::get('resultFlag2')){ ?>
			<div id="main2" class="main"  style="height:400px;border:1px solid #ccc;padding:10px;"></div>
			<div>
				<strong>说明：</strong>
			</div>
			<div>
				<p>（1）X轴：当前时间段内每次访问存储的id;</p>
				<p>（2）Y轴（单位）：总时间(μm) cpu时间(μm) 内存使用(bytes) 峰值内存使用(bytes)</p>
			</div>
			<?php }else{ ?>
			<p><strong>暂无此组下数据！</strong></p>
			<?php }?>
		</div>

        <div id="tab3" class="tab-pane">
			<?php if(BFW_View::get('resultFlag3')){ ?>
			<div id="main3" class="main"  style="height:400px;border:1px solid #ccc;padding:10px;"></div>
			<?php }else{ ?>
			<p><strong>暂无此组下数据！</strong></p>
			<?php }?>
        </div>

        <div id="tab4" class="tab-pane">
			<?php if(BFW_View::get('resultFlag4')){ ?>
			<div id="main4" class="main"  style="height:400px;border:1px solid #ccc;padding:10px;"></div>
			<?php }else{ ?>
			<p><strong>暂无此组下数据！</strong></p>
			<?php }?>
        </div>

		<div id="tab5" class="tab-pane">
			<?php if(BFW_View::get('resultFlag5')){ ?>
			<div id="main5" class="main"  style="height:400px;border:1px solid #ccc;padding:10px;"></div>
			<?php }else{ ?>
			<p><strong>暂无此组下数据！</strong></p>
			<?php }?>
        </div>

		<div id="tab6" class="tab-pane">
			<?php if(BFW_View::get('resultFlag6')){ ?>
			<div id="main6" class="main"  style="height:400px;border:1px solid #ccc;padding:10px;"></div>
			<?php }else{ ?>
			<p><strong>暂无此组下数据！</strong></p>
			<?php }?>
        </div>

		<div id="tab7" class="tab-pane">
			<?php if(BFW_View::get('resultFlag7')){ ?>
			<div id="main7" class="main"  style="height:400px;border:1px solid #ccc;padding:10px;"></div>
			<?php }else{ ?>
			<p><strong>暂无此组下数据！</strong></p>
			<?php }?>
        </div>
    </div>
							
<?php }else { ?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Warning!</h4>
	请重新输入查询条件，查无此结果！
</div>
<?php } ?>
					</div>
				</div>
				</article>															
			</div><!-- /span10 -->
							
		</div><!-- /row -->
		
	</div><!-- /container -->
</section><!-- /section -->

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./include/js/jquery-1.11.1.min.js"></script>
    <script src="./include/bootstrap/js/bootstrap.min.js"></script>
    <script src="./include/bootstrap_datetime/js/bootstrap-datetimepicker.js"></script>
    <script src="./include/bootstrap_datetime/js/locales/bootstrap-datetimepicker.fr.js"></script>
    <script src="./include/js/resqueshow.js"></script>
	
	<script src="./include/echarts/doc/asset/js/esl/esl.js"></script>
    <script src="./include/echarts/doc/asset/js/codemirror.js"></script>
    <script src="./include/echarts/doc/asset/js/javascript.js"></script>
	
	<script src="./include/echarts/build/echarts-original.js"></script>
	<script type="text/javascript">
		//[1]1小时
		var echartdatas_ids = [];
		var echartdatas_wts = [];
		var echartdatas_mus = [];
		var echartdatas_pmus = [];
		var echartdatas_cpus = [];
		echartdatas_ids =<?php echo BFW_View::get('echartdatas_ids');?>;
		echartdatas_wts =<?php echo BFW_View::get('echartdatas_wts');?>;
		echartdatas_mus =<?php echo BFW_View::get('echartdatas_mus');?>;
		echartdatas_pmus =<?php echo BFW_View::get('echartdatas_pmus');?>;
		echartdatas_cpus =<?php echo BFW_View::get('echartdatas_cpus');?>;
		//[2]6小时
		var echartdatas_ids2 = [];
		var echartdatas_wts2 = [];
		var echartdatas_mus2 = [];
		var echartdatas_pmus2 = [];
		var echartdatas_cpus2 = [];
		echartdatas_ids2 =<?php echo BFW_View::get('echartdatas_ids2');?>;
		echartdatas_wts2 =<?php echo BFW_View::get('echartdatas_wts2');?>;
		echartdatas_mus2 =<?php echo BFW_View::get('echartdatas_mus2');?>;
		echartdatas_pmus2 =<?php echo BFW_View::get('echartdatas_pmus2');?>;
		echartdatas_cpus2 =<?php echo BFW_View::get('echartdatas_cpus2');?>;
		//[3]
		var echartdatas_ids3 = [];
		var echartdatas_wts3 = [];
		var echartdatas_mus3 = [];
		var echartdatas_pmus3 = [];
		var echartdatas_cpus3 = [];
		echartdatas_ids3 =<?php echo BFW_View::get('echartdatas_ids3');?>;
		echartdatas_wts3 =<?php echo BFW_View::get('echartdatas_wts3');?>;
		echartdatas_mus3 =<?php echo BFW_View::get('echartdatas_mus3');?>;
		echartdatas_pmus3 =<?php echo BFW_View::get('echartdatas_pmus3');?>;
		echartdatas_cpus3 =<?php echo BFW_View::get('echartdatas_cpus3');?>;
		//[4]
		var echartdatas_ids4 = [];
		var echartdatas_wts4 = [];
		var echartdatas_mus4 = [];
		var echartdatas_pmus4 = [];
		var echartdatas_cpus4 = [];
		echartdatas_ids4 =<?php echo BFW_View::get('echartdatas_ids4');?>;
		echartdatas_wts4 =<?php echo BFW_View::get('echartdatas_wts4');?>;
		echartdatas_mus4 =<?php echo BFW_View::get('echartdatas_mus4');?>;
		echartdatas_pmus4 =<?php echo BFW_View::get('echartdatas_pmus4');?>;
		echartdatas_cpus4 =<?php echo BFW_View::get('echartdatas_cpus4');?>;
		//[5]
		var echartdatas_ids5 = [];
		var echartdatas_wts5 = [];
		var echartdatas_mus5 = [];
		var echartdatas_pmus5 = [];
		var echartdatas_cpus5 = [];
		echartdatas_ids5 =<?php echo BFW_View::get('echartdatas_ids5');?>;
		echartdatas_wts5 =<?php echo BFW_View::get('echartdatas_wts5');?>;
		echartdatas_mus5 =<?php echo BFW_View::get('echartdatas_mus5');?>;
		echartdatas_pmus5 =<?php echo BFW_View::get('echartdatas_pmus5');?>;
		echartdatas_cpus5 =<?php echo BFW_View::get('echartdatas_cpus5');?>;
		//[6]
		var echartdatas_ids6 = [];
		var echartdatas_wts6 = [];
		var echartdatas_mus6 = [];
		var echartdatas_pmus6 = [];
		var echartdatas_cpus6 = [];
		echartdatas_ids6 =<?php echo BFW_View::get('echartdatas_ids6');?>;
		echartdatas_wts6 =<?php echo BFW_View::get('echartdatas_wts6');?>;
		echartdatas_mus6 =<?php echo BFW_View::get('echartdatas_mus6');?>;
		echartdatas_pmus6 =<?php echo BFW_View::get('echartdatas_pmus6');?>;
		echartdatas_cpus6 =<?php echo BFW_View::get('echartdatas_cpus6');?>;
		//[7]
		var echartdatas_ids7 = [];
		var echartdatas_wts7 = [];
		var echartdatas_mus7 = [];
		var echartdatas_pmus7 = [];
		var echartdatas_cpus7 = [];
		echartdatas_ids7 =<?php echo BFW_View::get('echartdatas_ids7');?>;
		echartdatas_wts7 =<?php echo BFW_View::get('echartdatas_wts7');?>;
		echartdatas_mus7 =<?php echo BFW_View::get('echartdatas_mus7');?>;
		echartdatas_pmus7 =<?php echo BFW_View::get('echartdatas_pmus7');?>;
		echartdatas_cpus7 =<?php echo BFW_View::get('echartdatas_cpus7');?>;
		
		var echartdatas_wts76 = [];
		var echartdatas_mus76 = [];
		var echartdatas_pmus76 = [];
		var echartdatas_cpus76 = [];
		echartdatas_wts76 =<?php echo BFW_View::get('echartdatas_wts76');?>;
		echartdatas_mus76 =<?php echo BFW_View::get('echartdatas_mus76');?>;
		echartdatas_pmus76 =<?php echo BFW_View::get('echartdatas_pmus76');?>;
		echartdatas_cpus76 =<?php echo BFW_View::get('echartdatas_cpus76');?>;


		/*
		// 路径配置
        require.config({
            paths:{ 
                //'echarts' : 'http://echarts.baidu.com/build/echarts',
                //'echarts/chart/bar' : 'http://echarts.baidu.com/build/echarts'
                'echarts' : '../../include/echarts/src',
                'echarts/chart/bar' : '../../include/echarts/src'
			},
            {
                name: 'zrender',
                //location: 'http://ecomfe.github.io/zrender/src',
                location: '../../include/zrender/src',
                main: 'zrender'
            }
        });
		 */
        // 使用
        require(
            [
                'echarts',
                'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
            ],
function(ec) {
	//[1]1小时
	var myChart = ec.init(document.getElementById('main')); 
	var option = {
		tooltip : {
			trigger: 'axis'
		},
		legend: {
			data:['总时间','内存使用','峰值内存使用','cpu时间']
		},
		toolbox: {
			show : true,
			feature : {
				mark : {show: true},
				dataView : {show: true, readOnly: false},
				magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
				restore : {show: true},
				saveAsImage : {show: true}
			}
		},
		calculable : true,
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
			{
				name:'总时间',
				type:'line',
				stack: '总量',
				data:echartdatas_wts
			},
			{
				name:'内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_mus
			},
			{
				name:'峰值内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_pmus
			},
			{
				name:'cpu时间',
				type:'line',
				stack: '总量',
				data: echartdatas_cpus
			},
		]
	};
	// 为echarts对象加载数据 
	myChart.setOption(option); 

	//==================
	//[2]6小时
	var myChart2 = ec.init(document.getElementById('main2')); 
	var option2 = {
		tooltip : {
			trigger: 'axis'
		},
		legend: {
			data:['总时间','内存使用','峰值内存使用','cpu时间']
		},
		toolbox: {
			show : true,
			feature : {
				mark : {show: true},
				dataView : {show: true, readOnly: false},
				magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
				restore : {show: true},
				saveAsImage : {show: true}
			}
		},
		calculable : true,
		xAxis : [
			{
				type : 'category',
				boundaryGap : false,
				data : echartdatas_ids2
			}
		],
		yAxis : [
			{
				type : 'value',
				splitArea : {show : true}
			}
		],
		series : [
			{
				name:'总时间',
				type:'line',
				stack: '总量',
				data:echartdatas_wts2
			},
			{
				name:'内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_mus2
			},
			{
				name:'峰值内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_pmus2
			},
			{
				name:'cpu时间',
				type:'line',
				stack: '总量',
				data: echartdatas_cpus2
			},
		]
	};
	// 为echarts对象加载数据 
	myChart2.setOption(option2); 

	//[3]24小时
	var myChart3 = ec.init(document.getElementById('main3')); 
	var option3 = {
		tooltip : {
			trigger: 'axis'
		},
		legend: {
			data:['总时间','内存使用','峰值内存使用','cpu时间']
		},
		toolbox: {
			show : true,
			feature : {
				mark : {show: true},
				dataView : {show: true, readOnly: false},
				magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
				restore : {show: true},
				saveAsImage : {show: true}
			}
		},
		calculable : true,
		xAxis : [
			{
				type : 'category',
				boundaryGap : false,
				data : echartdatas_ids3
			}
		],
		yAxis : [
			{
				type : 'value',
				splitArea : {show : true}
			}
		],
		series : [
			{
				name:'总时间',
				type:'line',
				stack: '总量',
				data:echartdatas_wts3
			},
			{
				name:'内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_mus3
			},
			{
				name:'峰值内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_pmus3
			},
			{
				name:'cpu时间',
				type:'line',
				stack: '总量',
				data: echartdatas_cpus3
			},
		]
	};
	// 为echarts对象加载数据 
	myChart3.setOption(option3); 

	//[4]2天
	var myChart4 = ec.init(document.getElementById('main4')); 
	var option4 = {
		tooltip : {
			trigger: 'axis'
		},
		legend: {
			data:['总时间','内存使用','峰值内存使用','cpu时间']
		},
		toolbox: {
			show : true,
			feature : {
				mark : {show: true},
				dataView : {show: true, readOnly: false},
				magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
				restore : {show: true},
				saveAsImage : {show: true}
			}
		},
		calculable : true,
		xAxis : [
			{
				type : 'category',
				boundaryGap : false,
				data : echartdatas_ids4
			}
		],
		yAxis : [
			{
				type : 'value',
				splitArea : {show : true}
			}
		],
		series : [
			{
				name:'总时间',
				type:'line',
				stack: '总量',
				data:echartdatas_wts4
			},
			{
				name:'内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_mus4
			},
			{
				name:'峰值内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_pmus4
			},
			{
				name:'cpu时间',
				type:'line',
				stack: '总量',
				data: echartdatas_cpus4
			},
		]
	};
	// 为echarts对象加载数据 
	myChart4.setOption(option4); 

	//[5]一周
	var myChart5 = ec.init(document.getElementById('main5')); 
	var option5 = {
		tooltip : {
			trigger: 'axis'
		},
		legend: {
			data:['总时间','内存使用','峰值内存使用','cpu时间']
		},
		toolbox: {
			show : true,
			feature : {
				mark : {show: true},
				dataView : {show: true, readOnly: false},
				magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
				restore : {show: true},
				saveAsImage : {show: true}
			}
		},
		calculable : true,
		xAxis : [
			{
				type : 'category',
				boundaryGap : false,
				data : echartdatas_ids5
			}
		],
		yAxis : [
			{
				type : 'value',
				splitArea : {show : true}
			}
		],
		series : [
			{
				name:'总时间',
				type:'line',
				stack: '总量',
				data:echartdatas_wts5
			},
			{
				name:'内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_mus5
			},
			{
				name:'峰值内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_pmus5
			},
			{
				name:'cpu时间',
				type:'line',
				stack: '总量',
				data: echartdatas_cpus5
			},
		]
	};
	// 为echarts对象加载数据 
	myChart5.setOption(option5); 


	//[6]今天
	var myChart6 = ec.init(document.getElementById('main6')); 
	var option6 = {
		tooltip : {
			trigger: 'axis'
		},
		legend: {
			data:['总时间','内存使用','峰值内存使用','cpu时间']
		},
		toolbox: {
			show : true,
			feature : {
				mark : {show: true},
				dataView : {show: true, readOnly: false},
				magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
				restore : {show: true},
				saveAsImage : {show: true}
			}
		},
		calculable : true,
		xAxis : [
			{
				type : 'category',
				boundaryGap : false,
				data : echartdatas_ids6
			}
		],
		yAxis : [
			{
				type : 'value',
				splitArea : {show : true}
			}
		],
		series : [
			{
				name:'总时间',
				type:'line',
				stack: '总量',
				data:echartdatas_wts6
			},
			{
				name:'内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_mus6
			},
			{
				name:'峰值内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_pmus6
			},
			{
				name:'cpu时间',
				type:'line',
				stack: '总量',
				data: echartdatas_cpus6
			},
		]
	};
	// 为echarts对象加载数据 
	myChart6.setOption(option6); 
	

	//[7]昨天对比
	var myChart7 = ec.init(document.getElementById('main7')); 
	var option7 = {
		tooltip : {
			trigger: 'axis'
		},
		legend: {
			//data:['总时间','内存使用','峰值内存使用','cpu时间']
			data:['总时间','内存使用','峰值内存使用','cpu时间','today总时间','today内存使用','today峰值内存使用','todayCPU时间']
		},
		toolbox: {
			show : true,
			feature : {
				mark : {show: true},
				dataView : {show: true, readOnly: false},
				magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
				restore : {show: true},
				saveAsImage : {show: true}
			}
		},
		calculable : true,
		xAxis : [
			{
				type : 'category',
				boundaryGap : false,
				data : echartdatas_ids7
			}
		],
		yAxis : [
			{
				type : 'value',
				splitArea : {show : true}
			}
		],
		series : [
			{
				name:'总时间',
				type:'line',
				stack: '总量',
				data:echartdatas_wts7
			},
			{
				name:'内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_mus7
			},
			{
				name:'峰值内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_pmus7
			},
			{
				name:'cpu时间',
				type:'line',
				stack: '总量',
				data: echartdatas_cpus7
			},


			{
				name:'today总时间',
				type:'line',
				stack: '总量',
				data:echartdatas_wts76
			},
			{
				name:'today内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_mus76
			},
			{
				name:'today峰值内存使用',
				type:'line',
				stack: '总量',
				data:echartdatas_pmus76
			},
			{
				name:'todayCPU时间',
				type:'line',
				stack: '总量',
				data: echartdatas_cpus76
			},
		]
	};
	// 为echarts对象加载数据 
	myChart7.setOption(option7); 


});
</script>
</body>
</html>
