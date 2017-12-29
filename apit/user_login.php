<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * user_login 用户登录接口
 * 参数
 * mobile:手机号
 * password:密码
 * token
 * 返回值
 * uid:用户id
 * not:消息未读数
 * type：类型（0普通用户、1服务商）
 */
header ( 'Content-type: application/json' );
require 'config.php';

$mobile = trim ( $_POST ['mobile'] );
$passwd = trim ( $_POST ['password'] );
$token  = trim ( $_POST ['token'] ); 

$sql = "SELECT uid,passwd,type,flag FROM ".T('user')." WHERE mobile ='$mobile'";
$res = $mysqli->query ( $sql );
if ($res->num_rows == 1) {
	$row = $res->fetch_assoc ();
	if($row ['flag'] == "1"){
		Errors::exitWithJson ( 20007 );
	}else{
		if (md5 ( $passwd ) == $row ['passwd']) {
			//用户未读条数
			$sql_n = "SELECT count(*) FROM ".T('notification')." WHERE ruid=".$row['uid']." and flag='1' and isread='0'";
			$rt_n  = $mysqli->query($sql_n);
			$rto_n = $rt_n->fetch_row();
			
			$sql_u_u = "UPDATE ".T('user')." SET last_time = NOW(),token='$token' WHERE uid=".$row['uid'];
			$mysqli->query($sql_u_u);
			$data = array (
				'uid'  => $row ['uid'],
				'type' => $row ['type'],
				'not'  => $rto_n[0]
					);
			Errors::exitWithJson ( 0, $data );
		}else{
			Errors::exitWithJson ( 20010 );
		}
	}
}else{
	Errors::exitWithJson ( 20011);
}
