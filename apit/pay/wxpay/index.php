<?php
header ( 'Content-type: application/json' );
require 'TestpayAction.class.php';

$input = new TestpayAction();
//微信支付
$order = $input->wxpay($_POST['no'],$_POST['reward']);
echo json_encode($order);
