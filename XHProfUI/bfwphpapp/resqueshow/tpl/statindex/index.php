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
    <link href="./include/css/datepicker.css" rel="stylesheet">

    <!-- Fav and touch icons -->
    <style type="text/css">
        ul {
            margin:5px;
        }
        .affix li {
            list-style-type : none;
            height : 30px;
            line-height:30px;
            vertical-align:middle;
        }
        ul.slides li{
            width : 33.3%;
            overflow:hidden;
            float : left;
            border:0px solid #ccc;
            margin: 15px 0;
            list-style-type : none;
            position:relative;
        }
        ul.slides li a {
            padding:5px;
            display:block;
        }
        ul.slides li a strong{
            font-size:15px;
            color : #1e90ff;
        }
        ul.slides li a:hover {
            background-color:#eee;
            text-decoration:none;
        }
        ul.slides li img {
            width:60%;
        }
        ul.slides li span {
            color:#666;
            width:36%;
            vertical-align:top;
            display:inline-block;
            *zoom:1;
        }
        .span10 h3 {
            clear:both;
            margin:10px 0;
            padding-bottom:10px;
            border-bottom:1px solid #ddd;
        }
        .span10 h3 a {
            display:inline-block;
            *zoom:1;
            padding-top:80px;
        }
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
                    <li><a href="./app.php?target=mod_statrequest">单次调用统计</a></li>
                    <li><a href="./app.php?target=mod_statline">分时调用统计</a></li>
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
	
    <div class="container">
        <div class="row-fluid">
            <div class="span2">
                <p></p>
            </div>
            <div class="span10">
				<p><?php echo BFW_View::get('test');?></p>
            </div>
        </div>
        
    </div>


    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./include/js/jquery-1.11.1.min.js"></script>
    <script src="./include/bootstrap/js/bootstrap.min.js"></script>
    <script src="./include/js/bootstrap-datepicker.js"></script>
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
  </body>
</html>
