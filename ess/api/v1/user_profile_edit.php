<?php
/**
 * 用户资料编辑
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/DBC.class.php';
require '../common/API.class.php';
//require '../common/image_gd.inc.php';
require '../common/number_string.inc.php';

// session uid
$uid = $_SESSION ['user'] ['id'];

if (empty ( $uid )) {
	API::exitWithJson ( API::E_ACCESS_ERROR );
}


$dbc = new DBC ();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}
$fields = array ();


if (! empty ( $_POST ['gender'] )) {
	$gender = $mysqli->real_escape_string ( $_POST ['gender'] );
	$sql_gender ="UPDATE se_user SET gender = '$gender' ,gm =1 WHERE gm =0 AND user_id = $uid";
	$mysqli->query($sql_gender);
	
	if(empty($_FILES) && empty($_POST['fullname'])){
		API::exitWithJson ( API::E_OK );
	}
	
}

if (! empty ( $_POST ['fullname'] )) {
	$fullname = $mysqli->real_escape_string ( $_POST ['fullname'] );
	$fields [] = "fullname='$fullname'";
}

if (! empty ( $_FILES )) {
	
	if (is_uploaded_file ( $_FILES ['avatar'] ['tmp_name'] )) {
		
		$file_ext = pathinfo ( $_FILES ['avatar'] ['name'], PATHINFO_EXTENSION );
		
		if (empty ( $file_ext )) {
			// 文件扩展没有
			$file_ext = "jpg";
		}
		
		$dir_path = AVATAR_DIR;
		if (! is_dir ( $dir_path )) {
			@mkdir ( $dir_path, 0755, true );
		}
		$file_name = date ( 'YmdHi' ) . rand_string_only_number ( 8 ) . "_$uid" . ".$file_ext";
		$des_path = $dir_path . $file_name;
		
		$r = move_uploaded_file ( $_FILES ['avatar'] ['tmp_name'], $des_path );
		// 上传文件错误
		if ($r == FALSE) {
			API::exitWithJson ( API::E_UPLOAD_FILE_ERROR );
		} else {
			$fields [] = "avatar = '$file_name' ";
		}
	}
}
$strFd = join ( ',', $fields);
if ($strFd) {
	$sql_u = "UPDATE se_user SET {$strFd} WHERE user_id='$uid' ";
	
	if ($mysqli->query ( $sql_u )) {
		API::exitWithJson ( API::E_OK );
	} else {
		API::exitWithJson ( API::E_DB_CONNECTION );
	}
} else {
	API::exitWithJson ( API::E_PARAM_VALUE_ERROR );
}
