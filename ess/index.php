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
//$tab_name = "tab_product";
//$smarty->assign("tab_name", $tab_name);
//require 'header.php';

switch ($act) {
    case 'logout':
        clearCookie('dq_sysUser');
        location('./');
        break;
    
    case 'login':
        $mobile = $_POST['mobile'];
        $pwd = $_POST['pwd'];
        $_pwd = sha1($pwd);
        $sql = "SELECT * FROM se_user WHERE mobile_phone='$mobile' AND password='$_pwd'";
        if ($res = $mysqli->query($sql)) {
            if ($res->num_rows == 1) {
                $row = $res->fetch_assoc();
                if ($row['uflag'])
                    echo "此账户已屏蔽！";
                else if ($row['utype'] != 'ADMIN')
                    echo "此账户无权限登录！";
                else {
                    $user_id = $row['user_id'];
                    $user_name = $row['fullname'];
                    
                    $userToken = sha1(TOKEN + $user_id); 
                    $arr=array("dqToken"=>$userToken,"dqUid"=>$user_id,"dqName"=>$user_name);
                    cookie('dq_sysUser', json_encode($arr));
                    echo 1;
                }
            } else
                echo "此账户不存在或用户名密码输入错误！";
        } else
            echo "查询失败！";
        exit();
        break;
    
    case 'edit':
        $product_id = intval($_POST['product_id']);
        $str = "";
        if ($product_id) {
            $res = $mysqli->query("SELECT *,(SELECT name FROM se_product_brand WHERE brand_id=p.brand) AS brand_name,
            (SELECT name FROM se_product_category WHERE cid=p.category) AS category_name,
            (SELECT name FROM se_product_model WHERE model_id=p.model) AS model_name,
            (SELECT name FROM se_product_measure WHERE mid=p.measure) AS measure_name
            FROM se_product p WHERE product_id='$product_id'");
            $row = $res->fetch_assoc();
            $str = json_encode($row);
        }
        echo $str;
        exit();
        break;
    
    case 'del':
        $product_id = intval($_POST['product_id']);
        $sql = "UPDATE se_product SET flag=1,edit_uid='$sysuid',edit_time=NOW() WHERE product_id='$product_id'";
        if ($mysqli->query($sql))
            echo 1;
        else
            echo 0;
        exit();
        break;
    
    case 'getAutoBrand':
        $str = '';
        $keyword = $_GET['q'];
        if ($keyword) {
            // 品牌
            $res = $mysqli->query("SELECT brand_id,name FROM se_product_brand WHERE flag=0 AND name like '%$keyword%'");
            while ($row = $res->fetch_assoc()) {
                $str .= $row['name'] . ',' . $row['brand_id'] . "\r\n";
            }
        }
        echo $str;
        break;
    
    case 'getAutoCategory':
        $str = '';
        $keyword = $_GET['q'];
        if ($keyword) {
            $res = $mysqli->query("SELECT cid,name FROM se_product_category WHERE flag=0 AND name like '%$keyword%'");
            while ($row = $res->fetch_assoc()) {
                $str .= $row['name'] . ',' . $row['cid'] . "\r\n";
            }
        }
        echo $str;
        break;
    
    case 'getAutoModel':
        $str = '';
        $keyword = $_GET['q'];
        if ($keyword) {
            $res = $mysqli->query("SELECT model_id,name FROM se_product_model WHERE flag=0 AND name like '%$keyword%'");
            while ($row = $res->fetch_assoc()) {
                $str .= $row['name'] . ',' . $row['model_id'] . "\r\n";
            }
        }
        echo $str;
        break;
    
    case 'getAutoMeasure':
        $str = '';
        $keyword = $_GET['q'];
        if ($keyword) {
            $res = $mysqli->query("SELECT mid,name FROM se_product_measure WHERE flag=0 AND name like '%$keyword%'");
            while ($row = $res->fetch_assoc()) {
                $str .= $row['name'] . ',' . $row['mid'] . "\r\n";
            }
        }
        echo $str;
        break;
        
    case 'getModel':
        $_categories = $_POST ['category_id'];
        $_brands = $_POST ['brand_id'];
        
        $arr = array ();
        if (! empty ( $_brands )) {
            $arr [] = "  brand IN ( $_brands) ";
        }
        if (! empty ( $_categories )) {
            $arr [] = "  category IN ( $_categories) ";
        }
        if (count ( $arr )) {
            
            $where =  implode ( " AND ", $arr );
            $sql = "SELECT DISTINCT model AS model_id,name  FROM se_product  AS A,se_product_model AS B  WHERE $where  AND A.model = B.model_id";
            
        } else {
            $sql = "SELECT DISTINCT model AS model_id,name  FROM se_product  AS A,se_product_model AS B  WHERE A.model = B.model_id";
            
        }
        
        $res = $mysqli->query ( $sql );
        $opt="<option value=''>款型</option>";
        if ($res) {
            $data = array ();
            while ( $row = $res->fetch_assoc () ) { 
                $opt .= '<option value="' . $row ['model_id'] . '">' . $row ['name'] . '</option>';
            }
        } 
        echo $opt;
        exit();
        break;
    
    case 'save_pro':
        $brand_name = $_POST['brand_name'];
        $category_name = $_POST['category_name'];
        $model_name = $_POST['model_name'];
        $measure_name = $_POST['measure_name'];
        $specification = $_POST['specification'];
        $specification = empty($specification) ? "0" : $specification;
        $market_price = $_POST['market_price'];
        $market_price = empty($market_price) ? "0" : $market_price;
        $min_price = $_POST['min_price'];
        $min_price = empty($min_price) ? "0" : $min_price;
        $product_id = intval($_POST['product_id']);
        // brand
        $res_brand = $mysqli->query("SELECT brand_id FROM se_product_brand WHERE name='$brand_name' and flag=0 LIMIT 1");
        $row_brand = $res_brand->fetch_row();
        $brand_id = $row_brand[0];
        if (empty($brand_id)) {
            $mysqli->query("INSERT INTO se_product_brand SET name='$brand_name',create_uid='$sysuid',create_time=NOW()");
            $brand_id = $mysqli->insert_id;
        }
        $brand_id = ! empty($brand_id) ? $brand_id : '0';
        // category
        $res_c = $mysqli->query("SELECT cid FROM se_product_category WHERE name='$category_name' and flag=0 LIMIT 1");
        $row_c = $res_c->fetch_row();
        $category_id = $row_c[0];
        if (empty($category_id)) {
            $mysqli->query("INSERT INTO se_product_category SET name='$category_name',create_uid='$sysuid',create_time=NOW()");
            $category_id = $mysqli->insert_id;
        }
        $category_id = ! empty($category_id) ? $category_id : "0";
        // model
        $res_model = $mysqli->query("SELECT model_id FROM se_product_model WHERE name='$model_name' and flag=0 LIMIT 1");
        $row_model = $res_model->fetch_row();
        $model_id = $row_model[0];
        if (empty($model_id)) {
            $mysqli->query("INSERT INTO se_product_model SET name='$model_name',create_uid='$sysuid',create_time=NOW()");
            $model_id = $mysqli->insert_id;
        }
        $model_id = ! empty($model_id) ? $model_id : "0";
        // measure
        $res_m = $mysqli->query("SELECT mid FROM se_product_measure WHERE name='$measure_name' and flag=0 LIMIT 1");
        $row_m = $res_m->fetch_row();
        $measure_id = $row_m[0];
        if (empty($measure_id)) {
            $mysqli->query("INSERT INTO se_product_measure SET name='$measure_name',create_uid='$sysuid',create_time=NOW()");
            $measure_id = $mysqli->insert_id;
        }
        if ($product_id)
            $sql = "UPDATE se_product SET brand='$brand_id',category='$category_id',model='$model_id',measure='$measure_id',
specification='$specification',market_price='$market_price',min_price='$min_price',edit_uid='$sysuid',edit_time=NOW() WHERE product_id='$product_id'";
        else
            $sql = "INSERT INTO se_product SET brand='$brand_id',category='$category_id',model='$model_id',measure='$measure_id',
specification='$specification',market_price='$market_price',min_price='$min_price',edit_uid='$sysuid',edit_time=NOW()";
        //echo $sql;
        if ($mysqli->query($sql))
            echo 1;
        else
            echo 0;
        exit();
        
        break;
    
    default:
        if ($systoken) {
            header("location: project.php"); exit;
        } else{
            $smarty->display("login.html");
        }
        break;
}
