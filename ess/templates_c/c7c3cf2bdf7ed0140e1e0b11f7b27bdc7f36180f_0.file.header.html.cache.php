<?php
/* Smarty version 3.1.30, created on 2017-09-07 13:42:50
  from "/www/mecan.net/ess/templates/header.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b0dc5ad4bcb6_16748148',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c7c3cf2bdf7ed0140e1e0b11f7b27bdc7f36180f' => 
    array (
      0 => '/www/mecan.net/ess/templates/header.html',
      1 => 1504762965,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59b0dc5ad4bcb6_16748148 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '78661194359b0dc5ad3f7c0_59936148';
?>
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

		<?php if ($_smarty_tpl->tpl_vars['tab_name']->value == 'tab_project') {?>
		<li class="uk-active"><a href="project.php"><span
				class="ft18">项目申报</span> <?php if ($_smarty_tpl->tpl_vars['pending_cnt']->value > 0) {?> <span
				class="uk-badge cnt"><?php echo $_smarty_tpl->tpl_vars['pending_cnt']->value;?>
</span> <?php }?></a></li> <?php } else { ?>
		<li><a href="project.php"><span class="ft18">项目申报</span><?php if ($_smarty_tpl->tpl_vars['pending_cnt']->value > 0) {?> <span class="uk-badge cnt"><?php echo $_smarty_tpl->tpl_vars['pending_cnt']->value;?>
</span>
				<?php }?></a></li> <?php }?> <?php if ($_smarty_tpl->tpl_vars['tab_name']->value == 'tab_product') {?>
		<li class="uk-active"><a href="product.php"><span class="ft18">产品</span></a></li>
		<?php } else { ?>
		<li><a href="product.php"><span class="ft18">产品</span></a></li>
		<?php }
if ($_smarty_tpl->tpl_vars['tab_name']->value == 'tab_user') {?>
		<li class="uk-active"><a href="user.php"><span class="ft18">用户</span></a></li>
		<?php } else { ?>
		<li><a href="user.php"><span class="ft18">用户</span></a></li> <?php }?>
		<?php if ($_smarty_tpl->tpl_vars['tab_name']->value == 'tab_feedback') {?>
		<li class="uk-active"><a href="feedback.php"><span
				class="ft18">用户反馈</span></a></li> <?php } else { ?>
		<li><a href="feedback.php"><span class="ft18">用户反馈</span></a></li>
		<?php }?>

	</ul>
</div><?php }
}
