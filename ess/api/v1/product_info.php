<?php
/**
 * 获取产品分类等信息
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月9日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}

$arr_all = array ();
// ================================
$sql = "SELECT cid ,name FROM se_product_category WHERE flag =0";

$res_1 = $mysqli->query ( $sql );

if ($res_1) {
	$arr_1 = array ();
	while ( $row = $res_1->fetch_assoc () ) {
		$arr_1 [] = $row;
	}
	$arr_all ['category'] = $arr_1;
}
// ================================
$sql_2 = "SELECT brand_id ,name FROM se_product_brand WHERE flag =0";

$res_2 = $mysqli->query ( $sql_2 );

if ($res_2) {
	$arr_2 = array ();
	while ( $row = $res_2->fetch_assoc () ) {
		$arr_2 [] = $row;
	}
	$arr_all ['brand'] = $arr_2;
}
// ================================
/*
$sql_3 = "SELECT model_id ,name FROM se_product_model WHERE flag =0";

$res_3 = $mysqli->query ( $sql_3 );

if ($res_3) {
	$arr_3 = array ();
	while ( $row = $res_3->fetch_assoc () ) {
		$arr_3 [] = $row;
	}
	$arr_all ['model'] = $arr_3;
}
*/
API::exitWithJson ( API::E_OK, $arr_all );
