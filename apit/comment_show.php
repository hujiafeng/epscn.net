<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * comment_show  获取订单评价接口
 * 参数
 * id:订单ID
 * 返回值
 * content:评价内容
 * zhpf:综合评分
 * fwzl：服务质量
 * sgzl：施工质量
 * time:评价时间
 * photo:评价图片
 */
header ( 'Content-type: application/json' );
require 'config.php';

$id = ( int ) $_POST ['id'];
if(!$id)
	Errors::exitWithJson(20000);

$sql = "SELECT * FROM ".T('evaluate')." where nid=$id";
$res = $mysqli->query ( $sql );
if ($res) {
	$result = $res->fetch_assoc ();
	
	// 获取相关图片
	$_assoc_photo = array ();
	$sql_photo = "SELECT small,large FROM ".T('photo')." WHERE n_id = $id AND flag=1 and type=4";
	$res2 = $mysqli->query ( $sql_photo );
	while ( $row = $res2->fetch_assoc () ) {
		$row ['small'] = PHOTO_URL . $row ['small'];
		$row ['large'] = PHOTO_URL . $row ['large'];
		$_assoc_photo [] = $row;
	}
	$result ['photo'] = $_assoc_photo;
	
	Errors::exitWithJson ( 0, $result );
} else {
	Errors::exitWithJson ( 10002 );
}