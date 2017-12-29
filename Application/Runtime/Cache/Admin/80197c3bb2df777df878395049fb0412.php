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
</head>
<body class="J_scroll_fixed">


 <div class="wrap jj">
<style type="text/css">
	html{_overflow-y:scroll}
	.need_tr{ font-weight:bold;background:#f2f2f2; line-height:20px; padding-top:10px; padding-left:10px;}
</style>
<div class="pad_10">
  <div class="common-form">
<table width="100%" class="table_form contentWrap">
        <tbody>
		<tr>
            <td colspan="2" class="need_tr">个人资料</td>
        </tr>
        <tr>
            <td width="80">手机号</td>
			<td><?php echo ($info[mobile]); ?></td>
        </tr>
		<tr>
            <td width="80">性别</td>
			<td><?php echo ($info[gender]); ?></td>
        </tr>
		<tr>
            <td width="80">年龄</td>
			<td><?php echo ($info[age]); ?></td>
        </tr>
        <tr>
            <td width="80">地区</td>
			<td><?php echo ($info[city]); ?></td>
        </tr>
        <tr>
            <td colspan="2" class="need_tr">服务商资料</td>
        </tr>
        <tr>
            <td width="80">服务商编号</td>
			<td><?php echo ($info[number]); ?></td>
        </tr>
		<tr>
            <td width="80">联系人姓名</td>
			<td><?php echo ($info[name]); ?></td>
        </tr>
		<tr>
            <td width="80">公司名称</td>
			<td><?php echo ($info[company]); ?></td>
        </tr>
		<tr>
            <td width="80">公司地址</td>
			<td><?php echo ($info[address]); ?></td>
        </tr>
		<tr>
            <td width="80">服务区域</td>
			<td><?php echo ($info[city_f]); ?></td>
        </tr>
        
		<tr>
            <td width="80">设备类型</td>
			<td><?php echo ($info[task]); ?></td>
        </tr>
        <tr>
            <td width="100">协议到期时间</td>
			<td><?php echo ($info[end_time]); ?></td>
        </tr>
        <tr>
            <td width="80">服务年龄</td>
			<td><?php echo ($info[years]); ?></td>
        </tr>
        <tr>
            <td width="80">已缴保证金</td>
			<td><?php echo ($info[bz_reward]); ?></td>
        </tr>
          
        </tbody>
      </table>
  </div>
  </div>
</div>
</body>
</html>