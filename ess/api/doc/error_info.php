<?php
/**
 *@author wsshh1314@outlook.com
 *@version	1.0
 *@abstract 2015年11月10日
 *@since  Version 1.0
 */

include '../common/API.class.php';
$err = API::getAllErrors();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>error intro</title>

<style>
.errtable {
	border: 1px solid #ccc;
	width: 500px;
	border-collapse: collapse;
}

th, td {
	border: 1px solid #666;
	padding: 4px;
	min-height: 20px;
}

.fun {
	text-align: center;
	background-color: #999;
}
</style>
</head>
<body>
	<table class="errtable">

		<tr>
			<td colspan="2" class="fun">错误码说明</td>
		</tr>
		<?php foreach ($err as $code=>$msg):?>
			<tr>
			<td><?php echo $code;?></td>
			<td><?php echo $msg;?></td>
		</tr>
		<?php endforeach;?>
	</table>
</body>
</html>