<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:46:29
  from "E:\www\eps\ess\templates\user_score_record.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0cb550d9f80_92189749',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9a6631c16b0b24ca6767c90fa761c8b644cb1a01' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\user_score_record.html',
      1 => 1505803958,
      2 => 'file',
    ),
    '0a925040523a0ac5dcf123b8512936343c774fd6' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\top.html',
      1 => 1505803958,
      2 => 'file',
    ),
    '26ae1aee85cb6d9f2097548b3349283637b5c86c' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\header.html',
      1 => 1505803958,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 0,
),true)) {
function content_59c0cb550d9f80_92189749 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户积分明细-电气销售家</title>
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<link rel="stylesheet" href="css/page.css" />
<script src="jquery/jquery-1.7.2.min.js"></script>
<script src="uikit/js/uikit.min.js"></script>
<script src="uikit/js/uikit-icons.min.js"></script>
<script>
	$(function() {
		$("#save_record").click(function() {
			var user_id = $("#user_id").val();
			var score = $("input[name='score']").val();
			if (score.length == 0 || score == 0) {
				alert("兑换积分不能为零！");
			} else {
				$.post('user.php', {
					act : 'redeem_points',
					user_id : user_id,
					score : score
				}, function(data) {
					if (data == 1)
						setTimeout(function() {
							window.location.reload();
						}, 500);
					else
						alert("兑换记录保存失败！");

				});
			}
		});
		
		$("[id^='view_detail_']").click(function() {
			var _data = $(this).attr('id');
			var project_id = _data.split("_")[2];
			
			$.post('project.php', {
				act : 'detail',
				project_id : project_id
			}, function(data) {
				$("#detail_table").html(data);
			});
		});
	});

	function del(record_id) {
		if (confirm("确定删除这条记录吗？")) {
			$.post('user.php', {
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

				<li><a href="project.php"><span class="ft18">项目申报</span> <span class="uk-badge cnt">18</span>
				</a></li>  		<li><a href="product.php"><span class="ft18">产品</span></a></li>
				<li class="uk-active"><a href="user.php"><span class="ft18">用户</span></a></li>
						<li><a href="feedback.php"><span class="ft18">用户反馈</span></a></li>
		
	</ul>
</div>
		<h2>
			王平积分明细<span style="font-size:16px;color:#999">&nbsp;&nbsp; ( 当前积分：0 )</span> <span style="float: right;"><a class="uk-text-small uk-link-muted"
				id="add_record" href="#modal-record" uk-toggle>+创建积分兑现</a></span>
		</h2>

		<table class="uk-table uk-table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>获得积分</th>
					<th>兑现积分</th>
					<th>产品信息</th>
					<th>操作人/时间</th>
					<th>废弃人/时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
		<div class="uk-margin uk-margin-bottom">&nbsp;</div>

		<div id="modal-record" class="uk-flex-top" uk-modal>
			<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
				<form class="uk-form-horizontal uk-margin-large">
					<input type="hidden" id="user_id" value='6'
						name="record_id">
					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">兑换积分：</label>
						<div class="uk-form-controls">
							<input class="uk-input" id="form-horizontal-text" type="text"
								name="score">
						</div>
					</div>
					<p class="uk-text-right">
						<button class="uk-button uk-button-default uk-modal-close"
							type="button">取消</button>
						<button class="uk-button uk-button-primary" type="button"
							id="save_record">确定</button>
					</p>
				</form>
			</div>
		</div>
		
		<div id="modal-detail" uk-modal>
			<div class="uk-modal-dialog">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<div class="uk-modal-header">
					<h2>相关项目信息</h2>
				</div>
				<div class="uk-modal-body" uk-overflow-auto>
					<table class="uk-text-small" style="line-height: 35px;">
						<col width="80" />
						<col width="220" />
						<col width="80" />
						<col width="220" />
						<tbody id="detail_table">
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</body>
</html><?php }
}
