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
<script type="text/javascript" src="/Public/js/lightbox-2.6.min.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/css/lightbox.css"/>

<body class="J_scroll_fixed">

 <div class="wrap jj">
<style type="text/css">
	html{_overflow-y:scroll}
	.n_img{width:70px; height:70px; float:left; display:inline; margin-top:5px; margin-left:5px;}
	.need_tr{ font-weight:bold;background:#f2f2f2; line-height:20px; padding-top:10px; padding-left:10px;}
</style>
<ul class="nav nav-tabs">
     <li><a href="<?php echo U('Fgongdan/lists');?>" >订单列表</a></li> 
     <li class="active"><a href='#' >订单详情</a></li> 
</ul>

<div class="pad_10">
  <div class="common-form">
  <form name="myform" action="<?php echo U('Fgongdan/bukuan');?>" method="post" id="myform">
  <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
   <table width="1000px" class="table_form contentWrap">
          <tbody>
		<tr>
            <td width="80" class="need_td">订单ID</td>
			<td><?php echo ($info["id"]); ?></td>
            <td width="80" class="need_td">订单号</td>
			<td><?php echo ($info["no"]); ?></td>
        </tr>
		<tr>
            <td width="80" class="need_td">订单毛利</td>
			<td>￥<?php echo ($info["maoli"]); ?></td>
			<td width="80" class="need_td">订单状态</td>
			<td><?php echo ($info["status_name"]); ?></td>
        </tr>
		<tr>
            <td colspan="2" class="need_tr">需求方信息</td><td colspan="2" class="need_tr">服务方信息</td>
       	</tr>
        <tr>
			<td width="80" class="need_td">需求方</td>
            <td><?php echo ($info["u_x_mobile"]); ?><br /><?php echo ($info["u_x_khdw"]); ?></td>
			<td width="80" class="need_td">服务商</td>
			<td><?php echo ($info["u_f_mobile"]); ?><br /><?php echo ($info["u_f_company"]); ?></td>
       	</tr>
		<tr>
			<td width="80" class="need_td">服务费合计</td>
            <td>
			￥<?php echo ($info["reward"]); ?>
				<?php if($info["reward_m"] == '1' ): ?><font color="red">(账外收入)</font><?php endif; ?>
			</td>
			<td width="80" class="need_td">服务酬劳</td>
			<td>
			￥
            <?php if($bk == 1): ?><input type="text" name="info[get_reward]" style="width:100px;" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9.]/g,'');}).call(this)">
			<?php else: ?>
				<?php echo ($info["get_reward"]); ?>
                <?php if($info["reward_m_f"] == '1' ): ?><font color="red">(账外支出)</font><?php endif; endif; ?>
			</td>
       	</tr>
		<tr>
            <td width="80" class="need_td">支付方式</td>
			<td><?php echo ($info["n_payed_name"]); ?></td>
			<td width="80" class="need_td">工程师</td>
			<td><?php echo ($info["js_name"]); ?> - <?php echo ($info["js_number"]); ?></td>
       	</tr>
		<tr>
			<td width="80" class="need_td">订单发布</td>
            <td><?php echo ($info["time"]); ?></td>
			<td width="80" class="need_td">指定人员</td>
			<td><?php echo ($info["js_time"]); ?></td>
        </tr>
        <tr>
			
			<td width="80" class="need_td">需求确认</td>
			<td><?php echo ($info["check_time"]); ?></td>
			<td width="80" class="need_td">申请完工</td>
			<td><?php echo ($info["app_over_time"]); ?></td>
        </tr>
		<tr>
            
			<td width="80" class="need_td">确认完工</td>
			<td><?php echo ($info["end_time"]); ?></td>
            <td width="80" class="need_td">确认完工</td>
			<td><?php echo ($info["end_time_f"]); ?></td>
        </tr>
		<tr>
           <td width="80" class="need_td">支付时间</td>
			<td><?php echo ($info["pay_time"]); ?></td>
            <td width="80" class="need_td">确认打款</td>
			<td><?php echo ($info["reward_time"]); ?></td>
        </tr>

		<tr>
            <td width="80" class="need_td">需方描述</td>
			<td colspan="3"><?php echo ($info["miaoshu1"]); ?></td>
        </tr>
		<tr>
            <td width="80" class="need_td">需方图片</td>
			<td colspan="3">
			<?php if(is_array($info_s)): foreach($info_s as $k=>$v): ?><a href="/uploads/<?php echo ($v["large"]); ?>" target="_blank"><img src='/statics/admin/n_shipin.jpg' class="n_img" /></a><?php endforeach; endif; ?>
			<?php if(is_array($info_m)): foreach($info_m as $k=>$v): ?><a href="/uploads/<?php echo ($v["large"]); ?>" data-lightbox="example-set"><img src='/uploads/<?php echo ($v["small"]); ?>' class="n_img" /></a><?php endforeach; endif; ?>
			</td>
        </tr>
        <tr>
            <td width="80" class="need_td">业务员-需</td>
			<td><?php echo ($info["clerk_x_name"]); ?></td>
            <td width="80" class="need_td">业务员-服</td>
			<td><?php echo ($info["clerk_f_name"]); ?></td>
        </tr>
		<?php if($evaluate["id"] > 0): ?><tr>
            <td width="80" class="need_td">评价</td>
			<td colspan="3">综合评分(<?php echo ($evaluate["zhpf"]); ?>) 客户经理(<?php echo ($evaluate["fwzl"]); ?>) 现场服务(<?php echo ($evaluate["sgzl"]); ?>)</td>
        </tr>
		<tr>
            <td width="80" class="need_td">评价内容</td>
			<td colspan="3"><?php echo ($evaluate["content"]); ?></td>
        </tr>
		<tr>
            <td width="80" class="need_td">评价图片</td>
			<td colspan="3">
			<?php if(is_array($info_j)): foreach($info_j as $k=>$v): ?><a href="/uploads/<?php echo ($v["large"]); ?>" data-lightbox="example-set"><img src='/uploads/<?php echo ($v["large"]); ?>' class="n_img" /></a><?php endforeach; endif; ?>
			</td>
        </tr><?php endif; ?>
		<tr>
            <td colspan="4" class="need_tr">服务内容</td>
       	</tr>
		<tr>
            <td width="80" class="need_td">设备类别</td>
			<td><?php echo ($info["s_type"]); ?></td>
            <td width="80" class="need_td">设备款型</td>
			<td><?php echo ($info["k_title"]); ?></td>
        </tr>
		<tr>
			<td width="100" class="need_td">任务类型</td>
			<td><?php echo ($info["biaoqian"]); ?></td>
			<td width="100" class="need_td">预计上门</td>
			<td><?php echo ($info["go_time"]); ?></td>
        </tr>
		<tr>
			<td width="100" class="need_td">服务身份</td>
			<td><?php echo ($info["fw_id"]); ?></td>
			<td width="80" class="need_td">客户经理</td>
			<td><?php echo ($info["gw_name"]); ?> - <?php echo ($info["gw_number"]); ?></td>
        </tr>
		 
        <tr>
            <td width="80" class="need_td">现场联系人</td>
			<td><?php echo ($info["lx_name"]); ?> - <?php echo ($info["lx_number"]); ?></td>
			<td width="80" class="need_td">服务地点</td>
			<td><?php echo ($info["city"]); echo ($info["address"]); ?></td>
        </tr>
		<tr>
            <td width="80" class="need_td">需求确认</td>
			<td colspan="3"><?php echo ($info["miaoshu2"]); ?></td>
        </tr>
		<tr>
            <td width="80" class="need_td">确认图片</td>
			<td colspan="3">
			<?php if(is_array($info_p)): foreach($info_p as $k=>$v): ?><a href="/uploads/<?php echo ($v["large"]); ?>" data-lightbox="example-set"><img src='/uploads/<?php echo ($v["small"]); ?>' class="n_img" /></a><?php endforeach; endif; ?>
			</td>
        </tr>
		<?php if($report["id"] > 0): ?><tr>
            <td colspan="4" class="need_tr">完工报告</td>
       	</tr>
		<tr>
		<td width="80" class="need_td">常规工时</td>
			<td><?php echo ($report["routine_time"]); ?> 天.人</td>
			<td width="80" class="need_td">加班工时</td>
			<td><?php echo ($report["overtime"]); ?> 天.人</td>
        </tr>
		<td width="80" class="need_td">零配件费用</td>
			<td><?php echo ($report["fitting_reward"]); ?> 元</td>
			<td width="80" class="need_td">报告生成</td>
			<td><?php echo ($report["time"]); ?></td>
        </tr>
		<tr>
            <td width="80" class="need_td">报告内容</td>
			<td colspan="3"><?php echo ($report["content"]); ?></td>
        </tr>
		<tr>
            <td width="80" class="need_td">报告图片</td>
			<td colspan="3">
			<?php if(is_array($info_b)): foreach($info_b as $k=>$v): ?><a href="/uploads/<?php echo ($v["large"]); ?>" data-lightbox="example-set"><img src='/uploads/<?php echo ($v["small"]); ?>' class="n_img" /></a><?php endforeach; endif; ?>
			</td>
        </tr><?php endif; ?>
		<tr>
            <td colspan="4" class="need_tr">执行备注</td>
       	</tr>
		<tr>
			<td colspan="4">
			<?php if(is_array($inform)): foreach($inform as $k=>$v): ?><p /><?php echo ($v["time"]); ?><br /><?php echo ($v["content"]); endforeach; endif; ?>
		</td>
       	</tr>
		<?php if($info["billing"] > 0): ?><tr>
            <td colspan="4" class="need_tr">发票管理</td>
       	</tr>
		<tr>
		<td width="80" class="need_td">是否开票</td>
			<td>是</td>
			<td width="80" class="need_td">是否邮寄</td>
			<td><?php if($info["billing"] == 2): ?>是<?php endif; ?></td>
        </tr>
		<td width="80" class="need_td">快递公司</td>
			<td><?php echo ($mailing["name"]); ?></td>
			<td width="80" class="need_td">快递单号</td>
			<td><?php echo ($mailing["number"]); ?></td>
        </tr><?php endif; ?>
        </tbody>
      </table>
	  <?php if($bk == 1): ?><div class="form-actions">
      <input name="dosubmit" type="submit"  value="确认完工" class="btn  btn-primary btn_submit" id="dosubmit">
	 </div><?php endif; ?>
	 </form>
	  
  </div>
  </div>
</div>
</body>
</html>