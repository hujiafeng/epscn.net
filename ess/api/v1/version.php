<?php
/**
 * 版本升级信息
 * @version v4
 */
header ( 'Content-type: application/json' );
if (isset ( $_REQUEST ['android'] )) {
	echo json_encode ( array (
			'v' => 1,
			'version' => '1.0',
			"url" => "http://www.dailyfashion.cn/app/DailyFashion.apk",
			"description" => "◇「修正」了某些错误；
◇「笔记」新增「笔记合辑」入口，各类精彩笔记内容浏览更便捷；
◇「搜索」进一步优化，并新增「品牌和设计师」、「款型」引导入口；
◇「修正」了某些机型登录不能保持，以及操作无效的问题；

请务必更新到新版App，否则内容将无法正常访问。
" 
	) );
	exit ();
}
// ios
if ($_POST ['app_type'] == 2) // ipad
{
	echo json_encode ( array (
			"v" => 1.0,
			"url" => "https://itunes.apple.com/cn/app/tian-tian-shi-zhuang/id739631005?mt=8" 
	) );
} else {
	echo json_encode ( array (
			"v" => "2.1",
			'build'=>"1709011", //通过次判断
			"url" => "https://itunes.apple.com/cn/app/tian-tian-shi-zhuang/id739631005?mt=8",
			"description"=>"◇「笔记」新增「笔记合辑」入口，各类精彩笔记内容浏览更便捷；
◇「搜索」进一步优化，并新增「品牌和设计师」、「款型」引导入口；
◇「修正」了某些机型登录不能保持，以及操作无效的问题；

请务必更新到新版App，否则内容将无法正常访问。
"
	) );
}
