<?php
/**
  *@email wsshh1314@outlook.com	
  *@date 2014年7月10日
  *@version 1.0
  *@since 1.0
  *@description 
  */
//require_once dirname ( __FILE__ ) . '/../library/HttpClient.class.php';
require_once '/message/Client.php';


class SMS {
	/**
	 *
	 * @param String $phone        	
	 * @param String $msg        	
	 * @return Ambigous <number, mixed, boolean, string, unknown>
	 */
	public static function MTSend($phone, $msg) {
		
		$gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';
		$serialNumber = '3SDK-EMY-0130-KCXLN';
		$password = '040142';
		$sessionKey = '123456';
		$connectTimeOut = 2;
		$readTimeOut = 10;
		$proxyhost = false;
		$proxyport = false;
		$proxyusername = false;
		$proxypassword = false;
		
		$sendMSG = $msg;
		
		$client = new Client ( $gwUrl, $serialNumber, $password, $sessionKey, $proxyhost, $proxyport, $proxyusername, $proxypassword, $connectTimeOut, $readTimeOut );
		$client->setOutgoingEncoding ( "UTF-8" );
		// $smsContent=urlencode($smsContent);
		// return $mobile;
		
		print_r($client->getVersion());
		exit;
		//return $client->sendSMS ( array ("$phone"), "$sendMSG", '', '', 'GBK', 5 );
	}
}

?>