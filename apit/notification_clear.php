<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * notification_clear 消息清空接口
 * 参数
 * uid:用户id
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST ['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$sql = "UPDATE ".T('notification'). " SET flag = '0' WHERE ruid = $uid";
$res =$mysqli->query($sql);
if($res){
	Errors::exitWithJson(0);
}else {
	Errors::exitWithJson(10002 ,$sql);
}