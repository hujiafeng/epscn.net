<?php
/* Smarty version 3.1.30, created on 2017-09-06 14:04:42
  from "/www/mecan.net/ess/templates/user_score_record.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59af8ffa5e0331_81000271',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b263fc4d292fad6b01ed3b7f9bb9fc95cb4ffece' => 
    array (
      0 => '/www/mecan.net/ess/templates/user_score_record.html',
      1 => 1504677557,
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
      1 => 1503363109,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 0,
),true)) {
function content_59af8ffa5e0331_81000271 (Smarty_Internal_Template $_smarty_tpl) {
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
html{
 font-family: 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', sans-serif;
}
.ft18 {
	font-size: 18px;
}

.uk-flex-center li {
	margin-right: 50px;
}
 .uk-active a {
   border-bottom:#1e87f0 solid 2px;
   padding-bottom:10px;
}
.cnt{
  margin-top: -20px;
}
</style>
<div class="uk-margin-medium-top">
	<ul class="uk-flex-center " uk-tab>
				<li><a href="index.php"><span class="ft18">产品</span></a></li> 				<li><a href="project.php"><span class="ft18">项目申报</span>				<span class="uk-badge cnt">17</span>
				</a></li>
		 		<li class="uk-active"><a href="user.php"><span class="ft18">用户</span></a></li>
			</ul>
</div>
		<h2>
			柯南你就是个死神积分明细<span style="font-size:16px;color:#999">&nbsp;&nbsp; ( 当前积分：4125 )</span> <span style="float: right;"><a class="uk-text-small uk-link-muted"
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
								<tr class="uk-text-small">
					<td>34</td>
					<td>+1675.00</td>
					<td></td>
					<td>中压元器件</br>VBM SmartEX-12</br>固封极柱,00-0,210mm/275mm,手车式，1，1</br>品牌：明及</br>采购价：28475.00</br>结算价：26800.00</br>实际采购数量：1台</br></td>
					<td>系统管理员 <br/> 2017-09-05 16:51:47</td>
					<td></td>
					<td><a href="javascript:del('34')"
						class="uk-text-small uk-text-primary">删除</a>
						&nbsp;&nbsp;
						<a href="#modal-detail" id="view_detail_4"
						class="uk-text-small uk-text-primary" uk-toggle>项目信息</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>33</td>
					<td>+2000.00</td>
					<td></td>
					<td>中压元器件</br>VBM SmartEX-12</br>固封极柱,00-0,210mm/275mm,手车式，1，1</br>品牌：明及</br>采购价：27000.00</br>结算价：26800.00</br>实际采购数量：10台</br></td>
					<td>系统管理员 <br/> 2017-09-05 16:50:03</td>
					<td></td>
					<td><a href="javascript:del('33')"
						class="uk-text-small uk-text-primary">删除</a>
						&nbsp;&nbsp;
						<a href="#modal-detail" id="view_detail_4"
						class="uk-text-small uk-text-primary" uk-toggle>项目信息</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>24</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-08-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('24')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>23</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-08-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('23')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>1</td>
					<td>+2000.00</td>
					<td></td>
					<td>中压元器件</br>VBM SmartEX-12</br>固封极柱,00-0,210mm/275mm,手车式，1，1</br>品牌：明及</br>采购价：29920.00</br>结算价：28160.00</br>实际采购数量：1台</br></td>
					<td>柯南你就是个死神 <br/> 2017-08-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('1')"
						class="uk-text-small uk-text-primary">删除</a>
						&nbsp;&nbsp;
						<a href="#modal-detail" id="view_detail_5"
						class="uk-text-small uk-text-primary" uk-toggle>项目信息</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>7</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-08-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('7')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>6</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-08-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('6')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>2</td>
					<td>+2000.00</td>
					<td></td>
					<td>中压元器件</br>VBM SmartEX-12</br>固封极柱,00-0,210mm/275mm,手车式，1，1</br>品牌：明及</br>采购价：31680.00</br>结算价：28160.00</br>实际采购数量：1台</br></td>
					<td>柯南你就是个死神 <br/> 2017-08-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('2')"
						class="uk-text-small uk-text-primary">删除</a>
						&nbsp;&nbsp;
						<a href="#modal-detail" id="view_detail_5"
						class="uk-text-small uk-text-primary" uk-toggle>项目信息</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>3</td>
					<td></td>
					<td>-2000.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-08-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('3')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>4</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-08-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('4')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>5</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-08-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('5')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>19</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('19')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>20</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('20')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>21</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('21')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>22</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('22')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>25</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-07-15 17:08:17 </td>
					<td><a href="javascript:del('25')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>18</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('18')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>17</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('17')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>8</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('8')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>9</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('9')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>10</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('10')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>11</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('11')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>12</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('12')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>13</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('13')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>15</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('15')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>16</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('16')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
								<tr class="uk-text-small">
					<td>14</td>
					<td></td>
					<td>-100.00</td>
					<td></td>
					<td>柯南你就是个死神 <br/> 2017-07-11 16:19:30</td>
					<td> 柯南你就是个死神
						 <br/> 2017-08-11 17:08:17 </td>
					<td><a href="javascript:del('14')"
						class="uk-text-small uk-text-primary">删除</a>
												</td>
				</tr>
				
			</tbody>
		</table>
		<div class="uk-margin uk-margin-bottom">&nbsp;</div>

		<div id="modal-record" class="uk-flex-top" uk-modal>
			<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
				<form class="uk-form-horizontal uk-margin-large">
					<input type="hidden" id="user_id" value='1'
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
