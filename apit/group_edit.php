<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * group_edit 修改分组接口
 * 参数
 * id：分组id
 * title:分组名称
 */
header("Content-type: application/json");
require "config.php";

$id = $_POST['id'];
if (!$id)
	Errors::exitWithJson (10000);

$title = $_POST['title'];
//修改分组
$sql = "UPDATE ".T('device')." SET title='$title' WHERE id = $id";
$res = $mysqli->query ( $sql );
if ($res) {
	Errors::exitWithJson (0);
} else {
	Errors::exitWithJson (-1);
}