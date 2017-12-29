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
<ul class="nav nav-tabs">
       <li class="active"><a href='javascript:;'>修改菜单</a></li>
       <li><a href='<?php echo U("Menu/index");?>'>菜单管理</a></li>
   
  </ul>
<style type="text/css">
	html{_overflow-y:scroll}
</style>
<div class="common-form">
  <form method="post" id="myform" action="<?php echo U('Menu/edit');?>" class="form-horizontal J_ajaxForm">
     <table cellpadding="2" cellspacing="2" width="100%">
    <input type="hidden" name="id" value="<?php echo ($Menudata['id']); ?>" />
      <tbody>
        <tr>
          <th width="140">上级:</th>
          <td><select name="parentid" >
              <option value="0">作为一级菜单</option>
              <?php if(is_array($Menucache)): $i = 0; $__LIST__ = $Menucache;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['id']); ?>' <?php if(($Menudata['parentid']) == $vo['id']): ?>selected<?php endif; ?>> <?php echo ($vo['name']); ?>
                </option>
                <?php if(is_array($vo['lower'])): $i = 0; $__LIST__ = $vo['lower'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($lo['id']); ?>' <?php if(($Menudata['parentid']) == $lo['id']): ?>selected<?php endif; ?>>&nbsp;├ <?php echo ($lo['name']); ?>
                  </option>
                  <?php if(is_array($lo['lower'])): $i = 0; $__LIST__ = $lo['lower'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$loo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($loo['id']); ?>'  <?php if(($Menudata['parentid']) == $loo['id']): ?>selected<?php endif; ?>>&nbsp;│&nbsp;├ <?php echo ($loo['name']); ?>
                    </option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            </select></td>
        </tr>
        <tr>
          <th>名称:</th>
          <td><input type="text" class="input-text" name="name" value="<?php echo ($Menudata['name']); ?>"></td>
        </tr>
        <tr>
          <th>项目:</th>
          <td><input type="text" class="input-text" name="app" value="<?php echo ($Menudata['app']); ?>">
            </td>
        </tr>
        <tr>
          <th>模块:</th>
          <td><input type="text" class="input-text" name="model" value="<?php echo ($Menudata['model']); ?>">
            </td>
        </tr>
        <tr>
          <th>方法:</th>
          <td><input type="text" class="input-text" name="action" value="<?php echo ($Menudata['action']); ?>">
            </td>
        </tr>
        <tr>
          <th>参数:</th>
          <td><input type="text" class="input-text" name="data" value="<?php echo ($Menudata['data']); ?>">
            例:groupid=1&amp;type=2</td>
        </tr>
<!--        <tr>
          <th>备注:</th>
          <td><textarea name="remark" rows="5" cols="57"><?php echo ($Menudata['remark']); ?></textarea></td>
        </tr>
-->        <tr>
          <th>是否显示:</th>
          <td><input type="radio" name="status" value="1"  <?php if(($Menudata['status']) == "1"): ?>checked<?php endif; ?> > 是 <input type="radio" name="status" value="0" <?php if(($Menudata['status']) == "0"): ?>checked<?php endif; ?>> 否</td>
        </tr>
        
      </tbody>
    </table>
    <div class="form-actions">
      <input type="hidden" name="type" value="1" />
      <input type="submit" value="提交" class="btn btn-primary btn_submit J_ajax_submit_btn" name="dosubmit">
      <input type="reset" value="重置" class="btn btn-primary btn_submit J_ajax_submit_btn">
		      </div>
  </form>
  </div>
</div>
</body>
</html>