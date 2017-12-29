<?php
  /**
 	*@author wsshh1314@outlook.com
  	*@version	1.0
 	*@abstract 2015年7月3日
	*@since  Version 1.0
	*/
header("Content-type:text/html;charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>应用下载</title>
<style>
table{border-collapse:collapse;border:1px solid #ccc;width:100%;font-size:17px;}
td {border:1px solid #ccc;padding:8px;}
th{padding:15px;font-size:20px;background-color:#e8e8e8;text-align:left;}

.pure-button {
    /* Structure */
    display: inline-block;
    zoom: 1;
    line-height: normal;
    white-space: nowrap;
    vertical-align: middle;
    text-align: center;
    cursor: pointer;
    -webkit-user-drag: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

/* Firefox: Get rid of the inner focus border */
.pure-button::-moz-focus-inner {
    padding: 0;
    border: 0;
}

/*csslint outline-none:false*/

.pure-button {
    font-family: inherit;
    font-size: 100%;
    padding: 0.5em 1em;
    color: #444; /* rgba not supported (IE 8) */
    color: rgba(0, 0, 0, 0.80); /* rgba supported */
    border: 1px solid #999;  /*IE 6/7/8*/
    border: none rgba(0, 0, 0, 0);  /*IE9 + everything else*/
    background-color: #E6E6E6;
    text-decoration: none;
    border-radius: 2px;
}

.pure-button-hover,
.pure-button:hover,
.pure-button:focus {
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#1a000000',GradientType=0);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(transparent), color-stop(40%, rgba(0,0,0, 0.05)), to(rgba(0,0,0, 0.10)));
    background-image: -webkit-linear-gradient(transparent, rgba(0,0,0, 0.05) 40%, rgba(0,0,0, 0.10));
    background-image: -moz-linear-gradient(top, rgba(0,0,0, 0.05) 0%, rgba(0,0,0, 0.10));
    background-image: -o-linear-gradient(transparent, rgba(0,0,0, 0.05) 40%, rgba(0,0,0, 0.10));
    background-image: linear-gradient(transparent, rgba(0,0,0, 0.05) 40%, rgba(0,0,0, 0.10));
}
.pure-button:focus {
    outline: 0;
}
.pure-button-active,
.pure-button:active {
    box-shadow: 0 0 0 1px rgba(0,0,0, 0.15) inset, 0 0 6px rgba(0,0,0, 0.20) inset;
    border-color: #000\9;
}

.pure-button[disabled],
.pure-button-disabled,
.pure-button-disabled:hover,
.pure-button-disabled:focus,
.pure-button-disabled:active {
    border: none;
    background-image: none;
    filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
    filter: alpha(opacity=40);
    -khtml-opacity: 0.40;
    -moz-opacity: 0.40;
    opacity: 0.40;
    cursor: not-allowed;
    box-shadow: none;
}

.pure-button-hidden {
    display: none;
}

/* Firefox: Get rid of the inner focus border */
.pure-button::-moz-focus-inner{
    padding: 0;
    border: 0;
}

.pure-button-primary,
.pure-button-selected,
a.pure-button-primary,
a.pure-button-selected {
    background-color: rgb(0, 120, 231);
    color: #fff;
}

.alert{color:#c33;padding:6px 0px;font-size:15px;font-weight:bold};
.bottom{position: absolute;bottom:10px;left:20px;}
</style>
</head>
<body>

	<table class="pure-table pure-table-bordered">
		<thead>
			<tr>
				<th>&nbsp;&nbsp;&nbsp;</th>
				<th>电气销售家</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>应&nbsp;&nbsp;用</td>
				<td><img src="120.png"
					style="width: 60px; width: 60px; border: 1px solid #f8f8f8; border-radius: 12px;" /></td>

			</tr>
			<tr>
				<td>安装要求及注意</td>
				<td>iPad 或iPhone 均可安装 ,但 确保iOS系统版本为8.0及以上系统 <br/><br/>
				<span class="alert">注意：<br/>如果iOS系统为9.0及以上版本，应用安装后,请到手机的“设置”=>“通用”=>“描述文件”或者“设备管理” 点击信任相关的企业级应用，否则程序安装后不可运行
				<br/><br/>若是微信里打开本页面，请换用Safari浏览器打开，点击才可安装</span>
				<br/><br/>
				</td>

			</tr>

			<tr>
				<td>版本</td>
				<td>1.0( 测试版)</td>

			</tr>

			<tr>
				<td>安&nbsp;&nbsp;装</td>
				<td><a class="pure-button pure-button-primary"
					href="itms-services://?action=download-manifest&url=https://dn-mecan.qbox.me/ess_v1.0_a5.plist">
						点击安装</a></td>

			</tr>
		</tbody>
	</table>
	<div class="bottom">

		<div class="pure-u-1-1" style="bottom:0px;padding:30px 2px 10px 2px;text-align:center;color:#666;font-size:14px">
			<p>&copy;<?php echo date('Y');?> mecan.net</p>
		</div>
	</div>

</body>
</html>