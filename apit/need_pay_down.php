<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * need_pay_down 对公转账接口
 * 参数
 * uid：用户id
 * no:订单号
 */
header ( 'Content-type: application/json' );
require 'config.php';

$no = $_POST ['no'];
$uid = $_POST['uid'];

if(!$no || !$uid)
	Errors::exitWithJson(20000);

$sql = "UPDATE ".T('need')." SET pay_mode='2' WHERE no = '$no' and uid_x = $uid";
$res = $mysqli->query ( $sql );
if($res){
	Errors::exitWithJson(0);
}else{
	Errors::exitWithJson ( 10002 );
}



