<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_token 获取用户token接口
 * 参数
 * uid：用户id
 * token：token
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST ['uid'];
$token = $_POST ['token'];
if (!$uid)
	Errors::exitWithJson (10000);

$sql = "UPDATE ".T('user')." SET token='$token' WHERE uid=".$uid;
$res = $mysqli->query($sql);
if ($res) {
	Errors::exitWithJson ( 0 );
} else {
	Errors::exitWithJson ( 1 );
}