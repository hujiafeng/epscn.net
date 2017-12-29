<?php
/**
 * 项目列表
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

$_projectid = ( int ) $_POST ['project_id'];

//params
//1=>草稿 2审核 3 跟踪
// user_id
$_uid = ( int ) $_SESSION ['user'] ['id'];

$_s = $_POST['type'];

if($_s == '1'){
	$status = "AND project_status = 'DRAFT' ";
	
}
else if($_s == '2'){
	$status = "AND ( project_status = 'PENDING' OR  project_status = 'REFUSED' ) ";
	
}
else if($_s ==3) {
	$status = "AND ( project_status = 'TRACKING' OR  project_status = 'DONE') ";
	
}
else{
	$status ='';
}
$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}

$_page = ( int ) $_POST ['page'];

if (empty ( $_page )) {
	$_page = 1;
}
$COUNT = 20;
$_start = $COUNT * ($_page - 1);

$_limit = " LIMIT $_start ,$COUNT";

$sql = "SELECT project_id ,name,project_no,purchaser,project_status, refuse_reason FROM se_project WHERE create_uid = $_uid AND flag =0  $status ORDER BY project_id DESC $_limit";

$arr_result = array ();

//
$pid_array = array ();

if ($res = $mysqli->query ( $sql )) {
	while ( $row = $res->fetch_assoc () ) {
		//
		
		$pid_array [] = $row ['project_id'];
		$arr_result [] = $row;
	}
	
	$projectids = implode ( ",", $pid_array );
	
	// query all products
	$sql = "";
	
	//
	$sql_2 = "SELECT pp_id ,project_id ,A.product_id ,purchase_price,purchase_num,C.name AS model_name,D.name AS brand_name,E.name AS category_name,F.name AS unit
 FROM se_project_products  AS A LEFT JOIN `se_product` AS B  ON A.`product_id` =B.product_id  
 LEFT JOIN `se_product_model` AS C ON C.model_id = B.model 
 LEFT JOIN `se_product_brand` AS D ON D.brand_id  = B.brand
 LEFT JOIN `se_product_category` AS E ON E.cid  = B.category
 LEFT JOIN `se_product_measure` AS F ON F.mid  = B.measure
 WHERE   A.flag =0 AND A.project_id  IN ($projectids) ";
	
	$arr_products = array ();
	
	$res_2 = $mysqli->query ( $sql_2 );
	if ($res_2) {
		while ( $row = $res_2->fetch_assoc () ) {
			
			$project_id = $row ['project_id'];
			
			if (array_key_exists ( $project_id, $arr_products )) {
				$arr_products [$project_id] [] = $row;
			} else {
				$arr_products [$project_id] = array ();
				$arr_products [$project_id] [] = $row;
			}
		}
	}
	
	// Append
	foreach ( $arr_result as &$item ) {
		$project_id = $item ['project_id'];
		if(empty($arr_products [$project_id])){
			$item ['products'] = array();
			
		}
		else{
			$item ['products'] = $arr_products [$project_id];
			
		}
	}
	
	API::exitWithJson ( API::E_OK, $arr_result );
}
else{
	API::exitWithJson(API::E_DB_QUERY_ERROR,null,array($sql,$sql_2));
}
