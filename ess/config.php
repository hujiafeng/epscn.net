<?php
ini_set('display_errors', 'off'); // 错误提示, 上线则关闭
                                  // error_reporting(~E_NOTICE);
ini_set('date.timezone', 'PRC'); // 时区
define('CURSCRIPT', basename($_SERVER['PHP_SELF'])); // 当前脚本名如config.php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS); // 根目录绝对地址
define('PHOTO_ROOT', ROOT . 'photo' . DS); // 图片目录
define('SITE_URL', "/DataDisk/www/wwwroot/www.epscn.net/ess/"); // 网址define('SITE_URL', "/www/mecan.net/ess/");
define('PHOTO_URL', SITE_URL . 'photo/'); // 图片网址
define('JQ_URL', SITE_URL . 'jquery/jquery.min.js'); // jquery地址
define('SMARTY_DIR', SITE_URL . 'common/libs/');
define('TOKEN','ez6192iyjbqmuol07dhkx45scfwtrnpa');

$cfgDb = array(
    'host' => 'localhost', // 地址 61.160.222.28
    'user' => 'root', // 用户 db_all_admin
    'pass' => '4d5b6b0ebe601561', // 密码 PinMiX2013P41
    'name' => 'dq_sale_expert'
); // 数据库名

   
// 管理登录
if (isset($_COOKIE['dq_sysUser'])) {
    $_dqUser=json_decode($_COOKIE['dq_sysUser'],true);
    $sysuid=$_dqUser['dqUid'];
    $sysuname=$_dqUser['dqName'];
    $systoken=$_dqUser['dqToken'];
}


// 其他
$act = $_REQUEST['act'];
$redirect = $_REQUEST['redirect'] ? $_REQUEST['redirect'] : $_SERVER['HTTP_REFERER'];
$time = time();

include_once (SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = SITE_URL . 'templates';
$smarty->compile_dir = SITE_URL . "templates_c";
$smarty->cache_dir = SITE_URL . "cache";
$smarty->cache_lifetime = 0;
$smarty->caching = true;

$smarty->left_delimiter = "{#";
$smarty->right_delimiter = "#}";

$smarty->assign("sysuname",$sysuname);





