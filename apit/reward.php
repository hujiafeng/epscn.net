<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * reward 酬劳明细接口
 * 参数
 * page：页数
 * uid：用户id
 * 返回值
 * time：时间
 * contact：金额
 * remark：说明
 * n_no：订单号
 * type:1订单消费，2服务酬劳
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST ['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$page = $_POST['page'];
if(empty($page)){
	$page =1;
}
$COUNT_p = 20;
$startpage = ($page - 1)*$COUNT_p;

//统计记录数
$sql1 = "SELECT count(*) from ".T('reward')." where uid=$uid ";
$rt=$mysqli->query($sql1);
$rto=$rt->fetch_row();

$result['list'] = array ();
$result['count'] = "0";

$sql = "SELECT * from  ".T('reward')." where uid=$uid ORDER BY id DESC  LIMIT $startpage, $COUNT_p ";
$res = $mysqli->query ( $sql );
if ($res) {
	while ( $row = $res->fetch_assoc () ) {
		$result['list'][] = $row;

	}
	$result['count']=$rto[0];
	Errors::exitWithJson(0,$result);
} else {
	Errors::exitWithJson ( 10002 );
}