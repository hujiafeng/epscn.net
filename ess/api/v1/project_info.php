<?php
/**
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
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
// query basic info
$sql = "SELECT project_id ,name,project_no,purchaser,project_status FROM se_project WHERE project_id =$_projectid AND create_uid= $_uid";

$res_info = $mysqli->query ( $sql );

$info = array ();
if ($res_info) {
	$info = $res_info->fetch_assoc ();
	
	if($info['project_status'] == 'DONE' || $info['project_status'] == 'TRACKING'){
		//Add report_url
		$info['report_url'] = ROOT_URL."report/project/$_projectid/".sha1("PROJECT".$_projectid.APP_KEY);
		
	}
	
	/*
	 * 添加的产品
	 */
	$sql_prodcuts = "SELECT A.pp_id,A.product_id,A.purchase_price,A.purchase_num ,B.market_price,B.specification,
(SELECT name FROM se_product_category WHERE cid =  B.category ) AS category_name,
(SELECT name FROM se_product_brand WHERE brand_id =  B.brand ) AS brand_name,
(SELECT name FROM se_product_model WHERE model_id =  B.model ) AS model_name,
(SELECT name FROM se_product_measure WHERE mid =  B.measure ) AS unit 
FROM se_project_products AS A LEFT JOIN se_product AS B 
ON   A.product_id = B.product_id   WHERE A.project_id = $_projectid AND A.flag =0  ";
	
	$arr_p = array ();
	
	if ($res_products = $mysqli->query ( $sql_prodcuts )) {
		while ( $row = $res_products->fetch_assoc () ) {
			$arr_p [] = $row;
		}
	}
	// append products
	$info ['products'] = $arr_p;
	
	API::exitWithJson ( API::E_OK, $info );
} else {
	API::exitWithJson ( API::E_DB_QUERY_ERROR );
}