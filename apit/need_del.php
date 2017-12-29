<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * need_del 订单删除接口
 * 参数
 * id:订单id
 * uid:用户uid
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST['uid'];
$id = $_POST ['id'];
if (!$uid || !$id)
	Errors::exitWithJson (10000);

$t_sql = "SELECT status from ".T('need')." where id=$id";
$t_res = $mysqli->query ( $t_sql );
if(!$t_res)
	Errors::exitWithJson ( 10002 );

$row=$t_res->fetch_assoc();
if($row["status"] == "-2")
	Errors::exitWithJson ( 10003 );

//只有自己删除自己的need
$sql = "UPDATE " . T ( 'need' ) . " SET status = '-2',del_time = NOW() WHERE id = $id AND uid_x = $uid and status < 13";
$res = $mysqli->query ( $sql );

Errors::exitWithJson(0);
