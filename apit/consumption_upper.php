<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * consumption_upper 消费清单（线上）接口
 * 参数
 * page：页数
 * uid：用户id
 * 返回值
 * reward：总支出
 * time：时间
 * contact：金额变化
 * remark：说明
 * n_no：订单号
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
$COUNT_p =20;
$startpage = ($page -1)*$COUNT_p;
$where = " where c.uid=$uid and c.n_no=n.no and n.n_type=1";

//统计记录数
$sql1 = "SELECT count(*) as count,sum(contact) as reward from ".T('consumption')." as c,".T('need')." as n $where";
$rt=$mysqli->query($sql1);
$rto=$rt->fetch_row();

$result['list'] = array ();
$sql = "SELECT c.* from ".T('consumption')." as c,".T('need')." as n $where ORDER BY id DESC  LIMIT $startpage, $COUNT_p ";
$res = $mysqli->query ( $sql );
if ($res) {
	$i=0;
	while ( $row = $res->fetch_assoc () ) {
		$result['list'][$i]["time"] = $row["time"];
		$result['list'][$i]["contact"] = $row["contact"];
		$result['list'][$i]["remark"] = $row["remark"];
		$result['list'][$i]["n_no"] = $row["n_no"];

		$i++;
	}
	
	$result['count']=$rto[0]?$rto[0]:"0";
	$result['reward']=$rto[1]?$rto[1]:"0";

	Errors::exitWithJson(0,$result);
} else {
	Errors::exitWithJson ( 10002 );
}