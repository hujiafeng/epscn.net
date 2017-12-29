<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * device_add 设备添加接口
 * 参数
 * uid：用户id
 * did:分组id
 * name:设备名称
 * type:产品型号
 * modename:制造厂商
 * modeyear:制造年月
 * number:产品型号
 * voltage:额定电压
 * current:额定电流
 * short_current:额定短路开断电流
 * 返回值
 * gid:设备id
 */
header ( 'Content-type: application/json' );
require 'config.php';
require ROOT.'ThinkPHP/Library/Vendor/phpqrcode/phpqrcode.php';

$uid = $_POST['uid'];
$did = $_POST['did'];
if (!$uid || !$did)
	Errors::exitWithJson (20000);

$name          = $_POST['name'];
$type          = $_POST['type'];
$modename      = $_POST['modename'];
$modeyear      = $_POST['modeyear'];
$number        = $_POST['number'];
$voltage       = $_POST['voltage'];
$current       = $_POST['current'];
$short_current = $_POST['short_current'];
//设备编号
$no            = date("s").sprintf("%06d",mt_rand(1, 99999));

//添加设备
$sql = "INSERT INTO ".T('device_goods')." SET did='$did',uid='$uid',name='$name',type='$type',modename='$modename',modeyear='$modeyear',number='$number',
voltage='$voltage',current='$current',short_current='$short_current',
no='$no',time = NOW()";
$res = $mysqli->query ( $sql );
if ($res) {
	$data = array (
		"gid" => ( string ) $mysqli->insert_id
	);
	//文字图片
	$dst_path = SITE_URL.'statics/images/saoma.png';
	//创建图片的实例
	$dst = imagecreatefromstring(file_get_contents($dst_path));
	//打上文字
	$font = ROOT.'statics/images/lantingxihei.ttf';//字体路径
	$black = imagecolorallocate($dst, 0x32, 0x32, 0x33);//字体颜色
	$black2 = imagecolorallocate($dst, 0x97, 0x97, 0x98);//字体颜色
	imagefttext($dst, 16, 0, 85, 70, $black, $font, $name);
	imagefttext($dst, 12, 0, 85, 96, $black2, $font, $no);
	//输出图片
	imagepng($dst,ROOT."uploads/erweima/$no.png");
	imagedestroy($dst);
	//header( "Content-Type: image/png" );
	
	//生成二维码图片
	$object = new QRcode();
	$errorCorrectionLevel =intval(3) ;//容错级别
	$matrixPointSize = intval(17);//生成图片大小
	$object->png($no, ROOT."uploads/erweima/".$no."_1.png", $errorCorrectionLevel, $matrixPointSize, 0);
	
	//二维码图片再次合成
	$dst_path2 = ROOT."uploads/erweima/$no.png";
	$src_path = ROOT."uploads/erweima/".$no."_1.png";
	//创建图片的实例
	$dst2 = imagecreatefromstring(file_get_contents($dst_path2));
	$src = imagecreatefromstring(file_get_contents($src_path));
	//获取水印图片的宽高
	list($src_w, $src_h) = getimagesize($src_path);
	//将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
	imagecopymerge($dst2, $src, 80, 150, 0, 0, $src_w, $src_h, 100);
	//输出图片
	//header( "Content-Type: image/png" );
	imagepng($dst2,ROOT."uploads/erweima/$no.png");
	//imagedestroy($dst2);
	//imagedestroy($src);

	Errors::exitWithJson ( 0, $data );
} else {
	Errors::exitWithJson ( 10002 );
}

