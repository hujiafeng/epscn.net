<?php
/**
 * 
 * 项目编辑
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
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

$_project_id = ( int ) $_POST ['project_id']; // 可选
                                              // 项目名称
$_name = $mysqli->real_escape_string ( $_POST ['name'] );
// purchaser
$_purchaser = $_POST ['purchaser'];

// 产品信息
$_product_array = json_decode ( $_POST ['products'], TRUE );

if (empty ( $_project_id )) {
	
	// 创建新项目
	$_NO = 'P' . date ( "ymdHi" ) . sprintf ( "%04d", mt_rand ( 1, 9999 ) );
	
	$sql = "INSERT INTO se_project SET name = '$_name',project_no = '$_NO',purchaser = '$_purchaser',project_status = 'DRAFT',create_uid = $_uid ,create_time = NOW()";
	
	if ($res = $mysqli->query ( $sql )) {
		// 插入ID
		$insert_id = $mysqli->insert_id;
		
		$arr_sql = array ();
		
		foreach ( $_product_array as $product ) {
			
			$_pp_project_id = $insert_id;
			$_pp_product_id = $product ['product_id']; // 产品ID
			$_pp_purchase_price = $product ['purchase_price']; // 采购价格
			$_pp_purchase_num = $product ['purchase_num']; // 购买数量
			$_pp_user_price = $product ['user_price']; // 用户价格
			
			$sql_p = "INSERT INTO se_project_products SET project_id  =$insert_id,product_id = $_pp_product_id,purchase_price = '$_pp_purchase_price',purchase_num = '$_pp_purchase_num',
			last_price  = '$_pp_user_price' ,create_uid  = $_uid,create_time = NOW()";
			$arr_sql [] = $sql_p;
		}
		
		$sql_2 = implode ( ";", $arr_sql );
		
		if ($mysqli->multi_query ( $sql_2 )) {
			// 返回项目ID
			API::exitWithJson ( API::E_OK, array (
					"project_id" => ( string ) $insert_id 
			) );
		} else {
			API::exitWithJson ( API::E_DB_QUERY_ERROR );
		}
	} else {
		API::exitWithJson ( API::E_DB_QUERY_ERROR );
	}
} else {
	// 修改项目信息
	// API::exitWithJson ( API::E_UNKOWN_ERROR );
	
	$sql = "UPDATE se_project SET name = '$_name',purchaser = '$_purchaser',project_status = 'DRAFT' WHERE project_id = $_project_id ";
	
	if ($mysqli->query ( $sql )) {
		
		if(count($_product_array) ==0){
			// 返回项目ID
			API::exitWithJson ( API::E_OK, array (
					"project_id" => ( string ) $_project_id
			) );
		}
		else{
			$arr_sql = array ();
			
			foreach ( $_product_array as $product ) {
				$_pp_product_id = $product ['product_id']; // 产品ID
				$_pp_purchase_price = $product ['purchase_price']; // 采购价格
				$_pp_purchase_num = $product ['purchase_num']; // 购买数量
				$_pp_user_price = $product ['user_price']; // 用户价格
				
				$sql_p = "INSERT INTO se_project_products SET project_id  =$_project_id,product_id = $_pp_product_id,purchase_price = '$_pp_purchase_price',purchase_num = '$_pp_purchase_num',
				last_price  = '$_pp_user_price' ,create_uid  = $_uid,create_time = NOW()";
				$arr_sql [] = $sql_p;
			}
			
			$sql_2 = implode ( ";", $arr_sql );
			
			if ($mysqli->multi_query ( $sql_2 )) {
				// 返回项目ID
				API::exitWithJson ( API::E_OK, array (
						"project_id" => ( string ) $_project_id
				) );
			} else {
				API::exitWithJson ( API::E_DB_QUERY_ERROR );
			}
		}

	} else {
		API::exitWithJson ( API::E_DB_QUERY_ERROR );
	}
}