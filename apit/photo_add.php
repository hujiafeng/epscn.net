<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * photo_add 订单照片、视频提交处理接口
 * 参数
 * uid：用户id
 * id:订单ID
 * photo:图片
 * video：视频
 * 返回值
 * 成功返回0，上传错误返回30000
 */
header ( 'Content-type: application/json' );
require 'config.php';
require 'common/thumb.func.php';

$id = intval ( $_POST ['id'] ); 
if(!$id)
	Errors::exitWithJson(20000);
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

//视频上传
$tempFile2 = $_FILES ['video'] ['tmp_name'];
//返回文件路径的信息
$fileParts2 = pathinfo ( $_FILES ['video'] ['name'] );
//把所有字符转换为小写
$fext2 = strtolower ( $fileParts2 ['extension'] );

$time =time();
$rand = rand ( 10000, 99999 );
if($_FILES ['photo'] ['name']){
	$photo_min = $ym . $time . '_' . $rand . '_1.' . $fext;
	$photo_max = $ym . $time . '_' . $rand . '_2.' . $fext;
	//移动图片
	$result_move = move_uploaded_file ($tempFile, PHOTO_ROOT . $photo_max );
	//检测是否移动成功
	if ($result_move == false){
		$sql_u = "UPDATE ".T('need')." SET status = '-2' WHERE id = $id";
		$mysqli->query ( $sql_u );
		
		Errors::exitWithJson(30000);
	}
	//图片裁剪小图并存储
	thumb(PHOTO_ROOT . $photo_max, PHOTO_ROOT . $photo_min, 80,80);
	
    //插入数据
    $sql = "INSERT INTO ".T('photo')." SET n_id='$id',type = 1,large='$photo_max',small='$photo_min'";
    $mysqli->query ( $sql );
    
    Errors::exitWithJson ( 0 );
}elseif($_FILES ['video'] ['name']){
	$vedio = $ym . $time . '_' . $rand . '.' . $fext2;
	//移动视频
	$result_move = move_uploaded_file ( $tempFile2, PHOTO_ROOT . $vedio );
	//检测是否移动成功
	if ($result_move == false){
		$sql_u = "UPDATE ".T('need')." SET status = '-2' WHERE id = $id";
		$mysqli->query ( $sql_u );
		
		Errors::exitWithJson(30000);
	}

	//获取视频的第一帧为图片
	$to = $ym . $time . '_' . $rand."_1.jpg";
	$cmd = "/opt/ffmpeg/ffmpeg -i ".PHOTO_ROOT.$vedio." -ss 0.05 -t 1 -s 180x180 ".PHOTO_ROOT.$to;
	exec($cmd);
	
	//插入数据
	$sql = "INSERT INTO ".T('photo')." SET n_id='$id',type = 2,large='$vedio',small='$to'";
	$mysqli->query ( $sql );

	Errors::exitWithJson ( 0 );
}else {
	Errors::exitWithJson ( 20000 ,__LINE__);
}
