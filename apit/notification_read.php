<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * notification_read 消息已读接口
 * 参数
 * uid：用户id
 * noti_id：消息id（为空表示全部已读）
 */

header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST ['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$_noti_id = $_POST ['noti_id'];
//全部已读
if($_noti_id){
	$where .= " AND noti_id= $_noti_id";
}

$sql = "UPDATE ".T('notification')." SET isread='1' WHERE ruid=$uid".$where;
$res =$mysqli->query($sql);
if($res){
	Errors::exitWithJson(0);
}else {
	Errors::exitWithJson(10002);
}