<?php
/**
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月18日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
$name = php_sapi_name ();
if ($name != 'cli') {
	exit ( "==>cli program!\n" );
}

$smsContent = "【销售助手】，恭贺您，项目成功签订合同！";
$mobile = "13951214127";

$gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';
$serialNumber = '3SDK-CHZ-0130-KCYPR';
$password = '699505';
$sessionKey = '123456';
$connectTimeOut = 2;
$readTimeOut = 10;
$proxyhost = false;
$proxyport = false;
$proxyusername = false;
$proxypassword = false;

include '../common/message/Client.php';
$client = new Client ( $gwUrl, $serialNumber, $password, $sessionKey, $proxyhost, $proxyport, $proxyusername, $proxypassword, $connectTimeOut, $readTimeOut );
$client->setOutgoingEncoding ( "UTF-8" );

///$info = $client->getBalance();
$statusCode = $client->sendSMS ( array (
		"$mobile"
), "$smsContent" );

echo $statusCode;
//echo $info;
