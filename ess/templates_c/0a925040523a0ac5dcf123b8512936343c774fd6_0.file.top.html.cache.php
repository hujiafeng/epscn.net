<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:41:43
  from "E:\www\eps\ess\templates\top.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0ca37320003_78842927',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0a925040523a0ac5dcf123b8512936343c774fd6' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\top.html',
      1 => 1505803958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c0ca37320003_78842927 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '1086159c0ca37314486_90171571';
?>
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
       <?php echo $_smarty_tpl->tpl_vars['sysuname']->value;?>
  &nbsp;  &nbsp; <a href="index.php?act=logout" >退出</a>  &nbsp;  &nbsp; 
    </div>
</div><?php }
}
