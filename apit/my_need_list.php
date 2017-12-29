<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * my_need_list 我的订单列表接口
 * 参数
 * uid：用户id
 * status：（待确认1、待完工2、待付款3、已完成4）
 * page：页数
 * content：搜索内容
 * 返回值
 * id：用户id
 * no：订单号
 * status：（待确认需求11、待指派人员12、待服务完成13、待确认完工14、待支付费用15、交易完成16、已取消-2）
 * kuanxing：款型
 * miaoshu1：工作内容
 * city：省市区
 * address：地址
 * go_time：完成时间
 * reward：服务费
 * evaluate：1已评价，0未评价
 * pay_mode：2线下结算
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid     = $_POST['uid'];
$status  = $_POST['status'];
$content = $_POST['content'];
if (!$uid)
	Errors::exitWithJson (10000);
//分页
$_page = ( int ) $_POST ['page'];
if (empty ( $_page )) {
	$_page = 1;
}
$s_page = ($_page - 1) * 10;
$PC = 10;
//状态搜索
if($status == "1"){
	$status = "AND (status='11' or status='12') ";
}elseif($status == "2"){
	$status = "AND (status='13' or status='14') ";
}elseif($status == "3"){
	$status = "AND status='15' ";
}elseif($status == "4"){
	$status = "AND (status='16' or status='-2') ";
}

//内容搜索
if($content){
	$status = $status."AND (no LIKE '%$content%' or city LIKE '%$content%' or address LIKE '%$content%') ";
}

//统计记录数
$sql1 = "SELECT count(*) FROM ".T('need')." WHERE uid_x = $uid ".$status;
$rt=$mysqli->query($sql1);
if($rt)
	$rto=$rt->fetch_row();

$sql = "SELECT id,no,status,kuanxing,miaoshu1,city,address,go_time,reward,pay_mode FROM ".T('need')." AS A WHERE uid_x = $uid ".$status." ORDER BY time DESC LIMIT $s_page ,$PC";
$res = $mysqli->query ( $sql );
if($res){
	$result['list'] = array ();
	while ( $row = $res->fetch_assoc () ) {
		if($row['kuanxing']){
			$sql_m = "SELECT title FROM ".T('m_library')." WHERE id =".$row['kuanxing'];
			$r_m=$mysqli->query($sql_m);
			$m_s=$r_m->fetch_row();
			$row['kuanxing'] = $m_s[0];
		}
		//查询是否已评价
		$sql_r = "SELECT id FROM ".T('evaluate')." WHERE nid=".$row['id'];
		$res_r = $mysqli->query($sql_r);
		$row_r = $res_r->fetch_row();
		$row["evaluate"] = $row_r["0"]?"1":"0";
		
		$result['list'][] = $row;
	}
	$result['count']=$rto[0]?$rto[0]:"0";

	Errors::exitWithJson(0,$result);
}else{
	Errors::exitWithJson(10002);
}
