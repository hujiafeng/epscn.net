<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * group_add 添加分组接口
 * 参数
 * uid：用户id
 * title:分组名称
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$title = $_POST['title'];


$sql = "SELECT id FROM ".T('device')." WHERE uid=$uid and title ='$title' ";
$res = $mysqli->query ( $sql );
$row = $res->fetch_assoc ();
if (!isset($row['id'])) {
	//添加分组
	$sql = "INSERT INTO ".T('device' )." SET uid='$uid',title='$title'";
	$res = $mysqli->query ( $sql );
	if ($res) {
		Errors::exitWithJson (0);
	} else {
		Errors::exitWithJson (-1);
	}
} else {
	Errors::exitWithJson ( 30001 );
}