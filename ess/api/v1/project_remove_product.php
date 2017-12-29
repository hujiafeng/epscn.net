<?php
/**
 * 删除产品
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月15日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

$_uid = ( int ) $_SESSION ['user'] ['id'];
if (empty ( $_uid )) {
	API::exitWithJson ( API::E_ACCESS_ERROR );
}

$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}

$_project_id = $_POST ['project_id']; //

$_pp_id = $_POST ['pp_id']; // 产品ID

if (empty ( $_pp_id ) ) {
	API::exitWithJson ( API::E_PARAM_VALUE_ERROR );
}
// 删除，实为更新状态
$sql = "UPDATE se_project_products SET flag = 1 WHERE pp_id = $_pp_id  AND create_uid = $_uid";

if ($mysqli->query ( $sql )) {
	API::exitWithJson ( API::E_OK );
} else {
	API::exitWithJson ( API::E_DB_QUERY_ERROR );
}