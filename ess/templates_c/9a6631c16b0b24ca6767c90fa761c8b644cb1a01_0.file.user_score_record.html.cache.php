<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:46:29
  from "E:\www\eps\ess\templates\user_score_record.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0cb550c6707_09266698',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9a6631c16b0b24ca6767c90fa761c8b644cb1a01' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\user_score_record.html',
      1 => 1505803958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:top.html' => 1,
    'file:header.html' => 1,
  ),
),false)) {
function content_59c0cb550c6707_09266698 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '1849559c0cb54e37d86_86219362';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户积分明细-电气销售家</title>
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<link rel="stylesheet" href="css/page.css" />
<?php echo '<script'; ?>
 src="jquery/jquery-1.7.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="uikit/js/uikit.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="uikit/js/uikit-icons.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>
</head>
<body>
	<?php $_smarty_tpl->_subTemplateRender("file:top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<div class="uk-container">
		<?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<h2>
			<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
积分明细<span style="font-size:16px;color:#999">&nbsp;&nbsp; ( 当前积分：<?php echo $_smarty_tpl->tpl_vars['score_now']->value;?>
 )</span> <span style="float: right;"><a class="uk-text-small uk-link-muted"
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
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'temp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['temp']->value) {
?>
				<tr class="uk-text-small">
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['record_id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['get_score'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['redeem_score'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['products'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['act_uname'];?>
 <br/> <?php echo $_smarty_tpl->tpl_vars['temp']->value['act_time'];?>
</td>
					<td><?php if (!empty($_smarty_tpl->tpl_vars['temp']->value['del_uid'])) {?> <?php echo $_smarty_tpl->tpl_vars['temp']->value['del_uname'];?>

						 <br/> <?php echo $_smarty_tpl->tpl_vars['temp']->value['del_time'];?>
 <?php }?></td>
					<td><a href="javascript:del('<?php echo $_smarty_tpl->tpl_vars['temp']->value['record_id'];?>
')"
						class="uk-text-small uk-text-primary">删除</a>
						<?php if ($_smarty_tpl->tpl_vars['temp']->value['get_score']) {?>&nbsp;&nbsp;
						<a href="#modal-detail" id="view_detail_<?php echo $_smarty_tpl->tpl_vars['temp']->value['project_id'];?>
"
						class="uk-text-small uk-text-primary" uk-toggle>项目信息</a>
						<?php }?>
						</td>
				</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</tbody>
		</table>
		<div class="uk-margin uk-margin-bottom"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</div>

		<div id="modal-record" class="uk-flex-top" uk-modal>
			<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
				<form class="uk-form-horizontal uk-margin-large">
					<input type="hidden" id="user_id" value='<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
'
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
