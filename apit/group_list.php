<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * group_list 获取分组列表接口
 * 参数
 * uid：用户id
 * 返回值
 * id:分组id
 * title:分组名
 * g_count:分组设备数量
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$sql = "SELECT id,title FROM ".T('device')." WHERE uid = $uid ORDER BY id DESC";
$res = $mysqli->query ( $sql );
if($res){
	$result['list'] = array ();
	while ( $row = $res->fetch_assoc () ) {
		//用户未读条数
		$sql_g = "SELECT count(*) FROM ".T('device_goods')." WHERE did=".$row['id'];
		$rt_g  = $mysqli->query($sql_g);
		$rto_g = $rt_g->fetch_row();
			
		$row["g_count"] = $rto_g["0"];
		$result['list'][] = $row;
	}
	Errors::exitWithJson(0,$result);
}else{
	Errors::exitWithJson(10002);
}
