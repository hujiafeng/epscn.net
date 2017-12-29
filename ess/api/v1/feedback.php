<?php
/**
 * 意见反馈
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

$dbc = new DBC();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}

$_info = $mysqli->real_escape_string ( $_POST ['info'] );
$_contact = $mysqli->real_escape_string ( $_POST ['contact'] );
$_version = $_POST ['version'];
$_app_type = $_POST ['app_type'];

if (empty ( $_app_type )) {
	$_app_type = 0;
}
$_uid = (int) $_SESSION['user']['id'];

$sql = "INSERT INTO se_feedback SET info = '$_info',uid = $_uid,contact ='$_contact',app_type = $_app_type ,version ='$_version' ";

if ($mysqli->query ( $sql )) {
	API::exitWithJson ( API::E_OK );
} else {
	API::exitWithJson ( API::E_DB_QUERY_ERROR );
}
