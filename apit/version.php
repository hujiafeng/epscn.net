<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * version 版本升级接口
 */
header ( 'Content-type: application/json' );
echo json_encode ( array (
		"version" => "1.1.0",
		"url"     => "https://www.epscn.net/addon/EPS.apk",
		"desc"    =>"发现新版本" 
) );