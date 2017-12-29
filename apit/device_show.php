<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * device_show 设备详情接口
 * 参数
 * no:设备编号
 * 返回值
 * uid：用户id
 * did:分组id
 * title:分组名称
 * name:设备名称
 * type:产品型号
 * modename:制造厂商
 * modeyear:制造年月
 * number:产品型号
 * voltage:额定电压
 * current:额定电流
 * short_current:额定短路开断电流
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
 * 温度
 * 环境：wd_h
 * A相：wd_a
 * B相：wd_b
 * C相：wd_c
 * 温升
 * 环境：ws_h
 * A相：ws_a
 * B相：ws_b
 * C相：ws_c
 * 短路开断总次数：z_breaking_times
 * 已使用：breaking_times
 * 机械寿命：z_mechanical_life
 * 已使用：mechanical_life
 * photo:图片
 * code_img:二维码
 */
header ( 'Content-type: application/json' );
require 'config.php';

$no = $_POST['no'];
if(!$no)
	Errors::exitWithJson(20000);

$sql = "SELECT *,
		(SELECT title FROM ".T('device')." WHERE id=".T('device_goods').".did) AS title FROM ".T('device_goods')." WHERE no = $no ";
$res = $mysqli->query ( $sql );
$result_row = $res->fetch_assoc ();
// 获取相关图片
$_assoc_photo = array ();
if($result_row["gid"]){
	$sql_photo = "SELECT large FROM ".T('device_photo')." WHERE gid = ".$result_row["gid"]." AND flag=1 and (type=1 or type=2) order by type desc";
	$res2 = $mysqli->query ( $sql_photo );
	while ( $row = $res2->fetch_assoc () ) {
		$row ['large'] = PHOTO_URL . $row ['large'];
		$_assoc_photo [] = $row;
	}
}else{
	Errors::exitWithJson ( 30002 );
}
$result_row ['photo'] = $_assoc_photo;
$result_row ['code_img'] = PHOTO_URL . "erweima/".$no.".png";
Errors::exitWithJson ( 0, $result_row );

