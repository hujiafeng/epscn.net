<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * comment_photo_add 评价照片提交处理接口
 * 参数
 * id:订单ID
 * photo:图片
 * 返回值
 * 成功返回0，上传错误返回30000
 */
header ( 'Content-type: application/json' );
require 'config.php';
require 'common/thumb.func.php';

$id = intval ( $_POST ['id'] );
if (!$id)
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

$time =time();
$rand = rand ( 10000, 99999 );
if($_FILES ['photo'] ['name']){
	$photo_min = $ym . $time . '_' . $rand . '_pjs.' . $fext;
	$photo_max = $ym . $time . '_' . $rand . '_pj.' . $fext;
	//移动图片
	$result_move = move_uploaded_file ($tempFile, PHOTO_ROOT . $photo_max );
	//检测是否移动成功
	if ($result_move == false){
		Errors::exitWithJson(30000);
	}
	//图片裁剪小图并存储
	thumb(PHOTO_ROOT . $photo_max, PHOTO_ROOT . $photo_min, 80,80);
	
    //插入数据
    $sql = "INSERT INTO ".T('photo')." SET n_id='$id',type = 4,large='$photo_max',small='$photo_min'";
    $mysqli->query ( $sql );
    
    Errors::exitWithJson ( 0 );
}else {
	Errors::exitWithJson ( 20000 ,__LINE__);
}
