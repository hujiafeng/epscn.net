<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * billing 获取开票资料接口
 * 参数
 * uid：用户id
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

//获取用户信息
$sql = "SELECT khdw,pay_number,register_address,company_phone,bank,bank_number FROM ".T('user')." WHERE uid=".$uid;
$res = $mysqli->query ( $sql );
if ($res) {
	$result = array ();
	while ( $row = $res->fetch_assoc () ) {
		$result = $row;
	}
	Errors::exitWithJson(0,$result);
}else{
	Errors::exitWithJson(10002);
}