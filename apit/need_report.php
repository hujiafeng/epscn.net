<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * need_report  完工报告接口
 * 参数
 * id:订单ID
 * 返回值
 * routine_time:常规工时
 * overtime：加班工时
 * fitting_reward：零配件费用
 * content：内容
 * photo：图片
 * inform：执行备注
 * time:时间
 * content：内容
 */
header ( 'Content-type: application/json' );
require 'config.php';

$id = ( int ) $_POST ['id'];
if($id == 0)
	Errors::exitWithJson(20000);

$sql = "SELECT routine_time,overtime,fitting_reward,content FROM  ".T('report'). " WHERE nid = $id";
$res = $mysqli->query ( $sql );
if ($res) {
	$result = $res->fetch_assoc ();
	// 获取相关图片
	$_assoc_photo = array ();
	$sql_photo = "SELECT small,large,type FROM ".T('photo')." WHERE n_id = $id AND flag=1 and type=5";
	$res2 = $mysqli->query ( $sql_photo );
	while ( $row = $res2->fetch_assoc () ) {
		$row ['small'] = PHOTO_URL . $row ['small'];
		$row ['large'] = PHOTO_URL . $row ['large'];
		$_assoc_photo [] = $row;
	}
	$result ['photo'] = $_assoc_photo;
	
	// 获取执行备注
	$inform = array ();
	$sql_inform = "SELECT time,content FROM ".T('inform')." WHERE nid = $id";
	$res_inform = $mysqli->query ( $sql_inform );
	while ( $row_inform = $res_inform->fetch_assoc () ) {
		$inform [] = $row_inform;
	}
	$result ['inform'] = $inform;

	Errors::exitWithJson ( 0, $result );
} else {
	Errors::exitWithJson ( 10002 );
}