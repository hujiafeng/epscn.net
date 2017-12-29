<?php
/**
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月23日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
header("Content-type: text/html; charset=utf-8");
// CLI方式运行
$name = php_sapi_name();
if ($name != 'cli') {
    exit("Runtime Error \n");
}
$cfgDB = array(
    'host' => 'localhost',
    'user' => 'dba_three', // 用户 db_all_admin
    'pass' => 'interest0820', // 密码 PinMiX2013P41
    'name' => 'dq_sale_expert'
);

$mysqli = new mysqli ($cfgDB['host'], $cfgDB['user'], $cfgDB['pass'], $cfgDB['name']);
if (!$mysqli->connect_error) $mysqli->query("SET NAMES 'UTF8'");


include 'PushService.class.php';

$ruid = intval($argv[1]); // 推送给某用户
$msg = $argv[2];

$res = $mysqli->query("SELECT * FROM se_device_token WHERE user_id=$ruid");
while ($row = $res->fetch_assoc()) {
    $token = $row['token'];
    $app_type = $row['app_type'];
    if ($token) {
        if ($app_type < 3) {
            PushService::iosPush($token, $msg);
        }else {
            $arrToken[] = $token;
        }
    }
}

if(count($arrToken)>0){
    $ret= PushService::androidPush($arrToken, $msg);
    //echo $ret;
}


