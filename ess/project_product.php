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

$tab_name = "tab_project";
$smarty->assign("tab_name", $tab_name);
require 'header.php';
switch ($act) {
    case 'purchase_record':
        /* $pp_id = intval($_GET['pp_id']);
        $smarty->assign("pp_id",$pp_id);
        $res_pp=$mysqli->query("SELECT project_id FROM se_project_products WHERE pp_id='$pp_id'");
        $row_pp=$res_pp->fetch_row();
        $project_id=$row_pp[0];
        $smarty->assign("project_id",$project_id);
        $res = $mysqli->query("SELECT * ,(SELECT fullname FROM se_user WHERE user_id=r.act_uid) AS act_uname,
(SELECT fullname FROM se_user WHERE user_id=r.del_uid) AS del_uname
 FROM se_score_record r WHERE pp_id='$pp_id'");
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        $smarty->assign("data", $data);*/
        $project_id = intval($_GET['project_id']);
        $res_pname = $mysqli->query("SELECT name FROM se_project WHERE project_id='$project_id'");
        $row_pname = $res_pname->fetch_row();
        $project_name = $row_pname[0];
        $smarty->assign("project_id", $project_id);
        $smarty->assign("project_name", $project_name);
        $res_p = $mysqli->query("SELECT pp_id  FROM se_project_products WHERE project_id='$project_id' AND flag=0");
        while ($row_p = $res_p->fetch_row()) {
            if (! empty($ppIds))
                $ppIds .= ",";
            $ppIds .= $row_p[0];
        }
        if (! empty($ppIds)) {
            $res = $mysqli->query("SELECT * ,(SELECT fullname FROM se_user WHERE user_id=r.act_uid) AS act_uname,
(SELECT fullname FROM se_user WHERE user_id=r.del_uid) AS del_uname,
(SELECT product_id FROM se_project_products WHERE pp_id=r.pp_id) AS product_id
 FROM se_score_record r WHERE pp_id IN ($ppIds)");
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $data[$i] = $row;
                $str = "";
                if($row['pp_id']){
                $res_p = $mysqli->query("SELECT pp.purchase_price,pp.last_price,p.specification,
            (SELECT name FROM se_product_brand WHERE brand_id=p.brand) AS brand_name,
            (SELECT name FROM se_product_category WHERE cid=p.category) AS category_name,
            (SELECT name FROM se_product_model WHERE model_id=p.model) AS model_name,
            (SELECT name FROM se_product_measure WHERE mid=p.measure) AS unit
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
                }
                $data[$i]['unit'] = $row_p['unit'];
                $data[$i]['products'] = $str;
                ++ $i;
            }
            
        }
        $smarty->assign("data", $data);
        $smarty->display("project_score_record.html");
        break;
    
    case 'save_record':
        /*$pp_id = intval($_POST['pp_id']);
        $purchase_num = $_POST['purchase_num'];
        $res = $mysqli->query("SELECT purchase_price, last_price,create_uid FROM se_project_products WHERE pp_id='$pp_id'");
        $row = $res->fetch_assoc();
        $purchase_price = $row['purchase_price'];
        $last_price = $row['last_price'];
        if ($purchase_price > $last_price) {
            $score = ($purchase_price - $last_price) * $purchase_num;
        } else {
            $score = 0;
        }
        $score = sprintf("%.2f", $score);
        $sql = "INSERT INTO se_score_record SET pp_id='$pp_id',purchase_num='$purchase_num',act_uid='$sysuid',
              act_time=NOW(),score='$score'";
        if ($mysqli->query($sql)) {
            $mysqli->query("UPDATE se_user SET score_total=score_total+$score,score_now=score_now+$score 
WHERE user_id='" . $row['create_uid'] . "'");
            echo 1;
        } else
            echo 0;*/
        $ppIds = explode(",", trim($_POST['ppIds'], ","));
        $purchaseNums = explode(",", trim($_POST['purchaseNums'], ","));
        $flag = 1;
        if (! empty($ppIds) && ! empty(purchaseNums)) {
            foreach ($ppIds as $key => $value) {
                $pp_id = $value;
                $purchase_num = $purchaseNums[$key];
                $res = $mysqli->query("SELECT purchase_price, last_price,create_uid FROM se_project_products WHERE pp_id='$pp_id'");
                $row = $res->fetch_assoc();
                $purchase_price = $row['purchase_price'];
                $last_price = $row['last_price'];
                if ($purchase_price > $last_price) {
                    $score = ($purchase_price - $last_price) * $purchase_num;
                } else {
                    $score = 0;
                }
                $score = sprintf("%.2f", $score);
                $sql = "INSERT INTO se_score_record SET pp_id='$pp_id',purchase_num='$purchase_num',act_uid='$sysuid',
              act_time=NOW(),score='$score',user_id='" . $row['create_uid'] . "'";
                if ($mysqli->query($sql)) {
                    $mysqli->query("UPDATE se_user SET score_total=score_total+$score,score_now=score_now+$score
WHERE user_id='" . $row['create_uid'] . "'");
                    // msg
                    require 'MSGWrapper.php';
                    $ruid = $row['create_uid'];
                    $msg = MSGWrapper::makeMsg(MSGWrapper::MSG_SCORE_GET, $score, null);
                    $sql_n = "INSERT INTO se_message SET obj_id='0',obj_type=2,suid='3',msg='$msg',ruid='$ruid',
                            create_time=NOW()";
                    $mysqli->query($sql_n);
                    MSGWrapper::doWith(MSGWrapper::MSG_SCORE_GET, $ruid);
                } else
                    $flag = 0;
            }
            echo $flag;
        } else
            echo 0;
        exit();
        break;
    
    case 'del_record':
        $record_id = intval($_POST['record_id']);
        $res = $mysqli->query("SELECT score FROM se_score_record WHERE record_id='$record_id'");
        $row = $res->fetch_row();
        $score = $row[0];
        $sql = "UPDATE se_score_record SET flag=1 ,del_uid='$sysuid',del_time=NOW() WHERE record_id='$record_id'";
        if ($mysqli->query($sql)) {
            $mysqli->query("UPDATE se_user SET score_total=score_total-$score,score_now=score_now-$score
WHERE user_id='" . $row['create_uid'] . "' AND score_now>=$score");
            echo 1;
        } else
            echo 0;
        exit();
        break;
    
    default:
        $project_id = intval($_GET['project_id']);
        $res_pj = $mysqli->query("SELECT name FROM se_project WHERE project_id='$project_id'");
        $row_pj = $res_pj->fetch_row();
        $pj_name = $row_pj[0];
        $smarty->assign("pj_name", $pj_name);
        $res = $mysqli->query("SELECT pp.* ,(SELECT name FROM se_product_brand WHERE brand_id=p.brand) AS brand_name,
            (SELECT name FROM se_product_category WHERE cid=p.category) AS category_name,
            (SELECT name FROM se_product_model WHERE model_id=p.model) AS model_name,
            (SELECT name FROM se_product_measure WHERE mid=p.measure) AS measure_name,p.specification,
            (SELECT count(record_id) FROM se_score_record WHERE pp_id=pp.pp_id AND score>=0 AND flag=0) AS last_num
               FROM se_project_products pp ,se_product p 
               WHERE pp.project_id='$project_id' AND pp.product_id=p.product_id");
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        $smarty->assign("data", $data);
        $smarty->display("project_product.html");
        break;
}