<?php
/**
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月8日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
 

$cfgDB ['host'] = 'localhost'; //
$cfgDB ['user'] = 'dba_three';
$cfgDB ['pass'] = 'interest0820';
$cfgDB ['name'] = 'dq_sale_expert';


include '../api/common/DBC.class.php';

$dbc = new DBC();

$mysqli =$dbc->get_MySQLi_Object();

if($mysqli){
	
	//
	//
	$json_str = file_get_contents('./products.json');
	
	
	$array =json_decode($json_str,TRUE);
	
	
	//var_dump($array);
	
	foreach ($array as $row)
	{
		$name   =$mysqli->real_escape_string($row['model_name']);

		//$sql_model = "INSERT INTO se_product_model SET name  = '$name' ,create_time = NOW()";

		//$sql = "INSERT INTO se_product SET brand =1 "
		//$mysqli->query($sql_model);

		$sql1 = "SELECT model_id FROM se_product_model WHERE name = '$name'";

		if($r1 = $mysqli->query($sql1)){
			$first =$r1->fetch_assoc();

			$model_id = $first['model_id'];

			
		}
		else{
			$model_id = 0;
		}
		
		//comp

		$sep = '';
		if(!empty($row['ac_plan'])){
			$sep .= $row['ac_plan'];
		}
		if(!empty($row['sc_plan'])){
			$sep .= ",".$row['sc_plan'];
		}
					if(!empty($row['sc_current'])){
			$sep .= ",".$row['sc_current'];
		}
		if(!empty($row['phase_distance'])){
			$sep .= ",".$row['phase_distance']."/".$row['pole_distance'];
		}
		if(!empty($row['install_type'])){
			$sep .= ",".$row['install_type'];
		}
		if(!empty($row['shell_frame'])){
			$sep .= ",".$row['shell_frame'];
		}
		//ac_plan sc_plan,sc_current,phase_distance,pole_distance,install_type,shell_frame

		$sql_2 ="INSERT INTO se_product SET  model = $model_id, market_price = '{$row['face_price']}',specification = '$sep'";

		$mysqli->query($sql_2);
	}
	
}

