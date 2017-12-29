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
<script type="text/javascript" src="/statics/js/jquery.min1.12.3.js"></script>
<script type="text/javascript" src="/statics/layer/layer.js"></script>

</head>
<body>
<style type="text/css">
html{_overflow-y:scroll}
.status0,.status2{color:#FF0000}
.status1{color:#0000ff}
.shoukuan{ cursor:pointer;}
.sk_cont{ padding:15px 20px; line-height:40px; font-size:14px;}
.sk_cont e{color:red}
</style>
<div class="wrap jj">
	<ul class="nav nav-tabs">
		<li><a href='<?php echo U("Finance/lists");?>'>全部</a></li>
		<li class="active"><a href='<?php echo U("Finance/billing");?>'>待开票</a></li>
		<li><a href='<?php echo U("Finance/mailing");?>' >待邮寄</a></li>
		<li><a href='<?php echo U("Finance/completed");?>' >已完成</a></li>
	</ul>
	<form name="searchform" action="<?php echo U('Finance/billing');?>" method="get"  class="well form-search" id="searchform">
	<input type="hidden" name="status" value="<?php echo ($_GET['status']); ?>" />
<div class="search_type cc mb10">
	 <div class="mb10">
              <input type="text" value="<?php echo ($_GET['no']); ?>" class="input-text" name="no" placeholder="订单号/客户手机号/客户单位" />
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
			  <th width="10%" align="left" >完工时间</th>
	          <th width="20%" align="left" >客户单位</th>
	          <th width="10%" align="left" >开票金额</th>
			  <th width="10%" align="left" >支出成本</th>
			  <th width="10%" style="text-align:center">开票状态</th>
			  <th width="10%" style="text-align:center">收款状态</th>
	          <th width="15%" >操作</th>
	        </tr>
	      </thead>
	      <tbody>

	      <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
	          <td width="2%" align="center"><?php echo ($key+1); ?></td>
	          <td width="6%" ><a href="<?php echo U('Gongdan/show',array('id'=>$v['id']));?>"><?php echo ($v["no"]); ?></a></td>
			  <td width="10%" ><?php echo ($v["end_time"]); ?></td>
	          <td width="20%" ><?php echo ($v["mobile"]); ?>/<?php echo ($v["khdw"]); ?></td>
	          <td width="10%" ><?php echo ($v["reward"]); if($v["reward_m"] == '1' ): ?><font color="red">(账外收)</font><?php endif; ?></td>
			  <td width="10%" ><?php echo ($v["get_reward"]); if($v["reward_m_f"] == '1' ): ?><font color="red">(账外支)</font><?php endif; ?></td>
			  <td width="10%" style="text-align:center" class="status0">待开票</td>
			  <td width="10%" style="text-align:center" class="status<?php echo ($v["pay_mode"]); ?>"><?php echo ($v["pay_status"]); ?></td>
	          <td width="15%"  align="center">
			   <span class="delbtn" data="<?php echo U('Finance/billing',array('id'=>$v['id']));?>" cont="订单 <?php echo ($v["no"]); ?><br>确认开票？">确认开票</span> |
			   <?php if($v["pay_mode"] == '2'): ?><a name="<?php echo ($v["id"]); ?>" no="<?php echo ($v["no"]); ?>" reward="<?php echo ($v["reward"]); ?>"  class="shoukuan">确认收款</a><?php endif; ?>
	          </td>
	        </tr><?php endforeach; endif; ?>
	      </tbody>
	    </table>
	    <div class="pagination"><?php echo ($Page); ?></div>
	</div>
</div>
<script>
$('.shoukuan').on('click', function(){
	var id = $(this).attr("name");
	var no = $(this).attr("no");
	var reward = $(this).attr("reward");
  	layer.open({
	  title:"确认收款",
	  btn: ['确认','取消'], //按钮
	  yes: function(index, layero){
			  var reward_m = $('input[name="reward_m"]:checked').val();
			  if(!reward_m){
				reward_m = "2";
			  }
			  window.location.href = "/Admin/Finance/shoukuan/id/"+id+"/reward_m/"+reward_m+".html";
			  layer.close(index);
			},
	  type: 1,
	  skin: 'layui-layer-rim', //加上边框
	  area: ['350px', '250px'], //宽高
	  content: '<div class="sk_cont"> 订 单 号 ：'+no+'<br />费用合计：￥'+reward+'<br />账外收入：<input name="reward_m" type="checkbox" value="1" style="width:20px; height:20px;"> <e>(不选为账内收入)</e></div>'
	});
});
</script>
</body>
</html>