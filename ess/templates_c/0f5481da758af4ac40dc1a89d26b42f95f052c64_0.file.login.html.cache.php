<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:38:45
  from "E:\www\eps\ess\templates\login.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0c98578cd08_36495094',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0f5481da758af4ac40dc1a89d26b42f95f052c64' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\login.html',
      1 => 1505803959,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c0c98578cd08_36495094 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '314659c0c985717a07_98376246';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>登录-电气销售家</title>
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no" />
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<link rel="stylesheet" href="css/common.css" />
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
		$("#login").click(function() {
			var mobile = $("input[name='mobile']").val();
			var pwd = $("input[name='pwd']").val();
			if (mobile.length == 0 || pwd.length == 0) {
				alert("请填写手机和密码？");
			} else {
				$.post('index.php', {
					act : 'login',
					mobile : mobile,
					pwd : pwd
				}, function(data) {
					//alert(data);
					if (data == 1)
						setTimeout(function() {
							window.location.reload();
						}, 500);
					else
						alert(data);
				});
			}

		})
	})
<?php echo '</script'; ?>
>
</head>
<body>
	<div class="uk-container">
		<div class="login">
			<div class="uk-margin">
				<img src="img/sys_logo.png" width="290" height="63" />
			</div>
			<div class="uk-margin">
				<form>
					<div class="uk-margin">
						<div class="uk-inline">
							<span class="uk-form-icon" uk-icon="icon: user"></span> <input
								class="uk-input" type="text" placeholder="手机号码" name="mobile">
						</div>
					</div>

					<div class="uk-margin">
						<div class="uk-inline">
							<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
							<input class="uk-input" type="password" placeholder="登录密码"
								name="pwd">
						</div>
					</div>
				</form>
				<button class="uk-button uk-button-primary" id="login">登录</button>
			</div>
		</div>
	</div>
</body>
</html><?php }
}
