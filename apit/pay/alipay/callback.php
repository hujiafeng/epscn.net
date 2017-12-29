<?php
require_once("../../config.php");
require_once("AopClient.php");
$aop = new AopClient;
//支付宝公钥（开放平台->应用公钥（2048）生成）
$aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlVJZqtqocJhkPbkRZT0Co7rxtERYayWiYtksmt5ALuUENXEp4rJBg6Bn5+CJYfDcH6Q16hZZLULNPwRTDLosmt6pqFFqXuqZ+hN8vX8vsKv/2dph/vxe1Xz4/MSPTYhUCuMUV4ixNEqoXEBrF9BW0/DtHixtMGMCay73E6oV504qYQ3vu3dE1Swi0grfEzVsAtMQ2neyDeFRehji96lkHU2dIn1i57FFjCwgdozn2vxdsGn/tObSZCC4VMIWsFyDA3MJwZQf9eJYHLx45kBHtIFBT7m5D+kwYPgrQZX1fkPS6yV+DSVA1/IdVbhBaGk/mZDDNB5bBdflweAuq05V/QIDAQAB';
$flag = $aop->rsaCheckV1($_POST, NULL, "RSA2");

$file_handle =fopen(ROOT."apit/pay/alipay/pay_log.txt", "a+");
$response = json_encode($_POST);
if($flag){
	fwrite($file_handle, "true");
	$out_trade_no = $_POST["out_trade_no"];
	$_pay_money = $_POST['total_fee'];
	
	$sql_payed ="UPDATE ".T('need')." SET status='16',pay_mode='4',pay_time=NOW(),reward='$_pay_money',reward_m='2' WHERE no ='$out_trade_no' and status='15'";
	$res = $mysqli->query($sql_payed);
	if($res){
		$t_sql = "SELECT uid_x from ".T('need')." where no=$out_trade_no";
		$t_res = $mysqli->query ( $t_sql );
		$row=$t_res->fetch_assoc();

		//订单消费记录
		$sql_con = "INSERT INTO ".T('reward')." SET uid=".$row["uid_x"].",contact='$_pay_money',remark='订单消费',type=1,n_no='$out_trade_no'";
		$mysqli->query ( $sql_con );
	}	

	echo "success";
}else{
fwrite($file_handle, "false");
}

/*if(!empty($_POST))
fwrite($file_handle, "==>".date("Y-m-d H:i")."\n$response\n");
fclose($file_handle);*/

?>