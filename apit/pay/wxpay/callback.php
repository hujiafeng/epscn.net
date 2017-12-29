<?php
header ( 'Content-type: application/json' );
require 'TestpayAction.class.php';
$input = new TestpayAction();

$order = $input->callback();

echo json_encode($order);