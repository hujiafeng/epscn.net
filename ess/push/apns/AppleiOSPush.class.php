<?php
/**
 * wsshh1314@outlook.com
 * @version 1.0
 *
 */
class AppleiOSPush
{

    //推送模式,默认是Debug
    public $isDebug = true;
    //正式URL
    private $SSLURL_Product = 'ssl://gateway.push.apple.com:2195';
    private $SSLURL_Debug = 'ssl://gateway.sandbox.push.apple.com:2195';

    /**
     *
     * 发送推送消息
     * @param string $deviceToken 设备令牌标示
     * @param string $pemFilePath pem证书路径
     * @param string $passphrase 证书短语密码
     * @param int $bagde 标注数字，一般代表消息数目
     * @param string OR Mix $alert 消息文字内容 或 Array
     * @param string $sound (default) 声音
     * @param array $otherData 其它数据，Key＝>Value对
     *
     * @return 发送结果，成功 true
     */

    public function pushMessage($deviceToken, $pemFilePath, $passphrase, $bagde = 1, $alert, $sound = 'default', $otherData = null)
    {

        $sendResult = false;

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $pemFilePath);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);


        if ($this->isDebug == true) {
            // Open a connection to the APNS server
            $fp = stream_socket_client(
                $this->SSLURL_Debug, $err,
                $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        } else {
            $fp = stream_socket_client(
                $this->SSLURL_Product, $err,
                $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        }

        if (!$fp) {
            $sendResult = false;
           // exit('Failed To connect!');
	     echo "Failed $deviceToken \n";
        } else {
            // Create the payload body
            $body['aps'] = array(
                'badge' => $bagde,
                'alert' => $alert,
                'sound' => $sound);

            if ($otherData != null) {
                foreach ($otherData as $key => $v) {
                    $body[$key] = $v;

                }
            }
            // Encode the payload as JSON
            $payload = json_encode($body);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));
            // Close the connection to the server

            if (!$result) {
                $sendResult = false;
            } else {
                $sendResult = true;
            }
            fclose($fp);
        }

        return $sendResult;

    }


}

