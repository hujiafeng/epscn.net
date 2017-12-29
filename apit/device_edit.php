<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * device_edit 设备修改接口
 * 参数
 * gid:设备id
 * uid：用户id
 * did:分组id
 * name:设备名称
 * type:产品型号
 * modename:制造厂商
 * modeyear:制造年月
 * number:产品型号
 * voltage:额定电压
 * current:额定电流
 * short_current:额定短路开断电流
 * 返回值
 * gid:设备id
 */
header ( 'Content-type: application/json' );
require 'config.php';

$gid = $_POST['gid'];
$uid = $_POST['uid'];
$did = $_POST['did'];
if (!$gid || !$uid || !$did)
	Errors::exitWithJson (20000);

$name          = $_POST['name'];
$type          = $_POST['type'];
$modename      = $_POST['modename'];
$modeyear      = $_POST['modeyear'];
$number        = $_POST['number'];
$voltage       = $_POST['voltage'];
$current       = $_POST['current'];
$short_current = $_POST['short_current'];

//修改设备
$sql = "UPDATE ".T('device_goods')." SET did='$did',name='$name',type='$type',modename='$modename',modeyear='$modeyear',number='$number',
voltage='$voltage',current='$current',short_current='$short_current'
WHERE gid = $gid and uid=$uid";
$res = $mysqli->query ( $sql );
if ($res) {
	//删除之前图片
	$sql_p = "DELETE from ".T('device_photo' )." WHERE gid = $gid";
	$mysqli->query ( $sql_p );
	
	$data = array (
			"gid" => $gid
	);
	
	Errors::exitWithJson ( 0,$data );
} else {
	Errors::exitWithJson ( -1 );
}

