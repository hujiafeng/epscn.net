<?php
/**
 * 提交用户的设备token
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月21日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

// params
// 1=>草稿 2审核 3 跟踪
// user_id
if ($_POST ['user_id']) {
	$_uid = ( int ) $_POST ['user_id'];
} else {
	$_uid = ( int ) $_SESSION ['user'] ['id'];
}

$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}

$_token = $_POST ['token'];

if(empty($_token)){
	API::exitWithJson(API::E_PARAM_VALUE_ERROR);
}
$app_version = $_POST ['app_ver']; // App version
$app_type = $_POST ['app_type']; // 1－>iphone

$_agent = $_SERVER ['HTTP_USER_AGENT'];

$SQL_0 = "SELECT id  FROM se_device_token WHERE token = '$_token'";
$result_0 = $mysqli->query ( $SQL_0 );
if ($result_0) {
	$row = $result_0->fetch_assoc ();
	if (empty ( $row ['id'] )) {
		// New insert
		$SQL_1 = "INSERT INTO se_device_token (token,user_id,app_ver,app_type,os_info) VALUES('$_token',$_uid,'$app_version',$app_type,'$_agent') ";
		$result_1 = $mysqli->query ( $SQL_1 );
		if ($result_1) {
			API::exitWithJson ( API::E_OK );
		} else {
			API::exitWithJson ( API::E_DB_QUERY_ERROR ,$SQL_1);
		}
	} else { // 存在则更新相关信息
		
		if (empty ( $_uid )) {
			$SQL_2 = "UPDATE se_device_token SET app_ver = '$app_version',app_type = $app_type,os_info = '$_agent' WHERE id = {$row['id']}";
		} else {
			$SQL_2 = "UPDATE se_device_token SET user_id = $_uid,app_ver = '$app_version',app_type = $app_type,os_info = '$_agent' WHERE id = {$row['id']}";
		}
		$result_2 = $mysqli->query ( $SQL_2 );
		if ($result_2) {
			
			API::exitWithJson ( API::E_OK );
		} else {
			API::exitWithJson ( API::E_DB_QUERY_ERROR ,$SQL_2);
		}
	}
} else {
	API::exitWithJson ( API::E_DB_QUERY_ERROR);
}
