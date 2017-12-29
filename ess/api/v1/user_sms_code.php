<?php
/**
 * 发送手机验证码
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月24日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/API.class.php';
require '../common/DBC.class.php';
require '../common/number_string.inc.php';
require 'common/SmsDemo.php';

$_phone = $_POST ['phone'];



if (china_phone_num_check ( $_phone ) == 0) {
	API::exitWithJson ( API::E_PARAM_VALUE_ERROR );
}
$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();
if($mysqli){
	$sql = "SELECT user_id FROM se_user WHERE mobile_phone ='$_phone'";
	if($res =$mysqli->query($sql)){
		$row =  $res->fetch_assoc();
		if(!empty($row)){
			API::exitWithJson ( API::E_PHONE_EXIST );
		}
	}
}

$redis = RedisFactory::getRedisInstance ();

$PHONE_KEY = RedisFactory::redisKey ( "phone", $_phone );

if ($redis) {
	// 发送记述
	$ref_count = $redis->get ( $PHONE_KEY );
	if ($ref_count >= 5) {
		API::exitWithJson ( API::E_REQUEST_FREQUENTLY );
	}
}

$code = rand_string_only_number ( 6 );
$token = md5 ( APP_KEY . $_phone );

$demo = new SmsDemo(
		"LTAIIYg1pBYLlZL1",
		"y7Sg7piNpnU2afV1Ua2uHuXrjh0WG1"
);
$response = $demo->sendSms(
		"电气销售家", // 短信签名
		"SMS_83180087", // 短信模板编号
		$_phone, // 短信接收者
		Array(  // 短信模板中字段的值
				"code"=>$code,
				"product"=>"dsd"
		),
		"123"
);

if ($redis->exists ( $PHONE_KEY )) {
	$redis->incr ( $PHONE_KEY );
} else {
	$redis->setEx ( $PHONE_KEY, 3600 * 24, "1" );
}
API::exitWithJson ( API::E_OK, array (
'code' => $code,
'sms_token' => $token
) );

/* $msg = preg_replace ( '/<code>/', $code, SMS_TEMPLATE );
$str = SMS::MTSend ( $_phone, $msg );
if ($str == 0) { // 发送成功
                 //
	if ($redis->exists ( $PHONE_KEY )) {
		$redis->incr ( $PHONE_KEY );
	} else {
		$redis->setEx ( $PHONE_KEY, 3600 * 24, "1" );
	}
	
	API::exitWithJson ( API::E_OK, array (
			'code' => $code,
			'sms_token' => $token 
	) );
} else { // 发送失败
	API::exitWithJson ( API::E_SMS_ERROR, $str );
} */

