<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_profile 个人信息提交接口
 * 参数
 * uid：用户id
 * gender:性别
 * age:年龄
 * city:地区
 * avatar:头像
 * mailbox:邮箱
 * 返回值
 * gender:性别
 * age:年龄
 * city:地区
 * avatar:头像
 * mailbox:邮箱
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST ['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$gender = $_POST ['gender'];
$age    = $_POST ['age'];
$city   = $_POST ['city'];
$mailbox= $_POST ['mailbox'];

//创建储存目录
$ym = date ( 'Y/m/' );
$time =time();
$rand = rand ( 10000, 99999 );

if (! is_dir ( AVATAR_ROOT . $ym ))
	@mkdir ( AVATAR_ROOT . $ym, 0777, true );

//图片上传
$tempFile = $_FILES['avatar']['tmp_name'];
//返回文件路径的信息
$fileParts = pathinfo ( $_FILES['avatar']['name'] );
//把所有字符转换为小写
$fext = strtolower ( $fileParts['extension'] );

$sql = "UPDATE ".T('user')." SET gender='$gender',age='$age',city='$city',mailbox='$mailbox'";
// 如果上传头像
if ($_FILES['avatar']['name']) {
	$photo_max = $ym . $time . '_' . $rand . '_2.' . $fext;
	$result_move = move_uploaded_file($tempFile,AVATAR_ROOT.$photo_max );
	//检测是否移动成功
	if ($result_move == false)
		Errors::exitWithJson(30000);

	$sql .= ",avatar= '$photo_max'";
	$_POST["avatar"] = AVATAR_URL.$photo_max;
}else{
	$_POST["avatar"] = '';
}

$sql .= " WHERE uid = $uid";
$res_update = $mysqli->query ( $sql );
if ($res_update) {
	Errors::exitWithJson ( 0, $_POST );
} else {
	Errors::exitWithJson ( 10002);
} 


