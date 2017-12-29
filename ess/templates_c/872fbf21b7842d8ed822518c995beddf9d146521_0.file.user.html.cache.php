<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:42:39
  from "E:\www\eps\ess\templates\user.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0ca6f6eca80_55133679',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '872fbf21b7842d8ed822518c995beddf9d146521' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\user.html',
      1 => 1505803959,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:top.html' => 1,
    'file:header.html' => 1,
  ),
),false)) {
function content_59c0ca6f6eca80_55133679 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '3065159c0ca6f5bbf89_18282445';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户-电气销售家</title>
<link rel="stylesheet" href="css/common.css" />
<link rel="stylesheet" href="css/page.css" />
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
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
<?php echo '</script'; ?>
>
</head>
<body>
	<?php $_smarty_tpl->_subTemplateRender("file:top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<div class="uk-container">
		<?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


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
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'temp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['temp']->value) {
?>
				<tr class="uk-text-small">
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['user_id'];?>
</td>
					<td><img class="uk-preserve-width" src="<?php echo $_smarty_tpl->tpl_vars['temp']->value['avatar'];?>
"
						width="40"> <span class="uk-text-primary"><?php echo $_smarty_tpl->tpl_vars['temp']->value['fullname'];?>
</span>
					</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['mobile_phone'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['utype'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['gender'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['score_now'];?>
/<?php echo $_smarty_tpl->tpl_vars['temp']->value['score_total'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['reg_time'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['plat'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['temp']->value['uflag'] == 0) {?><span class="green">√</span><?php } else { ?>
						<span class="red">x</span><?php }?>
					</td>
					<td><a href="#set_utype" class="uk-text-small uk-text-primary"
						id="set_utype_<?php echo $_smarty_tpl->tpl_vars['temp']->value['user_id'];?>
_<?php echo $_smarty_tpl->tpl_vars['temp']->value['utype'];?>
" uk-toggle>设置用户类型</a>
						&nbsp;&nbsp;<a
						href="user.php?act=score_record&user_id=<?php echo $_smarty_tpl->tpl_vars['temp']->value['user_id'];?>
"
						class="uk-text-small uk-text-primary">积分与兑现</a> &nbsp;&nbsp; <a
						href="user.php?act=user_product&user_id=<?php echo $_smarty_tpl->tpl_vars['temp']->value['user_id'];?>
"
						class="uk-text-small uk-text-primary">设置产品结算价格</a></td>
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
