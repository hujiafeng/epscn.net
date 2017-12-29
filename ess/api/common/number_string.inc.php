<?php
/**
 * 字符数字处理
 *@author shaohui <wsshh1314@outlook.com>
 *@version 1.0
 *
 */
/**
 * 随机串，只包含数字
 *
 * @param int $lenght
 * @return string
 */
function rand_string_only_number($lenght) {
	$res_str = '';
	//
	for($i = 0; $i < $lenght; $i ++) {
		$res_str .= chr ( mt_rand ( 48, 57 ) );
	}
	return $res_str;
}
/**
 * 随机串只包含字母
 *
 * @param int $length        	
 * @return string
 */
function rand_string_only_letter($length) {
	$res_str = '';
	$str_pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$pool_length = strlen ( $str_pool ) - 1;
	for($i = 0; $i < $length; $i ++) {
		$index = mt_rand ( 0, $pool_length );
		$res_str .= $str_pool [$index];
	}
	return $res_str;
}
/**
 *
 * 短语生成
 * 
 * @param int $length        	
 * @return string
 */
function gen_salt($length) {
	$res_str = '';
	$str_pool = '0123456789abcdefghijklmnopqrstuvwxyz';
	$pool_length = strlen ( $str_pool ) - 1;
	for($i = 0; $i < $length; $i ++) {
		$index = mt_rand ( 0, $pool_length );
		$res_str .= $str_pool [$index];
	}
	return $res_str;
}
/*
 * 中国电信: 133、1349、153、180、181、189，17X
 * 中国联通: 130、131、132、145、155、156、185、186，17X
 * 中国移动: 1340-1348、135、136、137、138、139、147、150、151、152、157、158、159、182、183、184、187、188，17X
 *
 */
/**
 *
 * 只有网段检测
 * 
 * @param string $phone_num        	
 * @return int[0|1]
 */
function china_phone_num_check($phone_num) {
	if (strlen ( $phone_num ) != 11)
		return 0;
	$pattern = "/^1[34578]{1}\d{9}$/";
	return preg_match ( $pattern, $phone_num );
}
/**
 *
 * 特殊字符检，有则返回1
 * 
 * @param string $string        	
 * @return int 1|0
 */
function str_special_char($string) {
	$pattern = "/[\?\\\.\*\+\-\"\]\[\^\$\?\{\}\|!',\/%#@~:<>]/";
	return preg_match ( $pattern, $string );
}
?>