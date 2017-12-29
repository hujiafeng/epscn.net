<?php
header ( 'Content-type: application/json' );
require_once("../../config.php");

require_once("AopClient.php");
require_once("AlipayTradeAppPayRequest.php");
//传递订单参数
$no     = $_POST['no'];
$reward = $_POST['reward'];

$aop = new AopClient;
$aop->gatewayUrl = "https://openapi.alipaydev.com/gateway.do";
$aop->appId = "2017072407879227";
//应用私钥（2048）
$aop->rsaPrivateKey = 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCYS0gcWQEvl8eZ0CWRzkmbJqXRXRVUHobpT51rVUtIw9Rj2FcvTnVOoVL7NUlp8vJ7+nWTD0UBqeJCU4XstjomA49JkpaMxuvHR0FXiBaKmKq/wyIu4t2O6Y9SkZY2IIXjMlIspyC2tpD3QF14SKAJj42He3AuaEFHVkbe3mG978K7gW5fxbCPIG4Fn2lN6gET2IY5IuD+V0mkXm+zRnK08UuflWfj2gcbS4IL5pfjtA8GGeVeTpoXvl9UerljBeeH37DUf5McTMZZKDmcrN0SV8UJW67G5UqsZjsqgi6Tc177+TyflhCDA54HuqoV1CahkG3BpfEtBOFSvKtDu8YxAgMBAAECggEAJPBdlUKhXwHZkB1Ef5EhmVhOb/G78qNU5dJBxH7zu7qEEZOv0fGd0myey/+oxuH+nsOpMPpLKpQiJSRNH5UzlXTXlGjRy2OUXMmTt79yeDt/bvPNnsG4K6nK8aQOYyKQVwMlm18OOEMf9ljOUxaKescu9OWj2B3Bd6QdnIEkBAV7jbRL+SvvV00b+Wac88PhjwsiFXTZYqJjPhSje2g3JXG6VkvBnx+bILdM3U/KBOUaDBjDGNzHjd5zTSenSyTNkwEpHKxzNWYl/3FBAmTLgv429yJ8NgGAYNuITQEtoP5Rw4YUZj829+ScBaqRNtUYo4nVczrC8rKCODpYQrK6gQKBgQDVG4KTik/rmR0qftJUP11wXEZion3Q//vRSh/ahELLOXiKEyJDe8d2tty1qT8HeF/n4AKsbFeHXl99/78OUjJ73vifWI2UEOg83N7niUPGta2rNKixtFKu48xT5TeVW9ncbpLvEzcUCCrNNiYGkxdHViVrfzMhvL2Haeg1XLaeTQKBgQC28lM3YUAJMVXLu1M6gp5CVjkYHMgf+k12BqGBNo5e/AmSpsNoxdiuBQ3Sn8cC4VukfQLAEco7IuuuQNgy0LpJImqsgq8hrAf6INLpZqzCv/hnDBNvFfWU6s8YOGJDHmmquE4VLTsV4A44XglBL2g8DB52paZf6AJ5C0jr9xOhdQKBgDQg0ZUDjT8lKgQ+F3byNQoKGFGCS+J264MrbZVHKwuJGFo2CfiV65m3a0+ogblzEYqnuh+xNMvxIsywZWy8YIr6ZLidsawZYqWYpZHfesu9nyi07driMCOFp3KSLEGFwUnxZlHC0oM86DNgXnbXPid+BBNCfyBuibH5DwsWjbk1AoGAYeDeItf2AbUSePCdA8XUVBt7amojq/Ant0iu6cm9fBYOLRbpn0mStu/fSFvRhrn5ZNS5PveFogP54f2xbeZ8dBpkxi0Y88PtdKZRESysq3k3tjIgx6MRA/5olEW+VLiVwg/fPrc3UGnSUdgFzYlGlDHLrqDLla40fHxMJGrJZu0CgYEAjePxX3N2eGoCRxQwOZKSdcxYIrDSzzyGuLs+Rm/J55KfBZ5zw7whFKqgGyge25Rn0IWZ95dPU82zk33Pa3uBCT/4d30UN9UX2UgJuY7PMhZDsPGwyZ85HDCqBCaDxqDrDfVRWAIYi5sYPV1GiqA7TAAy3EDGtCrcMXfhjkD9tRA=';
$aop->format = "json";
$aop->charset = "UTF-8";
$aop->signType = "RSA2";
//支付宝公钥（开放平台->应用公钥（2048）生成）
$aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlVJZqtqocJhkPbkRZT0Co7rxtERYayWiYtksmt5ALuUENXEp4rJBg6Bn5+CJYfDcH6Q16hZZLULNPwRTDLosmt6pqFFqXuqZ+hN8vX8vsKv/2dph/vxe1Xz4/MSPTYhUCuMUV4ixNEqoXEBrF9BW0/DtHixtMGMCay73E6oV504qYQ3vu3dE1Swi0grfEzVsAtMQ2neyDeFRehji96lkHU2dIn1i57FFjCwgdozn2vxdsGn/tObSZCC4VMIWsFyDA3MJwZQf9eJYHLx45kBHtIFBT7m5D+kwYPgrQZX1fkPS6yV+DSVA1/IdVbhBaGk/mZDDNB5bBdflweAuq05V/QIDAQAB';
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
$request = new AlipayTradeAppPayRequest();
//SDK已经封装掉了公共参数，这里只需要传入业务参数
$bizcontent = "{\"body\":\"\"," 
                . "\"subject\": \"订单支付\","
                . "\"out_trade_no\": \"$no\","
                . "\"timeout_express\": \"30m\"," 
                . "\"total_amount\": \"$reward\","
                . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                . "}";
$request->setNotifyUrl("https://www.epscn.net/apit/pay/alipay/callback.php");
$request->setBizContent($bizcontent);

//这里和普通的接口调用不同，使用的是sdkExecute
$response = $aop->sdkExecute($request);
//htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
//echo json_encode($response);//就是orderString 可以直接给客户端请求，无需再做处理。
$data = array ("response" => $response);
Errors::exitWithJson(0,$data);
?>