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
	var url='/Admin/Gongdan';
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
				upload_url: "/Admin/Gongdan/uploadImg",
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
				button_text_style : '.spanButtonPlaceholder { font-family: Helvetica, Arial, sans-serif; font-size: 14pt;} ',
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
	

<script type="text/javascript" src="/statics/js/jquery.select.js"></script>

<script type="text/javascript" src="/Public/js/lightbox-2.6.min.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/css/lightbox.css"/>
<style type="text/css">
	html{_overflow-y:scroll}
	.n_img{width:100px; height:100px; float:left; display:inline; margin-top:5px; margin-left:5px;}
	.need_td{ font-weight:bold; width:100px;}
	.swfupload{ float:left;border:1px solid #ccc; padding-top:35px; padding-left:8px;}
	#thumbnails ul li{float:left;list-style-type:none;width:105px;margin-left:5px;}
#thumbnails .button{display:block;position: relative;right:-84px;top: -118px;width: 30px;z-index: 1103;cursor:pointer;}
#pic_list li{padding:0 0 0 5px;}
</style>

</head>
<body class="J_scroll_fixed">
 <div class="wrap jj">

<ul class="nav nav-tabs">
     <li><a href="<?php echo U('Gongdan/lists');?>">订单列表</a></li> 
     <li class="active"><a href='#' >技术评审</a></li> 
</ul>

<div class="pad_10">
  <div class="common-form">
  <form name="myform" action="<?php echo U('Gongdan/check');?>" method="post" id="myform">
  <input type="hidden" name="s" id="" value=""/>
  <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
  <input type="hidden" name="no" value="<?php echo ($info["no"]); ?>">
  <input type="hidden" name="uid_x" value="<?php echo ($info["uid_x"]); ?>">
   <table width="800px" class="table_form contentWrap">
		   <tr>
            <td width="80" class="need_td">订单号</td>
            <td><?php echo ($info["no"]); ?></td>
           </tr>
		   <tr>
            <td width="80" class="need_td">设备类别</td>
            <td><?php echo ($info["s_type"]); ?></td>
           </tr>
		   <tr>
            <td width="80" class="need_td">设备款型</td>
            <td><?php echo ($info["k_title"]); ?></td>
           </tr>
           <tr>
            <td width="80" class="need_td">任务类型</td>
            <td><?php echo ($info["biaoqian"]); ?></td>
           </tr>
           <tr>
            <td width="80" class="need_td">需求描述</td>
            <td><?php echo ($info["miaoshu1"]); ?></td>
           </tr>
           <tr>
            <td width="80" class="need_td">描述图片</td>
            <td>
			<?php if(is_array($info_s)): foreach($info_s as $k=>$v): ?><a href="/uploads/<?php echo ($v["large"]); ?>" target="_blank"><img src='/statics/admin/n_shipin.jpg' class="n_img" /></a><?php endforeach; endif; ?>
			<?php if(is_array($info_p)): foreach($info_p as $k=>$v): ?><a href="/uploads/<?php echo ($v["large"]); ?>" data-lightbox="example-set"><img src='/uploads/<?php echo ($v["small"]); ?>' class="n_img" /></a><?php endforeach; endif; ?></td>
           </tr>
           <tr>
            <td width="80" class="need_td">服务地点</td>
            <td><?php echo ($info["city"]); echo ($info["address"]); ?></td>
           </tr>
           <tr>
            <td width="80" class="need_td">服务身份</td>
            <td><?php echo ($info["fw_id"]); ?></td>
           </tr>
      	  <tr>
  			<td width="80" class="need_td">确认需求</td>
  			<td><textarea name="info[miaoshu2]" cols="20" rows="3" style="width:400px;" id="miaoshu2"></textarea>（必填）</td>
          </tr>
		  <tr>
			<td width="80" class="need_td">现场联系人</td>
			<td><input type="text" name="info[lx_name]" class="input-text" id="lx_name">（必填）</td>
			</tr>
			<tr>
			<td width="80" class="need_td">联系人电话</td>
			<td><input type="text" name="info[lx_number]" class="input-text" id="lx_number" maxlength="11">（必填）</td>
			</tr>
		  <tr>
  			<td width="80" class="need_td">需求图片</td>
  			<td>
			<div style="width: 700px;height:130px;font-size: 12px;">
				<span id="spanButtonPlaceholder"></span>
				<div id="thumbnails">
					<ul id="pic_list" style="margin: 5px;"></ul>
					<div style="clear: both;"></div>
				</div>
			</div>
			</td>
          </tr>
        <tr>
  			<td width="80" class="need_td">预计上门</td>
  			<td><input type="text"  name="info[go_time]" id="go_time" class="input-text date" style="width:200px;" >（必填）
          &nbsp;<script type="text/javascript">
          Calendar.setup({
              weekNumbers: true,
              inputField : "go_time",
              trigger    : "go_time",
              dateFormat: "%Y-%m-%d",
              showTime: 12,
              minuteStep: 1,
              onSelect   : function() {this.hide();}
          });
      </script>
			</td>
          	</tr>
			<tr>
  			<td width="80" class="need_td">需求方</td>
  			<td><?php echo ($info["u_x_mobile"]); ?> <?php echo ($info["u_x_khdw"]); ?></td>
          	</tr>
			<tr>
  			<td width="80" class="need_td">服务方</td>
  			<td><input id="testInput_f" type="text" class="input-text" style="width:400px;">（必填）
            	<input id="testInputval_f" type="hidden" name="info[uid_f]]"></td>
          	</tr>
			<tr>
  			<td width="80" class="need_td">客户经理</td>
  			<td><select name="info[gw_name]" id="gw">
			<option value="">——请选择——</option>
			<?php if(is_array($fw)): foreach($fw as $key=>$v): ?><option value="<?php echo ($v["name"]); ?>_<?php echo ($v["number"]); ?>"><?php echo ($v["number"]); ?> <?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
			</select>（必填）</td>
          	</tr>
      </table>
	  <div class="form-actions">
      <input name="dosubmit" type="submit"  value="提交" class="btn  btn-primary btn_submit" id="dosubmit">
	 </div>
	 </form>
  </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
	$("form").submit(function(e){
		var miaoshu2 = $("#miaoshu2").val();
		var lx_name = $("#lx_name").val();
		var lx_number = $("#lx_number").val();
		var go_time = $("#go_time").val();
		var testInput_f = $("#testInput_f").val();
		var gw = $("#gw").val();

		if(!miaoshu2){
			alert("确认需求不能为空！");
			return false;
		}
		if(!lx_name){
			alert("现场联系人不能为空！");
			return false;
		}
		if(!lx_number){
			alert("联系人电话不能为空！");
			return false;
		}
		if(!go_time){
			alert("请选择预计上门！");
			return false;
		}
		if(!testInput_f){
			alert("请选择服务方！");
			return false;
		}
		if(testInput_f.substr(0,11) == <?php echo ($info["u_x_mobile"]); ?>){
			alert("服务方与需求方不能是同一个账号！");
			return false;
		}
		if(!gw){
			alert("请选择服务顾问！");
			return false;
		}
  });
  
  
  })
</script>

<script type="text/javascript">
	var datas_f =[{<?php if(is_array($user_f)): foreach($user_f as $key=>$v): ?>"id":"<?php echo ($v["uid"]); ?>","text":"<?php echo ($v["mobile"]); ?> <?php echo ($v["company"]); ?>"},{<?php endforeach; endif; ?>
"id":"","text":""}];
var itemSelectFuntion_f = function(){
	$("#testInputval_f").val(this.id);
  		};
  	$.selectSuggest('testInput_f',datas_f,itemSelectFuntion_f);
</script>
</body>
</html>