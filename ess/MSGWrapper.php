<?php

class MSGWrapper
{

    const SYSTEM = 0;
    const MSG_PROJECT_CHECK_YES = 1;// 项目审核通过
    const MSG_PROJECT_CHECK_NO = 2;// 项目不通过
    const MSG_SCORE_GET = 3;//获取积分
    const MSG_SCORE_USE = 4;//兑换积分
    
    public static function doWith($msg_type, $to_uid) {
        // 没有接收用户，退出
        if (empty ( $to_uid )) {
            return;
        }
        $msg = "";
        $msg=self::makePushMsg($msg_type);
        $today = date ( 'Y-m-d' );
        $log = "/www/mecan.net/ess/push/log/$today.log";
        $cmd = "php -f /www/mecan.net/ess/push/push-cli.php  $to_uid  $msg ";
        exec ( $cmd );
    }
    
    public static function makeMsg($msg_type, $obj_name, $other_status) {
        $msg = "";
        $mt = ( int ) $msg_type;
        
        switch ($mt){
            case self::MSG_PROJECT_CHECK_YES :
                $msg = "项目名{$obj_name}，已通过审核。";
                break;
                
            case self::MSG_PROJECT_CHECK_NO :
                $msg = "项目名{$obj_name}，未能通过审核。";
                if ($other_status) {
                    $msg .= "（{$other_status}）";
                }
                break;
                
            case self::MSG_SCORE_GET :
                $msg = "已获得 {$obj_name}积分。";
                break;
                
            case self::MSG_SCORE_USE :
                $msg = "{$obj_name}积分已成功兑现。";
                break;
        }
        return $msg;
    }
    
    public static function makePushMsg($msg_type) {
        $msg = "";
        $mt = ( int ) $msg_type;
        
        switch ($mt){
            case self::MSG_PROJECT_CHECK_YES :
                $msg = "项目已通过审核。";
                break;
                
            case self::MSG_PROJECT_CHECK_NO :
                $msg = "项目未通过审核。";
                break;
                
            case self::MSG_SCORE_GET :
                $msg = "您有获得新的积分。";
                break;
                
            case self::MSG_SCORE_USE :
                $msg = "您的积分有新的兑换。";
                break;
        }
        return $msg;
    }
}