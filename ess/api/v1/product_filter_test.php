<?php
/**
 * 获取产品筛选结果 TEST
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

$_uid = ( int ) $_SESSION ['user'] ['id'];

$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}
$_categories = $_POST ['categories'];
$_brands = $_POST ['brands'];
$_models = $_POST ['models'];

$_keyword = $_POST ['keyword']; // 规格

$arr = array ();
if (! empty ( $_brands )) {
	$arr [] = "  brand IN ( $_brands) ";
}
if (! empty ( $_categories )) {
	$arr [] = "  category IN ( $_categories) ";
}

if (! empty ( $_models )) {
	$arr [] = "  model IN ( $_models) ";
}

$PAGE_COUNT = 50;

if (empty ( $_POST ['page'] )) {
	$_page = 1;
} else {
	$_page = ( int ) $_POST ['page'];
}
$start = ($_page - 1) * $PAGE_COUNT;
$limit = " LIMIT $start,$PAGE_COUNT ";

if (! empty ( $_keyword )) {
	//替换中文分割逗号
	$_str = mb_ereg_replace ( "[,;，]", " ", $_keyword );
	
	$arr_key = explode ( " ", $_str );
	
	$_array_wheres = array ();
	
	foreach ( $arr_key as $word ) {
		if (! empty ( $word )) {
			$_array_wheres [] = " ( specification LIKE '%$word%') ";
		}
	}
	
	$other_where =  implode(" AND ",$_array_wheres);
	
}

if (count ( $arr )) {
	
	$where = " WHERE " . implode ( " AND ", $arr );
	
	if (! empty ( $_keyword )) {
		$where .= " $other_where ";//AND ( specification LIKE '%$keyword%')
	}
} else {
	
	if (! empty ( $_keyword )) {
		$where = " WHERE $other_where ";
	} else {
		$where = '';
	}
}

$sql = "SELECT product_id ,specification,market_price,min_price,
(SELECT price FROM `se_user_products` WHERE product_id = A.`product_id`  AND user_id = $_uid) AS user_price,
(SELECT name FROM se_product_measure WHERE mid = A.measure) AS unit,
(SELECT name FROM se_product_brand WHERE brand_id = A.brand) AS brand_name,
(SELECT name FROM se_product_category WHERE cid = A.category) AS category_name,
(SELECT name FROM se_product_model WHERE model_id = A.model) AS model_name
FROM se_product  AS A $where  $limit ";

$res = $mysqli->query ( $sql );

if ($res) {
	$data = array ();
	while ( $row = $res->fetch_assoc () ) {
		
		//
		$row ['market_price'] = $row ['market_price'];
		if (empty ( $row ['user_price'] )) {
			$row ['user_price'] = $row ['min_price'];
		}
		unset ( $row ['min_price'] );
		$row ['name_'] = "test";
		
		$data [] = $row;
	}
	
	API::exitWithJson ( API::E_OK, $data );
} else {
	API::exitWithJson ( API::E_DB_QUERY_ERROR, $sql );
}

