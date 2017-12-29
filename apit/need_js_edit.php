<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * need_js_edit 技师修改接口
 * 参数
 * id:订单ID
 * js_name:技师姓名
 * js_number：技师手机号
 */
header ( 'Content-type: application/json' );
require 'config.php';

$id = $_POST ['id'];
if(!$id)
	Errors::exitWithJson(20000);

$js_name   = $_POST["js_name"];
$js_number = $_POST["js_number"];

$sql = "UPDATE ".T('need')." SET js_name='$js_name',js_number='$js_number' WHERE id = $id";
$res = $mysqli->query ( $sql );
if($res){
	Errors::exitWithJson(0);
}else{
	Errors::exitWithJson ( 10002 );
}



