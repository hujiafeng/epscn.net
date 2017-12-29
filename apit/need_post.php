<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * need_post 订单发布接口
 * 参数
 * uid：用户id
 * s_type:设备类型
 * m_id:设备款型id
 * biaoqian:标签
 * city:省市区
 * address:服务地点
 * zuobiao:坐标
 * description:工作内容
 * fw_name:服务身份
 * 返回值
 * id:订单id
 * no:订单号
 */
header ( 'Content-type: application/json' );
require 'config.php';

$uid = $_POST['uid'];
if (!$uid)
	Errors::exitWithJson (10000);
//查询该用户的业务员，绑定订单
$clerk_x = "";
$sql_u = "SELECT clerk_x FROM ".T('user')." WHERE uid =".$uid;
$res_u = $mysqli->query($sql_u);
if($res_u){
	$row_u = $res_u->fetch_row();
	$clerk_x = $row_u[0];
}

$s_type    = $_POST['s_type'];
$m_id      = $_POST['m_id'];
$biaoqian  = $_POST['biaoqian'];
$city      = $_POST['city'];
$address   = $_POST['address'];
$zuobiao   = $_POST['zuobiao'];
$miaoshu1  = $_POST['description'];
$fw_id     = $_POST['fw_name'];
//订单号
$no        = date("yms").sprintf("%05d",mt_rand(1, 99999));

//添加订单
$sql = "INSERT INTO ".T ( 'need' )." SET no='$no',s_type='$s_type',kuanxing='$m_id',biaoqian='$biaoqian',address='$address',city='$city',zuobiao='$zuobiao',miaoshu1='$miaoshu1',fw_id='$fw_id',uid_x='$uid',clerk_x='$clerk_x',time = NOW()";
$res = $mysqli->query ( $sql );
if ($res) {
	$data = array (
			"id" => ( string ) $mysqli->insert_id ,
			"no" => $no
	);
	
	Errors::exitWithJson ( 0, $data );
} else {
	Errors::exitWithJson ( 10002 ,$sql);
}