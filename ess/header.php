<?php
$res_pending=$mysqli->query("SELECT project_id FROM se_project WHERE project_status='PENDING' AND flag=0");
$pending_cnt=$res_pending->num_rows;
$smarty->assign("pending_cnt", $pending_cnt);