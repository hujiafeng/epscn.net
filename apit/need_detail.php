<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * need_detail  订单详情接口
 * 参数
 * id:订单ID
 * type:用户类型（0普通用户，1服务商）
 * 返回值
 * id:订单ID
 * no:订单号
 * kuanxing:设备款型
 * status：（待确认需求11、待指派人员12、待服务完成13、待确认完工14、待支付费用15、交易完成16、待完工审核17、待酬劳结算18、交易完成_服务方19、已取消-2）
 * biaoqian:任务类型
 * miaoshu1:工作描述1
 * city:省市区
 * address:详细地址
 * fw_id:服务身份
 * gw_name:顾问姓名
 * gw_number:专属顾问
 * miaoshu2:工作描述（评定描述）
 * go_time:上门时间
 * reward:服务费合计
 * get_reward:服务酬劳
 * zuobiao：坐标
 * longitude：经度
 * latitude：纬度
 * js_name:技师姓名
 * js_number：技师电话
 * lx_name:现场联系人
 * lx_number：现场联系人电话
 * report:是否已出完工报告，1是、0否
 * photo:图片（type图片1、视频2，small小图，large大图）
 * photo2:评审图片（small小图，large大图）
 * evaluate：1已评价，0未评价
 * pay_mode：2线下结算
 * time：工单发布时间
 * check_time：审核通过时间
 * js_time：指定人员时间
 * app_over_time:服务商申请完工时间
 * end_time：确认完工时间
 * pay_time：确认收款时间
 * end_time_f:服务商确认完工时间
 * reward_time:确认打款时间
 * del_time:订单取消时间
 */
header ( 'Content-type: application/json' );
require 'config.php';

$id = ( int ) $_POST['id'];
$type = $_POST['type'];
if(!$id)
	Errors::exitWithJson(20000);

$sql = "SELECT id,no,status,js_name,js_number,lx_name,lx_number,biaoqian,miaoshu1,city,address,zuobiao,fw_id,gw_name,gw_number,miaoshu2,
		go_time,reward,get_reward,pay_mode,time,check_time,js_time,app_over_time,end_time,pay_time,end_time_f,reward_time,del_time,
		(SELECT title FROM ".T('m_library')." WHERE id=".T('need').".kuanxing) AS kuanxing FROM ".T('need')." WHERE id = $id ";
$res = $mysqli->query ( $sql );
if ($res) {
	$result_row = $res->fetch_assoc ();
	
	if($result_row["zuobiao"]){
		$zb = explode(",",$result_row["zuobiao"]);
	}
	$result_row["longitude"] = $zb[0];
	$result_row["latitude"] = $zb[1];
	
	if($result_row["pay_mode"] == "2" || $result_row["pay_mode"] == "3"){
		$result_row["pay_mode"] = "2";
	}
	
	//查询是否已出完工报告
	$sql_r = "SELECT id FROM ".T('report')." WHERE nid=$id";
	$res_r = $mysqli->query($sql_r);
	$row_r = $res_r->fetch_row();
	$result_row["report"] = $row_r["0"]?"1":"0";
	
	//查询是否已评价
	$sql_e = "SELECT id FROM ".T('evaluate')." WHERE nid=$id";
	$res_e = $mysqli->query($sql_e);
	$row_e = $res_e->fetch_row();
	$result_row["evaluate"] = $row_e["0"]?"1":"0";
	
	//服务端工单详情状态
	if($type && $result_row["status"] > 13){
		if($result_row["get_reward"] == ""){
			$result_row['status'] = "17";//待完工审核
		}else{
			if($result_row["reward_time"] == ""){
				$result_row['status'] = "18";//待酬劳结算
			}else{
				$result_row['status'] = "19";//交易完成
			}
		}
	}
	
	// 获取相关图片
	$_assoc_photo = array ();
	$sql_photo = "SELECT small,large,type FROM ".T('photo')." WHERE n_id = $id AND flag=1 and type<3 order by type desc";
	$res2 = $mysqli->query ( $sql_photo );
	while ( $row = $res2->fetch_assoc () ) {
		$row ['type']  = $row ['type'];
		$row ['small'] = PHOTO_URL . $row ['small'];
		$row ['large'] = PHOTO_URL . $row ['large'];
		$_assoc_photo [] = $row;
	}
	$result_row ['photo'] = $_assoc_photo;
	
	// 获取相关图片
	$_assoc_photo2 = array ();
	$sql_photo2 = "SELECT small,large,type FROM ".T('photo')." WHERE n_id = $id AND flag=1 and type=3";
	$res3 = $mysqli->query ( $sql_photo2 );
	while ( $row2 = $res3->fetch_assoc () ) {
		$row2 ['small'] = PHOTO_URL . $row2 ['small'];
		$row2 ['large'] = PHOTO_URL . $row2 ['large'];
		$_assoc_photo2 [] = $row2;
	}
	$result_row ['photo2'] = $_assoc_photo2;
	
	Errors::exitWithJson ( 0, $result_row );
} else {
	Errors::exitWithJson ( 10002 ,$sql);
}