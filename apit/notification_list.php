<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * notification_list 消息列表接口
 * 参数
 * page：页数
 * uid：用户id
 * 返回值
 * noti_id：消息id
 * content：内容
 * isread：是否已读（0未读、1已读）
 * ctime：时间
 * count：消息数量
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST ['uid'];
if (!$uid)
	Errors::exitWithJson (10000);

$page  = $_POST['page'];
if(empty($page)){
	$page =1;
}
$COUNT_p =20;
$startpage = ($page -1)*$COUNT_p;

$where = " WHERE ruid = ".$uid." AND flag =1";
$sql = "SELECT noti_id,content,isread,ctime FROM  ".T('notification')." $where ORDER BY ctime DESC  LIMIT $startpage, $COUNT_p ";
$res = $mysqli->query ( $sql );

//统计记录数
$sql1 = "SELECT count(*) from ".T('notification').$where;
$rt=$mysqli->query($sql1);
$rto=$rt->fetch_row();

if ($res) {
	$result['list'] = array ();
	while ( $row = $res->fetch_assoc () ) {
		$result['list'][] = $row;
	}
	$result['count']=$rto[0];
	Errors::exitWithJson(0,$result);
} else {
	Errors::exitWithJson ( 10002 );
}