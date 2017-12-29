<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * feedback 用户反馈接口
 * 参数
 * uid:用户id
 * title:标题
 * info:内容
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST ['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$title = $_POST['title'];
$info  = $_POST['info'];
if (!$title)
	Errors::exitWithJson (20000);

if (stripos ( $info, "script" ) === FALSE) {
	$sql = "INSERT INTO " . T ( 'feedback' ) . " SET uid='$uid',info='$info',title='$title'";
	$mysqli->query ( $sql );
	Errors::exitWithJson ( 0 );
}else{
	Errors::exitWithJson ( 20000 );
	
}
