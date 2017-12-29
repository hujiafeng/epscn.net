<?php
/* Smarty version 3.1.30, created on 2017-08-21 13:43:58
  from "/www/mecan.net/ess/templates/project_product.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_599a731ea172b3_76231566',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a8c5efef48832197dcfa5a6c29af12fa4eed9dfa' => 
    array (
      0 => '/www/mecan.net/ess/templates/project_product.html',
      1 => 1503044262,
      2 => 'file',
    ),
    'dc29824e50dfd381aae9e28adf117303e9a9ea3c' => 
    array (
      0 => '/www/mecan.net/ess/templates/top.html',
      1 => 1503044262,
      2 => 'file',
    ),
    'c7c3cf2bdf7ed0140e1e0b11f7b27bdc7f36180f' => 
    array (
      0 => '/www/mecan.net/ess/templates/header.html',
      1 => 1503045310,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 0,
),true)) {
function content_599a731ea172b3_76231566 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>项目产品-电气销售家</title>
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<script src="jquery/jquery-1.7.2.min.js"></script>
<script src="uikit/js/uikit.min.js"></script>
<script src="uikit/js/uikit-icons.min.js"></script>
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
       飞天牛  &nbsp;  &nbsp; <a href="index.php?act=logout" >退出</a>  &nbsp;  &nbsp; 
    </div>
</div>
	<div class="uk-container">
		<div class="uk-margin-medium-top">
	<ul class="uk-flex-center " uk-tab>
				<li><a href="index.php"><span class="">产品</span></a></li> 				<li class="uk-active"><a href="project.php"><span class="">项目申报</span></a></li>
						<li><a href="user.php"><span class="">用户</span></a></li>
			</ul>
</div>
		<h5>我的项目申报20002 项目产品</h5>
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
				
			</tbody>
		</table>
	</div>
</body>
</html><?php }
}
