<?php
class Errors {
	// 是否显示错误信息
	private static $_show_msg = true;
	private static $_errors = array (
			- 1 => "Unknown Error", // 未知错误
			0 => "No Error", // 没有错误
			1 => "General Error", // 通用错误，错误不重要
			2 => "Forbidden", // 被屏蔽，系统，USER
			3 => "UnLogin", // 未登录
			
			/* server side error */
			10000 => "请重新登录", // 会话错误或未登录
			10001 => "数据库连接失败", // 数据库连接失败
			10002 => "数据库查询错误", // 数据库查询错误
			10003 => "请勿重复操作",
			10004 => "暂无数据",
			10005 => "用户名或密码错误",
			/* client error */
			20000 => "参数错误", // 参数值错误
			20001 => "访问频繁", // 访问频繁
			20002 => "Token Error", // token错误
			20003 => "手机号已被注册", // 手机号已被注册
			20004 => "验证码错误", // 验证码错误
			20005 => "访问被拒", // 访问被拒
			20006 => "File Upload Error",
			20007 => "手机号被封停",
			20008 => "旧密码不正确",
			20009 => "Access Expired",
			20010 => "密码不正确",
			20011 => "手机号未注册",
			
			30000 => "图片存储失败",
			30001 => "分组名已存在",
			30002 => "设备不存在或已删除"
	);
	
	/**
	 * 请重新登录
	数据库连接失败
	数据库查询错误
	账号不存在
	您输入的密码不正确
	参数值错误
	手机号已被注册
	验证码错误
	图片存储失败
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
					"Unknown Error" 
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
	public static function exitWithJson($error_code = 0, $addon = null) {
		if ($error_code == 0)
			$arr = array (
					0,
					"no error" 
			);
		else
			$arr = self::getError ( $error_code );
		$arr = array (
				"code" => $arr [0],
				"msg" => $arr [1] 
		);
		if ($addon)
			$arr ["data"] = $addon;
		if (! self::$_show_msg)
			unset ( $arr ["msg"] );
		exit ( json_encode ( $arr ) );
	}
}
