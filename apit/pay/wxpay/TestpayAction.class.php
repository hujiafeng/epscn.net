<?php
class TestpayAction{

    /*
    配置参数
    */
    var $config = array(
        'appid' => "wx5c763a0cc8f6f99f",    /*微信开放平台上的应用id*/
        'mch_id' => "1488385062",   /*微信申请成功之后邮件中的商户id*/
        'api_key' => "e10adc3949ba59abbe56e057f20f8831",    /*在微信商户平台上自己设定的api密钥 32位*/
        'notify_url' => 'https://www.epscn.net/apit/pay/wxpay/callback.php' /*自定义的回调程序地址id*/
    	//'notify_url' => 'http://test.epscn.net/apit/pay/wxpay/callback.php' /*自定义的回调程序地址id*/
    		
    ); 
//获取预支付订单
    public function wxpay($osn,$total_fee){
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $notify_url = $this->config["notify_url"];
        $out_trade_no = $osn;
        $total_fee    = $total_fee*100;
        $onoce_str    = $this->getRandChar(32);
        $data["appid"]  = $this->config["appid"];
        $data["body"]   = "支付订单";
        $data["mch_id"] = $this->config['mch_id'];
        $data["nonce_str"]  = $onoce_str;
        $data["notify_url"] = $notify_url;
        $data["out_trade_no"] = $out_trade_no;
        $data["spbill_create_ip"] = $this->get_client_ip();
        $data["total_fee"] = $total_fee;
        $data["trade_type"] = "APP"; 
        $s = $this->getSign($data, false);
        $data["sign"] = $s;
        $xml = $this->arrayToXml($data);
        $response = $this->postXmlCurl($xml, $url);
        //将微信返回的结果xml转成数组
        $res = $this->xmlstr_to_array($response);
        $sign2 = $this->getOrder($res['prepay_id']); 
        echo json_encode($sign2);
		die();
    }

//回调数据
	public function callback(){
		$postObj  = $this->xmlstr_to_array($GLOBALS["HTTP_RAW_POST_DATA"]);
		if(($postObj['total_fee'])&&($postObj['result_code']=='SUCCESS')){
			
			$osn       = $postObj['out_trade_no'];//订单号
			$total_fee = $postObj['total_fee']/100;//金额
			$time_end  = $postObj['time_end'];//支付时间
			$trade_no  = $postObj['transaction_id'];//微信支付单号
			
		//链接数据库
			$mysqli = new mysqli ('localhost', 'dbAxyKj', 'JinriLiqiu14', 'www_epscn_net');
			if (!$mysqli->connect_error){
				$mysqli->query("SET NAMES 'utf8mb4'");
			}else{
				exit('fail');
			}
			
			$sql_payed ="UPDATE d_need SET status='16',pay_mode='5',pay_time=NOW(),reward='$total_fee',reward_m='2' WHERE no ='$osn' and status='15'";
			$res = $mysqli->query($sql_payed);
			if($res){
				$t_sql = "SELECT uid_x from d_need where no=$osn";
				$t_res = $mysqli->query ( $t_sql );
				$row=$t_res->fetch_assoc();
			
				//订单消费记录
				$sql_con = "INSERT INTO d_consumption SET uid=".$row["uid_x"].",contact='$total_fee',remark='订单消费',type=1,n_no='$osn'";
				$mysqli->query ( $sql_con );
			}
			
		    echo 'success';
			exit;
		}else{
			echo 'error';
			exit;
		}
	}
/*
        生成签名
    */
    function getSign($Obj)
    {
        foreach ($Obj as $k => $v)
        {
            $Parameters[strtolower($k)] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //echo "【string】 =".$String."</br>";
        //签名步骤二：在string后加入KEY
        $String = $String."&key=".$this->config['api_key'];
        //echo "<textarea style='width: 50%; height: 150px;'>$String</textarea> <br />";
        //签名步骤三：MD5加密
        $result_ = strtoupper(md5($String));
        return $result_;
    }
    //执行第二次签名，才能返回给客户端使用
    public function getOrder($prepayId){
        $data["appid"] = $this->config["appid"];
        $data["noncestr"] = $this->getRandChar(32);
        $data["package"] = "Sign=WXPay";
        $data["partnerid"] = $this->config['mch_id'];
        $data["prepayid"] = $prepayId;
        $data["timestamp"] = time();
        $s = $this->getSign($data, false);
        $data["sign"] = $s;
        return $data;
    }
	/*
	 *	获取回调接口返回信息
	 */
	 public function get_xml_obj(){
	 	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		return $postObj;
	 }
	 //对象转数组
	public function object_to_array($array) {  
		if(is_object($array)) {  
			$array = (array)$array;  
		 } if(is_array($array)) {  
			 foreach($array as $key=>$value) {  
				 $array[$key] = $this->object_to_array($value);  
			 }  
		 }  
		return $array;  
	}
    //获取指定长度的随机字符串
    function getRandChar($length){
       $str = null;
       $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
       $max = strlen($strPol)-1;
       for($i=0;$i<$length;$i++){
        $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
       }
       return $str;
    }
    /*
        获取当前服务器的IP
    */
    function get_client_ip()
    {
        if ($_SERVER['REMOTE_ADDR']) {
        $cip = $_SERVER['REMOTE_ADDR'];
        } elseif (getenv("REMOTE_ADDR")) {
        $cip = getenv("REMOTE_ADDR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
        $cip = getenv("HTTP_CLIENT_IP");
        } else {
        $cip = "unknown";
        }
        return $cip;
    }
	
    /**
    xml转成数组
    */
    function xmlstr_to_array($xmlstr) {
		  $doc = new DOMDocument();
		  $doc->loadXML($xmlstr);
		  return $this->domnode_to_array($doc->documentElement);
    }
    //数组转xml
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
             if (is_numeric($val))
             {
                $xml.="<".$key.">".$val."</".$key.">"; 


             }
             else
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        }
        $xml.="</xml>";
        return $xml; 
    }
    //将数组转成uri字符串
    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
               $v = urlencode($v);
            }
            $buff .= strtolower($k) . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) 
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }
     //post https请求，CURLOPT_POSTFIELDS xml格式
    function postXmlCurl($xml,$url,$second=30)
    {       
        //初始化curl        
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data)
        {
            curl_close($ch);
            return $data;
        }
        else 
        { 
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }
    function domnode_to_array($node) {
      $output = array();
      switch ($node->nodeType) {
       case XML_CDATA_SECTION_NODE:
       case XML_TEXT_NODE:
        $output = trim($node->textContent);
       break;
       case XML_ELEMENT_NODE:
        for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
         $child = $node->childNodes->item($i);
         $v = $this->domnode_to_array($child);
         if(isset($child->tagName)) {
           $t = $child->tagName;
           if(!isset($output[$t])) {
            $output[$t] = array();
           }
           $output[$t][] = $v;
         }
         elseif($v) {
          $output = (string) $v;
         }
        }
        if(is_array($output)) {
         if($node->attributes->length) {
          $a = array();
          foreach($node->attributes as $attrName => $attrNode) {
           $a[$attrName] = (string) $attrNode->value;
          }
          $output['@attributes'] = $a;
         }
         foreach ($output as $t => $v) {
          if(is_array($v) && count($v)==1 && $t!='@attributes') {
           $output[$t] = $v[0];
          }
         }
        }
       break;
      }
      return $output;
    }
	
}
?>