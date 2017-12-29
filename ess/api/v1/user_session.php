<?php
/**
 * 如果client 用户登录， Keeping session
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月25日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';
require '../common/Token.class.php';

$_access_token = $_POST ['access_token'];

$_user_id = $_POST ['user_id'];

$_token = Token::genAccessToken ( APP_ID, APP_KEY, $_user_id );

if ($_token != $_access_token) {
	// 不是合法用户
	API::exitWithJson ( API::E_ACCESS_ERROR );
}

$_uid = $_SESSION ['user'] ['id'];

//
$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}
$sql = "SELECT *,(SELECT COUNT(*) FROM se_message WHERE ruid = A.user_id AND rread = 0 AND type = 0) AS noti_count 
,(SELECT COUNT(*) FROM se_message WHERE ruid = A.user_id AND rread = 0 AND type >0) AS msg_count FROM se_user  AS A WHERE user_id = $_user_id ";

$res = $mysqli->query ( $sql );

if ($res) {
	$row = $res->fetch_assoc ();
	if (isset ( $row ['user_id'] )) {
		// 获取用户记录
		// 用户被禁止
		if ($row ['uflag'] == '1') {
			API::exitWithJson ( API::E_FORBIDDEN );
		}
		// session  ，rewrite
		$_SESSION ['user'] ['id'] = $row ['user_id'];
		
		session_write_close ();
		
		$data = array ();
		$data ['user_id'] = $row ['user_id'];
		$data ['fullname'] = $row ['fullname'];
		$data ['gender'] = $row ['gender'];
		$data ['avatar'] = empty($row ['avatar'])?"":ROOT_URL."avatar/".$row['avatar'];
		$data ['score_total'] = $row ['score_total'];
		$data ['score_now'] = $row ['score_now'];
		$data ['gm'] = $row ['gm'];
		$data ['msg_count'] = $row ['msg_count'];
		$data ['noti_count'] = $row ['noti_count'];
		$data["test"] ="";
		// 恢复会话使用
		$data ['access_token'] = $_token;
		
		API::exitWithJson ( API::E_OK, $data );
	}
}
else{
	API::exitWithJson(API::E_DB_QUERY_ERROR);
}
