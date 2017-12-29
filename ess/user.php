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

$tab_name = "tab_user";
$smarty->assign("tab_name", $tab_name);
require 'header.php';
switch ($act) {
    case 'save_utype':
        $user_id = intval($_POST['user_id']);
        $utype = $_POST['utype'];
        if ($user_id > 0) {
            $sql = "UPDATE se_user SET  utype='$utype' WHERE user_id='$user_id'";
            if ($mysqli->query($sql)) {
                $mysqli->query("INSERT INTO se_user_utype_record SET utype='$utype', user_id='$user_id' ,act_uid='$sysuid',act_time=NOW()");
                echo 1;
            } else
                echo 0;
        } else
            echo 0;
        exit();
        break;
    
    case 'score_record':
        require 'common/Page.class.php';
        $user_id = intval($_GET['user_id']);
        $res_u = $mysqli->query("SELECT fullname,score_now FROM se_user WHERE user_id='$user_id'");
        $row_u = $res_u->fetch_assoc();
        $smarty->assign("username", $row_u['fullname']);
        $smarty->assign("score_now", $row_u['score_now']);
        $smarty->assign("user_id", $user_id);
        $sql = "SELECT * ,(SELECT fullname FROM se_user WHERE user_id=r.act_uid) AS act_uname,
         (SELECT fullname FROM se_user WHERE user_id=r.del_uid) AS del_uname,
         (SELECT project_id FROM se_project_products WHERE pp_id=r.pp_id ) AS project_id
         FROM se_score_record r WHERE user_id='$user_id' ORDER BY act_time DESC LIMIT 50";
        $page = new Page($sql);
        $sql = $page->StartPage();
        $res = $mysqli->query($sql);
        $i = 0;
        while ($row = $res->fetch_assoc()) {
            $data[$i] = $row;
            $data[$i]['get_score'] = $row['score'] > 0 ? "+" . $row['score'] : "";
            $data[$i]['redeem_score'] = $row['score'] < 0 ? $row['score'] : "";
            $str = "";
            if ($row['score'] > 0 && $row['pp_id'] > 0) {
                $res_p = $mysqli->query("SELECT pp.purchase_price,pp.last_price,p.specification,
            (SELECT name FROM se_product_brand WHERE brand_id=p.brand) AS brand_name,
            (SELECT name FROM se_product_category WHERE cid=p.category) AS category_name,
            (SELECT name FROM se_product_model WHERE model_id=p.model) AS model_name,
            (SELECT name FROM se_product_measure WHERE mid=p.measure) AS measure_name
                 FROM se_project_products pp ,se_product p WHERE pp.pp_id='" . $row['pp_id'] . "'");
                $row_p = $res_p->fetch_assoc();
                if ($row_p['category_name'])
                    $str .= $row_p['category_name'] . "</br>";
                if ($row_p['model_name'])
                    $str .= $row_p['model_name'] . "</br>";
                if ($row_p['specification'])
                    $str .= $row_p['specification'] . "</br>";
                if ($row_p['brand_name'])
                    $str .= "品牌：" . $row_p['brand_name'] . "</br>";
                if ($row_p['purchase_price'])
                    $str .= "采购价：" . $row_p['purchase_price'] . "</br>";
                if ($row_p['last_price'])
                    $str .= "结算价：" . $row_p['last_price'] . "</br>";
                if ($row['purchase_num'])
                    $str .= "实际采购数量：" . $row['purchase_num'] . $row_p['measure_name']."</br>";
            }
            $data[$i]['products']=$str;
            $i ++;
        }
        $endpage = $page->EndPage(3, 1);
        $smarty->assign("page", $endpage);
        $smarty->assign("data", $data);
        $smarty->display("user_score_record.html");
        break;
    
    case 'redeem_points':
        require 'MSGWrapper.php';
        $user_id = intval($_POST['user_id']);
        $score = $_POST['score'];
        $_score = - $score;
        $sql = "INSERT INTO se_score_record SET score='$_score',user_id='$user_id',act_uid='$sysuid',act_time=NOW() ";
        if ($mysqli->query($sql)) {
            $mysqli->query("UPDATE se_user SET score_now=score_now-$score
WHERE user_id='$user_id' AND score_now>=$score");
            // msg
            $ruid = $user_id;
            $msg = MSGWrapper::makeMsg(MSGWrapper::MSG_SCORE_USE, $score, null);
            $sql_n = "INSERT INTO se_message SET obj_id='0',obj_type=2,suid='3',msg='$msg',ruid='$ruid',
                            create_time=NOW()";
            $mysqli->query($sql_n);
            MSGWrapper::doWith(MSGWrapper::MSG_SCORE_USE, $ruid);
            echo 1;
        } else
            echo 0;
        exit();
        break;
    
    case 'del_record':
        $record_id = intval($_POST['record_id']);
        $res = $mysqli->query("SELECT user_id,score FROM se_score_record WHERE record_id='$record_id'");
        $row = $res->fetch_assoc();
        $score = $row['score'];
        $user_id = $row['user_id'];
        $sql = "UPDATE se_score_record SET flag=1 WHERE record_id='$record_id'";
        if ($mysqli->query($sql)) {
            if ($score < 0) {
                $mysqli->query("UPDATE se_user SET score_now=score_now-$score
WHERE user_id='$user_id'");
            }
            echo 1;
        } else
            echo 0;
        exit();
        break;
    
    case 'user_product':
        require 'common/Page.class.php';
        $user_id = intval($_POST['user_id']) ? intval($_POST['user_id']) : $_GET['user_id'];
        $smarty->assign("user_id", $user_id);
        $kw = $_GET['kw'];
        $smarty->assign("kw", $kw);
        $brand_id = $_GET['brand'];
        $smarty->assign("brand_id", $brand_id);
        $category_id = $_GET['category'];
        $smarty->assign("category_id", $category_id);
        $model_id = $_GET['model'];
        $smarty->assign("model_id", $model_id);
        $sql = "SELECT *,
        (SELECT price FROM se_user_products WHERE user_id='$user_id' AND product_id=p.product_id) AS last_price,
        (SELECT name FROM se_product_brand WHERE brand_id=p.brand) AS brand_name,
        (SELECT name FROM se_product_category WHERE cid=p.category) AS category_name,
        (SELECT name FROM se_product_model WHERE model_id=p.model) AS model_name,
        (SELECT name FROM se_product_measure WHERE mid=p.measure) AS measure_name
        FROM se_product p WHERE flag=0";
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
        $sql .= " order by product_id desc limit 50";
        
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
        $res_model = $mysqli->query("SELECT model_id,name FROM se_product_model WHERE flag=0");
        while ($row_model = $res_model->fetch_assoc()) {
            $model[] = $row_model;
        }
        $smarty->assign("model", $model);
        
        $smarty->display("user_product.html");
        break;
    
    case 'save_agio':
        $user_id = intval($_POST['user_id']);
        $productIds = explode(",", trim($_POST['productIds'], ","));
        $agio = $_POST['agio'];
        $flag = 0;
        foreach ($productIds as $key => $value) {
            $res = $mysqli->query("SELECT market_price FROM se_product WHERE product_id='$value'");
            $row = $res->fetch_row();
            $price = $row[0] * $agio;
            $price = sprintf("%.2f", $price);
            $res_a = $mysqli->query("SELECT up_id FROM se_user_products WHERE user_id='$user_id' AND product_id='$value'");
            $row_a = $res_a->fetch_row();
            if ($row_a[0])
                $sql = "UPDATE se_user_products SET price='$price' WHERE up_id='" . $row_a[0] . "'";
            else
                $sql = "INSERT INTO se_user_products SET price='$price',user_id='$user_id',product_id='$value'";
            if ($mysqli->query($sql)) {
                if ($row_a[0])
                    $up_id = $row_a[0];
                else
                    $up_id = $mysqli->insert_id;
                $mysqli->query("INSERT INTO se_user_products_record SET up_id='$up_id',act_uid='$sysuid',act_time=NOW(),price='$price'");
                $flag = 1;
            } else {
                $flag = 0;
            }
        }
        echo $flag;
        exit();
        break;
    
    default:
        require 'common/Page.class.php';
        $gender_arr = array(
            "N" => "无",
            "M" => "男",
            "F" => "女"
        );
        $utype_arr = array(
            "MEMBER" => "普通成员",
            "ADMIN" => "管理员"
        );
        $plat_arr = array(
            "NONE" => "无",
            "WEIXIN" => "微信",
            "WEIBO" => "微博"
        );
        $kw = $_GET['kw'];
        $sql = "SELECT * FROM se_user";
        if ($kw) {
            if (is_numeric($kw))
                $sql .= " WHERE (user_id='$kw' or mobile_phone like '%$kw%')";
            else
                $sql .= " WHERE fullname like '%$kw%'";
        }
        $sql .= " ORDER BY user_id desc LIMIT 50";
        $page = new Page($sql);
        $sql = $page->StartPage();
        $res = $mysqli->query($sql);
        $i = 0;
        while ($row = $res->fetch_assoc()) {
            $data[$i] = $row;
            $data[$i]['avatar'] = empty($row['avatar']) ? "img/avatar.png" : "avatar/" . $row['avatar'];
            $data[$i]['gender'] = $gender_arr[$row['gender']];
            $data[$i]['utype'] = $utype_arr[$row['utype']];
            $open_id = $row['open_id'] ? "/" . $row['open_id'] : "";
            $data[$i]['plat'] = $plat_arr[$row['open_plat']] . $open_id;
            $i ++;
        }
        $endpage = $page->EndPage(3, 1);
        $smarty->assign("page", $endpage);
        $smarty->assign("data", $data);
        $smarty->display("user.html");
        break;
}
