<?php
/* Smarty version 3.1.30, created on 2017-09-06 14:04:15
  from "/www/mecan.net/ess/templates/project_score_record.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59af8fdf7d6920_54298730',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d91f113bf5965c0ae8f85f17536aeb4de5b2719' => 
    array (
      0 => '/www/mecan.net/ess/templates/project_score_record.html',
      1 => 1504677827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:top.html' => 1,
    'file:header.html' => 1,
  ),
),false)) {
function content_59af8fdf7d6920_54298730 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '97744275559af8fdf7a0864_60152143';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>项目产品采购记录-电气销售家</title>
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
			<?php echo $_smarty_tpl->tpl_vars['project_name']->value;?>
 <span class="uk-text-large">实际采购记录</span>  &nbsp;&nbsp; <span style="float: right;"><a class="uk-text-small uk-link-muted"
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
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'temp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['temp']->value) {
?>
				<tr class="uk-text-small">
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['record_id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['products'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['purchase_num'];
echo $_smarty_tpl->tpl_vars['temp']->value['unit'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['act_uname'];?>
 &nbsp;&nbsp; <?php echo $_smarty_tpl->tpl_vars['temp']->value['act_time'];?>
</td>
					<td><?php if (!empty($_smarty_tpl->tpl_vars['temp']->value['del_uid'])) {?> <?php echo $_smarty_tpl->tpl_vars['temp']->value['del_uname'];?>

						&nbsp;&nbsp; <?php echo $_smarty_tpl->tpl_vars['temp']->value['del_time'];?>
 <?php }?></td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['score'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['temp']->value['flag'] == 0) {?> <a
						href="javascript:del('<?php echo $_smarty_tpl->tpl_vars['temp']->value['record_id'];?>
')"
						class="uk-text-small uk-text-primary">删除</a> <?php } else { ?> <span
						class="uk-text-small uk-text-danger">已删除</span> <?php }?>
					</td>
				</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</tbody>
		</table>

		<div id="modal-record" class="uk-modal-container" uk-modal>
			<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h2 class="uk-modal-title">添加采购记录</h2>
				<form class="uk-form-horizontal uk-margin-large">
					<input type="hidden" id="project_id" value='<?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
'
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
