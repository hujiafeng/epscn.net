<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_info 获取个人资料接口
 * 参数
 * uid：用户id
 * 返回值
 * gender:性别
 * age:年龄
 * city:地区
 * avatar:头像
 * mobile：手机号
 * khdw:客户单位
 * type：类型（0普通用户、1服务商）
 * mailbox:邮箱
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

//获取用户信息
$sql = "SELECT gender,age,city,avatar,mobile,type,khdw,mailbox FROM ".T('user')." WHERE uid=".$uid;
$res = $mysqli->query ( $sql );
if ($res) {
	$result = array ();
	while ( $row = $res->fetch_assoc () ) {
		//头像处理
		if($row["avatar"]){
			$row["avatar"] = AVATAR_URL.$row["avatar"];
		}else{
			$row["avatar"] = "";
		}

		$result = $row;
	}
	Errors::exitWithJson(0,$result);
}else{
	Errors::exitWithJson(10002);
}