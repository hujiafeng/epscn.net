<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_logout 用户退出接口
 * 参数
 * uid：用户id
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST ['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$sql = "UPDATE ".T('user')." SET token='' WHERE uid=".$uid;
$mysqli->query($sql);

unset($_SESSION['user']);
session_destroy();

echo json_encode(array("code" => 0, "msg" =>"no error"));
