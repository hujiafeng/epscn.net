<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:48:01
  from "E:\www\eps\ess\templates\feedback.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0cbb18c5507_86996775',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd7b26ec2cad1c8395f3708cec952af1758c7bd04' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\feedback.html',
      1 => 1505803958,
      2 => 'file',
    ),
    '0a925040523a0ac5dcf123b8512936343c774fd6' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\top.html',
      1 => 1505803958,
      2 => 'file',
    ),
    '26ae1aee85cb6d9f2097548b3349283637b5c86c' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\header.html',
      1 => 1505803958,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 0,
),true)) {
function content_59c0cbb18c5507_86996775 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户反馈-电气销售家</title>
<link rel="stylesheet" href="css/common.css" />
<link rel="stylesheet" href="css/page.css" />
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
       系统管理员  &nbsp;  &nbsp; <a href="index.php?act=logout" >退出</a>  &nbsp;  &nbsp; 
    </div>
</div>
	<div class="uk-container">
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

				<li><a href="project.php"><span class="ft18">项目申报</span> <span class="uk-badge cnt">18</span>
				</a></li>  		<li><a href="product.php"><span class="ft18">产品</span></a></li>
				<li><a href="user.php"><span class="ft18">用户</span></a></li> 				<li class="uk-active"><a href="feedback.php"><span
				class="ft18">用户反馈</span></a></li> 
	</ul>
</div>

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
								<tr class="uk-text-small">
					<td>104</td>
					<td><img class="uk-preserve-width" src="img/avatar.png"
						width="40"> <span class="uk-text-primary">flowers</span>
					</td>
					<td width="30%" style="word-break : break-all;">提个建议，界面不美</td>
					<td></td>
					<td>1.0</td>
					<td>android</td>
					<td>2017-09-04 10:20:27</td>
				</tr>
								<tr class="uk-text-small">
					<td>103</td>
					<td><img class="uk-preserve-width" src="avatar/20170904122875065211_1.jpg"
						width="40"> <span class="uk-text-primary">柯南你就是个死神</span>
					</td>
					<td width="30%" style="word-break : break-all;">什么鬼</td>
					<td></td>
					<td>1.0</td>
					<td>android</td>
					<td>2017-08-29 17:14:42</td>
				</tr>
								<tr class="uk-text-small">
					<td>102</td>
					<td><img class="uk-preserve-width" src="avatar/20170904122875065211_1.jpg"
						width="40"> <span class="uk-text-primary">柯南你就是个死神</span>
					</td>
					<td width="30%" style="word-break : break-all;">android.support.v7.widget.AppCompatEditText{4250ce50 VFED..CL .F...... 48,436-1032,808 #7f0b0073 app:id/feedback}</td>
					<td></td>
					<td>1.0</td>
					<td>android</td>
					<td>2017-08-29 17:13:21</td>
				</tr>
								<tr class="uk-text-small">
					<td>101</td>
					<td><img class="uk-preserve-width" src="avatar/20170905145845352586_5.jpg"
						width="40"> <span class="uk-text-primary">洪星照我去战痘</span>
					</td>
					<td width="30%" style="word-break : break-all;">项目测试</td>
					<td></td>
					<td>1.0</td>
					<td>iphone</td>
					<td>2017-08-29 17:08:46</td>
				</tr>
								<tr class="uk-text-small">
					<td>100</td>
					<td><img class="uk-preserve-width" src="avatar/20170905145845352586_5.jpg"
						width="40"> <span class="uk-text-primary">洪星照我去战痘</span>
					</td>
					<td width="30%" style="word-break : break-all;">好回家看看
</td>
					<td></td>
					<td>1.0</td>
					<td>iphone</td>
					<td>2017-08-29 17:02:26</td>
				</tr>
								<tr class="uk-text-small">
					<td>99</td>
					<td><img class="uk-preserve-width" src="avatar/20170824114530978855_4.jpeg"
						width="40"> <span class="uk-text-primary">飞天狗狗的奇特之旅</span>
					</td>
					<td width="30%" style="word-break : break-all;">http://www.mecan.net/ess/report/project/18/69cc6acb7cacbbcdc1c51ab28b29038900fada95http://www.mecan.net/ess/report/project/18/69cc6acb7cacbbcdc1c51ab28b29038900fada95http://www.mecan.net/ess/report/project/18/69cc6acb7cacbbcdc1c51ab28b29038900fada95查看采购单</td>
					<td></td>
					<td>1.0</td>
					<td>iphone</td>
					<td>2017-08-28 14:20:23</td>
				</tr>
								<tr class="uk-text-small">
					<td>98</td>
					<td><img class="uk-preserve-width" src="avatar/20170904122875065211_1.jpg"
						width="40"> <span class="uk-text-primary">柯南你就是个死神</span>
					</td>
					<td width="30%" style="word-break : break-all;">提意见做了修改</td>
					<td></td>
					<td>1.0</td>
					<td>iphone</td>
					<td>2017-08-25 15:17:34</td>
				</tr>
								<tr class="uk-text-small">
					<td>97</td>
					<td><img class="uk-preserve-width" src="avatar/20170905145845352586_5.jpg"
						width="40"> <span class="uk-text-primary">洪星照我去战痘</span>
					</td>
					<td width="30%" style="word-break : break-all;">提意见测试</td>
					<td></td>
					<td>1.0</td>
					<td>iphone</td>
					<td>2017-08-24 22:33:22</td>
				</tr>
								<tr class="uk-text-small">
					<td>96</td>
					<td><img class="uk-preserve-width" src="avatar/20170905145845352586_5.jpg"
						width="40"> <span class="uk-text-primary">洪星照我去战痘</span>
					</td>
					<td width="30%" style="word-break : break-all;">用户反馈测试</td>
					<td></td>
					<td>1.0</td>
					<td>iphone</td>
					<td>2017-08-23 22:48:34</td>
				</tr>
								<tr class="uk-text-small">
					<td>95</td>
					<td><img class="uk-preserve-width" src="avatar/20170904122875065211_1.jpg"
						width="40"> <span class="uk-text-primary">柯南你就是个死神</span>
					</td>
					<td width="30%" style="word-break : break-all;">继续加油，期待更好！</td>
					<td></td>
					<td>1.0</td>
					<td>iphone</td>
					<td>2017-08-23 12:43:45</td>
				</tr>
								<tr class="uk-text-small">
					<td>94</td>
					<td><img class="uk-preserve-width" src="img/avatar.png"
						width="40"> <span class="uk-text-primary"></span>
					</td>
					<td width="30%" style="word-break : break-all;">叶落乌啼霜满天，叶落乌啼霜满天</td>
					<td></td>
					<td>1.0</td>
					<td>iphone</td>
					<td>2017-08-23 12:41:25</td>
				</tr>
								<tr class="uk-text-small">
					<td>93</td>
					<td><img class="uk-preserve-width" src="img/avatar.png"
						width="40"> <span class="uk-text-primary"></span>
					</td>
					<td width="30%" style="word-break : break-all;">好的，刚开始，开始疯狂模式</td>
					<td></td>
					<td>1.0</td>
					<td>iphone</td>
					<td>2017-08-17 15:03:19</td>
				</tr>
				
			</tbody>
		</table>

		<div class="uk-margin uk-margin-bottom">&nbsp;</div>
</body>
</html><?php }
}
