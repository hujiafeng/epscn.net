<?php
/**
 *@author wsshh1314@outlook.com
 *@version	1.0
 *@abstract 2015年11月9日
 *@since  Version 1.0
 */
// define API _ROOT FOR Ver2
define ( "API_ROOT", "https://www.epscn.net/ess/api/v1/" );
//
$APIS = array ();

$APIS ["user_login"] = array (
		"name" => "用户登录",
		"desc" => "",
		"params" => array (
				array (
						"name" => "mobile_phone",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "手机号码" 
				),
				array (
						"name" => "password",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "密码" 
				) 
		) 
);

$APIS ["user_sms_code"] = array (
		"name" => "用户获取短信验证码",
		"desc" => "",
		"params" => array (
				array (
						"name" => "phone",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "手机号码" 
				),
				array (
						"name" => "action",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "reg|find" 
				) 
		) 
);
$APIS ["user_register"] = array (
		"name" => "用户注册",
		"desc" => "",
		"params" => array (
				array (
						"name" => "sms_token",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "获取验证码发送成功时获得的鉴权token" 
				),
				array (
						"name" => "phone",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "手机号码" 
				),
				array (
						"name" => "password",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "密码" 
				),
				array (
						"name" => "avatar",
						"must" => "yes",
						"type" => "FILE",
						"default" => "",
						"desc" => "头像" 
				),
				array (
						"name" => "gender",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "N|F|M" 
				) 
		
		) 
);
$APIS ["user_profile_edit"] = array (
		"name" => "用户信息完善",
		"desc" => "",
		"params" => array (
				array (
						"name" => "gender",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "N |F| M" 
				),
				array (
						"name" => "fullname",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "昵称" 
				),
				array (
						"name" => "avatar",
						"must" => "NO",
						"type" => "FILE",
						"default" => "",
						"desc" => "头像 " 
				) 
		) 
);

$APIS ["user_session"] = array (
		"name" => "用户恢复会话",
		"desc" => "",
		"params" => array (
				array (
						"name" => "user_id",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => ""
				),
				array (
						"name" => "access_token",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "登录后返回"
				)
		)
);
$APIS ["project_info"] = array (
		"name" => "项目详情",
		"desc" => "",
		"params" => array (				array (
				"name" => "project_id",
				"must" => "yes",
				"type" => "string",
				"default" => "",
				"desc" => "项目ID"
		))
);
$APIS ["product_info"] = array (
		"name" => "产品分类信息",
		"desc" => "",
		"params" => array () 
);
$APIS ["product_models"] = array (
		"name" => "根据品牌品类获取型号",
		"desc" => "",
		"params" => array (
				array (
						"name" => "brands",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "品牌Ids ，逗号分割 ，可以空" 
				),
				array (
						"name" => "categories",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "逗号分割 ，可以空" 
				) 
		
		) 
);
$APIS ["project_edit"] = array (
		"name" => "编辑项目申报",
		"desc" => "",
		"params" => array (
				array (
						"name" => "project_id",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "不设置则代表新建" 
				),
				array (
						"name" => "name",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "名称" 
				),
				array (
						"name" => "purchaser",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "采购方" 
				),
				array (
						"name" => "products",
						"must" => "NO",
						"type" => "string",
						"default" => "",
						"desc" => "json string,未保存过的产品 JSON 编码的array <br>
							[{\"purchase_price\":\"2323.00\",\"purchase_num\":12,\"product_id\":\"12\",\"user_price\":\"2000\"},{},...]" 
				) 
		) 
);
$APIS ["project_list"] = array (
		"name" => "项目列表",
		"desc" => "",
		"params" => array (
				array (
						"name" => "type",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "1草稿 ，2 审核 ，3 跟踪"
				),
				array (
						"name" => "page",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "每页20"
				)
		)
);
$APIS ["project_submit"] = array (
		"name" => "提交审核",
		"desc" => "",
		"params" => array (
				array (
						"name" => "project_id",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "不设置则代表新建" 
				) 
		) 
);

$APIS ["project_remove"] = array (
		"name" => "删除项目",
		"desc" => "",
		"params" => array (
				array (
						"name" => "project_id",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "项目ID" 
				) 
		) 
);
$APIS ["project_remove_product"] = array (
		"name" => "删除项目产品",
		"desc" => "",
		"params" => array (
				array (
						"name" => "project_id",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "项目ID" 
				),
				array (
						"name" => "pp_id",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "已经添加的产品" 
				) 
		) 
);
$APIS ["product_filter"] = array (
		"name" => "产品筛选（for 添加）",
		"desc" => "",
		"params" => array (
				array (
						"name" => "models",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "品牌IDs,逗号分割" 
				),
				array (
						"name" => "categories",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "品类IDs,逗号分割" 
				),
				array (
						"name" => "brands",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "brand IDs,逗号分割" 
				),
				array (
						"name" => "keyword",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "进一步搜索keyword" 
				) 
		) 
);
$APIS ["notification_list"] = array (
		"name" => "通知列表",
		"desc" => "",
		"params" => array (
				array (
						"name" => "page",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "from 1"
				)
		)
);
$APIS ["user_device_token"] = array (
		"name" => "推送token或channelID",
		"desc" => "",
		"params" => array (
				array (
						"name" => "token",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "token 或channel ID"
				),
				array (
						"name" => "app_type",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "ios 1 ,android 2"
				),
				array (
						"name" => "app_ver",
						"must" => "yes",
						"type" => "string",
						"default" => "",
						"desc" => "程序版本"
				),
				array (
						"name" => "user_id",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "用户ID "
				),
		)
);

$APIS ["user_score_detail"] = array (
		"name" => "积分详情",
		"desc" => "",
		"params" => array (
				array (
						"name" => "page",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "from 1"
				)
		)
);
$APIS ["notification_remove"] = array (
		"name" => "删除通知",
		"desc" => "",
		"params" => array (
				array (
						"name" => "mid",
						"must" => "YES",
						"type" => "string",
						"default" => "",
						"desc" => "消息ID，"
				)
		)
);
$APIS ["product_filter_test"] = array (
		"name" => "产品筛选（for 添加）",
		"desc" => "",
		"params" => array (
				array (
						"name" => "models",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "品牌IDs,逗号分割"
				),
				array (
						"name" => "categories",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "品类IDs,逗号分割"
				),
				array (
						"name" => "brands",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "brand IDs,逗号分割"
				),
				array (
						"name" => "keyword",
						"must" => "no",
						"type" => "string",
						"default" => "",
						"desc" => "进一步搜索keyword"
				)
		)
);