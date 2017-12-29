<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_unlearn_pwd 忘记密码提交接口
 * 参数
 * mobile:手机号
 * new_pw:新密码
 * captcha:手机验证码
 */
header ( 'Content-type: application/json' );
require 'config.php';

$mobile  = $_POST ['mobile'];
$new_pwd = $_POST ['new_pw'];
$captcha = $_POST ['captcha'];
if ($captcha != $_SESSION ['captcha'])
	Errors::exitWithJson ( 20004 ,array("captcha"=>$_SESSION['captcha']));

$sql = "SELECT uid FROM " . T ( 'user' ) . " WHERE mobile='$mobile' ";
$res = $mysqli->query ( $sql );
$row = $res->fetch_assoc ();
if ($row ['uid']) {
	$new_pwd = md5 ( $new_pwd );
	$sql_u = "UPDATE ".T('user')." SET passwd='$new_pwd' WHERE uid=".$row ['uid'];
	$res_u = $mysqli->query ( $sql_u );
	if ($res_u) {
		Errors::exitWithJson ( 0 );
	} else {
		Errors::exitWithJson ( 1 );
	}
} else
	Errors::exitWithJson ( 20011 );