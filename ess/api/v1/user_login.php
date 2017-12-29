<?php
/**
 * 登录
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';
require '../common/Token.class.php';

$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}
if (isset ( $_POST ['mobile_phone'] )) {
	// 手机登录
	
	$_phone = $_POST ['mobile_phone'];
	
	$_password = sha1 ( $_POST ['password'] );
	
	$sql = "SELECT A.* ,(SELECT COUNT(*) FROM se_message WHERE ruid = A.user_id AND rread = 0 AND type = 0) AS noti_count 
,(SELECT COUNT(*) FROM se_message WHERE ruid = A.user_id AND rread = 0 AND type >0) AS msg_count FROM se_user AS A WHERE mobile_phone = '$_phone' ";
	
	$res = $mysqli->query ( $sql );
	
	if ($res) {
		$row = $res->fetch_assoc ();
		if (isset ( $row ['user_id'] )) {
			// 获取用户记录
			// 用户被禁止
			if ($row ['uflag'] == '1') {
				API::exitWithJson ( API::E_FORBIDDEN );
			}
			if($row['password'] != $_password){
				API::exitWithJson(API::E_PASSWORD_ERROR);
			}
			// session
			$_SESSION ['user'] ['id'] = $row ['user_id'];
			session_write_close ();
			
			$data = array ();
			$data ['user_id'] = $row ['user_id'];
			$data ['fullname'] = $row ['fullname'];
			$data ['gender'] = $row ['gender'];
			$data ['avatar'] = empty($row ['avatar'])?"":ROOT_URL."avatar/".$row ['avatar'];
			$data ['score_total'] = $row ['score_total'];
			$data ['score_now'] = $row ['score_now'];
			$data ['msg_count'] = $row['msg_count'];
			$data['noti_count']=$row['noti_count'];
			$data ['gm'] = $row ['gm'];//性别修改
			
			// 恢复会话使用
			$data ['access_token'] = Token::genAccessToken ( APP_ID, APP_KEY, $row ['user_id'] );
			
			API::exitWithJson ( API::E_OK, $data );
		}
		else{
			API::exitWithJson(API::E_PARAM_VALUE_ERROR);
		}
	}
} else {
	// 其他登录方式暂不支持
	API::exitWithJson ( API::E_PARAM_VALUE_ERROR );
}