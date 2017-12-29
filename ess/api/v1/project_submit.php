<?php
/**
 * 项目提交审核
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月16日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

$_projectid = ( int ) $_POST ['project_id'];

$_uid = $_SESSION ['user'] ['id'];

if (empty ( $_uid )) {
	API::exitWithJson ( API::E_ACCESS_ERROR );
}
$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}

$_project_id = $_POST ['project_id'];

if (empty ( $_project_id )) {
	API::exitWithJson ( API::E_PARAM_VALUE_ERROR );
}

$sql = "UPDATE se_project SET project_status = 'PENDING' WHERE create_uid = $_uid AND project_id =$_project_id";

if ($mysqli->query ( $sql )) {
	API::exitWithJson ( API::E_OK );
} else {
	API::exitWithJson ( API::E_DB_QUERY_ERROR );
}