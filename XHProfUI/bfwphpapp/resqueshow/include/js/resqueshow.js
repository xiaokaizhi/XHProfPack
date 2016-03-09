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
    $('#dp1').datetimepicker({
		format: 'yyyy-mm-dd hh:ii:ss',
		weekStart: 0,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
    });
    $('#dp2').datetimepicker({
		format: 'yyyy-mm-dd hh:ii:ss',
		weekStart: 0,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
    });
	
	//[2]mod_statrequest 页面按钮请求
	$("#btnsearch").click(function(){
		var dp1 = $("#dp1").val();
		var dp2 = $("#dp2").val();

		var objtype = $("#objtype").val();
		
		var url = './app.php?target=mod_statrequest&search=1&objtype='+objtype+'&dp1='+dp1+'&dp2='+dp2;

		$("#searchform").attr('action',url);

	});

	//[3]mod_statline 页面按钮请求
	$("#btnsearchtime").click(function(){
		var objtype = $("#objtype").val();
		
		var url = './app.php?target=mod_statline&search=1&objtype='+objtype;

		$("#searchtimeform").attr('action',url);

	});

	//[4]mod_statline 页面按钮
	//默认按小时查看
	$('#btn1').addClass('btn-info');
	$('#tab1').show();
	$('#tab2').hide();
	$('#tab3').hide();
	$('#tab4').hide();
	$('#tab5').hide();
	$('#tab6').hide();
	$('#tab7').hide();

	$('#btn1').click(function(){
		$(this).addClass('btn-info');
		$('#btn2').removeClass('btn-info');
		$('#btn3').removeClass('btn-info');
		$('#btn4').removeClass('btn-info');
		$('#btn5').removeClass('btn-info');
		$('#btn6').removeClass('btn-info');
		$('#btn7').removeClass('btn-info');
		$('#tab1').show();
		$('#tab2').hide();
		$('#tab3').hide();
		$('#tab4').hide();
		$('#tab5').hide();
		$('#tab6').hide();
		$('#tab7').hide();
	});

	$('#btn2').click(function(){
		$(this).addClass('btn-info');
		$('#btn1').removeClass('btn-info');
		$('#btn3').removeClass('btn-info');
		$('#btn4').removeClass('btn-info');
		$('#btn5').removeClass('btn-info');
		$('#btn6').removeClass('btn-info');
		$('#btn7').removeClass('btn-info');

		$('#tab2').show();
		$('#tab1').hide();
		$('#tab3').hide();
		$('#tab4').hide();
		$('#tab5').hide();
		$('#tab6').hide();
		$('#tab7').hide();
	});

	$('#btn3').click(function(){
		$(this).addClass('btn-info');
		$('#btn1').removeClass('btn-info');
		$('#btn2').removeClass('btn-info');
		$('#btn4').removeClass('btn-info');
		$('#btn5').removeClass('btn-info');
		$('#btn6').removeClass('btn-info');
		$('#btn7').removeClass('btn-info');

		$('#tab3').show();
		$('#tab1').hide();
		$('#tab2').hide();
		$('#tab4').hide();
		$('#tab5').hide();
		$('#tab6').hide();
		$('#tab7').hide();
	});

	$('#btn4').click(function(){
		$(this).addClass('btn-info');
		$('#btn1').removeClass('btn-info');
		$('#btn2').removeClass('btn-info');
		$('#btn3').removeClass('btn-info');
		$('#btn5').removeClass('btn-info');
		$('#btn6').removeClass('btn-info');
		$('#btn7').removeClass('btn-info');

		$('#tab4').show();
		$('#tab1').hide();
		$('#tab2').hide();
		$('#tab3').hide();
		$('#tab5').hide();
		$('#tab6').hide();
		$('#tab7').hide();
	});

	$('#btn5').click(function(){
		$(this).addClass('btn-info');
		$('#btn1').removeClass('btn-info');
		$('#btn2').removeClass('btn-info');
		$('#btn3').removeClass('btn-info');
		$('#btn4').removeClass('btn-info');
		$('#btn6').removeClass('btn-info');
		$('#btn7').removeClass('btn-info');

		$('#tab5').show();
		$('#tab1').hide();
		$('#tab2').hide();
		$('#tab3').hide();
		$('#tab4').hide();
		$('#tab6').hide();
		$('#tab7').hide();
	});

	$('#btn6').click(function(){
		$(this).addClass('btn-info');
		$('#btn1').removeClass('btn-info');
		$('#btn2').removeClass('btn-info');
		$('#btn3').removeClass('btn-info');
		$('#btn4').removeClass('btn-info');
		$('#btn5').removeClass('btn-info');
		$('#btn7').removeClass('btn-info');

		$('#tab6').show();
		$('#tab1').hide();
		$('#tab2').hide();
		$('#tab3').hide();
		$('#tab4').hide();
		$('#tab5').hide();
		$('#tab7').hide();
	});

	$('#btn7').click(function(){
		$(this).addClass('btn-info');
		$('#btn1').removeClass('btn-info');
		$('#btn2').removeClass('btn-info');
		$('#btn3').removeClass('btn-info');
		$('#btn4').removeClass('btn-info');
		$('#btn5').removeClass('btn-info');
		$('#btn6').removeClass('btn-info');

		$('#tab7').show();
		$('#tab1').hide();
		$('#tab2').hide();
		$('#tab3').hide();
		$('#tab4').hide();
		$('#tab5').hide();
		$('#tab6').hide();
	});

})
