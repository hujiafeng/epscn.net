<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * device_list 获取某个分组设备列表接口
 * 参数
 * did：分组id
 * 返回值
 * gid:设备id
 * no:设备编号
 * name:设备名称
 * type:型号
 */
header ( 'Content-type: application/json' );
require 'config.php';

$did = $_POST['did'];
if (!$did)
	Errors::exitWithJson (20000);

$sql = "SELECT gid,no,name,type FROM ".T('device_goods')." WHERE did = $did ORDER BY gid DESC";
$res = $mysqli->query ( $sql );
if($res){
	$result['list'] = array ();
	while ( $row = $res->fetch_assoc () ) {
		$result['list'][] = $row;
	}
	Errors::exitWithJson(0,$result);
}else{
	Errors::exitWithJson(10002);
}
