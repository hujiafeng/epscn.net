<?php
session_start();
require 'common/DB.class.php';
require 'common/Error.class.php';
// 只允许APP客户端访问，其他都拒绝访问
/* if (strpos ( strtolower ( $_SERVER ['HTTP_USER_AGENT'] ), 'mozilla' ) !== false)
 Errors::exitWithJson ( 20005 ); */
// SSL ON
/* if ($_SERVER ['HTTPS'] != 'on') {
	echo json_encode ( array (
			"code" => 20005,
			"msg" => "Access Denied" 
	) );
	exit ();
} */
// APP_key
define ( 'APP_KEY', '81bd443e4f5ad60bed6e00d42d8babfd' );
define ( 'ROOT', '/www/eps/' ); // 根目录绝对地址
define ( 'PHOTO_ROOT', ROOT . 'uploads/' );
define ( 'SITE_URL', 'http://www.eps.com/' );
define ( 'PHOTO_URL', SITE_URL . 'uploads/' );
define ( 'AVATAR_ROOT', PHOTO_ROOT . 'avatar/' );
define ( 'AVATAR_URL', SITE_URL . 'uploads/avatar/' );
// 数据库配置
$cfgDb = array (
		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'root',
		'name' => 'eps' 
);
define ( 'TABLE_PREFIX', 'd_' );
function T($table) {
	return " ".TABLE_PREFIX . "$table ";
}
//数据库连接是否正确
$db = new DB ();
$mysqli = $db->get_MySQLi_Object ();
if (! $db->isOK)
	Errors::exitWithJson ( 10001 );


