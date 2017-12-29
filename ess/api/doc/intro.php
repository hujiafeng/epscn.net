<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
<style>
body {
	font-size: 14px;
}

div {
	margin: 8px 0px;
	padding-top: 4px;
}

.content {
	border: 1ps solid #ccc;
}

.title {
	font-size: 14px;
	font-weight: bold;
	margin: 3px;
}

table {
	border-collapse: collapse;
	border: 1px solid #666;
	width: 800px;
	font-size: 13px;
}

.fun {
	background-color: #ccc;
	color: red
}

th, td {
	border: 1px solid #666;
	padding: 4px;
	min-height: 20px;
}

th {
	background-color: #ccc;
}

.head {
	width: 120px;
}

.head2 {
	width: 60px
}

.head3 {
	width: 30px
}

.result {
	border: 1px solid #999;
	background-color: #ccc;
	width: 792px;
	padding: 4px;
	min-height: 150px;
}

input {
	margin: 4px;
}
.red{color:#c33;}
</style>
</head>
<body>
<?php include 'all_api.php';?>

	<div class="content">
		<!-- 请求说明 -->
		<div class="title">请求说明</div>
		<table class="tb">
			<tr>
				<td colspan="2" class="fun">需求详情</td>
			</tr>
			<tr>
				<td class="head">请求地址（url）</td>
				<td>
				<span class="red">
				<?php
				
				$api = $_GET ['api'];
				$url = API_ROOT . $api.".php";
				?>
					<!-- URL -->
					<?php echo $url;?>
					</span>
				</td>
			</tr>
			<tr>
				<td>方法</td>
				<td>POST</td>
			</tr>
			<tr>
				<td>数据格式</td>
				<td>JSON</td>
			</tr>
			<tr>
				<td>认证</td>
				<td>登录会话</td>
			</tr>

		</table>
		<!-- 参数说明 -->
		<div class="title">参数说明</div>
		<table class="tb">
			<tr>
				<th class="head">参数</th>
				<th class="head2">类型</th>
				<th class="head3">必须</th>
				<th>参数说明</th>
			</tr>
			<?php
			
			$arr_params = $APIS [$api] ['params'];
			?>
		
		<?php foreach ($arr_params as $item): ?>
			<tr>
				<td><?php echo $item['name'];?></td>
				<td><?php echo $item['type'];?></td>
				<td><?php echo $item['must'];?></td>
				<td><?php echo $item['desc'];?></td>
			</tr>
		<?php endforeach;?>
		</table>
		<!-- 测试演示 -->
		<div class="title">测试</div>

		<div class="result">
			<form action="<?php echo $url;?>" method="post">
						<?php foreach ($arr_params as $item): ?>
						
						<?php echo $item['name'];?> <input
					name="<?php echo $item['name'];?>" type="text" value="" /> <br />
						<?php endforeach;?>
				
				<input type="submit" value="测试">
			</form>
		</div>
		<!-- 结果及说明 -->
		<div class="title">结果及说明</div>
		<div class="result">
			<br> <br>
			<pre></pre>
		</div>
		<div></div>
	</div>
</body>
</html>