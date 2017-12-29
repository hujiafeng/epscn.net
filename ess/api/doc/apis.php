<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" href="../css/demo.css" type="text/css">
<link rel="stylesheet" href="./css/zTreeStyle/zTreeStyle.css"
	type="text/css">
<script type="text/javascript" src="./js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="./js/jquery.ztree.core-3.5.min.js"></script>


<title></title>

<script>
<!--
var setting = {	};
<?php 
include './all_api.php';

$nodes_array = array();
$children = array();
foreach ($APIS as $key=> $api)
{
	$children[] = array("name"=>$api['name']."($key)","target"=>"apiintro","url"=>"./intro.php?api=".$key);
}
$nodes_array[] = array("name"=>"接口列表","open"=>true,"children"=>$children);

$node2_childrens = array(array("name"=>"错误说明","url"=>"error_info.php","target"=>"apiintro"));

$nodes_array[]= array("name"=>"其他","open"=>true,"children"=>$node2_childrens);


?>
var zNodes =<?php echo json_encode($nodes_array);?>

$(document).ready(function(){
	$.fn.zTree.init($("#treeDemo"), setting, zNodes);
});
</script>
<style type="text/css">
body {
	text-align: center;
	font-size: 12px;
	margin: 0px;
	background-color:#f0f6e4;margin:0px;
}

.top {
	font-weight: bold;
	font-size: 14px;
	background-color: #ccc;
	padding: 4px;
}

.apilist {
	text-align: left;
	width: 100%;
}

li {
	margin-top: 5px;
}

a {
	text-decoration: none;
	color: blue;
}

a:hover {
	text-decoration: underline;
	color: red;
}
.left{background-color:#f0f6e4}
</style>
<base target="apiintro" />
</head>
<body>
	<div class="content_wrap">
		<div class="zTreeDemoBackground left">
			<ul id="treeDemo" class="ztree"></ul>
		</div>

	</div>
</body>
</html>