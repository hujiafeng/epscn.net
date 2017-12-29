<?php
/**
 * 手机用户注册
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
require './config.php';
require '../common/API.class.php';
require '../common/DBC.class.php';
require '../common/number_string.inc.php';
$_phone = $_POST ['phone'];
$_passwd = $_POST ['password'];
$_sms_token = $_POST ['sms_token'];

$pattern = "/^1[34578]{1}\d{9}/";

$token = md5 ( APP_KEY . $_phone );
// sms_token 错误，非正常注册
if (empty ( $_sms_token ) || $token != $_sms_token) {
	API::exitWithJson ( API::E_PARAM_VALUE_ERROR );
}

// 手机号错误
if (preg_match ( $pattern, $_phone ) == 0) {
	API::exitWithJson ( API::E_PARAM_VALUE_ERROR );
}


$dbc = new DBC();
$mysqli = $dbc->get_MySQLi_Object ();

if ($mysqli == FALSE) {
	API::exitWithJson ( API::E_DB_CONNECTION );
}

$_gender   =$_POST['gender'];
if(empty($_gender)){
	$_gender ='N';
}
//
$_fullname  =$mysqli-> real_escape_string($_POST['fullname']);

//头像
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
		$file_name = date ( 'YmdHi' ) . rand_string_only_number ( 8 ) . "_0" . ".$file_ext";
		$des_path = $dir_path . $file_name;
		
		$r = move_uploaded_file ( $_FILES ['avatar'] ['tmp_name'], $des_path );
	}
}


$_password = sha1 ( $_passwd );



$sql = "INSERT INTO se_user SET mobile_phone  = '$_phone',password = '$_password',fullname = '$_fullname',avatar = '$file_name',gender ='$_gender', reg_time =  NOW()";

if ($mysqli->query ( $sql )) {
	API::exitWithJson ( API::E_OK );
} else {
	API::exitWithJson ( API::E_DB_QUERY_ERROR ,$sql);
}



