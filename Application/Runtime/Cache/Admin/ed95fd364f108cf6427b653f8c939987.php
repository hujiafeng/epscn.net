<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($Config["sitename"]); ?> - 后台管理中心</title>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/statics/simpleboot/themes/flat/theme.min.css" rel="stylesheet">
    <link href="/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <style>
		.length_3{width: 180px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script language="javascript" type="text/javascript" src="/st/js/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="/st/js/admin_common.js"></script>
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/statics/js/jquery.js"></script>
   <script language="javascript" type="text/javascript" src="/statics/js/formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="/statics/js/formvalidatorregex.js" charset="UTF-8"></script>

	<style>
	.pagination{margin: 20px 0px;line-height:30px;text-indent:15px;}
	.pagination a,.current{text-indent:0px;}
	.red{color:red;}
	/*表单验证*/
.onShow,.onFocus,.onError,.onCorrect,.onLoad,.onTime{display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline; vertical-align:middle;background:url(/statics/images/msg_bg.png) no-repeat;	color:#444;line-height:18px;padding:2px 10px 2px 23px; margin-left:10px;_margin-left:5px}
.onShow{background-position:3px -147px;border-color:#40B3FF;color:#959595}
.onFocus{background-position:3px -147px;border-color:#40B3FF;}
.onError{background-position:3px -47px;border-color:#40B3FF; color:red}
.onCorrect{background-position:3px -247px;border-color:#40B3FF;}
.onLamp{background-position:3px -200px}
.onTime{background-position:3px -1356px}
.table_form  tr td{   padding-bottom:10px;}
.delbtn{ color:#F00; cursor:pointer;}
	</style>


<script language="JavaScript"> 
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>

	<link rel="stylesheet" type="text/css" href="/statics/xcConfirm/css/xcConfirm.css"/>
	<script src="/statics/xcConfirm/js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
     <script type="text/javascript">
			$(function(){
				$(".delbtn").click(function(){
				var url=$(this).attr('data');
				var cont=$(this).attr('cont');
				if(cont){
					var txt=  cont; 
				}else{
					var txt=  "确实要删除该信息？"; 
				}
				
				var title="信息提示";
	            xcbox(title,txt,url);	
				});
	
				
	/*
	title:标题,txt 提示信息，url跳转地址
	*/			
				
	function 	xcbox(title,txt,url){
		
    var option = { 
        title: title, 
        btn: parseInt("0011",2), 
        onOk: function(){ 
		//确认
         location.href=url;
        }, 
        onCancel:function(){ 
         //取消      
        }, 
        onClose:function(){ 
        //关闭        
        } 
    } 
    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning, option);
		
		}		
				
				
				});
			</script>
<script type="text/javascript">
	var path='/Public';
	var url='/Admin/Agongdan';
</script>
<script type="text/javascript" src="/Public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/Public/js/swfupload.js"></script>
<script type="text/javascript" src="/Public/js/handlers.js"></script>

<link rel="stylesheet" type="text/css" href="/statics/js/calendar/jscal2.css"/>
<link rel="stylesheet" type="text/css" href="/statics/js/calendar/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="/statics/js/calendar/win2k.css"/>
<script type="text/javascript" src="/statics/js/calendar/calendar.js"></script>
<script type="text/javascript" src="/statics/js/calendar/lang/en.js"></script>

<!-- <link href="/Public/css/default.css" rel="stylesheet" type="text/css" /> -->
<script type="text/javascript">
	var swfu;
	window.onload = function () {
		swfu = new SWFUpload({
			upload_url: "/Admin/Agongdan/uploadImg",
			post_params: {"PHPSESSID": "<?php echo session_id();?>"},
			file_size_limit : "2 MB",
			file_types : "*.jpg;*.png;*.gif;*.bmp",
			file_types_description : "JPG Images",
			file_upload_limit : "100",
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			button_image_url : "",
			button_placeholder_id : "spanButtonPlaceholder",
			button_width: 20,
			button_height: 65,
			button_text : '+',
			button_text_style : '.spanButtonPlaceholder {background:red} ',
			button_text_top_padding: 0,
			button_text_left_padding: 0,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,			
			flash_url : "/Public/swf/swfupload.swf",
			custom_settings : {
				upload_target : "divFileProgressContainer"
			},				
			debug: false
		});
	};
</script>
	

<script type="text/javascript" src="/statics/js/jquery.select2.js"></script>

<style type="text/css">
	html{_overflow-y:scroll}
	.biaoqian {display: none;}
label {display: inline;}
.biaoqian + label {background-color: #fafafa;
	border: 1px solid #cacece;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
	padding: 9px;
	border-radius: 3px;
	display: inline-block;
	position: relative;
}
.biaoqian + label:active, .biaoqian:checked + label:active {box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);}
.biaoqian:checked + label {
	background-color: #e9ecee;
	border: 1px solid #adb8c0;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
	color: #99a1a7;
}
.swfupload{ float:left;border:1px solid #ccc; padding-top:35px; padding-left:8px;}
#thumbnails ul li{float:left;list-style-type:none;width:105px;margin-left:5px; height:100px;}
#thumbnails .button{display:block;position: relative;right:-84px;top: -118px;width: 30px;z-index: 1103;cursor:pointer;}
#pic_list li{padding:0 0 0 5px;}
#container {
        width: 800px;
        height:400px;
        margin: 0px;
        font-size: 13px;
    }
    
    #pickerBox {
        z-index: 9999;
        width: 300px;
    }
    
    #pickerInput {
        width: 200px;
        padding: 5px 5px;
    }
    
    #poiInfo {
        background: #fff;
    }
    
    .amap_lib_placeSearch .poibox.highlight {
        background-color: #CAE1FF;
    }
    
    .amap_lib_placeSearch .poi-more {
        display: none!important;
    }
</style>
</head>
<body class="J_scroll_fixed">
 <div class="wrap jj">
<div class="pad_10">
  <div class="common-form">
    <form name="myform" action="<?php echo U('Agongdan/add');?>" method="post" id="myform">
	<input type="hidden" name="s" id="" value=""/>
	<input type="hidden" name="info[n_type]" value="2"/>
<table width="100%" class="table_form contentWrap">

        <tbody>
          <tr>
            <td width="80">设备类别</td>
            <td>
            	<select name="info[s_type]" id="s_type">
				<option value="中压断路器">中压断路器</option>  
				<option value="中压开关柜">中压开关柜</option>
				<option value="低压开关柜">低压开关柜</option>  
				<option value="预装式变电站">预装式变电站</option>
				<option value="微机综保及智能仪表">微机综保及智能仪表</option>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;
				款型&nbsp;
			   <select class="kuanxing">
				   <option value="1">VBI型机构断路器</option>
				   <option value="2">VS1机构中压断路器</option>
				   <option value="3">外资/合资中压断路器</option>
			   </select>
			   <select class="kuanxing">
				   <option value="4">中置式中压开关柜</option>
				   <option value="5">充气式中压环网柜</option>
			   </select>
			   <select class="kuanxing">
				   <option value="7">抽出式低压开关柜</option>
				   <option value="8">固定分隔式低压开关柜</option>
			   </select>
			   <select class="kuanxing">
				   <option value="9">欧式箱变</option>
				   <option value="10">美式箱变</option>
			   </select>
			   <select class="kuanxing">
				   <option value="11">微机综合保护装置</option>
				   <option value="12">多功能电力仪表</option>
			   </select>
            </td>
            </tr>
            <tr>
            <td width="80">任务类型</td>
            <td>
			<!--<input name="info[biaoqian][]" type="radio" value="安装" class="biaoqian" id="bq1" /><label for="bq1">安装</label>-->
			<input name="info[biaoqian]" type="radio" value="安装" class="biaoqian" id="bq1" /><label for="bq1">安装</label>
			<input name="info[biaoqian]" type="radio" value="调试" class="biaoqian" id="bq2" /><label for="bq2">调试</label>
			<input name="info[biaoqian]" type="radio" value="检修" class="biaoqian" id="bq3" /><label for="bq3">检修</label>
			<input name="info[biaoqian]" type="radio" value="保养" class="biaoqian" id="bq4" /><label for="bq4">保养</label>
			<input name="info[biaoqian]" type="radio" value="改造" class="biaoqian" id="bq5" /><label for="bq5">改造</label>
			<input name="info[biaoqian]" type="radio" value="其他" class="biaoqian" id="bq6" /><label for="bq6">其他</label>
			</td>
            </tr>
            
		  <tr>
            <td width="80">服务地点</td>
            <td>
			 <div id="pickerBox">
        <input id="pickerInput" placeholder="输入关键字选取地点" /><b id="addrss_b" style="display:none; color:#FF0000; font-weight:lighter;">地址获取成功</b>
        <div id="poiInfo"></div>
    </div>
			<div id="container" class="map" tabindex="0"></div>
   
    <script type="text/javascript" src='//webapi.amap.com/maps?v=1.3&key=313001df758558e6252df426f4b71b3d'></script>
    <!-- UI组件库 1.0 -->
    <script src="//webapi.amap.com/ui/1.0/main.js?v=1.0.10"></script>
    <script type="text/javascript">
    var map = new AMap.Map('container', {
        zoom: 15
    });

    AMapUI.loadUI(['misc/PoiPicker'], function(PoiPicker) {
        var poiPicker = new PoiPicker({
            //city:'北京',
            input: 'pickerInput'
        });
        //初始化poiPicker
        poiPickerReady(poiPicker);
    });

    function poiPickerReady(poiPicker) {
        window.poiPicker = poiPicker;
        var marker = new AMap.Marker();
        var infoWindow = new AMap.InfoWindow({
            offset: new AMap.Pixel(0, -20)
        });

        //选取了某个POI
        poiPicker.on('poiPicked', function(poiResult) {

            var source = poiResult.source,
                poi = poiResult.item,
                info = {
                    //source: source,
                   // id: poi.id,
                    //name: poi.name,
                    //location: poi.location.toString(),
                    address: poi.address
                };

            marker.setMap(map);
            infoWindow.setMap(map);

            marker.setPosition(poi.location);
            infoWindow.setPosition(poi.location);
			//地址处理
			$("#zuobiao").val(poi.location.toString());
			$("#pickerInput").val(poi.name);
			if(poi.address == false){
				$("#address").val(poi.name);
				info = {address:poi.name};
			}else{
				$("#address").val(poi.address);
			}
			$("#addrss_b").show();
			
            infoWindow.setContent('地址信息: <pre>' + JSON.stringify(info, null, 2) + '</pre>');
            infoWindow.open(map, marker.getPosition());

            //map.setCenter(marker.getPosition());
        });

        /*poiPicker.onCityReady(function() {
            poiPicker.suggest('美食');
        });*/
    }
    </script>
<input type="hidden" name="info[zuobiao]" class="input-text" id="zuobiao">
<input type="hidden" name="info[address]" class="input-text" id="address">
			 </td>
            </tr>
			<tr>
  			<td width="80">服务身份</td>
  			<td><input type="text" name="info[fw_id]" class="input-text">（非必填）</td>
          	</tr>
          	<tr>
  			<td width="80">需求描述</td>
  			<td><textarea name="info[miaoshu1]" cols="20" rows="5" style="width:500px;" id="miaoshu1"></textarea></td>
          </tr>
		  <tr>
  			<td width="80">描述图片</td>
  			<td style="">
			<div style="width:800px;font-size: 12px;height:120px;" id="pingshentupianheight">
				<span id="spanButtonPlaceholder"></span>
				<div id="thumbnails">
					<ul id="pic_list"></ul>
					<div style="clear: both;"></div>
				</div>
			</div>
			</td>
          </tr>
			<tr>
  			<td width="80">需求方</td>
  			<td><input id="testInput" type="text" class="input-text">
            	<input id="testInputval" type="hidden" name="info[uid_x]]"></td>
          	</tr>
        </tbody>
      </table>

     <div class="form-actions">
      <input name="dosubmit" type="submit"  value="提交" class="btn  btn-primary btn_submit">
	 </div>
    </form>
  </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	 $("#s_type").change(function(){
	   $("#s_type option").each(function(i,o){
		   if($(this).attr("selected"))
		   {
			   $(".kuanxing").hide();
			   $(".kuanxing").prop("name","");
			   $(".kuanxing").eq(i).show();
			   $(".kuanxing").eq(i).prop("name","info[kuanxing]");
		   }
	   });
   });
   $("#s_type").change();
		   
/*	$("form").submit(function(e){
		var ex = /^\d+$/;
		var biaoqian = $(".biaoqian:checked").val();
		var zuobiao = $("#zuobiao").val();
		var miaoshu1 = $("#miaoshu1").val();
		var testInput = $("#testInput").val();

		if(!biaoqian){
			alert("请选择标签！");
			return false;
		}
		if(!zuobiao){
			alert("请输入地址！");
			return false;
		}
		if(!miaoshu1){
			alert("需求描述不能为空！");
			return false;
		}
		if(!testInput){
			alert("请选择需求方！");
			return false;
		}
  });*/
})

var datas =[{<?php if(is_array($user_x)): foreach($user_x as $key=>$v): ?>"id":"<?php echo ($v["uid"]); ?>","text":"<?php echo ($v["mobile"]); ?> <?php echo ($v["khdw"]); ?>"},{<?php endforeach; endif; ?>"id":"","text":""}];
var itemSelectFuntion = function(){
	$("#testInputval").val(this.id);
};
$.selectSuggest('testInput',datas,itemSelectFuntion);
</script>
</body>
</html>