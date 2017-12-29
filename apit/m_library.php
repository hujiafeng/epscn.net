<?php
/** * Copyright (c)2016,ChangZhou xiangyu Network Technology Co., Ltd.
 * @version	1.0.0
 * @since  2017年9月15日
 * m_library 分类款型接口
 * 参数
 * n_time:服务器返的时间
 * type:分类id
 * 返回值
 * id:款型id
 * img：款型图片
 * title：标题
 * remark：备注
 * percentage：百分比
 * type：分类
 */
header ( 'Content-type: application/json' );
require 'config.php';

//客户端返回时间，处理增量查询
$n_time = $_POST['n_time'];
$type = $_POST['type'];

$sql_n = "SELECT count(*) FROM ".T('m_library')." WHERE type=$type and UNIX_TIMESTAMP(time) > $n_time order by seq ASC";
$rt_n  = $mysqli->query($sql_n);
$rto_n = $rt_n->fetch_row();

$result ['list'] = array();
$result['n_time'] = (string)time();
$result['type'] = (string)$type;

if($rto_n["0"] || !$n_time){
	$sql = "SELECT * FROM ".T('m_library')." where type=$type order by seq ASC";
	$res = $mysqli->query ( $sql );
	if ($res) {
		while ( $row = $res->fetch_assoc () ) {
			$row["img"] = $row["img"]?PHOTO_URL.$row["img"]:"";
			$result ['list'][] = $row;
		}
	}
}
print_r($result);
Errors::exitWithJson(0,$result);