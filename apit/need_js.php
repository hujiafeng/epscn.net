<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * need_js 指派技师接口
 * 参数
 * id:订单ID
 * js_name:技师姓名
 * js_number：技师手机号
 */
header ( 'Content-type: application/json' );
require 'config.php';
require ROOT.'ThinkPHP/Library/Org/Jpush/Jpush_f.class.php';

$id = $_POST ['id'];
if(!$id)
	Errors::exitWithJson(20000);

$js_name   = $_POST["js_name"];
$js_number = $_POST["js_number"];

$t_sql = "SELECT u.uid,u.token,n.no,n.status from ".T('need')." as n,".T('user')." as u where n.uid_x=u.uid and n.id=$id";
$t_res = $mysqli->query ( $t_sql );
if(!$t_res)
	Errors::exitWithJson ( 10002 );

$row=$t_res->fetch_assoc();
if($row["status"] != "12")
	Errors::exitWithJson ( 10003 );

$sql = "UPDATE ".T('need')." SET status='13',js_name='$js_name',js_number='$js_number',js_time=NOW() WHERE id = $id and status=12";
$res = $mysqli->query ( $sql );
if($res){
	Errors::exitWithJson(0);
}else{
	Errors::exitWithJson ( 10002 );
}



