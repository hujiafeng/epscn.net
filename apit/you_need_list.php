<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * you_need_list 服务商订单列表接口
 * 参数
 * uid：用户id
 * status：（待指派1、待完工2、待结算3、已完成4）
 * page：页数
 * content：搜索内容
 * 返回值
 * id：订单id
 * no：订单号
 * status：（待指派人员12、待服务完成13、待完工审核14、待酬劳结算15、交易完成16、已取消-2）
 * kuanxing：款型
 * miaoshu2：工作内容
 * city:省市区
 * address：地址
 * go_time：完成时间
 * get_reward：服务酬劳
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST['uid'];
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
$status = $_POST ['status'];
//状态搜索
if($status == "1"){
	$status = "AND status='12' ";
}elseif($status == "2"){
	$status = "AND status > 12";
}elseif($status == "3"){
	$status = "AND status > 13 and reward_time = '' and get_reward != '' ";
}elseif($status == "4"){
	$status = "AND status > 13 and reward_time != '' and get_reward != '' ";
}

//内容搜索
if($content){
	$status = $status."AND (no LIKE '%$content%' or city LIKE '%$content%' or address LIKE '%$content%' or fw_id LIKE '%$content%') ";
}

//统计记录数
$sql1 = "SELECT count(*) FROM ".T('need')." WHERE uid_f = $uid ".$status;
$rt=$mysqli->query($sql1);
if($rt)
	$rto=$rt->fetch_row();

$sql = "SELECT id,no,status,kuanxing,miaoshu2,city,address,go_time,get_reward FROM ".T('need')." WHERE uid_f = $uid ".$status." ORDER BY time DESC LIMIT $s_page ,$PC";
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
		if($status == "2"){
			if($row['status'] > 13){
				$row['status'] = "14";
			}
		}elseif($status == "3"){
			$row['status'] = "15";
		}elseif($status == "4"){
			if($row['status'] != "-2"){
				$row['status'] = "16";
			}
		}
		
		$result['list'][] = $row;
	}
	$result['count']=$rto[0]?$rto[0]:"0";
	
	Errors::exitWithJson(0,$result);
}else{
	Errors::exitWithJson(10002);
}
