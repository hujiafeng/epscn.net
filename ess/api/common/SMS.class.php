<?php
/**
 *@email wsshh1314@outlook.com	
 *@date 2014年7月10日
 *@version 1.0
 *@since 1.0
 *@description 
 */
require_once dirname ( __FILE__ ) . '/message/Client.php';
class SMS {
	public static function MTSend($phone, $msg) {
		$gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';
		$serialNumber = '3SDK-CHZ-0130-KCYPR'; // '3SDK-EMY-0130-KCXLN';
		$password = '699505';
		$sessionKey = '123456';
		$connectTimeOut = 2;
		$readTimeOut = 10;
		$proxyhost = false;
		$proxyport = false;
		$proxyusername = false;
		$proxypassword = false;
		
		$client = new Client ( $gwUrl, $serialNumber, $password, $sessionKey, $proxyhost, $proxyport, $proxyusername, $proxypassword, $connectTimeOut, $readTimeOut );
		$client->setOutgoingEncoding ( "UTF-8" );
		// $smsContent=urlencode($smsContent);
		// return $mobile;
		return $client->sendSMS ( array (
				"$phone" 
		), "$msg", '', '', 'GBK', 5 );
	}
	
	// public static function MTSend($phone, $msg) {
	// $curl = curl_init ();
	// $serialNumber = '3SDK-CHZ-0130-KCYPR'; // '3SDK-EMY-0130-KCXLN';
	// $password = '699505';
	
	// curl_setopt_array ( $curl, array (
	// CURLOPT_URL => "http://sdk4http.eucp.b2m.cn/sdkproxy/sendsms.action",
	// CURLOPT_RETURNTRANSFER => true,
	// CURLOPT_ENCODING => "",
	// CURLOPT_MAXREDIRS => 10,
	// CURLOPT_TIMEOUT => 30,
	// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	// CURLOPT_CUSTOMREQUEST => "POST",
	// CURLOPT_POSTFIELDS => "cdkey=$serialNumber&password=$password&phone=$phone&message=$msg"
	// ) );
	
	// $response = curl_exec ( $curl );
	// $err = curl_error ( $curl );
	
	// curl_close ( $curl );
	// }
}
