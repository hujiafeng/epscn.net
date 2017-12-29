<?php
namespace Appframe;
use Think\Controller;
use Com\Util\Input;
class AppframeController extends Controller {
public  $db_config1,$db_config2;
    //各种缓存 比如当前登陆用户信息等
    protected $Cache = array();


    function _initialize() {
        //初始化站点配置信息
        $this->initSite();      
        //载入Input处理类
        //数据处理
        $this->__input();
        //跳转时间
        $this->assign("waitSecond", 10);

		$this->assign("TEMPpath","./Home/tpl/Admin/Common/");
    }

    /**
     * 对 get post 等进行处理
     */
    final private function __input() {
        $_POST   = $this->app__post($_POST);
        $_GET    = $this->app__post($_GET);
        $_COOKIE = $this->app__post($_COOKIE);
    }

    /**
     *  数据处理
     */
    final private function app__post($post) {
        if (!is_array($post)) {
            return $post;
        }
        foreach ($post as $k => $v) {
            if (is_array($v)) {
                $post[$k] = $this->app__post($v);
            } else {
                $post[$k] = Input::getVar($v);
            }
        }
        return $post;
    }




    /**
     * 初始化站点配置信息
     */
    final protected function initSite() {
        $Config = F("Config");
        if (!$Config) {
            $Config = M("fxconfig")->getField("varname,value");
            F("Config", $Config);
        }
        $this->Cache['Config'] = $Config;
        foreach ($this->Cache['Config'] as $k => $v) {
            define('CONFIG_' . strtoupper($k), $v);
        }
        $this->assign("Config", $Config);
        //分配当前操作名到模板  使用$Think.ACTION_NAME有时会有意外情况
        $appinfo = array(
            "action" => ACTION_NAME,
            "group" => CONTROLLER_NAME,
            "module" => MODULE_NAME
        );
        $this->assign("appinfo", $appinfo);
    }


    /**
     * Cookie 设置、获取、删除 
     */
    final static public function cookie($name, $value = '', $option = null) {
        // 默认设置
        $config = array(
            'prefix' => C('COOKIE_PREFIX'), // cookie 名称前缀
            'expire' => C('COOKIE_EXPIRE'), // cookie 保存时间
            'path' => C('COOKIE_PATH'), // cookie 保存路径
            'domain' => C('COOKIE_DOMAIN'), // cookie 有效域名
        );
        // 参数设置(会覆盖黙认设置)
        if (!empty($option)) {
            if (is_numeric($option))
                $option = array('expire' => $option);
            elseif (is_string($option))
                parse_str($option, $option);
            $config = array_merge($config, array_change_key_case($option));
        }
        // 清除指定前缀的所有cookie
        if (is_null($name)) {
            if (empty($_COOKIE))
                return;
            // 要删除的cookie前缀，不指定则删除config设置的指定前缀
            $prefix = empty($value) ? $config['prefix'] : $value;
            if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
                foreach ($_COOKIE as $key => $val) {
                    if (0 === stripos($key, $prefix)) {
                        setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
                        unset($_COOKIE[$key]);
                    }
                }
            }
            return;
        }
        $name = $config['prefix'] . $name;
        if ('' === $value) {
            $value = isset($_COOKIE[$name]) ? $_COOKIE[$name] : null; // 获取指定Cookie
            return authcode($value, "DECODE", C("AUTHCODE"));
        } else {
            if (is_null($value)) {
                setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
                unset($_COOKIE[$name]); // 删除指定cookie
            } else {
                //$value 加密
                $value = authcode($value, "", C("AUTHCODE"));
                // 设置cookie
                $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
                setcookie($name, $value, $expire, $config['path'], $config['domain']);
                $_COOKIE[$name] = $value;
            }
        }
    }

   

    /**
     * 验证码验证
     * @param type $verify 
     */
    static public function verify($verify) {

        if ($_SESSION['code'] == strtolower($verify)){
            unset($_SESSION['code']);
            return true;
        } else {
            return false;
        }
    }
	
/**
  *
  * 获取用户IP
  *
  */
    static public function getip(){
		
		  if(getenv('HTTP_CLIENT_IP')){
			  $onlineip=getenv('HTTP_CLIENT_IP');
		  }else if(getenv('HTTP_X_FORWARDED_FOR')){
			  $onlineip=getenv('HTTP_X_FORWARDED_FOR');
		  }else if(getenv('REMOTE_ADDR')){
			  $onlineip=getenv('REMOTE_ADDR');
		  }else{
			  $onlineip=$_SERVER['REMOTE_ADDR'];
		  }
		  return $onlineip;
	 }
	 
	 public function smtpMail ($address, $title, $message) {
	 	include ("ThinkPHP/Library/Com/phpmailer/class.phpmailer.php"); //邮件服务
	 	$mail = new \PHPMailer();
	 	//$mail->SMTPDebug = 1;
	 	//调试，报错同时得到更见详细的错误信息
	 	//$mail->SMTPDebug = 1;
	 
	 	//设定使用SMTP方式寄信
	 	$mail->IsSMTP();
	 
	 	//设定SMTP需要验证
	 	$mail->SMTPAuth = true;
	 
	 	//Gmail的SMTP主机需要使用ssl连
	 	//$mail->SMTPSecure = "ssl";
	 
	 	//Gmail的SMTP主机
	 	//Gmail的SMTP主机的SMTP端口为465
	 	//$mail->Port = 465;
	 	$mail->Port = 25;
	 	$mail->Host = "smtp.126.com";
	 	//$mail->Host = "smtp.ym.163.com";
	 	// 启用SMTP验证功能
	 	$mail->SMTPAuth = true;
	 	// 设置用户名和密码。
	 	$mail->Username = '';
	 	$mail->Password = '';
	 
	 	// 设置发件人邮箱
	 	$mail->From     = '';
	 	$mail->FromName     ='';
	 	// 设置编码
	 	$mail->CharSet  = "utf8";
	 	$mail->Encoding = "base64";
	 	//收件人地址
	 	$mail->AddAddress($address);
	 	$mail->IsHTML(true);
	 	// 设置邮件标题
	 	$mail->Subject = $title;
	 	$mail->Body = $message;
	 	//该属性的设置是在邮件正文不支持HTML的备用显示
	 	$mail->AltBody ="text/html";
	 	if(!$mail->Send()){
	 		return false;
	 	}else{
	 		return true;
	 	}
	 }
/**
  *
  * 关闭dialog弹窗
  *
  */	 
   public function close_dialog($id='add'){
	   echo '<script style="text/javascript">
	  setTimeout("window.top.right.location.reload();window.top.art.dialog({id:\"'.$id.'\"}).close();",2000); 
	   </script>';		 
	 }

}
?>