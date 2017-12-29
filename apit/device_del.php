<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * device_del 设备删除接口
 * 参数
 * gid:设备id
 */
header ( 'Content-type: application/json' );
require 'config.php';

$gid = $_POST['gid'];
if (!$gid)
	Errors::exitWithJson (20000);

//删除设备
$sql = "DELETE from ".T('device_goods' )." WHERE gid = $gid";
$res = $mysqli->query ( $sql );
if ($res) {
	
	//删除之前图片
	$sql_p = "DELETE from ".T('device_photo' )." WHERE gid = $gid";
	$mysqli->query ( $sql_p );
	
	Errors::exitWithJson (0);
} else {
	Errors::exitWithJson (-1);
}

