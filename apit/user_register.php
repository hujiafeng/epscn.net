<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_register 用户注册接口
 * 参数
 * captcha:手机验证码
 * mobile:手机号
 * password:密码
 * 返回值
 * uid：用户id
 */
header ( 'Content-type: application/json' );
require 'config.php';

//验证码是否正确
$mobile = trim ( $_POST ['mobile'] );
$password = trim ( $_POST ['password'] );
$captcha = $_POST ['captcha'];
if ($captcha != $_SESSION ['captcha'])
	Errors::exitWithJson ( 20004 ,array("captcha"=>$_SESSION['captcha']));

$sql = "SELECT uid FROM ".T('user')." WHERE mobile ='$mobile' ";
$res = $mysqli->query ( $sql );
$row = $res->fetch_assoc ();
if (!isset($row['uid'])) {
	$password = md5 ( $password );
	$sql = "INSERT INTO " . T ( 'user' ) . " SET mobile='$mobile',passwd='$password',reg_time = NOW(),last_time = NOW() ";
	$_res =$mysqli->query ( $sql );
	$user_id = $mysqli->insert_id;
	$data = array (
			'uid' => ( string ) $user_id
	);
	Errors::exitWithJson ( 0, $data );
} else {
	Errors::exitWithJson ( 20003,$sql );
}
