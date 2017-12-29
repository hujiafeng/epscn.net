<?php
/**
 * 积分细节
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

// user_id
$_uid = ( int ) $_SESSION ['user'] ['id'];

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

$sql  ="SELECT A.pp_id ,A.purchase_num,score ,DATE_FORMAT(act_time,'%Y-%m-%d') AS time,B.purchase_price,B.last_price,B.purchase_num,C.name AS model_name,D.name AS brand_name ,E.name AS category_name,F.name AS unit,G.name AS project_name ,G.project_no,P.specification
FROM se_score_record AS A LEFT JOIN se_project_products AS B ON A.pp_id = B.pp_id
LEFT JOIN se_product AS P ON P.product_id = B.pp_id
LEFT JOIN se_project AS G ON G.project_id = B.project_id
LEFT JOIN `se_product_model` AS C ON C.model_id = P.model 
LEFT JOIN `se_product_brand` AS D ON D.brand_id  = P.brand
LEFT JOIN `se_product_category` AS E ON E.cid  = P.category
LEFT JOIN `se_product_measure` AS F ON F.mid  = P.measure  WHERE A.user_id= $_uid AND A.flag = 0 ORDER BY act_time DESC $_limit";


if($res =$mysqli->query($sql)){
	//
	//
	$arr  =array();
	while ($row = $res->fetch_assoc()){
		
		$arr[] = $row;

	}
	API::exitWithJson(API::E_OK,$arr);
}
else{

	API::exitWithJson(API::E_DB_QUERY_ERROR,$sql);
}
