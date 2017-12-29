<?php
/* Smarty version 3.1.30, created on 2017-09-05 17:53:55
  from "/www/mecan.net/ess/templates/qbcode.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59ae743302fb08_07325828',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd2b65fef1451fe9857c2e357d98d278f611069f6' => 
    array (
      0 => '/www/mecan.net/ess/templates/qbcode.html',
      1 => 1504604893,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59ae743302fb08_07325828 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '95325957259ae7433015cd5_41631995';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>电气销售家-下载APP</title>
<?php echo '<script'; ?>
>
    var redirect = false;
    var ua = navigator.userAgent.toLowerCase();
	var iphone = ( ua.match(/(iphone|ipod)/g) ? true : false );
	var ipad = ( ua.match(/ipad/g) ? true : false );
    var weixin = ( ( ua.match(/MicroMessenger/i)=="micromessenger" ) ? true : false );
    var applink, url;
    if ( weixin ) {
           
			if ( iphone ){
				document.getElementById('jump').style.display = 'block';
			} else if ( ipad ){
				document.getElementById('jump1').style.display = 'block';
			    document.getElementById('jump').style.display = 'none';
			}
			else {
				document.getElementById('jump').style.display = 'block';
			}
    } else {
        if ( iphone ) {
            applink = 'http://www.mecan.net/ess/app/';
        } else if ( ipad ){
			applink = '';
		}else {
            applink = 'http://www.mecan.net/ess/Android_app/Ess.apk';
        }

        if ( window.location.hash !== "#no-refresh" ) { // avoid loop
            // 尝试跳转 App, iOS 和 Android 的跳法不一样
            //iOS ?  window.location = url : ""; // window.open(url);

            // 跳转下载
            window.setTimeout(function() {
                redirect = true;
                window.location = applink;
            }, 150);

           /* window.setTimeout(function() {
                if (redirect) {
                    window.location.href = window.location.href + '#no-refresh';
                    window.location.reload();
                }
            }, 1500);*/

        }
    }
<?php echo '</script'; ?>
>
</head>
<body>

</body>
</html><?php }
}
