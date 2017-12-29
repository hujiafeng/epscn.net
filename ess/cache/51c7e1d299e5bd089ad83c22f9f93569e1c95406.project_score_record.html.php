<?php
/* Smarty version 3.1.30, created on 2017-09-07 13:57:56
  from "/www/mecan.net/ess/templates/project_score_record.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b0dfe49ec021_66600844',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d91f113bf5965c0ae8f85f17536aeb4de5b2719' => 
    array (
      0 => '/www/mecan.net/ess/templates/project_score_record.html',
      1 => 1504677827,
      2 => 'file',
    ),
    'dc29824e50dfd381aae9e28adf117303e9a9ea3c' => 
    array (
      0 => '/www/mecan.net/ess/templates/top.html',
      1 => 1503307702,
      2 => 'file',
    ),
    'c7c3cf2bdf7ed0140e1e0b11f7b27bdc7f36180f' => 
    array (
      0 => '/www/mecan.net/ess/templates/header.html',
      1 => 1504762965,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 0,
),true)) {
function content_59b0dfe49ec021_66600844 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>项目产品采购记录-电气销售家</title>
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<script src="jquery/jquery-1.7.2.min.js"></script>
<script src="uikit/js/uikit.min.js"></script>
<script src="uikit/js/uikit-icons.min.js"></script>
<script>
	$(function() {
		$("#save_record").click(
				function() {
					var str = "";
					var num = "";
					$("input[name='ppIds']:checked").each(function() {
							var id = $(this).val();
							str += ',' + id;
							var purchase_num = $("input[name='purchase_num_"+ id + "']").val();
							if(purchase_num.length==0 || purchase_num==0){
							    //alert("请填写采购数量！");
					         return false;
							}else
								num += ',' + purchase_num;
				     });

					if (str.length == 0 || num.length==0) {
						alert("请选择产品并填写采购数量！");
					} else {
						$.post('project_product.php', {
							act : 'save_record',
							ppIds : str,
							purchaseNums : num
						}, function(data) {
							if (data == 1)
								setTimeout(function() {
									window.location.reload();
								}, 500);
							else
								alert("记录保存失败！");

						});
					}
				});

		$("#add_record").click(function() {
			var project_id = $("#project_id").val();
			$.post('project.php', {
				act : 'getProducts',
				project_id : project_id
			}, function(data) {
				$("#content").html(data);
			});
		});

		//init
		$("input[name='ppIds']").prop('checked', false);
		$("#checkAll").prop('checked', false);
		$("#checkAll").live('click', function(){ 
			var v = $(this).prop('checked');
			$("input[name='ppIds']").prop('checked', v);
		});

	});

	function del(record_id) {
		if (confirm("确定删除这条记录吗？")) {
			$.post('project_product.php', {
				act : "del_record",
				record_id : record_id
			}, function(data) {
				if (data == 1)
					setTimeout(function() {
						window.location.reload();
					}, 500);
				else
					alert("删除失败！");
			});
		}
	}
</script>
</head>
<body>
	<style type="text/css">
#head { height: 50px;background: #323232;}
#head .logo { float: left; margin: 10px 0 0 20px;}
#head .user { float: right; color: #FFFFFF; font: 14px Arial; margin: 15px 20px 0 0;}
#head .user a { color: #FFFFFF; text-decoration:none;}
#head .user a:hover {color:#FFFFFF; text-decoration:underline;}
</style>
<div id="head">
    <div class="logo"><img src="img/dqj_logo.png" width="132" height="24"/></div>
    <div class="user">
       系统管理员  &nbsp;  &nbsp; <a href="index.php?act=logout" >退出</a>  &nbsp;  &nbsp; 
    </div>
</div>
	<div class="uk-container">
		<style>
html {
	font-family: 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei',
		sans-serif;
}

.ft18 {
	font-size: 18px;
}

.uk-flex-center li {
	margin-right: 50px;
}

.uk-active a {
	border-bottom: #1e87f0 solid 2px;
	padding-bottom: 10px;
}

.cnt {
	margin-top: -20px;
}
</style>
<div class="uk-margin-medium-top">
	<ul class="uk-flex-center " uk-tab>

				<li class="uk-active"><a href="project.php"><span
				class="ft18">项目申报</span>  <span
				class="uk-badge cnt">17</span> </a></li>  		<li><a href="product.php"><span class="ft18">产品</span></a></li>
				<li><a href="user.php"><span class="ft18">用户</span></a></li> 				<li><a href="feedback.php"><span class="ft18">用户反馈</span></a></li>
		
	</ul>
</div>
		<h2>
			测试090402 <span class="uk-text-large">实际采购记录</span>  &nbsp;&nbsp; <span style="float: right;"><a class="uk-text-small uk-link-muted"
				id="add_record" href="#modal-record" uk-toggle>+添加采购记录</a></span>
		</h2>

		<table class="uk-table uk-table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>产品信息</th>
					<th>采购数量</th>
					<th>记录人/时间</th>
					<th>删除人/时间</th>
					<th>积分</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>

		<div id="modal-record" class="uk-modal-container" uk-modal>
			<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h2 class="uk-modal-title">添加采购记录</h2>
				<form class="uk-form-horizontal uk-margin-large">
					<input type="hidden" id="project_id" value='67'
						name="project_id">
					<div class="uk-margin" id="content"></div>
					<p class="uk-text-right">
						<button class="uk-button uk-button-default uk-modal-close"
							type="button">取消</button>
						<button class="uk-button uk-button-primary" type="button"
							id="save_record">确定</button>
					</p>
				</form>
			</div>
		</div>

	</div>
</body>
</html><?php }
}
