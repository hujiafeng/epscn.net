<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * need_comment  评价接口
 * 参数
 * id:订单ID
 * zhpf:综合评分
 * fwzl：服务质量
 * sgzl：施工质量
 * content:内容
 */
header ( 'Content-type: application/json' );
require 'config.php';

$id = ( int ) $_POST ['id'];
$zhpf = $_POST ['zhpf'];
$fwzl = $_POST ['fwzl'];
$sgzl = $_POST ['sgzl'];
$content = $_POST ['content'];

if(!$id || !$zhpf)
	Errors::exitWithJson(20000);

$yzsql = "SELECT id from ".T('evaluate')." where nid=$id";
$yzres = $mysqli->query ( $yzsql );
if(!$yzres)
	Errors::exitWithJson ( 10002 );
$yzrow=$yzres->fetch_assoc();
if($yzrow["id"])
	Errors::exitWithJson ( 10003 );

$sql = "INSERT INTO ".T('evaluate' )." SET nid='$id',zhpf='$zhpf',fwzl='$fwzl',sgzl='$sgzl',content='$content'";
$res = $mysqli->query ( $sql );
if ($res) {
	Errors::exitWithJson (0);
} else {
	Errors::exitWithJson (10002);
}


