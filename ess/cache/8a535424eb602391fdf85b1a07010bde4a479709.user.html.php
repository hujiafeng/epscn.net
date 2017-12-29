<?php
/* Smarty version 3.1.30, created on 2017-09-07 13:46:04
  from "/www/mecan.net/ess/templates/user.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b0dd1c57cb46_81095053',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '516841aea8b660e5401eb36a895fe1119f1a4a19' => 
    array (
      0 => '/www/mecan.net/ess/templates/user.html',
      1 => 1504516678,
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
function content_59b0dd1c57cb46_81095053 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户-电气销售家</title>
<link rel="stylesheet" href="css/common.css" />
<link rel="stylesheet" href="css/page.css" />
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<script src="jquery/jquery-1.7.2.min.js"></script>
<script src="uikit/js/uikit.min.js"></script>
<script src="uikit/js/uikit-icons.min.js"></script>
<script>
	$(function() {
		$("[id^='set_utype_']").click(function() {
			$("#user_id").val('0');
			var _data = $(this).attr('id');
			var _arr=_data.split("_");
			var user_id = _arr[2];
			var utype=_arr[3];
			$("#user_id").val(user_id);
			$("input[name='utype'][value='" + utype + "']").prop("checked", 'checked');
		});
		$("#save_utype").click(function() {
			var user_id = $("#user_id").val();
			var utype = $("input[name='utype']:checked").val();
			$.post('user.php', {
				act : 'save_utype',
				user_id : user_id,
				utype : utype
			}, function(data) {
				if (data == 1)
					setTimeout(function() {
						window.location.reload();
					}, 500);
				else
					alert("设置用户类型失败！");
			});
		})
	});
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

				<li><a href="project.php"><span class="ft18">项目申报</span> <span class="uk-badge cnt">17</span>
				</a></li>  		<li><a href="product.php"><span class="ft18">产品</span></a></li>
				<li class="uk-active"><a href="user.php"><span class="ft18">用户</span></a></li>
						<li><a href="feedback.php"><span class="ft18">用户反馈</span></a></li>
		
	</ul>
</div>

		<form class="uk-search uk-search-default" style="width:400px;">
			<span uk-search-icon></span> <input
				class="uk-search-input uk-text-small" type="search"
				placeholder="用户ID、姓名、手机..." name="kw"  style="width:400px;"/>
		</form>

		<table class="uk-table uk-table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>用户名</th>
					<th>手机号码</th>
					<th>用户类型</th>
					<th>性别</th>
					<th>当前积分/总积分</th>
					<th>注册时间</th>
					<th>平台</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
								<tr class="uk-text-small">
					<td>16</td>
					<td><img class="uk-preserve-width" src="avatar/20170905153862176806_0.jpg"
						width="40"> <span class="uk-text-primary">安卓测试0906</span>
					</td>
					<td>18015875680</td>
					<td>普通成员</td>
					<td>女</td>
					<td>0/0</td>
					<td>2017-09-05 15:38:09</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_16_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=16"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=16"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>15</td>
					<td><img class="uk-preserve-width" src="avatar/20170905111362365696_0.jpg"
						width="40"> <span class="uk-text-primary">海风吹啊吹啊</span>
					</td>
					<td>13685297921</td>
					<td>普通成员</td>
					<td>无</td>
					<td>221000/224000</td>
					<td>2017-09-05 11:13:52</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_15_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=15"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=15"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>14</td>
					<td><img class="uk-preserve-width" src="avatar/20170905111103846291_14.jpg"
						width="40"> <span class="uk-text-primary">我测试的</span>
					</td>
					<td>18118339820</td>
					<td>普通成员</td>
					<td>无</td>
					<td>0/0</td>
					<td>2017-09-05 11:11:05</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_14_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=14"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=14"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>13</td>
					<td><img class="uk-preserve-width" src="img/avatar.png"
						width="40"> <span class="uk-text-primary"></span>
					</td>
					<td>18118339824</td>
					<td>普通成员</td>
					<td>无</td>
					<td>0/0</td>
					<td>2017-09-04 16:06:58</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_13_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=13"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=13"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>12</td>
					<td><img class="uk-preserve-width" src="avatar/20170904141804249969_12.jpg"
						width="40"> <span class="uk-text-primary">安卓测试0904</span>
					</td>
					<td>18015875681</td>
					<td>普通成员</td>
					<td>女</td>
					<td>8800/8800</td>
					<td>2017-09-04 12:47:07</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_12_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=12"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=12"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>11</td>
					<td><img class="uk-preserve-width" src="img/avatar.png"
						width="40"> <span class="uk-text-primary">我的名字叫金三顺</span>
					</td>
					<td>13685297924</td>
					<td>普通成员</td>
					<td>无</td>
					<td>4500/5000</td>
					<td>2017-09-04 12:23:58</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_11_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=11"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=11"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>10</td>
					<td><img class="uk-preserve-width" src="img/avatar.png"
						width="40"> <span class="uk-text-primary">the one</span>
					</td>
					<td>18118339823</td>
					<td>普通成员</td>
					<td>无</td>
					<td>0/0</td>
					<td>2017-09-04 10:01:43</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_10_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=10"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=10"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>9</td>
					<td><img class="uk-preserve-width" src="img/avatar.png"
						width="40"> <span class="uk-text-primary">flowers</span>
					</td>
					<td>13685297923</td>
					<td>普通成员</td>
					<td>无</td>
					<td>0/0</td>
					<td>2017-09-04 09:59:24</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_9_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=9"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=9"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>8</td>
					<td><img class="uk-preserve-width" src="avatar/20170901100479551593_0.jpg"
						width="40"> <span class="uk-text-primary">张娘</span>
					</td>
					<td>18118339821</td>
					<td>普通成员</td>
					<td>无</td>
					<td>0/0</td>
					<td>2017-09-01 10:04:43</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_8_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=8"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=8"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>7</td>
					<td><img class="uk-preserve-width" src="avatar/20170831171899961814_0.jpg"
						width="40"> <span class="uk-text-primary">我咋</span>
					</td>
					<td>13685297922</td>
					<td>普通成员</td>
					<td>无</td>
					<td>0/0</td>
					<td>2017-08-31 17:18:12</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_7_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=7"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=7"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>6</td>
					<td><img class="uk-preserve-width" src="img/avatar.png"
						width="40"> <span class="uk-text-primary">王平</span>
					</td>
					<td>18961157999</td>
					<td>普通成员</td>
					<td>男</td>
					<td>0/0</td>
					<td>2017-08-25 18:46:30</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_6_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=6"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=6"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>5</td>
					<td><img class="uk-preserve-width" src="avatar/20170905145845352586_5.jpg"
						width="40"> <span class="uk-text-primary">洪星照我去战痘</span>
					</td>
					<td>13616129510</td>
					<td>普通成员</td>
					<td>男</td>
					<td>28000/28000</td>
					<td>2017-08-23 17:52:26</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_5_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=5"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=5"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>4</td>
					<td><img class="uk-preserve-width" src="avatar/20170824114530978855_4.jpeg"
						width="40"> <span class="uk-text-primary">飞天狗狗的奇特之旅</span>
					</td>
					<td>13951214127</td>
					<td>普通成员</td>
					<td>男</td>
					<td>0/0</td>
					<td>2017-08-23 16:57:04</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_4_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=4"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=4"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>3</td>
					<td><img class="uk-preserve-width" src="avatar/20170905172515659549_3.jpeg"
						width="40"> <span class="uk-text-primary">系统管理员</span>
					</td>
					<td>13912345678</td>
					<td>管理员</td>
					<td>男</td>
					<td>0/0</td>
					<td>2017-08-18 13:57:03</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_3_管理员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=3"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=3"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>2</td>
					<td><img class="uk-preserve-width" src="avatar/20170818135241939568_2.jpeg"
						width="40"> <span class="uk-text-primary">飞天猪</span>
					</td>
					<td>13951214128</td>
					<td>普通成员</td>
					<td>男</td>
					<td>0/0</td>
					<td>2017-08-18 13:49:54</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_2_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=2"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=2"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
								<tr class="uk-text-small">
					<td>1</td>
					<td><img class="uk-preserve-width" src="avatar/20170904122875065211_1.jpg"
						width="40"> <span class="uk-text-primary">柯南你就是个死神</span>
					</td>
					<td>13951214129</td>
					<td>普通成员</td>
					<td>男</td>
					<td>4125/5675</td>
					<td>2017-08-02 04:41:08</td>
					<td>无</td>
					<td><span class="green">√</span>					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_1_普通成员" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=1"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=1"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
				</tr>
				
			</tbody>
		</table>

		<div class="uk-margin uk-margin-bottom">&nbsp;</div>

		<div id="set_utype" class="uk-flex-top" uk-modal>
			<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
				<form class="uk-form-horizontal uk-margin-large">
					<input type="hidden" id="user_id" value='0'>
					<div class="uk-margin">
						<div class="uk-form-label">用户类型：</div>
						<div class="uk-form-controls">
							<p>
								<input class="uk-radio" type="radio" name="utype" checked
									value="MEMBER"> <span class="uk-text-small">普通成员</span>
							</p>
							<label><input class="uk-radio" type="radio" name="utype"
								value="ADMIN"> <span class="uk-text-small">管理员</span></label>
						</div>
					</div>
					<p class="uk-text-right">
						<button class="uk-button uk-button-default uk-modal-close"
							type="button">取消</button>
						<button class="uk-button uk-button-primary" type="button"
							id="save_utype">确定</button>
					</p>
				</form>
			</div>
		</div>

	</div>
</body>
</html><?php }
}
