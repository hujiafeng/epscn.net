<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * need_end  完工接口
 * id:订单ID
 */
header ( 'Content-type: application/json' );
require 'config.php';
require ROOT.'ThinkPHP/Library/Org/Jpush/Jpush_f.class.php';

$id = $_POST['id'];
if(!$id)
	Errors::exitWithJson(20000);

$yzsql = "SELECT status from ".T('need')." where id=$id";
$yzres = $mysqli->query ( $yzsql );
if(!$yzres)
	Errors::exitWithJson ( 10002 );

$yzrow=$yzres->fetch_assoc();
if($yzrow["status"] != "4")
	Errors::exitWithJson ( 10003 );


$sql = "UPDATE ".T('need')." SET status='5',end_time=NOW() WHERE id = $id and status=4";
$res = $mysqli->query ( $sql );
if($res){
	$t_sql = "SELECT u.uid,u.token,u.reward,n.no,n.get_reward from ".T('need')." as n,".T('user')." as u where n.uid_f=u.uid and n.id=$id";
	$t_res = $mysqli->query ( $t_sql );
	$row=$t_res->fetch_assoc();
	//修改服务商酬劳
	$z_reward = $row["reward"] + $row["get_reward"];
	$sql_u_u = "UPDATE ".T('user')." SET reward='$z_reward' WHERE uid=".$row["uid"];
	$mysqli->query ( $sql_u_u );
	//记录酬劳明细
	$contact = "+".$row["get_reward"];
	$sql_r = "INSERT INTO ".T('reward')." SET uid=".$row["uid"].",contact='$contact', remark='服务酬劳',n_no=".$row["no"];
	$mysqli->query ( $sql_r );
	
	//推送服务
	$s_name = "【服务商】订单".$row["no"]."需方已验收，酬劳￥".$row["get_reward"]."已入账，本次服务完成。";
	if ($row["token"]){
		//用户未读条数
		$sql_n = "SELECT count(*) FROM ".T('notification')." WHERE ruid=".$row["uid"]." and flag='1' and isread='0'";
		$rt_n  = $mysqli->query($sql_n);
		$rto_n = $rt_n->fetch_row();
	
		$Jpush = new Jpush_f();
		$receive = array('registration_id'=>array($row["token"]));
		$title   = "";
		$content = "$s_name";
		$m_time  = '86400';        //离线保留时间
		$not     = $rto_n[0]+1;
		$extras = array("type"=>"1", "nid"=>$id,"not"=>$not);   //自定义数组
		//调用推送,并处理
		$result = $Jpush->push($receive,$title,$content,$extras,$m_time);
	}
	//插入推送记录
	$sql_not = "INSERT INTO ".T('notification')." SET obj_id='".$row["no"]."',ruid=".$row["uid"].",content='$s_name'";
	$mysqli->query ( $sql_not );

	Errors::exitWithJson ( 0 );
}else{
	Errors::exitWithJson ( 10002 );
}