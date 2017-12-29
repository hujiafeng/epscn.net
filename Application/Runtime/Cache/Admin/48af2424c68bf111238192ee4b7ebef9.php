<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
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
<script type="text/javascript" src="/statics/js/region.js"></script>

<script type="text/javascript">
	var path='/Public';
	var url='/Admin/Temporary';
</script>
<script type="text/javascript" src="/Public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/Public/js/swfupload.js"></script>
<script type="text/javascript" src="/Public/js/handlers.js"></script>
<script type="text/javascript">
	var swfu;
	window.onload = function () {
		swfu = new SWFUpload({
			upload_url: "/Admin/Temporary/addphoto",
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
<script type="text/javascript" src="/Public/js/lightbox-2.6.min.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/css/lightbox.css"/>
</head>
<body class="J_scroll_fixed">
<script type="text/javascript">
  $(document).ready(function() {
	$(".city_b").click(function(){
		var shen = $("#province").find("option:selected").text();
		var shi = $("#city").find("option:selected").text();
		if(shen != "省份/直辖市" && shi != "请选择"){
			var n_city = $("#citys").val() + shen + shi + " ";
			$("#citys").show().val(n_city);
		}else{
			alert("请选择区域！");
		}
	});
	
	$("form").submit(function(e){
		var citys = $("#citys").val();
		var checkVal=''; 
		$("input[name='info[n_type][]']:checkbox").each(function(){ 
		  if($(this).attr('checked')){ 
			checkVal+=$(this).val()+','; 
		  } 
		}) 
		var name = $("#name").val();
		var number = $("#number").val();
		var wx_number = $("#wx_number").val();
		var bank = $("#bank").val();
		var bank_number = $("#bank_number").val();

		if(!citys){
			alert("请添加服务区域！");
			return false;
		}
		if(!checkVal){
			alert("请选择行业工种！");
			return false;
		}
		if(!name){
			alert("请填写姓名！");
			return false;
		}
		if(!number){
			alert("请填写手机号！");
			return false;
		}
		if(!wx_number){
			alert("请填写微信号！");
			return false;
		}
		
  	});



  })
</script>
<style type="text/css">
	.city_b{ font-size:24px; cursor:pointer}
	
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
#thumbnails ul li{float:left;list-style-type:none;width:105px;margin-left:5px;}
#thumbnails .button{display:block;position: relative;right:-84px;top: -118px;width: 30px;z-index: 1103;cursor:pointer;}
#pic_list li{padding:0 0 0 5px;}
.table_form tr td{ padding:0px;}
</style>
 <div class="wrap jj">
    <ul class="nav nav-tabs">
		<li><a href="<?php echo U('Temporary/index');?>" >临时工列表</a></li> 
		<li class="active"><a href="#">修改临时工</a></li> 
     </ul>
<div class="pad_10">
  <div class="common-form">
    <form name="myform" action="<?php echo U('Temporary/edit');?>" method="post" id="myform">
	<input type="hidden" name="s" id="" value=""/>
	<input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
	<div class="table_list">
<table width="100%" class="table_form contentWrap">

        <tbody>
		<tr>
            <td width="80">服务区域</td>
			<td>
			<input type="text" name="info[city]" class="input-text" id="citys" style="width:300px; border-top:0px; border-left:0px; border-right:0px;" value="<?php echo ($info["city"]); ?>"><br />
			<select name="province" id="province" onChange="loadRegion('province',2,'city','<?php echo U('Fwuser/getRegion');?>');" style="width:150px;">
		        <option value="0" selected>省份/直辖市</option>
		        <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		     </select>          
		     <select name="city" id="city" style="width:150px;">
		       <option value="0">市/县</option>
		     </select>&nbsp;&nbsp;<b class="city_b" title="添加">+</b>
		     </td>
        </tr>
		<tr>
            <td width="80">行业工种</td>
			<td>
			<?php if(is_array($type)): foreach($type as $k=>$v): if($v["check"] == '1'): ?><input name="info[n_type][]" type="checkbox" value="<?php echo ($v["name"]); ?>" class="biaoqian" id="bq<?php echo ($k); ?>" checked /><label for="bq<?php echo ($k); ?>"><?php echo ($v["name"]); ?></label>
				<?php else: ?>
				<input name="info[n_type][]" type="checkbox" value="<?php echo ($v["name"]); ?>" class="biaoqian" id="bq<?php echo ($k); ?>" /><label for="bq<?php echo ($k); ?>"><?php echo ($v["name"]); ?></label><?php endif; endforeach; endif; ?>
			</td>
        </tr>
		<tr>
            <td width="80">姓名</td>
			<td><input type="text" name="info[name]" class="input-text" id="name" value="<?php echo ($info["name"]); ?>"></td>
        </tr>
		<tr>
            <td width="80">手机号</td>
			<td><input type="text" name="info[number]" class="input-text" id="number" value="<?php echo ($info["number"]); ?>"></td>
        </tr>
		<tr>
            <td width="80">微信号</td>
			<td><input type="text" name="info[wx_number]" class="input-text" id="wx_number" value="<?php echo ($info["wx_number"]); ?>"></td>
        </tr>
		<tr>
            <td width="80">开户银行</td>
			<td><input type="text" name="info[bank]" class="input-text" id="bank" value="<?php echo ($info["bank"]); ?>"></td>
        </tr>
		<tr>
            <td width="80">银行卡号</td>
			<td><input type="text" name="info[bank_number]" class="input-text" id="bank_number" value="<?php echo ($info["bank_number"]); ?>"></td>
        </tr>
		<tr>
            <td width="80">能力等级</td>
			<td>
			<select name="info[grade]" style="width:150px;">
			   <option value="">—选择等级—</option>
			   <option value="1级" <?php if($info["grade"] == '1级'): ?>selected<?php endif; ?>>1级</option>
			   <option value="2级" <?php if($info["grade"] == '2级'): ?>selected<?php endif; ?>>2级</option>
			   <option value="3级" <?php if($info["grade"] == '3级'): ?>selected<?php endif; ?>>3级</option>
			   <option value="4级" <?php if($info["grade"] == '4级'): ?>selected<?php endif; ?>>4级</option>
			   <option value="5级" <?php if($info["grade"] == '5级'): ?>selected<?php endif; ?>>5级</option>
			</select>
		 </td>
        </tr>
		<tr>
          <td>身份证<br>(正+反面)</td>
          <td>
			<?php if(is_array($p)): foreach($p as $k=>$v): ?><a href="/uploads/<?php echo ($v["large"]); ?>" data-lightbox="example-set"><img src="/uploads/<?php echo ($v["large"]); ?>" style="width:100px;height:100px;"></a>&nbsp;<?php endforeach; endif; ?>
			</td>
          </tr>
		<tr>
          <td>重新上传<br>(正+反面)</td>
          <td>
			<div style="width:800px;font-size: 12px;height:120px;" id="pingshentupianheight">
				<span id="spanButtonPlaceholder"></span>
				<div id="thumbnails">
					<ul id="pic_list"></ul>
					<div style="clear: both;"></div>
				</div>
			</div>
			<br>
			<div style="color:red">[选择重新上传图片，不保留原图]</div><p>
			</td>
          </tr>
		<tr>
  			<td width="80">备注</td>
  			<td><textarea name="info[remark]" cols="20" rows="3" style="width:400px;"><?php echo ($info["remark"]); ?></textarea></td>
          </tr>
        </tbody>
      </table>
	</div>
     <div class="form-actions">
      <input name="dosubmit" type="submit"  value="提交" class="btn btn-primary btn_submit J_ajax_submit_btn">
	 </div>
    </form>
  </div>
  </div>
</div>
</body>
</html>