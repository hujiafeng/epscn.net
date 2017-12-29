<?php
/**
 * 系统通知
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月18日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';

$_page = ( int ) $_POST ['page'];

$_uid = $_SESSION ['user'] ['id'];

if (empty ( $_uid )) {
	API::exitWithJson ( API::E_ACCESS_ERROR );
}

$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}

if(empty($_page)){
	$_page =1;
}
$COUNT = 20;
$start = $COUNT *($_page -1);


$limit  = " LIMIT $start,$COUNT ";

$sql  ="SELECT mid ,`type`,obj_type,obj_id ,msg ,UNIX_TIMESTAMP(create_time) AS time, avatar As s_avatar,fullname AS s_name
FROM se_message AS A  LEFT JOIN se_user AS B  ON A.suid = B.user_id WHERE type = 0 AND ruid = $_uid AND flag =0 ORDER BY create_time DESC $limit ";



$array  =array();

if($res =$mysqli->query($sql)){
	
	while ($row =$res->fetch_assoc()){
		$row['s_avatar'] = empty($row ['s_avatar'])?"":ROOT_URL."avatar/".$row ['s_avatar'];

		$array[] =$row;
	}
	//
	//设置已阅
	$sql_2 ="UPDATE se_message SET rread = 1  WHERE rread =0 AND ruid = $_uid AND type = 0";
	$mysqli->query($sql_2);
	
	API::exitWithJson(API::E_OK,$array);
	
}
else{
	API::exitWithJson(API::E_DB_QUERY_ERROR,$sql);
}
