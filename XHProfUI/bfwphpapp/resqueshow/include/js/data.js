/**
 * Created with JetBrains PhpStorm.
 * User: sina
 * Date: 13-8-21
 * Time: 下午12:27
 * To change this template use File | Settings | File Templates.
 */

$(function(){
    /**
     * [1]设置日期格式
     */
    $('#inputDate').datepicker({
        format: 'yyyy-mm-dd'
    });
    var $date = $('#inputDate').val();

    /**
     *[2]保存数据到erecord表
     */
    $("#btnsubmit").click(function(){
        var $name = $("#inputName").val();
        if($name == ''){
            alert('请输入报告名称后重试！');
            return false;
        }
        $name = encodeURIComponent($name);
        var $type = $('#inputType').val();
        var $inputDate = $('#inputDate').val();
        console.log('name:type:date',$name+':'+$type+':'+$inputDate);
        $.ajax({
            type: "POST",
            url: "data?search=2",
            dataType: "html",
            data: {"type":$type,"date":$inputDate,"name":$name,"r":Math.random()},
            success: function(string){
                console.log('btnsubmit-ajax返回结果：',string);
                if(string != ""){
                    console.log('更新数据成功name:type:date',$name+':'+$type+':'+$inputDate);
                }else {
                    console.error('更新写入数据失败！');
                }
            }
        });
        $('#report').modal('hide');
    });

    /**
     * 页面自动载入时处理chart
     */
    var $json = $("#chartData").val();
    console.log('传入的值#chartData',$json);
    if ($json != '' && typeof ($json) !== 'undefined' && $json != null){
        $('body').data('string',$json);
        var $result = eval($('body').data('string'));
        console.warn('导入json：',$result);

        if($result[0] != '' && $result[0] != null && typeof($result[0] != 'undefined')){
            if($result[0].length > 0 ){


            }
        }
    }



});