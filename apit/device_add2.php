<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * device_add2 设备添加步骤2、设备修改步骤2接口
 * 参数
 * gid:设备id
 * 断路器/负荷开关/接触器
 * d_modename:制造厂商
 * d_type:产品型号
 * d_modeyear:制造年月
 * d_number:产品编号
 * 微机保护装置
 * w_modename:制造厂商
 * w_type:产品型号
 * w_modeyear:制造年月
 * w_number:产品编号
 * 互感器
 * h_modename:制造厂商
 * h_type:产品型号
 * h_modeyear:制造年月
 * h_number:产品编号
 * 接地开关
 * j_modename:制造厂商
 * j_type:产品型号
 * j_modeyear:制造年月
 * j_number:产品编号
 */
header ( 'Content-type: application/json' );
require 'config.php';

$gid = $_POST['gid'];
if (!$gid)
	Errors::exitWithJson (20000);

$d_modename    = $_POST['d_modename'];
$d_type        = $_POST['d_type'];
$d_modeyear    = $_POST['d_modeyear'];
$d_number      = $_POST['d_number'];
$w_modename    = $_POST['w_modename'];
$w_type        = $_POST['w_type'];
$w_modeyear    = $_POST['w_modeyear'];
$w_number      = $_POST['w_number'];
$h_modename    = $_POST['h_modename'];
$h_type        = $_POST['h_type'];
$h_modeyear    = $_POST['h_modeyear'];
$h_number      = $_POST['h_number'];
$j_modename    = $_POST['j_modename'];
$j_type        = $_POST['j_type'];
$j_modeyear    = $_POST['j_modeyear'];
$j_number      = $_POST['j_number'];

//修改设备
$sql = "UPDATE ".T('device_goods')." SET d_modename='$d_modename',d_type='$d_type',d_modeyear='$d_modeyear',d_number='$d_number',
w_modename='$w_modename',w_type='$w_type',w_modeyear='$w_modeyear',w_number='$w_number',
h_modename='$h_modename',h_type='$h_type',h_modeyear='$h_modeyear',h_number='$h_number',
j_modename='$j_modename',j_type='$j_type',j_modeyear='$j_modeyear',j_number='$j_number'
WHERE gid = $gid";
$res = $mysqli->query ( $sql );
if ($res) {
	$data = array (
			"gid" => $gid
	);
	Errors::exitWithJson ( 0, $data );
} else {
	Errors::exitWithJson ( -1 );
}

