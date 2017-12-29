<?php
/**
 * 删除通知消息
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月22日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */

require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

$mid = ( int ) $_POST ['mid'];

$_uid = $_SESSION ['user'] ['id'];

if (empty ( $_uid )) {
	API::exitWithJson ( API::E_ACCESS_ERROR );
}

$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}
 
$sql  = " UPDATE se_message SET flag = 1 WHERE ruid = $_uid AND mid = $mid";

if($mysqli->query($sql)){
	API::exitWithJson(API::E_OK);
	
}
else{
	API::exitWithJson(API::E_DB_QUERY_ERROR);
}