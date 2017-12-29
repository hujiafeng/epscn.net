<?php
header('Content-Type: text/html; charset=UTF-8');
require 'config.php';
require 'common/DB.class.php';
require 'common/Error.class.php';
require 'common/global.func.php';

$db = new DB();
$mysqli = $db->get_MySQLi_Object1();
if (! $db->isOK) {
    Error::exitWithJson(10001);
}
$tab_name = "tab_product";
$smarty->assign("tab_name", $tab_name);
require 'header.php';

require 'common/Page.class.php';
$sql = "SELECT * ,
        (SELECT name FROM se_product_brand WHERE brand_id=p.brand) AS brand_name,
        (SELECT name FROM se_product_category WHERE cid=p.category) AS category_name,
        (SELECT name FROM se_product_model WHERE model_id=p.model) AS model_name,
        (SELECT name FROM se_product_measure WHERE mid=p.measure) AS measure_name
        FROM se_product p WHERE flag=0";
$kw = $_GET['kw'];
$smarty->assign("kw", $kw);
$brand_id = $_GET['brand'];
$smarty->assign("brand_id", $brand_id);
$category_id = $_GET['category'];
$smarty->assign("category_id", $category_id);
$model_id = $_GET['model'];
$smarty->assign("model_id", $model_id);
if ($kw) {
    if (is_numeric($kw))
        $sql .= " AND product_id='$kw'";
    else
        $sql .= " AND specification like '%$kw%'";
}
if ($brand_id)
    $sql .= " AND brand='$brand_id' ";
if ($category_id)
    $sql .= " AND category='$category_id'";
if ($model_id)
    $sql .= " AND model='$model_id'";
$sql .= " ORDER BY product_id DESC LIMIT 50";
$page = new Page($sql);
$sql = $page->StartPage();
$res = $mysqli->query($sql);
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}
$endpage = $page->EndPage(3, 1);
$smarty->assign("page", $endpage);
$smarty->assign("data", $data);
// brand
$res_brand = $mysqli->query("SELECT brand_id,name FROM se_product_brand WHERE flag=0");
while ($row_brand = $res_brand->fetch_assoc()) {
    $brand[] = $row_brand;
}
$smarty->assign("brand", $brand);
// category
$res_c = $mysqli->query("SELECT cid,name FROM se_product_category WHERE flag=0");
while ($row_c = $res_c->fetch_assoc()) {
    $category[] = $row_c;
}
$smarty->assign("category", $category);
// model

$arr = array ();
if (! empty ( $brand_id )) {
    $arr [] = "  brand IN ( $brand_id) ";
}
if (! empty ( $category_id )) {
    $arr [] = "  category IN ( $category_id) ";
}
if (count ( $arr )) {
    $where =  implode ( " AND ", $arr );
    $sql_model = "SELECT DISTINCT model AS model_id,name  FROM se_product  AS A,se_product_model AS B  WHERE $where  AND A.model = B.model_id AND A.flag=0";
    
} else {
    $sql_model = "SELECT DISTINCT model AS model_id,name  FROM se_product  AS A,se_product_model AS B  WHERE A.model = B.model_id AND A.flag=0";    
}
$res_model = $mysqli->query($sql_model);
while ($row_model = $res_model->fetch_assoc()) {
    $model[] = $row_model;
}
$smarty->assign("model", $model);
$smarty->display("index.html");