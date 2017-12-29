<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:41:43
  from "E:\www\eps\ess\templates\project.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0ca3729b303_14918772',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0ca83678e1e65bc5dafb3f42988d8eac6e9a119f' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\project.html',
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
function content_59c0ca3729b303_14918772 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '2931659c0ca3712c001_05371407';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>项目-电气销售家</title>
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
<style type="text/css">
</style>
<?php echo '<script'; ?>
>
	function search_project(o_status) {
		$("input[name='o_status']").val(o_status);
		$("form[name='schForm']").submit();
	}
	$(
			function() {
				$("[id^='check_project_']").click(
						function() {
							$("#project_id").val('0');
							$("input[name='refuse_reason']").val('');
							$("input[name='project_status']:eq(0)").attr(
									"checked", 'checked');
							var _data = $(this).attr('id');
							var project_id = _data.split("_")[2];
							$("#project_id").val(project_id);

						});

				$("#save_check")
						.click(
								function() {
									var project_status = $(
											"input[name='project_status']:checked")
											.val();
									var refuse_reason = $(
											"input[name='refuse_reason']")
											.val();
									var project_id = $("#project_id").val();
									if (project_status == 'REFUSED'
											&& refuse_reason.length == 0) {
										alert("请注明不通过的理由！");
									} else {
										$.post('project.php', {
											act : 'check',
											project_id : project_id,
											project_status : project_status,
											refuse_reason : refuse_reason
										}, function(data) {
											//alert(data);
											if (data == 1)
												setTimeout(function() {
													window.location.reload();
												}, 500);
											else
												alert("审核失败！");
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
			})
<?php echo '</script'; ?>
>
</head>
<body>
	<?php $_smarty_tpl->_subTemplateRender("file:top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<div class="uk-container">
		<?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<form class="uk-search uk-search-default" name="schForm"
			style="width: 400px;">
			<span uk-search-icon></span> <input
				class="uk-search-input uk-text-small" type="search"
				placeholder="项目名称、编号..." name="kw" value="<?php echo $_smarty_tpl->tpl_vars['kw']->value;?>
"
				style="width: 400px;"> <input type="hidden" name="o_status"
				value='ALL' />
		</form>

		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['project_status_arr']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?> <?php if ($_smarty_tpl->tpl_vars['o_status']->value == $_smarty_tpl->tpl_vars['k']->value) {?>
		<button class="uk-button uk-button-primary"
			onClick="search_project('<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['val']->value[0];?>
</button>
		<?php } else { ?>
		<button class="uk-button uk-button-default"
			onClick="search_project('<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['val']->value[0];?>
</button>
		<?php }?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


		<table class="uk-table uk-table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>项目编号、名称</th>
					<th>采购方</th>
					<th>项目状态</th>
					<th>申报人</th>
					<th>审核人</th>
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
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['project_id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['project_no'];?>
<br /><?php echo $_smarty_tpl->tpl_vars['temp']->value['name'];?>

					</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['purchaser'];?>
</td>
					<td style="color:<?php echo $_smarty_tpl->tpl_vars['project_status_arr']->value[$_smarty_tpl->tpl_vars['temp']->value['project_status']][1];?>
"><?php echo $_smarty_tpl->tpl_vars['project_status_arr']->value[$_smarty_tpl->tpl_vars['temp']->value['project_status']][0];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['create_uname'];?>
<br/><?php echo $_smarty_tpl->tpl_vars['temp']->value['create_time'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['check_uname'];?>
<br/><?php echo $_smarty_tpl->tpl_vars['temp']->value['check_time'];?>
</td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_<?php echo $_smarty_tpl->tpl_vars['temp']->value['project_id'];?>
">详情</a>&nbsp;&nbsp; <?php if ($_smarty_tpl->tpl_vars['temp']->value['project_status'] == 'PENDING') {?><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="check_project_<?php echo $_smarty_tpl->tpl_vars['temp']->value['project_id'];?>
" uk-toggle>审核</a>
						&nbsp;&nbsp;<?php }?> 
						<?php if ($_smarty_tpl->tpl_vars['temp']->value['project_status'] != 'PENDING' && $_smarty_tpl->tpl_vars['temp']->value['project_status'] != 'DRAFT') {?><a
						href="project_product.php?act=purchase_record&project_id=<?php echo $_smarty_tpl->tpl_vars['temp']->value['project_id'];?>
"
						class="uk-text-small uk-text-primary">采购记录</a>
						<?php }?></td>
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
		<!-- 详情 -->
		<div id="modal-detail" uk-modal>
			<div class="uk-modal-dialog">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<div class="uk-modal-header">
					<h2>项目详情</h2>
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
	<!-- 审核 -->
	<div id="modal-center" class="uk-flex-top" uk-modal>
		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
			<form class="uk-form-horizontal uk-margin-large">
				<input type="hidden" id="project_id" value='0'>
				<div class="uk-margin">
					<div class="uk-form-label">项目审核：</div>
					<div class="uk-form-controls">
						<p>
							<input class="uk-radio" type="radio" name="project_status"
								checked value="TRACKING"> <span class="uk-text-small">通过</span>
						</p>
						<label><input class="uk-radio" type="radio"
							name="project_status" value="REFUSED"> <span
							class="uk-text-small">不通过</span></label>
						<p class="uk-margin-small">
							<input class="uk-input uk-form-width-larger uk-form-small"
								type="text" placeholder="不通过的理由..." name="refuse_reason" />
						</p>
					</div>
				</div>
				<p class="uk-text-right">
					<button class="uk-button uk-button-default uk-modal-close"
						type="button">取消</button>
					<button class="uk-button uk-button-primary" type="button"
						id="save_check">确定</button>
				</p>
			</form>
		</div>
	</div>
	</div>


</body>
</html><?php }
}
