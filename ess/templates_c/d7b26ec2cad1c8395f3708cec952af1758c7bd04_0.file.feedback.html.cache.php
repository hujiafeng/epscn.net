<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:42:57
  from "E:\www\eps\ess\templates\feedback.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0ca81084087_45631895',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd7b26ec2cad1c8395f3708cec952af1758c7bd04' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\feedback.html',
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
function content_59c0ca81084087_45631895 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '943259c0ca80ef7409_96625878';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户反馈-电气销售家</title>
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
				placeholder="反馈信息.." name="kw"  style="width:400px;"/>
		</form>

		<table class="uk-table uk-table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>用户名</th>
					<th>反馈信息</th>
					<th>联系方式</th>
					<th>版本号</th>
					<th>设备类型</th>
					<th>提交时间</th>
				</tr>
			</thead>
			<tbody>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'temp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['temp']->value) {
?>
				<tr class="uk-text-small">
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['id'];?>
</td>
					<td><img class="uk-preserve-width" src="<?php echo $_smarty_tpl->tpl_vars['temp']->value['avatar'];?>
"
						width="40"> <span class="uk-text-primary"><?php echo $_smarty_tpl->tpl_vars['temp']->value['uname'];?>
</span>
					</td>
					<td width="30%" style="word-break : break-all;"><?php echo $_smarty_tpl->tpl_vars['temp']->value['info'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['contact'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['version'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['app_type'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['submit_time'];?>
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
</body>
</html><?php }
}
