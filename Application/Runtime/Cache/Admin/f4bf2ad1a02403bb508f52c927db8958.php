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
var Menudelete = function(t){
	if(confirm('你确定要删除嘛？删除后不可恢复！')) location.href=t;
}
</script>
</head>
<body class="J_scroll_fixed">
<div class="wrap jj">
  <ul class="nav nav-tabs">
       <li class="active"><a href='javascript:;'>菜单管理</a></li>
       <li><a href='<?php echo U("Menu/add",array("parentid"=>0));?>' >添加菜单</a></li>
  </ul>
<style type="text/css">
	html{_overflow-y:scroll}
</style>
<form name="myform"  method="post" class="J_ajaxForm" action="<?php echo U('Menu/listorders');?>">
    <div class="table-list">
      <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <th width="80">排序</th>
            <th width="100">id</th>
            <th align="left">菜单名称</th>
            <th width="200">管理操作</th>
          </tr>
        </thead>
        <tbody>
        <?php echo ($categorys); ?>
        </tbody>
      </table>
      <div class="form-actions">
      <input type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn" value="排序" />
	  </div>
    </div>
  </div>
  </div>
</form>

</body>
</html>