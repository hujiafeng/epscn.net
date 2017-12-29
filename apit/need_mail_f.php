<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * need_mail_f 服务商发送订单邮件接口
 * 参数
 * id:订单id
 * uid:用户id
 * mail:邮箱账号
 */
header ( 'Content-type: application/json' );
require 'config.php';
require 'common/mail.class.php';

$id = ( int ) $_POST['id'];
$uid = $_POST['uid'];
$mail = $_POST['mail'];
if(!$id && !$uid && !$mail)
	Errors::exitWithJson(20000);

$sql = "SELECT id,no,sb_number,status,over_time,city,address,fw_id,js_name,js_number,gw_number,miaoshu2,reward,get_reward,n_type,uid_x,biaoqian,lx_name,lx_number,
		(SELECT title FROM ".T('m_library')." WHERE id=".T('need').".kuanxing) AS kuanxing FROM ".T('need')." WHERE id = $id and uid_f = $uid ";
$res = $mysqli->query ( $sql );
if ($res) {
	$row = $res->fetch_assoc ();
	
	//查询服务方手机号和公司名称
	$sql_u = "SELECT mobile,company FROM ".T('user')." WHERE uid=$uid";
	$res_u = $mysqli->query($sql_u);
	$row_u = $res_u->fetch_row();
	
	//支付方式
	if($row["n_type"] == "2"){
		$row["n_type_name"] = "线下结算";
	}else{
		$row["n_type_name"] = $row["pay_mode"]."支付";
	}
	
	if(!$row["fw_id"])
		$row["fw_id"] = "EPS服务工程师";
	
	//订单状态
	$status = array("1"=>"技术评审中","2"=>"等待付款","3"=>"待技师指派","4"=>"待服务完成","5"=>"交易完成");
	$row['status_name'] = $status[$row['status']];
	
	// 获取技术评审图片
	$photo = "";
	$sql_photo = "SELECT large FROM ".T('photo')." WHERE n_id = $id AND flag=1 and type=3 order by type desc";
	$res2 = $mysqli->query ( $sql_photo );
	while ( $row2 = $res2->fetch_assoc () ) {
		$photo .= '<div style="width:800px; height:500px; float:left; text-align:center; margin:15px;"><img src="'.PHOTO_URL.$row2['large'].'" style="max-height:500px; max-width:800px;"></div>';
	}
}

function SendMail($address, $title, $message, $fromname = '常州元一象与网络科技有限公司')
{
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->AddAddress($address);
	$mail->Body = $message;
	$mail->From = 'report@epscn.net';
	$mail->FromName = $fromname;
	$mail->Subject = $title;
	$mail->Host = 'smtp.mxhichina.com';
	$mail->Port = 465;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Username = 'report@epscn.net';
	$mail->Password = 'Eps654321';
	$mail->IsHTML(true);
	return ($mail->Send());
}

$address = $mail;
$title = '[服务商]EPS订单'.$row["no"];

$message = '
		<div id="main-main" style="padding:40px 0;font-family:Microsoft YaHei;color:#3e3a39">
    <table style="width:680px;margin:0 auto;border-collapse:collapse; border:0px solid #eeeeee">
    	<tr>
            <td colspan="4"><img src="'.SITE_URL.'statics/images/eps240.png"><img src="'.SITE_URL.'statics/images/logo110.png" style="float:right"></td>
       	</tr>
		<tr style="height:10px;">
        </tr>
		<tr style="height:30px;border-collapse:collapse;border-top:1px solid #eee;">
            <td style="width:96px;">服务商：</td>
			<td colspan="3">'.$row_u[0].' / '.$row_u[1].'</td>
        </tr>
		<tr style="height:30px;">
            <td style="width:96px;">订单号：</td>
			<td>'.$row["no"].' / '.$row["n_type_name"].'</td>
            <td style="width:96px;">订单状态：</td>
			<td>'.$row["status_name"].'</td>
        </tr>
		<tr style="height:30px;">
            <td>设备款型：</td>
			<td>'.$row["kuanxing"].'</td>
            <td>任务类型：</td>
			<td>'.$row["biaoqian"].'</td>
        </tr>
		<tr style="height:30px;">
            <td>服务身份：</td>
			<td colspan="3">'.$row["fw_id"].'</td>
        </tr>
		<tr style="height:30px;">
            <td>服务地点：</td>
			<td colspan="3">'.$row["city"].$row["address"].'</td>
        </tr>
		<tr style="height:30px;">
            <td style="width:96px;">工作内容：</td>
			<td colspan="3"  style="width:600px;">'.$row["miaoshu2"].'<br>现场联系人：'.$row["lx_name"].$row["lx_number"].'</td>
        </tr>
		<tr style="height:30px;">
            <td>技师姓名：</td>
			<td>'.$row["js_name"].'</td>
            <td>技师电话：</td>
			<td>'.$row["js_number"].'</td>
        </tr>
					<tr style="height:30px;">
            <td>接洽专员：</td>
			<td>'.$row["gw_number"].'</td>
            <td>上门时间：</td>
			<td>'.$row["over_time"].'</td>
        </tr>
		<tr style="height:30px;">
			<td>服务酬劳：</td>
			<td>'.$row["get_reward"].'元</td>
            <td colspan="2">您已同意 服务协议（服务商）</td>
        </tr>
		<tr style="height:650px"></tr>
		<tr>
			<td colspan="4">'.$photo.'</td>
        </tr>
		</table></div>';

if (SendMail($address, $title, $message)){
	Errors::exitWithJson(0);
}else{
	Errors::exitWithJson(-1);
}

