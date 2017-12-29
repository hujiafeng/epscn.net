<?php
/**
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月10日
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
//SELECT DISTINCT model,name  FROM se_product ,se_product_model  WHERE brand  IN (2)  AND model = model_id

$_categories = $_POST ['categories'];
$_brands = $_POST ['brands'];

$arr = array ();
if (! empty ( $_brands )) {
	$arr [] = "  brand IN ( $_brands) ";
}
if (! empty ( $_categories )) {
	$arr [] = "  category IN ( $_categories) ";
}
if (count ( $arr )) {
	
	$where =  implode ( " AND ", $arr );
	$sql = "SELECT DISTINCT model AS model_id,name  FROM se_product  AS A,se_product_model AS B  WHERE $where  AND A.model = B.model_id";
	
} else {
	$sql = "SELECT DISTINCT model AS model_id,name  FROM se_product  AS A,se_product_model AS B  WHERE A.model = B.model_id";
	
}


$res = $mysqli->query ( $sql );

if ($res) {
	$data = array ();
	while ( $row = $res->fetch_assoc () ) {
	
		$data [] = $row;
	}
	
	API::exitWithJson ( API::E_OK, $data );
} else {
	API::exitWithJson ( API::E_DB_QUERY_ERROR );
}