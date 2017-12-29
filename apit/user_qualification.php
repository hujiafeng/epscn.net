<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_qualification 获取服务商资质接口
 * 参数
 * uid：用户id
 * 返回值
 * number:服务商编号
 * name:负责人姓名
 * company:公司名称
 * address:公司地址
 * city_f：服务区域
 * task:服务类型
 * end_time：协议到期时间
 * bz_reward：已缴纳保证金
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

//获取用户信息
$sql = "SELECT number,name,company,address,city_f,task,end_time,bz_reward FROM ".T('user')." WHERE uid=".$uid;
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