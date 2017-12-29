<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * device_photo_add 设备图片提交处理接口
 * 参数
 * gid:设备id
 * photo:图片
 * type:一次方案图1，其他2
 * 返回值
 * 成功返回0，上传错误返回30000
 */
header ( 'Content-type: application/json' );
require 'config.php';

$gid = intval ( $_POST ['gid'] );
$type = $_POST ['type'];
if (!$gid)
	Errors::exitWithJson (20000);

//创建储存目录
$data = array ();
$ym = date ( 'Y/m/' );
if (! is_dir ( PHOTO_ROOT . $ym ))
	@mkdir ( PHOTO_ROOT . $ym, 0777, true );

//图片上传
$tempFile = $_FILES ['photo'] ['tmp_name'];
//返回文件路径的信息
$fileParts = pathinfo ( $_FILES ['photo'] ['name'] );
//把所有字符转换为小写
$fext = strtolower ( $fileParts ['extension'] );

$time = time();
$rand = rand ( 10000, 99999 );
if($_FILES ['photo'] ['name']){
	$photo_max = $ym . $time . '_' . $rand . '_pj.' . $fext;
	//移动图片
	$result_move = move_uploaded_file ($tempFile, PHOTO_ROOT . $photo_max );
	//检测是否移动成功
	if ($result_move == false){
		Errors::exitWithJson(30000);
	}

    //插入数据
    $sql = "INSERT INTO ".T('device_photo')." SET gid='$gid',type='$type',large='$photo_max'";
    $mysqli->query ( $sql );
    
    Errors::exitWithJson ( 0 );
}else {
	Errors::exitWithJson ( 20000 ,__LINE__);
}
