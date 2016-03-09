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

    <!-- Fav and touch icons -->
    <style type="text/css">
		
    </style>
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
								<p id="posthead">单次请求统计</p>						
							</div>								
						</div>

						<div>
						<?php $stTime = BFW_View::get('stTime'); $endTime = BFW_View::get('endTime');$objtype = BFW_View::get('objtype');?>
						<form class="well form-inline" name="searchform" id="searchform" action="./app.php?target=mod_statrequest&search=1" method="post">
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
								</div>
  								<div class="row-fluid">
  									<label for="dp1"><strong>起始时间：</strong></label>
									<input id="dp1" name="dp1" type="text" class="span3" value="<?php if($stTime) echo $stTime;?>" />
									&nbsp; 
  									<label for="dp2"><strong>截止时间：</strong></label>
									<input id="dp2" name="dp2" type="text" class="span3" value="<?php if($endTime) echo $endTime;?>" />
									&nbsp;
                        			<input type="submit" class="btn btn-info" id="btnsearch" value="查  询" />
                        		</div>
                        	</form>
						</div>
<?php $resultFlag = BFW_View::get('resultFlag');?>
<?php if($resultFlag){ ?>
<!-- echart 图 -->
<div id="main" class="main"  style="height:400px;border:1px solid #ccc;padding:10px;"></div>
<br />

<!-- 结果列表 分页显示 -->
<div id="resultlist">
	<div class="accordion" id="accordion2">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				接口调用信息列表
				</a>
			</div>
			<div id="collapseOne" class="accordion-body collapse in">
				<div class="accordion-inner">
				<br >
				<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success">
						<td>存储id</td><td>host</td><td>时间</td><td>总耗时(μm)</td>
						<td>cpu耗时(μm)</td><td>内存(bytes)</td><td>操作</td>
					</tr>	
				</thead>
				<tbody>
					<?php $tableData = BFW_View::get('tableData');?>
					<?php foreach($tableData as $key=>$value){ ?>
					<tr>
						<td><?php echo $value['id'];?></td>
						<td><?php echo $value['host'];?></td>
						<td><?php echo $value['timestamp'];?></td>
						<td><?php echo $value['wt'];?></td>
						<td><?php echo $value['cpu'];?></td>
						<td><?php echo $value['mu'];?></td>
						<td>
						<a href="./include/xhprof/xhprof_html/index.php?run=<?php echo $value['id'];?>" target="_blank" title= "查看"><i class="icon-pencil"></i>查看</a>
						</td>
					</tr>
					<?php } ?>	
				</tbody>
				</table>
<!-- 分页 -->
<?php 
$pageCnt = BFW_View::get('pageCnt');
$pageid = BFW_View::get('pageid');
$uri = $_SERVER['REQUEST_URI'];
?>
<?php if($pageCnt > 2){ ?>
	<div id="paginationdemo">
		<span class="all">Page <?php echo $pageid;?> of <?php echo $pageCnt;?></span>&nbsp;&nbsp;
		<?php for($page = 1; $page < $pageCnt+1; $page++){ ?>
			<?php if($pageid == $page){ ?>
			<span class="current"><?php echo $pageid;?></span>
			<?php }else{ ?>
			<a class='inactive' href='<?php echo "$uri&pageid=$page";?>'><?php echo $page;?></a>
			<?php } ?>
		<?php } ?>
	</div>
<?php } ?>
	<br >
							
				</div>
			</div>
		</div>
	</div>
</div><!-- /resultlist -->
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
	
	<!--
    <script src="./include/js/jquery.hotkeys.js"></script>
    <script src="./include/js/bootstrap-wysiwyg.js"></script>
	-->
    <script type="text/javascript">    
    $(window).load(function(){
      var section = $('[class=section]');
      function loadImage(i) {
          setTimeout(function(){
              var list = $('div>ul>li>a', section[i]);
              var nav = $('ol>li>img', section[i]);
              var href;
              var src;
              if (list.length > 0) {
                  for (var j = 0, k = list.length; j < k; j++) {
                      list[j].target = '_blank';
                      href = list[j].href.slice(list[j].href.lastIndexOf('/') + 1, -5);
                      src = list[j].firstChild.src.replace(
                          'cache', href
                      );
                      list[j].firstChild.alt = 'ECharts ' + href;
                      list[j].firstChild.src = src;
                  }
              }
          }, i * 100);
      }
      for (var i = 0, l = section.length; i < l; i++) {
          loadImage(i);
      }
    });	
    </script>
	<script src="./include/echarts/build/echarts-original.js"></script>
	<script type="text/javascript">

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
                // 基于准备好的dom，初始化echarts图表
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
            }
        );
    </script>
</body>
</html>
