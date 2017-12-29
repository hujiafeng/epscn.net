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
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.jqChart.min.js"></script>
<script type="text/javascript" src="/Public/js/highcharts.js"></script>
<script type="text/javascript" src="/Public/js/modules/exporting.js"></script>
<script type="text/javascript">
var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'column'
		},
		title: {
			text: '【最近一年内营收、支出、账外支出统计】'
		},
		xAxis: {
			categories: [
			<?php if(is_array($t_y)): foreach($t_y as $k=>$v): ?>'<?php echo ($v); ?>',<?php endforeach; endif; ?>
			]
		},
		tooltip: {
			formatter: function() {
				return ''+
					 this.series.name +': '+ this.y +'';
			}
		},
		credits: {
			enabled: false
		},
		series: [{
			name: '总营收',
			data: [
			<?php if(is_array($t_yse)): foreach($t_yse as $k=>$v): echo ($v); ?>,<?php endforeach; endif; ?>
			]
		}, {
			name: '总支出',
			data: [
			<?php if(is_array($t_zce)): foreach($t_zce as $k=>$v): echo ($v); ?>,<?php endforeach; endif; ?>
			]
		}, {
			name: '账外总支出',
			data: [
			<?php if(is_array($t_zwzce)): foreach($t_zwzce as $k=>$v): echo ($v); ?>,<?php endforeach; endif; ?>
			]
		}]
	});
	
	
});	
</script>
</head>
<body class="J_scroll_fixed">
<div class="wrap jj">
<style type="text/css">
	html{_overflow-y:scroll}
	.line_type_li{ width:200px; height:150px; margin:20px; float:left; background:#4AA41D; text-align:center; line-height:160%; font-size:30px; font-family:微软雅黑; cursor:pointer; color:#FFF;}
	.line_type_li span{ padding-top:15px; display:block;}
	.line_type_li:hover{ background:#1FB628;}
	.taskmain{ width:95%; float:left; margin-bottom:10px; }
	.taskmain ul{ float:left; margin:0px; padding:0px;}
	.taskmain ul li{margin:0px; padding:0px; list-style-type:none}
	.taskmain ul li{ width:220px; float:left; height:95px; margin-right:10px; color:#FFF; margin-top:10px;}
	.li1{ background: url('/statics/admin/1.jpg') no-repeat left center;}
	.li2{ background: url('/statics/admin/2.jpg') no-repeat left center;}
	.li3{ background: url('/statics/admin/3.jpg') no-repeat left center;}
	.li4{ background: url('/statics/admin/4.jpg') no-repeat left center;}
	.li5{ background: url('/statics/admin/1.png') no-repeat left center;}
	.li6{ background: url('/statics/admin/2.png') no-repeat left center;}
	.li7{ background: url('/statics/admin/3.png') no-repeat left center;}
	.li8{ background: url('/statics/admin/4.png') no-repeat left center;}
	.taskmain ul li span{ float:left; width:200px; padding:0px; margin-top:10px; text-indent:70px;}
	.taskmain ul li .sp1{ font-size:16px; font-weight:300}
	.taskmain ul li .sp2{font-size:34px; font-weight:300; margin-top:20px;}
    .tasktable{ width:95%; float:left; margin-top:20px;  }
</style>
<div class="pad-lr-10">
<div class="taskmain">
 <ul>
<li class="li1"><span class="sp2"><?php echo ($count1); ?></span><span class="sp1">用户数</span></li>
<li class="li2"><span class="sp2"><?php echo ($count2); ?></span><span class="sp1">服务商数</span></li>
<li class="li3"><span class="sp2"><?php echo ($count3); ?></span><span class="sp1">总订单数</span></li>
<li class="li4"><span class="sp2"><?php echo ($count4); ?></span><span class="sp1">总销售额</span></li>
<li class="li5"><span class="sp2"><?php echo ($count5); ?></span><span class="sp1">总支出额</span></li>
<li class="li6"><span class="sp2"><?php echo ($count6); ?></span><span class="sp1">总账外支</span></li>
<li class="li7"><span class="sp2"><?php echo ($count7); ?></span><span class="sp1">总应收款</span></li>
<li class="li8"><span class="sp2"><?php echo ($count8); ?></span><span class="sp1">总应付款</span></li>
</ul> 
</div>

<div id="container" style="width:1380px; height: 400px; margin: 0 auto; float:left"></div>

<ul class="nav nav-tabs" style="width:100%; height:37px;float:left; display:inline">     
<li class="active" ><a href='#' ><font color="#E26A6A">最近登录记录</font></a></li>
</ul>

<div class="table_list" >
      <table width="100%" class="table table-hover" style="margin-top:10px;">
       <thead>
        <tr>
        <th width="10%"></th>
            <th width="20%">用户名</th>
            <th align="center" width='20%'>密码</th>
            <th width="30%" align="center">状态</th>
            <th width="10%" align="center">时间</th>
            <th align="center" width='10%'>IP</th>
          </tr>
        </thead>
        <?php if(!$Logs): ?><tr><td colspan="5">暂无数据</td></tr><?php endif; ?>
         <?php if(is_array($Logs)): $i = 0; $__LIST__ = $Logs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td align="center"><?php echo ($vo["loginid"]); ?></td>
            <td align="center"><?php echo ($vo["username"]); ?></td>
            <td align="center"><?php echo ($vo["password"]); ?></td>
            <td align="center"><?php if($vo['status'] == 1): ?>登陆成功<?php else: ?><font color="#FF0000">登陆失败/</font><?php endif; echo ($vo["info"]); ?></td>
            <td align="center"><?php echo ($vo["logintime"]); ?></td>
            <td align="center"><?php echo ($vo["loginip"]); ?></td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
          </table>
    </div>
     
    </div>

</div>
</div>
</body>
</html>