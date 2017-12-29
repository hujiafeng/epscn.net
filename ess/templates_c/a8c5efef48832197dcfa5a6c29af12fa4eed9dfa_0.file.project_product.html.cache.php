<?php
/* Smarty version 3.1.30, created on 2017-08-21 13:43:50
  from "/www/mecan.net/ess/templates/project_product.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_599a73167c1b97_14656731',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a8c5efef48832197dcfa5a6c29af12fa4eed9dfa' => 
    array (
      0 => '/www/mecan.net/ess/templates/project_product.html',
      1 => 1503044262,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:top.html' => 1,
    'file:header.html' => 1,
  ),
),false)) {
function content_599a73167c1b97_14656731 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '1475179609599a7316793c12_63529753';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>项目产品-电气销售家</title>
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
</head>
<body>
	<?php $_smarty_tpl->_subTemplateRender("file:top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<div class="uk-container">
		<?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<h5><?php echo $_smarty_tpl->tpl_vars['pj_name']->value;?>
 项目产品</h5>
		<table class="uk-table uk-table-striped">
			<thead>
				<tr>
					<th>产品ID</th>
					<th>品牌</th>
					<th>类别</th>
					<th>型号</th>
					<th>规格</th>
					<th>计量单位</th>
					<th>采购价</th>
					<th>结算价</th>
					<th>采购数量</th>
					<th>结算数量</th>
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
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['product_id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['brand_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['category_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['model_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['specification'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['measure_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['purchase_price'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['last_price'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['purchase_num'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['last_num'];?>
</td>
					<td><a
						href="project_product.php?act=purchase_record&pp_id=<?php echo $_smarty_tpl->tpl_vars['temp']->value['pp_id'];?>
"
						class="uk-text-small uk-text-primary">采购记录</a></td>
				</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</tbody>
		</table>
	</div>
</body>
</html><?php }
}
