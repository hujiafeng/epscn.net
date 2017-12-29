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
<script type="text/javascript" src="/statics/js/region.js"></script>
</head>
<body>
<div class="wrap jj">
<style type="text/css">
	html{_overflow-y:scroll}
</style>
 
	<ul class="nav nav-tabs">
		<li class="active"><a href='#' >临时工列表</a></li> 
		<li><a href="<?php echo U('Temporary/add');?>">添加临时工</a></li> 
	</ul>
	<form name="searchform" action="<?php echo U('Temporary/index');?>" method="get"  class="well form-search" id="searchform">
		<select name="province" id="province" onChange="loadRegion('province',2,'city','<?php echo U('Fwuser/getRegion');?>');" style="width:150px;">
		<?php if($sheng != ''): ?><option value="<?php echo ($_GET['province']); ?>" selected><?php echo ($sheng); ?></option>
		<?php else: ?>
		<option value="0" selected>省份/直辖市</option><?php endif; ?>
			<?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		 </select>          
		 <select name="city" id="city" style="width:150px;">
		 <?php if($shi != ''): ?><option value="<?php echo ($_GET['city']); ?>" selected><?php echo ($shi); ?></option><?php endif; ?>
		   <option value="">市/县</option>
		 </select>
		 <select name="n_type" style="width:150px;">
		   <option value="">—选择工种—</option>
		   <?php if(is_array($type)): foreach($type as $k=>$v): ?><option value="<?php echo ($v); ?>" <?php if($_GET['n_type']== $v): ?>selected<?php endif; ?> ><?php echo ($v); ?></option><?php endforeach; endif; ?>
		 </select>
		  <input type="submit" value="搜索当前页"  class="btn btn-primary btn_submit" name="dosubmit" id="goodssearch">
	</form>
	<div class="table-list">
	    <table width="100%" class="table table-hover">
	      <thead>
	        <tr>
	          <th width="5%">ID</th>
			  <th width="15%" align="left" >服务区域</th>
	          <th width="15%" align="left" >行业工种</th>
	          <th width="10%" align="left" >姓名</th>
	          <th width="10%" align="left" >手机号</th>
			  <th width="10%" align="left" >微信号</th>
			  <th width="10%" align="left" >能力等级</th>
	          <th width="15%" >操作</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
	          <td width="5%" align="center"><?php echo ($v["id"]); ?></td>
			  <td width="15%" ><?php echo ($v["city"]); ?></td>
	          <td width="15%" ><?php echo ($v["n_type"]); ?></td>
			  <td width="10%" ><?php echo ($v["name"]); ?></td>
	          <td width="10%" ><?php echo ($v["number"]); ?></td>
	          <td width="10%" ><?php echo ($v["wx_number"]); ?></td>
	          <td width="10%" ><?php echo ($v["grade"]); ?></td>
	          <td width="15%"  align="center">
	          <a href="<?php echo U('Temporary/show',array('id'=>$v['id']));?>">查看</a> | 
	          <span class="delbtn" data="<?php echo U('Temporary/del_t',array('id'=>$v['id']));?>" cont="确定删除该顾问？">删除</span> |
			  <a href="<?php echo U('Temporary/edit',array('id'=>$v['id']));?>">修改</a>
	          </td>
	        </tr><?php endforeach; endif; ?>
	      </tbody>
	    </table>
	    <div class="pagination"><?php echo ($Page); ?></div>
	</div>
</div>
</body>
</html>