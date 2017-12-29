<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * group_del 删除分组接口
 * 参数
 * id:分组id
 */
header ( 'Content-type: application/json' );
require 'config.php';

$id = $_POST['id'];
if (!$id)
	Errors::exitWithJson (10000);

//删除分组
$sql = "DELETE from ".T('device' )." WHERE id = $id";
$res = $mysqli->query ( $sql );
if ($res) {
	Errors::exitWithJson (0);
} else {
	Errors::exitWithJson (-1);
}