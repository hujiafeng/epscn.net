<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * need_end_f 服务商申请完工接口
 * 参数
 * uid：用户id
 * id:订单ID
 */
header ( 'Content-type: application/json' );
require 'config.php';

$id = $_POST ['id'];
$uid = $_POST['uid'];

if(!$id || !$uid)
	Errors::exitWithJson(20000);

$sql = "UPDATE ".T('need')." SET status='14',app_over_time=NOW() WHERE id = $id and uid_f = $uid and status=13";
$res = $mysqli->query ( $sql );
if($res){
	Errors::exitWithJson(0);
}else{
	Errors::exitWithJson ( 10002 );
}



