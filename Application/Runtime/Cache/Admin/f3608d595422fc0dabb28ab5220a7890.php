<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
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
<link rel="stylesheet" type="text/css" href="/statics/js/calendar/jscal2.css"/>
<link rel="stylesheet" type="text/css" href="/statics/js/calendar/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="/statics/js/calendar/win2k.css"/>
<script type="text/javascript" src="/statics/js/calendar/calendar.js"></script> 
<script type="text/javascript" src="/statics/js/calendar/lang/en.js"></script>

</head>
<body>
<div class="wrap jj">
<style type="text/css">
	.mb10 a{font-size:15px; margin-right:10px; background:#fff; padding:6px 10px;}
	.mb10 a.a_n{ font-weight:bold; background:#2d3e50;color:#fff;}
	.mb10 a.a_n_20,.mb10 a.a_n_21{ background:#ffc000;color:#4a4a4a;}
</style>
	
	<form name="searchform" action="<?php echo U('Gongdan/lists');?>" method="get"  class="well form-search" id="searchform">
	<input type="hidden" name="status" value="<?php echo ($_GET['status']); ?>" />
<div class="search_type cc mb10">
	 <div class="mb10">
	 <a <?php if($_GET['status']== ''): ?>class="a_n"<?php endif; ?> href="<?php echo U('Gongdan/lists',array('id'=>$v['id']));?>">全部(<?php echo ($count_0); ?>)</a>
	 <?php if(is_array($status)): foreach($status as $k=>$v): ?><a class='<?php if($k == $_GET['status']): ?>a_n<?php endif; ?> a_n_<?php echo ($k); ?>' href="<?php echo U('Gongdan/lists',array('status'=>$k));?>"><?php echo ($v); ?></a><?php endforeach; endif; ?><br /><br />
	  发布时间:
              <input type="text" name="start_time" id="start_time" value="<?php echo ($_GET['start_time']); ?>" size="21" class="date"  style="width:100px;" >
              &nbsp;<script type="text/javascript">
			Calendar.setup({
			weekNumbers: true,
		    inputField : "start_time",
		    trigger    : "start_time",
		    dateFormat: "%Y-%m-%d",
		    showTime: 12,
		    minuteStep: 1,
		    onSelect   : function() {this.hide();}
			});
        </script>至
              <input type="text" name="end_time" id="end_time" value="<?php echo ($_GET['end_time']); ?>" size="21" class="date"  style="width:100px;" >
              &nbsp;<script type="text/javascript">
			Calendar.setup({
			weekNumbers: true,
		    inputField : "end_time",
		    trigger    : "end_time",
		    dateFormat: "%Y-%m-%d",
		    showTime: 12,
		    minuteStep: 1,
		    onSelect   : function() {this.hide();}
			});
        </script>
		
	<select name="info_f" style="width:80px;">
      <option value="需求方" <?php if($_GET['info_f']== '需求方' ): ?>selected<?php endif; ?>>需求方</option>
      <option value="服务方" <?php if($_GET['info_f']== '服务方' ): ?>selected<?php endif; ?>>服务方</option>
      </select>
	 <input type="text" value="<?php echo ($_GET['info_x']); ?>" class="input-text" name="info_x" style="width:200px;" placeholder="单号/需方手机号/公司名称" />
			  &nbsp;
              <input type="submit" value="搜索当前页"  class="btn btn-primary btn_submit" name="dosubmit" id="goodssearch">
            </div>
	</div>
  </form>
  

	<div class="table-list">
	    <table width="100%" class="table table-hover">
	      <thead>
	        <tr>
	          <th width="2%">#</th>
			  <th width="6%" align="left" >订单号</th>
			  <th width="10%" align="left" >发布时间</th>
	          <th width="5%" align="left" >设备类别</th>
			  <th width="15%" align="left" >需求方</th>
			  <th width="8%" style="text-align:center">服务费合计</th>
			  <th width="15%" align="left" >服务商</th>
			  <th width="5%" align="left" >服务酬劳</th>
			  <th width="20%" align="left" >服务地点</th>
	          <th width="15%" >操作</th>
	        </tr>
	      </thead>
	      <tbody>

	      <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
	          <td width="2%" align="center"><?php echo ($key+1); ?></td>
	          <td width="6%" ><a href="<?php echo U('Gongdan/show',array('id'=>$v['id']));?>"><?php echo ($v["no"]); ?></a></td>
			  <td width="10%" ><?php echo ($v["time"]); ?></td>
	          <td width="5%" ><?php echo ($v["s_type"]); ?></td>
			  <td width="15%" ><?php echo ($v["u_mobile"]); ?><br /><?php echo ($v["khdw"]); ?></td>
			  <td width="8%" style="text-align:center"><?php echo ($v["reward"]); ?></td>
			  <td width="15%" ><?php echo ($v["u_company"]); ?></td>
			  <td width="5%" ><?php echo ($v["get_reward"]); ?></td>
			  <td width="20%" ><?php echo ($v["city"]); echo ($v["address"]); ?></td>
	          <td width="15%"  align="center">
			  <?php if($v["status"] == '11'): ?><a href="<?php echo U('Gongdan/check',array('id'=>$v['id']));?>">需求确认</a> |<?php endif; ?>
			  <?php if($v["xffy"] == 1): ?><a href="<?php echo U('Gongdan/show',array('id'=>$v['id'],'bk'=>'1'));?>">需方费用</a> |<?php endif; ?>
			  <?php if(($v["status"] > 11) and ($v["status"] < 15)): ?><a href="<?php echo U('Gongdan/show',array('id'=>$v['id'],'bz'=>'1'));?>">执行备注</a> |<?php endif; ?>
			  <?php if($v["status"] == 14): if($v["report"] == 1): ?>报告已出 |
				<?php else: ?>
					<a href="<?php echo U('Gongdan/endbg',array('id'=>$v['id']));?>">完工报告</a> |<?php endif; endif; ?>
			  <?php if(($v["status"] == '14') and ($v["reward"] > 0) and ($v["report"] == 1)): ?><a href="<?php echo U('Gongdan/end',array('id'=>$v['id']));?>" onClick="return confirm('确定服务完成?');" style="color:#0000ff">确认完工</a> |<?php endif; ?>
			  <?php if($v["status"] < 13): ?><span class="delbtn" data="<?php echo U('Gongdan/deln',array('id'=>$v['id']));?>" cont="确定取消该订单？" >取消订单</span> |<?php endif; ?>
			  <?php if(($v["status"] == '15') and ($v["pay_mode"] == 0)): ?><span class="delbtn" data="<?php echo U('Gongdan/pay',array('id'=>$v['id']));?>" cont="订单号<?php echo ($v["no"]); ?><br />确定选择线下支付？" >线下支付</span> |<?php endif; ?>
	          </td>
	        </tr><?php endforeach; endif; ?>
	      </tbody>
	    </table>
	    <div class="pagination"><?php echo ($Page); ?></div>
	</div>
</div>
</body>
</html>