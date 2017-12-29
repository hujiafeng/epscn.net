<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * billing_edit 修改开票资料接口
 * 参数
 * uid：用户id
 * khdw:客户单位
 * pay_number:纳税人识别码
 * register_address:注册地址
 * company_phone:公司电话
 * bank：开户银行
 * bank_number:银行账号
 * 返回值
 * khdw:客户单位
 * pay_number:纳税人识别码
 * register_address:注册地址
 * company_phone:公司电话
 * bank：开户银行
 * bank_number:银行账号
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST['uid'];
if (!$uid)
	Errors::exitWithJson (10000);
//提交参数
$khdw             = $_POST ['khdw'];
$pay_number       = $_POST ['pay_number'];
$register_address = $_POST ['register_address'];
$company_phone    = $_POST ['company_phone'];
$bank             = $_POST ['bank'];
$bank_number      = $_POST ['bank_number'];

//修改用户信息
$sql = "UPDATE ".T('user')." SET khdw='$khdw',pay_number='$pay_number',register_address='$register_address',company_phone='$company_phone',bank='$bank',bank_number='$bank_number' WHERE uid = $uid";
$res_update = $mysqli->query ( $sql );
if ($res_update) {
	Errors::exitWithJson ( 0, $_POST );
} else {
	Errors::exitWithJson ( 10002);
} 