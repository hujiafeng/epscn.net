<?php if (!defined('THINK_PATH')) exit(); defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo CHARSET?>">
<head>
<title>后台管理系统</title>

<meta name="viewport" content="width=device-width">
<link href="/st/login/css/base.css" rel="stylesheet" type="text/css">
<link href="/st/login/css/login.css" rel="stylesheet" type="text/css">
<style>
.yzm{position:absolute; background:url(/statics/images/admin_img/login_ts140x89.gif) no-repeat; width:140px; height:89px;right:70px;top:-96px; text-align:center; font-size:12px; display:none;}

.yzm a:link,.yzm a:visited{color:#036;text-decoration:none;}
.yzm a:hover{color:#C30;}
.yzm img{cursor:pointer; margin:4px auto 7px; width:130px; height:50px; border:1px solid #fff;}
</style>
</head>
<body>



<div class="login">
<form action="<?php echo U('Public/tologin');?>" method="post" name="myform" id="form" >
	<div class="logo"></div>
    <div class="login_form">
    	<div class="user">

            <input type="input" id="username" class="text_value" name="username" onfocus="this.value='';" value="用户名"  autofocus />

            <input type="password" id="password" class="text_value" name="password" onfocus="this.value='';" value="密码">
          <input name="code" type="text" class="text_value" onfocus="document.getElementById('yzm').style.display='block';this.value='';" value="验证码" />
        
    <div id="yzm" class="yzm"><img id='code_img' onclick='this.src=this.src+"&"+Math.random()' src='/api.php?op=checkcode&code_len=4&font_size=20&width=130&height=50&font_color=&background='><br /><a href="javascript:document.getElementById('code_img').src='/api.php?op=checkcode&m=admin&c=index&a=checkcode&time='+Math.random();void(0);">单击更换验证码</a></div>
       
        </div>
        <button class="button" id="button_login" type="submit">登录</button>
    </div>
    
    <div id="tip"></div>
    <div class="foot">
	<?php echo ($Site["copyright"]); ?>
    </div>
    </form>
</div>

</body>
</html>