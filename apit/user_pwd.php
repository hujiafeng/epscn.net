<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_pwd 修改密码接口
 * 参数
 * uid：用户id
 * old_pw:老密码
 * new_pw:新密码
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST ['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$old_pwd = $_POST ['old_pw'];
$new_pwd = $_POST ['new_pw'];

$sql = "SELECT passwd FROM " . T ( 'user' ) . " WHERE uid='$uid' ";
$res = $mysqli->query ( $sql );
$row = $res->fetch_assoc ();
if (md5 ( $old_pwd ) == $row ['passwd']) {
	$new_pwd = md5 ( $new_pwd );
	$sql = "UPDATE ".T('user')." SET passwd='$new_pwd' WHERE uid='$uid'";
	$res = $mysqli->query ( $sql );
	if ($res) {
		Errors::exitWithJson ( 0 );
	} else {
		Errors::exitWithJson ( 1 );
	}
} else
	Errors::exitWithJson ( 20008 );