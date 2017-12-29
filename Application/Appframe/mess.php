<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title><?php echo 'lll';?></title>
<style type="text/css"> 
*{ padding:0; margin:0; font-size:12px}
a:link,a:visited{text-decoration:none;color:#0068a6}
a:hover,a:active{color:#ff6600;text-decoration: underline}
.showMsg{border: 1px solid #CDCDCD; zoom:1; width:350px; height:172px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px;background:#fff}
.showMsg h5{background-image: url(/st/images/msg_img/msg2.png);background-repeat: no-repeat; color:#666; padding-left:10px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
.showMsg .content{ padding:46px 12px 10px 45px; font-size:14px; height:64px; text-align:left}
.showMsg .bottom{ background:#EEEEEE; margin: 0 1px 1px 1px;line-height:26px; *line-height:30px; height:26px; text-align:center}
.showMsg .ok,.showMsg .guery{background: url(/st/images/msg_img/msg_bg.png) no-repeat 0px -560px;}
.showMsg .guery{background-position: left -560px;}

</style>
<script language="javascript" type="text/javascript" src="/st/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="/st/js/styleswitch.js"></script>
<script language="javascript" type="text/javascript" src="/st/js/admin_common.js"></script>

</head>
<body>
<div class="showMsg" style="text-align:center">
	<h5><?php echo '操作成功';?></h5>
    <div class="content guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;max-width:230px"><?php echo $msg?></div>
    <div class="bottom">
    <?php if($url_forward=='goback' || $url_forward=='') {?>
	<a href="javascript:history.back();" >[<?php echo L('return_previous');?>]</a>
    <script language="javascript">setTimeout("redirect('javascript:history.back();');",<?php echo $ms?>);</script> 
	<?php } elseif($url_forward=="close") {?>
	<input type="button" name="close" value="<?php echo 'close';?> " onClick="window.close();">
	<?php } elseif($url_forward=="blank") {?>
	
	<?php } elseif($url_forward) { 
		
	?>
	<a href="<?php echo $url_forward?>"><?php echo '如果您的浏览器没有自动跳转，请点击这里 ';?></a>
	<script language="javascript">setTimeout("redirect('<?php echo $url_forward?>');",<?php echo $ms?>);</script> 
	<?php }?>
	<?php if($returnjs) { ?> <script style="text/javascript"><?php echo $returnjs;?></script><?php } ?>
	<?php if ($dialog):?><script style="text/javascript">window.top.right.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();</script><?php endif;?>
        </div>
</div>
<script style="text/javascript">
	function close_dialog() {
		window.top.right.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();
	}
</script>

</body>
</html>

