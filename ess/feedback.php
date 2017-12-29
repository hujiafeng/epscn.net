<?php
header('Content-Type: text/html; charset=UTF-8');
require 'config.php';
require 'common/DB.class.php';
require 'common/Error.class.php';

if (! $systoken)
    Error::exitWithJson(10000);

$db = new DB();
$mysqli = $db->get_MySQLi_Object1();
if (! $db->isOK)
    Error::exitWithJson(10001);

$tab_name = "tab_feedback";
$smarty->assign("tab_name", $tab_name);
require 'header.php';

require 'common/Page.class.php';
$kw = $_GET['kw'];
$sql = "SELECT f.*,(SELECT fullname FROM se_user WHERE user_id=f.uid) AS uname,
       (SELECT avatar FROM se_user WHERE user_id=f.uid) AS avatar
                      FROM se_feedback f";
if ($kw)
    $sql .= " WHERE info like '%$kw%'";

$sql .= " ORDER BY submit_time DESC LIMIT 50";
$page = new Page($sql);
$sql = $page->StartPage();
$res = $mysqli->query($sql);
$i = 0;
while ($row = $res->fetch_assoc()) {
    $data[$i] = $row;
    $info=str_replace ( "\r\n", "<br/>", $row['info'] );
    $data[$i]['info']=$info;
    $data[$i]['avatar'] = empty($row['avatar']) ? "img/avatar.png" : "avatar/" . $row['avatar'];
    if ($row['app_type'] == 1)
        $app_type = 'iphone';
    else if ($row['app_type'] == 2)
        $app_type = 'iPad';
    else if ($row['app_type'] == 3)
        $app_type = 'android';
    $data[$i]['app_type'] = $app_type;
    ++$i;
}
$endpage = $page->EndPage(3, 1);
$smarty->assign("page", $endpage);
$smarty->assign("data", $data);
$smarty->display("feedback.html");