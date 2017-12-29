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
// 项目状态
$project_status_arr = array(
    "ALL" => array("所有",""),
    "DRAFT" => array("草稿","#CC0000"),
    "PENDING" => array("待审核","#CCCCC"),
    "TRACKING" => array("跟踪中","#888888"),
    "REFUSED" => array("审核不通过","#FF6600"),
    "DONE" => array("完成","#009966")
);
$smarty->assign("project_status_arr", $project_status_arr);

switch ($act) {
    case 'check':
        require 'MSGWrapper.php';
        $project_id = intval($_POST['project_id']);
        $project_status = $_POST['project_status'];
        $refuse_reason = $_POST['refuse_reason'];
        $sql = "UPDATE se_project SET project_status='$project_status',check_uid='$sysuid',check_time=NOW() ";
        if ($project_status == 'REFUSED')
            $sql .= " ,refuse_reason='$refuse_reason' ";
        $sql .= " WHERE project_id='$project_id'";
        if ($mysqli->query($sql)){
            $res_pn=$mysqli->query("SELECT name,create_uid FROM se_project WHERE project_id='$project_id'");
            $row_pn=$res_pn->fetch_assoc();
            $project_name=$row_pn['name'];
            $ruid=$row_pn['create_uid'];
            if($project_status=='REFUSED'){
                $msg = MSGWrapper::makeMsg ( MSGWrapper::MSG_PROJECT_CHECK_NO, $project_name, null );
                $sql_n = "INSERT INTO se_message SET obj_id='$project_id',obj_type=1,suid='3',msg='$msg',ruid='$ruid',
                            create_time=NOW()";
                //echo $sql_n;
                $mysqli->query ( $sql_n );
                MSGWrapper::doWith ( MSGWrapper::MSG_PROJECT_CHECK_NO, $ruid);
            }else if($project_status=='TRACKING'){
                $msg = MSGWrapper::makeMsg ( MSGWrapper::MSG_PROJECT_CHECK_YES, $project_name, null );
                $sql_n = "INSERT INTO se_message SET obj_id='$project_id',obj_type=1,suid='3',msg='$msg',ruid='$ruid',
                            create_time=NOW()";
                $mysqli->query ( $sql_n );
                MSGWrapper::doWith ( MSGWrapper::MSG_PROJECT_CHECK_YES, $ruid);
            }
            echo 1;
        }else
            echo 0;
        exit();
        break;
    
    case 'detail':
        $project_id = intval($_POST['project_id']);
        $res = $mysqli->query("SELECT * ,(SELECT fullname FROM se_user WHERE user_id=p.check_uid) AS check_uname FROM se_project p WHERE project_id='$project_id'");
        $row = $res->fetch_assoc();
        $str = "";
        if ($row['project_id']) {
            $str .= "<tr>
						<td align=\"right\">ID:</td>
						<td>{$row['project_id']}</td>
						<td align=\"right\">编号：</td>
						<td>{$row['project_no']}</td>
					</tr>
					<tr>
						<td align=\"right\">项目名:</td>
						<td>{$row['name']}</td>
						<td align=\"right\">采购方：</td>
						<td>{$row['purchaser']}</td>
					</tr>
					<tr>
						<td align=\"right\">采购产品:</td>
                        <td colspan=\"3\"></td>
					</tr>";
            $res_p = $mysqli->query("SELECT 
(SELECT name FROM se_product_brand WHERE brand_id=p.brand) AS brand_name,
            (SELECT name FROM se_product_category WHERE cid=p.category) AS category_name,
            (SELECT name FROM se_product_model WHERE model_id=p.model) AS model_name,
            (SELECT name FROM se_product_measure WHERE mid=p.measure) AS measure_name,
            (SELECT count(record_id) FROM se_score_record WHERE pp_id=pp.pp_id AND score>=0) AS last_num,
            pp.purchase_price,pp.last_price,pp.purchase_num,p.market_price,p.specification
            FROM se_project_products pp,se_product p 
            WHERE pp.product_id=p.product_id AND pp.project_id='$project_id'");
            while ($row_p = $res_p->fetch_assoc()) {
                $str .= " <tr style='color:#999'>
    						<td></td>
                            <td colspan=\"3\">{$row_p['specification']},{$row_p['category_name']},{$row_p['model_name']}<br/>
                                                                                        品牌：{$row_p['brand_name']}<br/>                                                       
                                                                                        面价/采购价/结算价（元/{$row_p['measure_name']}）：{$row_p['market_price']} &nbsp;/&nbsp; 
                                                                                       {$row_p['purchase_price']} &nbsp;/&nbsp;
                                                                                        {$row_p['last_price']}<br/>
                                                                                        采购/实际采购数量：{$row_p['purchase_num']} &nbsp;/&nbsp;
                                                                                      {$row_p['last_num']}<br/>                                                                                     
                            </td>
					       </tr>
<tr><td></td><td colspan=\"3\" style='border-top:#eaeaea solid 1px;line-height:10px;'>&nbsp;</td></tr>
";
            }
            
            $str .= "<tr>
						<td align=\"right\" >状态:</td>
                        <td colspan=\"3\"><span style=\"color:{$project_status_arr[$row[project_status]][1]}\">{$project_status_arr[$row[project_status]][0]}</span>";
            if ($row['check_uid'] && $row[project_status] > 'PENDING') {
                $str .= "<span style='color:#999;font-size:12px;'>&nbsp;&nbsp;&nbsp;&nbsp;{$row['check_uname']} &nbsp;&nbsp; {$row['check_time']}</span></td>
					 </tr>";
            } else {
                $str .= "</td>
					 </tr>";
            }
        }
        echo $str;
        exit();
        break;
    
    case 'getProducts':
        $project_id = intval($_POST['project_id']);
        $str .= "<table class=\"uk-table uk-table-striped\">
			<thead>
				<tr>
					<th><input class=\"uk-checkbox\" type=\"checkbox\" name=\"checkAll\"
						id=\"checkAll\" value='1'> ID</th>
					<th>型号</th>
					<th>品牌/类</th>
					<th>规格</th>
					<th>采购/已采购</th>
                    <th>采购单价(元)</th>
                    <th>采购数量</th>
				</tr>
			</thead>
			<tbody>
				
			";
        $res = $mysqli->query("SELECT pp.product_id,pp.purchase_num,p.specification,pp.pp_id,pp.purchase_price,
        (SELECT count(record_id) FROM se_score_record WHERE pp_id=pp.pp_id AND score>=0 AND flag=0) AS last_num,
        (SELECT name FROM se_product_brand WHERE brand_id=p.brand) AS brand_name,
        (SELECT name FROM se_product_category WHERE cid=p.category) AS category_name,
        (SELECT name FROM se_product_model WHERE model_id=p.model) AS model_name,
        (SELECT name FROM se_product_measure WHERE mid=p.measure) AS measure_name
        FROM se_project_products pp,se_product p WHERE pp.flag=0 AND pp.project_id='$project_id' AND pp.product_id=p.product_id");
        while ($row = $res->fetch_assoc()) {
            $str.="<tr class=\"uk-text-small\"><td><input class=\"uk-checkbox\" type=\"checkbox\"
						name=\"ppIds\" value=\"{$row['pp_id']}\">
						{$row['product_id']}</td>
					<td>{$row['model_name']}</td>
					<td>{$row['brand_name']}/{$row['category_name']}</td>
					<td>{$row['specification']}</td>
					<td>{$row['purchase_num']}/{$row['last_num']}</td>
                    <td>{$row['purchase_price']}</td>
					<td><input class=\"uk-input uk-form-width-medium uk-form-small\" type=\"text\"
								name=\"purchase_num_{$row['pp_id']}\"></td>	
				</tr>";
        }
        $str .= "</tbody>
		</table>";
        echo $str;exit();
        break;
    
    default:
        require 'common/Page.class.php';
        $kw = $_GET['kw'];
        $o_status = $_GET['o_status'];
        if ($o_status == '')
            $o_status = "ALL";
        $sql = "SELECT * ,(SELECT fullname FROM se_user WHERE user_id=p.create_uid) AS create_uname,
                (SELECT fullname FROM se_user WHERE user_id=p.check_uid) AS check_uname
                 FROM se_project p WHERE flag=0";
        if ($kw)
            $sql .= " AND (name like '%$kw%' OR project_no like '%$kw%' OR purchaser like '%$kw%')";
        if ($o_status && $o_status != 'ALL')
            $sql .= " AND `project_status` = '$o_status'";
        $sql .= " ORDER BY create_time desc LIMIT 50";
        $page = new Page($sql);
        $sql = $page->StartPage();
        $res = $mysqli->query($sql);
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        $smarty->assign("o_status", $o_status);
        $endpage = $page->EndPage(3, 1);
        $smarty->assign("page", $endpage);
        $smarty->assign("data", $data);
        $smarty->display("project.html");
        break;
}