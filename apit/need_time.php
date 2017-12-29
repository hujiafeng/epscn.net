<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.2.0
 * @since  2018年1月1日
 * need_time  订单时间接口
 * 参数
 * id:订单ID
 * type:用户类型（0普通用户，1服务商）
 * 返回值
 * status:（待确认需求11、待指派人员12、待服务完成13、待确认完工14、待支付费用15、交易完成16、待完工审核17、待酬劳结算18、交易完成_服务方19、已取消-2）
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

$id = ( int ) $_POST ['id'];
$type = $_POST['type'];
if(!$id)
	Errors::exitWithJson(20000);

$sql = "SELECT status,get_reward,pay_mode,time,check_time,js_time,app_over_time,end_time,pay_time,end_time_f,reward_time,del_time FROM  ".T('need'). " WHERE id = $id";
$res = $mysqli->query ( $sql );
if ($res) {
	$result = $res->fetch_assoc ();
	
	if($result["pay_mode"] == "2" || $result["pay_mode"] == "3"){
		$result["pay_mode"] = "2";
	}
	
	//服务端工单详情状态
	if($type && $result["status"] > 13){
		if($result["get_reward"] == ""){
			$result['status'] = "17";//待完工审核
		}else{
			if($result["reward_time"] == ""){
				$result['status'] = "18";//待酬劳结算
			}else{
				$result['status'] = "19";//交易完成
			}
		}
	}
	
	Errors::exitWithJson ( 0, $result );
} else {
	Errors::exitWithJson ( 10002 );
}