<?php
/**
 * API  Class,包含错误处理信息代码
 * @version 3.0
 */
class API {
	/* Error predefine,_errors key 一致 */
	const E_OK = 0;
	const E_GENERAL_ERROR = 1;
	const E_FORBIDDEN = 2;
	const E_NO_LOGIN = 3;
	const E_ACCESS_EXPIRED = 4;
	const E_REQUEST_FREQUENTLY = 5; // 操作频繁
	const E_VALUE_EXIST = 6;
	/* server side error */
	const E_ACCESS_ERROR = 10000;
	const E_DB_CONNECTION = 10001;
	const E_SMS_ERROR = 10002;
	const E_DB_QUERY_ERROR = 10003;
	const E_RESTART_SESSION = 11000;
	const E_GET_USER_INFO = 11001;
	/* user client side */
	const E_PARAM_VALUE_ERROR = 20000;
	const E_PARAM_MISS = 20001;
	const E_ACCOUNT_NOT_EXIST = 20002;
	const E_PASSWORD_ERROR = 20003;
	const E_OLD_PASSWORD_ERROR = 20004;
	const E_EMAIL_EXIST = 20005;
	const E_UPLOAD_FILE_ERROR = 20010;
	const E_PHONE_EXIST = 20006;
	/* unkown */
	const E_UNKOWN_ERROR = 40000;
	/*
	 * error map
	 */
	private static $_errors = array (
			/*COMMON*/
			0 => "no error", // 没有错误
			1 => "general error", // 通用错误
			2 => "forbidden", // 被屏蔽，系统，USER
			3 => "no login", // 没有登录或
			4 => "access token expired ", // 过期了
			5 => "request frequently",
			6 => "value exist",
			/*SERVER*/
			10000 => "access error", // 会话错误或未登录
			10001 => "database connection failed", // 数据库连接失败
			10002 => "sms send error", // SMS 发送错误
			10003 => "database query error",
			11000 => "restart key error", // 恢复会话错误
			11001 => "get user info error",
			/*USER*/
			20000 => "param value error", // 参数值错误
			20001 => "param miss error", // 缺少参数错误
			20002 => "account does not exist or fobidden", // 帐号不存在
			20003 => "password error", // 密码错误
			20004 => "old password error", // 原始密码错误
			20005 => "email already exists", // 邮箱已经存在
			20006 => "phone exist",
			20010 => "upload file error",
			/*undefined*/
			40000 => "unkown error" 
	); // 未知错误
	
	/*
	 * 显示错误显示
	 */
	private static $_show_msg = true; // 是否显示错误信息
	public static function getAllErrors() {
		return self::$_errors;
	}
	/**
	 * 获取错误信息.
	 *
	 * @param int $error_code        	
	 * @return array
	 */
	public static function getError($error_code) {
		$arr = null;
		foreach ( self::$_errors as $key => $value ) {
			if ($key == $error_code) {
				$arr = array (
						$key,
						$value 
				);
				break;
			}
		}
		if ($arr == null)
			$arr = array (
					$error_code,
					"unkown error" 
			);
		return $arr;
	}
	
	/**
	 * exit with json info.
	 *
	 * @param int $error_code
	 *        	错误码
	 * @param mixed $addon
	 *        	附加数据
	 */
	public static function exitWithJson($error_code = 0, $addon = null, $info = null) {
		// set header
		header ( 'Content-type: application/json' );
		
		if ($error_code == 0)
			$arr = array (
					0,
					"no error" 
			);
		else {
			$arr = self::getError ( $error_code );
		}
		$arr = array (
				"code" => $arr [0],
				"msg" => $arr [1] 
		);
		// main data body
		if ($addon)
			$arr ["data"] = $addon;
		// msg switch
		if (! self::$_show_msg) {
			unset ( $arr ["msg"] );
		}
		// info show
		if ($info) {
			$arr ['info'] = $info;
		}
		//
		exit ( json_encode ( $arr ) );
	}
}
