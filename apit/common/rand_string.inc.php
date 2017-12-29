<?php
	/**
	 *
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
 function rand_string_only_number($lenght){
 	$res_str='';
 	//
 	for($i=0;$i<$lenght;$i++){
 		$res_str .= chr(mt_rand(48, 57));
 	}
 	return $res_str;
 }
/**
 * 随机串只包含字母
 * 
 * @param int $length
 * @return string
 */
function rand_string_only_letter($length){
 	$res_str='';
 	$str_pool='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 	$pool_length=strlen($str_pool)-1;
 	for($i=0;$i<$length;$i++){
 		$index=mt_rand(0,$pool_length);
 		$res_str .= $str_pool[$index];
 	}
 	return $res_str;
}
/**
 * 
 * 短语生成
 * @param int $length
 * @return string
 */
function gen_salt($length){
	$res_str='';
 	$str_pool='0123456789abcdefghijklmnopqrstuvwxyz';
 	$pool_length=strlen($str_pool)-1;
 	for($i=0;$i<$length;$i++){
 		$index=mt_rand(0,$pool_length);
 		$res_str .= $str_pool[$index];
 	}
 	return $res_str;
}
 ?>