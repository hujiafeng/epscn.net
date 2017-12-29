<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_captcha 手机验证码接口
 * 参数
 * mobile：手机号
 * unlearn:忘记密码增加unlearn值为1
 * 返回值
 * captcha：验证码
 */
header ( 'Content-type: application/json' );
require 'config.php';
require 'common/SmsDemo.php';

// 获取参数
$mobile = "15755777975";//trim ( $_POST ['mobile'] );
if (!$mobile)
	Errors::exitWithJson (20000);

$sql = "SELECT uid FROM ".T('user')." WHERE mobile='$mobile'";
$res = $mysqli->query ( $sql );
// 未注册则发送短信验证码，忘记密码增加一个key值unlearn
$row = $res->fetch_assoc ();
if (!isset($row['uid']) || $_POST ['unlearn']) {
	$_SESSION ['captcha'] = rand ( 100000, 999999 ); // 验证码
	if($_POST ['unlearn']){
		$sms = "SMS_83180086";
	}else{
		$sms = "SMS_83180087";
	}
	$demo = new SmsDemo(
		"LTAIIYg1pBYLlZL1",
		"y7Sg7piNpnU2afV1Ua2uHuXrjh0WG1"
	);
	$response = $demo->sendSms(
			"EPS电气服务", // 短信签名
			"$sms", // 短信模板编号
			$mobile, // 短信接收者
			Array(  // 短信模板中字段的值
					"code"=>$_SESSION ['captcha'],
					"product"=>"dsd"
			),
			"123"
	);

	$arr_ret =array("captcha"=>(string)$_SESSION['captcha']);
	
	Errors::exitWithJson (0,$arr_ret);
} else
	Errors::exitWithJson ( 20003,$row); //手机号已被注册
