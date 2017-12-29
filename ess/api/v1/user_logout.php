<?php
/**
 * 安全注销
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月21日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
 
header ( 'Content-type: application/json' );

session_start();
//clear all session data
$_SESSION = array();
exit(json_encode(array("code"=>0)));