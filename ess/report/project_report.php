<?php
/**
 * 采购单View
 * rewrite to here
 * /ess/report/project/{$project_id}/{$token}
 * 验证project_id与token是否匹配
 * 
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月22日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
header ( "Content-Type: text/html; charset=UTF-8" );
error_reporting ( E_ALL );
// echo "TODO<br>";
// echo $_SERVER ['REQUEST_URI'] . "<hr/>";
// echo "项目ID：" . $_GET ['project_id'] . "<br/>";

// echo "验证string :" . $_GET ['token'];
/*
 * 简单判断,阻止不合法访问
 */
// api config
const APP_KEY = '86a2db4c0a478340508ef0d87b67cef8';
$str = sha1 ( "PROJECT" . $_GET ['project_id'] . APP_KEY );

$_isValid = ($str == $_GET ['token']);

$cfgDB ['host'] = 'localhost'; //
$cfgDB ['user'] = 'dba_three';
$cfgDB ['pass'] = 'interest0820';
$cfgDB ['name'] = 'dq_sale_expert';

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>采购单</title>
<link media="all" rel="stylesheet" href="/ess/report/ess001.css" />
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php if($_isValid):?>
	<?php
		$_project_id = $_GET ['project_id'];
		
		include '../api/common/DBC.class.php';
		
		$dbc = new DBC ();
		$mysqli = $dbc->get_MySQLi_Object ();
		
		if ($mysqli) {
			$sql_0 = "SELECT * FROM se_project where project_id = $_project_id";
			if ($res = $mysqli->query ( $sql_0 )) {
				$info = $res->fetch_assoc ();
			}
		}
		
		$sql = "SELECT A.pp_id,A.product_id,A.purchase_price,A.purchase_num ,B.market_price,B.specification,C.purchase_num AS real_num ,(A.purchase_price*C.purchase_num) AS money,
(SELECT name FROM se_product_category WHERE cid =  B.category ) AS category_name,
(SELECT name FROM se_product_brand WHERE brand_id =  B.brand ) AS brand_name,
(SELECT name FROM se_product_model WHERE model_id =  B.model ) AS model_name,
(SELECT name FROM se_product_measure WHERE mid =  B.measure ) AS unit
FROM se_score_record  AS C LEFT JOIN se_project_products AS A ON C.pp_id = A.pp_id LEFT JOIN se_product AS B ON   A.product_id = B.product_id
 WHERE A.project_id = $_project_id AND A.flag =0 AND C.score > 0";
		
		if ($mysqli) {
			$res = $mysqli->query ( $sql );
			$records = array ();
			if ($res) {
				
				while ( $row = $res->fetch_assoc () ) {
					//
					$records [] = $row;
				}
			}
		}
		$i = 0;
		$total =0;
		// echo $sql;
		?>
		<div class="head">采购单</div>
	<div class="no">
		<span>编号：</span><span><?php echo $info['project_no'];?></span>
	</div>
		<div class="no">
		<span>采购方：</span><span><?php echo $info['purchaser'];?></span>
	</div>
	<table class="tb">

		<tr>
			<th>序号</th>
			<th>名称</th>
			<th>规格</th>
			<th>数量</th>
			<th>单价</th>
			<th>金额</th>
			<th>其它</th>
		</tr>
	
	<?php foreach ($records as $record):?>
	<?php
			
	$i ++;
	$total += $record['money'];
			?>
		<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $record['model_name'];?></td>
			<td><?php echo $record['specification'];?></td>
			<td><?php echo $record['real_num'].$record['unit'];?></td>
			<td><?php echo $record['purchase_price']."元";?></td>
			<td><?php echo $record['money']."元";?></td>
			<td></td>
		</tr>
	<?php endforeach;?>
		<tr>
			<td colspan="1">合计：</td>
			<td colspan="6"><?php echo $total."元";?></td>
		</tr>
	</table>
	<?php else: ?>
	
	<div class="deny">
		<span>访问拒绝</span>
	</div>
	<?php endif;?>

</body>
</html>