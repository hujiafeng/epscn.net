<?php
/**
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年7月24日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */

session_start();

/*
 * 数据库配置
 */
$cfgDB ['host'] = 'localhost'; // 
$cfgDB ['user'] = 'root';
$cfgDB ['pass'] = 'root';
$cfgDB ['name'] = 'dq_sale_expert'; 

/*
 * define
 */
const ROOT_DIR  = "/DataDisk/www/wwwroot/www.epscn.net/ess/";
const ROOT_URL = "https://www.epscn.net/ess/";
// 头像目录
define ( 'AVATAR_DIR', ROOT_DIR . 'avatar/' );
//APP KEY
const APP_KEY = '86a2db4c0a478340508ef0d87b67cef8';
//短信预定义格式
const SMS_TEMPLATE = "【销售助手】您的短信验证码为<code>。如非本人操作，请忽略此短信。本短信免费。";

const APP_ID = "MJ0003";
