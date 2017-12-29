<?php
/** * Edit date：2015/4/29
 *     Author：NPT
 */

// 应用入口文件
// 检测PHP环境
ini_set('session.cookie_domain', ".domain.com");
error_reporting(0);
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
 //设定编码
header('Content-Type: text/html; charset="utf-8"');
//目录安全文件
define('BUILD_DIR_SECURE', true);
//define('DIR_SECURE_CONTENT', 'deney Access!');
//网站当前路径
define('SITE_PATH', getcwd());
//定义项目名称
define('APP_NAME', 'Application');
// 确定应用路径
define ( 'APP_PATH', SITE_PATH.'/Application/' );
//应用公共模块目录
define('COMMON_PATH',SITE_PATH.'/Common/');
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);
$_COOKIE['defaultLocale']=$_COOKIE['think_template'];
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';


