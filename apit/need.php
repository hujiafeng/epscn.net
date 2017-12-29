<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * need_del 订单删除接口
 * 参数
 * id:订单id
 * uid:用户uid
 */
header ( 'Content-type: application/json' );
require 'config.php';
require 'common/mail.class.php';

function SendMail($address, $title, $message, $fromname = '常州元一象与网络科技有限公司')
{
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->AddAddress($address);
	$mail->Body = $message;
	//$mail->From = 'cz_yyxy@163.com';
	$mail->From = 'report@epscn.net';
	$mail->FromName = $fromname;
	$mail->Subject = $title;
	//$mail->Host = 'smtp.163.com';
	$mail->Host = 'smtp.mxhichina.com';
	$mail->Port = 465;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Username = 'report@epscn.net';
	//$mail->Username = 'cz_yyxy';
	//$mail->Password = 'yyxy170630';
	//$mail->Password = 'yyxy888';
	$mail->Password = 'Eps654321';
	$mail->IsHTML(true);
	return ($mail->Send());
}

//$address = 'wangping01@vip.163.com';
//$address = '13813563135@163.com';
$address = '962538375@qq.com';
$title = 'EPS订单17102456132';

$message = '
		<div id="main-main" style="padding:40px 0;font-family:Microsoft YaHei;color:#3e3a39">
    <table style="width:680px;margin:0 auto;border-collapse:collapse; border:0px solid #eeeeee">
    	<tr>
            <td colspan="4"><img src="'.SITE_URL.'statics/images/eps240.png"><img src="'.SITE_URL.'statics/images/logo110.png" style="float:right"></td>
       	</tr>
		<tr style="height:10px;">
        </tr>
		<tr style="height:30px;border-collapse:collapse;border-top:1px solid #eee;">
            <td style="width:80px;">服务商：</td>
			<td colspan="3">13800000000 / 单位名称</td>
        </tr>
		<tr style="height:30px;">
            <td style="width:80px;">订单号：</td>
			<td>17102456132 / 线下结算</td>
            <td style="width:80px;">订单状态：</td>
			<td>待技师指派</td>
        </tr>
		<tr style="height:30px;">
            <td>设备款型：</td>
			<td>VBI机构断路器</td>
            <td>设备数量：</td>
			<td>88台</td>
        </tr>
		<tr style="height:30px;">
            <td>任务类型：</td>
			<td>安装</td>
            <td>服务身份：</td>
			<td>EPS服务工程师</td>
        </tr>
		<tr style="height:30px;">
            <td>服务地点：</td>
			<td colspan="3">武进区常武中路18号常州科教城创研港3号楼</td>
        </tr>
		<tr style="height:30px;">
            <td style="width:80px;">工作内容：</td>
			<td colspan="3"  style="width:600px;">武进区常武中路18号常研港3号进区常武中路18号常研港3号进区常武中路18号常研港3号进区常武中路18号常研港3号楼</td>
        </tr>
		<tr style="height:30px;">
            <td>接洽专员：</td>
			<td>15922222222</td>
            <td>上门时间：</td>
			<td>2017.10.22</td>
        </tr>
		<tr style="height:30px;">
			<td>服务酬劳：</td>
			<td>168元</td>
            <td colspan="2">您已同意 服务协议（服务商）</td>
        </tr>
		<tr style="height:30px;">
            <td colspan="4">任务内容图片</td>
        </tr>
		<tr>
			<td colspan="4">
			<div style="width:300px; height:300px; float:left; text-align:center; margin:15px;"><img src="'.SITE_URL.'statics/images/2.png" style="max-height:300px; max-width:300px;"></div>
			<div style="width:300px; height:300px; float:left; text-align:center; margin:15px;"><img src="'.SITE_URL.'statics/images/3.png" style="max-height:300px; max-width:300px;"></div>
			</td>
        </tr>
        </table>
    </div>

		';

if (SendMail($address, $title, $message)){
	Errors::exitWithJson(0);
}else{
	Errors::exitWithJson(-1);
}

