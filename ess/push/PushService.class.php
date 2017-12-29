<?php
/**
 * 
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年8月23日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
/**
 *
 * @author icity
 *        
 */
require_once dirname(__FILE__) . '/apns/AppleiOSPush.class.php';
require_once dirname(__FILE__) . '/baidu/sdk.php';

class PushService
{

    /**
     *
     * @param string $deveiceType
     * @param string $alert
     *            推送内容
     * @param unknown $arr_info
     */
    public static function iosPush($deviceToken, $alert, $arr_info = null)
    {
        $iosPush = new AppleiOSPush();
        $iosPush->isDebug = true;
        $pemfile = dirname(__FILE__) . '/apns/ess.pem';
        
        $passphrase = 'mecan7810W';
        echo $pemfile . PHP_EOL;
        
        return $iosPush->pushMessage($deviceToken, $pemfile, $passphrase, 1, $alert);
    }

    /**
     * android 推送
     * 
     * @param unknown $channel_id
     * @param unknown $title
     * @param unknown $description
     * @param unknown $arr_info
     */
    public static function androidPush($channel_id, $description, $arr_info = null)
    {
        $sdk=new PushSDK();
        $msg = array(
            'title' => "电气销售家",
            'description' => $description, //必选
            //'custom_content' => array('type' => 7, 'mid' => $arr_info[0], 'uid' => $arr_info[1]),
        );
        $opts = array(
            'msg_type' => 1,
        );
        $ret = $sdk->pushBatchUniMsg($channel_id, $msg, $opts);
        
        return $ret;
    }
}