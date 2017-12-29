<?php
/**
 * @author  Shaohui Wang <wsshh1314@outlook.com>
 * @version	1.0
 * @since 2017年3月27日
 * @copyright  (c)2017,ChangZhou Pinmix Network Technology Co., Ltd.
 */
 
class Token{
	
	/**
	 * 统一处理，修改产生算法不影响系统
	 * @param string $app_id 暂时不用，保留，做开放接口使用
	 * @param string $app_key
	 * @param string $salt 可以使用时间戳,随机数,uid组合
	 * @return string access_token
	 */
	const TOKEN_SALT = '748ae34119006a63ead13584c409b1b2';
	
	/**
	 * 生成Accesstoken
	 * @param string $app_id
	 * @param string $app_key
	 * @param string $salt
	 * @return string
	 */
	public static function genAccessToken( $app_id,$app_key,$salt){
		return sha1($app_id."_".$app_key."_".$salt);
	}
	/**
	 * 生成RefreshToken
	 * @param string $access_token
	 * @param string $appid
	 * @return string
	 */
	public static function genRefreshToken($access_token,$appid){
		return md5($access_token.$appid.self::TOKEN_SALT);
	}

}