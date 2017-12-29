<?php
/* Smarty version 3.1.30, created on 2017-09-07 16:39:35
  from "/www/mecan.net/ess/templates/index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b105c7d72772_80989908',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6cf222f6e66fefcc6f744b3ae5afb0e23a7b251f' => 
    array (
      0 => '/www/mecan.net/ess/templates/index.html',
      1 => 1504762965,
      2 => 'file',
    ),
    'dc29824e50dfd381aae9e28adf117303e9a9ea3c' => 
    array (
      0 => '/www/mecan.net/ess/templates/top.html',
      1 => 1503307702,
      2 => 'file',
    ),
    'c7c3cf2bdf7ed0140e1e0b11f7b27bdc7f36180f' => 
    array (
      0 => '/www/mecan.net/ess/templates/header.html',
      1 => 1504762965,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 0,
),true)) {
function content_59b105c7d72772_80989908 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>产品-电气销售家</title>
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<link rel="stylesheet" href="css/page.css" />
<script src="jquery/jquery-1.7.2.min.js"></script>
<script src="uikit/js/uikit.min.js"></script>
<script src="uikit/js/uikit-icons.min.js"></script>
<link rel="stylesheet" type="text/css"
	href="jquery/autocomplete/jquery.autocomplete.css" />
<script type="text/javascript"
	src="jquery/autocomplete/jquery.autocomplete.min.js"></script>
<script>
	$(function() {
	
		//brand
		$("#brand_name").autocomplete("index.php?act=getAutoBrand", {
			width : 250,
			max : 20,
			delay : 10,
			minChars : 1,
			matchSubset : 1,
			matchContains : 1,
			cacheLength : 20,
			formatItem : function(data, i, n) {
				var array = data.toString().split(',');
				return array[0];
			},
			formatResult : function(data, i, n) {
				var array = data.toString().split(',');
				return array[0];
			}
		});
		/*$("#brand_name").result(function(event, data, formatted) {
			var arr = data.toString().split(',');
			$("#brand_id").val(arr[1]);
		});*/
		//category
		$("#category_name").autocomplete("index.php?act=getAutoCategory", {
			width : 250,
			max : 20,
			delay : 10,
			minChars : 1,
			matchSubset : 1,
			matchContains : 1,
			cacheLength : 20,
			formatItem : function(data, i, n) {
				var array = data.toString().split(',');
				return array[0];
			},
			formatResult : function(data, i, n) {
				var array = data.toString().split(',');
				return array[0];
			}
		});
		/*$("#category_name").result(function(event, data, formatted) {
			var arr = data.toString().split(',');
			$("#category_id").val(arr[1]);
		});*/
		//model
		$("#model_name").autocomplete("index.php?act=getAutoModel", {
			width : 250,
			max : 20,
			delay : 10,
			minChars : 1,
			matchSubset : 1,
			matchContains : 1,
			cacheLength : 20,
			formatItem : function(data, i, n) {
				var array = data.toString().split(',');
				return array[0];
			},
			formatResult : function(data, i, n) {
				var array = data.toString().split(',');
				return array[0];
			}
		});
		/*$("#model_name").result(function(event, data, formatted) {
			var arr = data.toString().split(',');
			$("#model_id").val(arr[1]);
		});*/
		//measure
		$("#measure_name").autocomplete("index.php?act=getAutoMeasure", {
			width : 250,
			max : 20,
			delay : 10,
			minChars : 1,
			matchSubset : 1,
			matchContains : 1,
			cacheLength : 20,
			formatItem : function(data, i, n) {
				var array = data.toString().split(',');
				return array[0];
			},
			formatResult : function(data, i, n) {
				var array = data.toString().split(',');
				return array[0];
			}
		});
		/*$("#measure_name").result(function(event, data, formatted) {
			var arr = data.toString().split(',');
			$("#measure_id").val(arr[1]);
		});*/
		
		//3组3级款型切换
	   $("#brand").change(function () {
		   $("#sp").html('款型');
		   $("#model").val('');
		   var brand_id=$(this).val();
		   var category_id=$("#category").val();
		   $.post('index.php', {act: 'getModel', brand_id: brand_id,category_id:category_id}, function (data) {
                       $("#model").html(data);               
               
           });
	   });
		
		$("#category").change(function () {
			$("#sp").html('款型');
			 $("#model").val('');
			   var brand_id=$("#brand").val();
			   var category_id=$(this).val();
			   $.post('index.php', {act: 'getModel', brand_id: brand_id,category_id:category_id}, function (data) {
	                       $("#model").html(data);               
	               
	           });
		   });

		//提交表单
		$('#save_pro').click(
				function() {
					//var brand_id=$("#brand_id").val();
					var brand_name = $("#brand_name").val();
					//var measure_id=$("#measure_id").val();
					var measure_name = $("#measure_name").val();
					//var category_id=$("#category_id").val();
					var category_name = $("#category_name").val();
					//var model_id=$("#model_id").val();
					var model_name = $("#model_name").val();
					var specification = $("#specification").val();
					var market_price = $("#market_price").val();
					var product_id = $("#product_id").val();
					var min_price = $("#min_price").val();
					if (brand_name.length == 0 || measure_name.length == 0
							|| category_name.length == 0
							|| model_name.length == 0
							|| specification.length == 0
							|| market_price.length == 0
							|| min_price.length == 0) {
						alert("请完善产品信息！");
					} else {
						$.post('index.php', {
							act : 'save_pro',
							brand_name : brand_name,
							measure_name : measure_name,
							category_name : category_name,
							model_name : model_name,
							specification : specification,
							market_price : market_price,
							min_price : min_price,
							product_id : product_id
						}, function(data) {
							//alert(data);
							if (data == 1)
								setTimeout(function() {
									window.location.reload();
								}, 500);
							else
								alert('编辑产品失败！');

						});
					}
				});

		$("[id^='edit_pro_']").click(function() {
			var _data = $(this).attr('id');
			var product_id = _data.split("_")[2];
			$.post('index.php', {
				act : 'edit',
				product_id : product_id
			}, function(data) {
				if (data != '') {
					var proJson = jQuery.parseJSON(data);
					$("#product_id").val(proJson.product_id);
					$("#measure_name").val(proJson.measure_name);
					$("#brand_name").val(proJson.brand_name);
					$("#category_name").val(proJson.category_name);
					$("#model_name").val(proJson.model_name);
					$("#market_price").val(proJson.market_price);
					$("#min_price").val(proJson.min_price);
					$("#specification").val(proJson.specification);
				} else {
					$("#product_id").val(0);
					$("#measure_name").val('');
					$("#brand_name").val('');
					$("#category_name").val('');
					$("#model_name").val('');
					$("#market_price").val('');
					$("#min_price").val('');
					$("#specification").val('');
				}
			});
		});

		$("#add_pro").click(function() {
			$("#product_id").val(0);
			$("#measure_name").val('');
			$("#brand_name").val('');
			$("#category_name").val('');
			$("#model_name").val('');
			$("#market_price").val('');
			$("#min_price").val('');
			$("#specification").val('');
		});

		//brand
		/*$("#brand").change(function() {
			var brand = $(this).children('option:selected').val();
			var user_id = $("#user_id").val();
			if (brand.length > 0)
				window.location.href = "index.php?brand=" + brand;
		});
		//category
		$("#category").change(function() {
			var category = $(this).children('option:selected').val();
			var user_id = $("#user_id").val();
			if (category.length > 0)
				window.location.href = "index.php?category=" + category;
		});
		//model
		$("#model").change(function() {
			var model = $(this).children('option:selected').val();
			var user_id = $("#user_id").val();
			if (model.length > 0)
				window.location.href = "index.php?model=" + model;
		});*/
	});

	function del(product_id) {
		if (confirm("确定要删除这个产品吗？")) {
			$.post('index.php', {
				act : 'del',
				product_id : product_id
			}, function(data) {
				if (data == 1)
					setTimeout(function() {
						window.location.reload();
					}, 500);
				else
					alert("删除失败！");
			})
		}
	}
</script>


</head>
<body>
	<style type="text/css">
#head { height: 50px;background: #323232;}
#head .logo { float: left; margin: 10px 0 0 20px;}
#head .user { float: right; color: #FFFFFF; font: 14px Arial; margin: 15px 20px 0 0;}
#head .user a { color: #FFFFFF; text-decoration:none;}
#head .user a:hover {color:#FFFFFF; text-decoration:underline;}
</style>
<div id="head">
    <div class="logo"><img src="img/dqj_logo.png" width="132" height="24"/></div>
    <div class="user">
       系统管理员  &nbsp;  &nbsp; <a href="index.php?act=logout" >退出</a>  &nbsp;  &nbsp; 
    </div>
</div>
	<div class="uk-container">
		<style>
html {
	font-family: 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei',
		sans-serif;
}

.ft18 {
	font-size: 18px;
}

.uk-flex-center li {
	margin-right: 50px;
}

.uk-active a {
	border-bottom: #1e87f0 solid 2px;
	padding-bottom: 10px;
}

.cnt {
	margin-top: -20px;
}
</style>
<div class="uk-margin-medium-top">
	<ul class="uk-flex-center " uk-tab>

				<li><a href="project.php"><span class="ft18">项目申报</span> <span class="uk-badge cnt">17</span>
				</a></li>  		<li class="uk-active"><a href="product.php"><span class="ft18">产品</span></a></li>
				<li><a href="user.php"><span class="ft18">用户</span></a></li> 				<li><a href="feedback.php"><span class="ft18">用户反馈</span></a></li>
		
	</ul>
</div>
		<div>
			<form action="product.php" method="get" id="search_form">
				<div class="uk-inline">
					<span class="uk-form-icon" uk-icon="icon: search"></span> <input
						class="uk-input" type="text" placeholder="产品ID、规格..." name="kw"
						value="" style="width: 400px;" id="kw">
				</div>
				<div uk-form-custom="target: > * > span:first">
					<select id="brand" name="brand">
						<option value="">品牌</option>  						<option value="2">明及</option>
						  						<option value="3">阿斯博</option>
						 
					</select>
					<button class="uk-button uk-button-default" type="button"
						tabindex="-1">
						<span></span> <span uk-icon="icon: chevron-down"></span>
					</button>
				</div>

				<div uk-form-custom="target: > * > span:first">
					<select id="category" name="category">
						<option value="">品类</option>  						<option value="1">中压元器件</option>
						  						<option value="2">中压开关设备</option>
						  						<option value="3">低压元器件</option>
						  						<option value="4">智能组件及仪表</option>
						  						<option value="5">真空接触器</option>
						 
					</select>
					<button class="uk-button uk-button-default" type="button"
						tabindex="-1">
						<span></span> <span uk-icon="icon: chevron-down"></span>
					</button>
				</div>

				<div uk-form-custom="target: > * > span:first">
					<select id="model" name="model">
						<option value="">款型</option>  						<option value="1">VBM SmartEX-12</option>
						  						<option value="2">VBM Pro4-12</option>
						  						<option value="3">VBM Pro5-12</option>
						  						<option value="4">VBM Pro7A-12</option>
						  						<option value="5">VBM Pro7B-12</option>
						  						<option value="6">VBM Pro7C-12</option>
						  						<option value="7">VBM Pro7D-12</option>
						  						<option value="8">VBM Pro8-40.5</option>
						  						<option value="9">VBM Pro9-40.5</option>
						  						<option value="10">VBM10A-24</option>
						  						<option value="11">VBM10B-24</option>
						  						<option value="12">VBM10C-24</option>
						  						<option value="13">VBM10D-24</option>
						  						<option value="14">VBM Pro15-12</option>
						  						<option value="15">JT4-210</option>
						  						<option value="16">JT5-210</option>
						  						<option value="17">JT5-275</option>
						  						<option value="18">VBM-12T</option>
						  						<option value="19">JT9-40.5</option>
						  						<option value="20">VBM4-12</option>
						  						<option value="21">VBM16-12</option>
						  						<option value="22">VBM5-12</option>
						  						<option value="23">VBM7B</option>
						  						<option value="24">VBM7D-12</option>
						  						<option value="25">VBM9-40.5</option>
						  						<option value="26">JT4-275</option>
						  						<option value="27">隔离手车框架</option>
						  						<option value="28">VBM7A-12</option>
						  						<option value="29">VBM1-12</option>
						  						<option value="30">JT10-275</option>
						  						<option value="31">VDS4-12</option>
						  						<option value="32">VBM-12C</option>
						  						<option value="33">VBM8-40.5</option>
						  						<option value="34">SmartEx MVG-12</option>
						  						<option value="35">GNM-12上隔离开关</option>
						  						<option value="36">GNM-12下隔离开关</option>
						  						<option value="37">GNM-12隔离开关操作机构</option>
						  						<option value="38">VBM-12G</option>
						  						<option value="39">DM6B-S开关状态显示仪</option>
						  						<option value="40">VBM19-40.5</option>
						  						<option value="41">DM6A-S开关状态显示仪</option>
						  						<option value="42">DM6A-G开关状态显示仪</option>
						  						<option value="43">JN15-12接地开关</option>
						  						<option value="44">隔离车-24KV</option>
						  						<option value="45">JT5-150</option>
						  						<option value="46">MSH100</option>
						  						<option value="47">MSH150</option>
						 
					</select>
					<button class="uk-button uk-button-default" type="button"
						tabindex="-1" >
						<span id="sp"></span> <span uk-icon="icon: chevron-down"></span>
					</button>
				</div>
				<button class="uk-button uk-button-primary uk-margin-small-right"
					type="submit">搜索</button>

				<span style="float: right;"><button
						class="uk-button uk-button-primary uk-margin-small-right"
						type="button" uk-toggle="target: #modal-center" id="add_pro">+添加产品</button></span>
			</form>
		</div>
		<div id="modal-center" class="uk-flex-top" uk-modal>
			<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h2 class="uk-modal-title">添加产品</h2>

				<form class="uk-form-horizontal uk-margin-large">
					<input type="hidden" name="product_id" value='0' id="product_id" />
					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">计量单位</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" placeholder="计量单位"
								name="measure_name" id="measure_name" /><input type="hidden"
								name="measure_id" id="measure_id" value='0' />
						</div>
					</div>
					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">产品品牌</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" placeholder="产品品牌"
								name="brand_name" id="brand_name" /> <input type="hidden"
								name="brand_id" id="brand_id" value='0' />
						</div>
					</div>

					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">产品类别</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" placeholder="产品类别"
								name="category_name" id="category_name" /> <input type="hidden"
								name="category_id" id="category_id" value='0' />
						</div>
					</div>

					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">产品型号</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" placeholder="产品型号"
								name="model_name" id="model_name" /> <input type="hidden"
								name="model_id" id="model_id" value='0' />
						</div>
					</div>

					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">产品规格</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" name="specification"
								id="specification" placeholder="规格">
						</div>
					</div>
					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">面价
							(元)</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" name="market_price"
								id="market_price" placeholder="面价 (单位：元)">
						</div>

					</div>
					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">最低价
							(元)</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" name="min_price"
								id="min_price" placeholder="最低价 (单位：元)">
						</div>
					</div>
				</form>

				<p class="uk-text-right">
					<button class="uk-button uk-button-default uk-modal-close"
						type="button">取消</button>
					<button class="uk-button uk-button-primary" type="button"
						id="save_pro">保存</button>
				</p>
			</div>
		</div>
		<table class="uk-table uk-table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>型号</th>
					<th>品牌/类</th>
					<th>规格</th>
					<th>面价(元)</th>
					<th>最低价(元)</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				
				<tr class="uk-text-small">
					<td>758</td>
					<td>MSH150</td>
					<td>阿斯博 / 中压元器件</td>
					<td>抽出式,100A，758，47</td>
					<td>3000.00 / 台</td>
					<td>2400.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_758" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('758')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>757</td>
					<td>MSH100</td>
					<td>阿斯博 / 中压元器件</td>
					<td>,抽出式,100A，757，46</td>
					<td>2600.00 / 台</td>
					<td>2080.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_757" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('757')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>756</td>
					<td>MSH100</td>
					<td>阿斯博 / 中压元器件</td>
					<td>,抽出式,100A，756，46</td>
					<td>2200.00 / 台</td>
					<td>1760.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_756" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('756')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>755</td>
					<td>VBM-12G</td>
					<td>明及 / 中压元器件</td>
					<td>客户提供极柱,BF-0,210mm/275mm,手车式，755，38</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_755" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('755')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>754</td>
					<td>VBM4-12</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,BF-0-QY,275mm/275mm,手车式，754，20</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_754" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('754')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>753</td>
					<td>VBM4-12</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,BF-0,275mm/275mm,手车式，753，20</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_753" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('753')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>752</td>
					<td>VBM-12G</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,00-0,210mm/275mm,手车式，752，38</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_752" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('752')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>751</td>
					<td>VBM-12G</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,00-0,210mm/275mm,手车式，751，38</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_751" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('751')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>750</td>
					<td>VBM4-12</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,00-0,210mm/275mm,手车式，750，20</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_750" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('750')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>749</td>
					<td>VDS4-12</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,BF-0,210mm/275mm,手车式，749，31</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_749" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('749')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>748</td>
					<td>VDS4-12</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,BF-0,210mm/275mm,手车式，748，31</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_748" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('748')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>747</td>
					<td>VBM4-12</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,BF-2(5),210mm/275mm,手车式，747，20</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_747" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('747')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>746</td>
					<td>JT5-150</td>
					<td>阿斯博 / 中压元器件</td>
					<td>无,BF-0,150mm/275mm,手车式，746，45</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_746" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('746')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>745</td>
					<td>VBM5-12</td>
					<td>明及 / 中压元器件</td>
					<td>客户提供极柱,B0-0,210mm/205mm,手车式，745，22</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_745" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('745')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>744</td>
					<td>VBM1-12</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,BF-2(2.5),210mm/275mm,手车式，744，29</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_744" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('744')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>743</td>
					<td>JT5-210</td>
					<td>阿斯博 / 中压元器件</td>
					<td>无,BF-3(5),210mm/205mm,手车式，743，16</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_743" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('743')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>742</td>
					<td>VBM-12T</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,B0-0,210mm/275mm,固定式，742，18</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_742" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('742')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>741</td>
					<td>隔离车-24KV</td>
					<td>阿斯博 / 中压元器件</td>
					<td>无,B0-0,275mm/310mm,---，741，44</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_741" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('741')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>740</td>
					<td>VBM-12G</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,0F-0,275mm/310mm,手车式  带程序锁，740，38</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_740" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('740')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>739</td>
					<td>VBM-12G</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,0F-0,275mm/310mm,手车式，739，38</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_739" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('739')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>738</td>
					<td>VBM-12G</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,0F-0,210mm/275mm,手车式，738，38</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_738" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('738')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>737</td>
					<td>VBM5-12</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,BF-0,210mm/275mm,手车式，737，22</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_737" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('737')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>736</td>
					<td>VBM9-40.5</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,0F-0,300mm/400mm,手车式，736，25</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_736" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('736')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>735</td>
					<td>VBM1-12</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,BF-0-Y0,210mm/275mm,手车式，735，29</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_735" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('735')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>734</td>
					<td>VBM Pro7A-12</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,00-0-QY,210mm/275mm,固定式，734，4</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_734" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('734')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>733</td>
					<td>GNM-12隔离开关操作机构</td>
					<td>明及 / 中压元器件</td>
					<td>无,---,210mm/275mm,---，733，37</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_733" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('733')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>732</td>
					<td>JN15-12接地开关</td>
					<td>阿斯博 / 中压元器件</td>
					<td>无,---,210mm/275mm,---，732，43</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_732" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('732')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>731</td>
					<td>GNM-12上隔离开关</td>
					<td>明及 / 中压元器件</td>
					<td>无,---,210mm/275mm,---，731，35</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_731" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('731')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>730</td>
					<td>GNM-12上隔离开关</td>
					<td>明及 / 中压元器件</td>
					<td>无,---,210mm/275mm,---，730，35</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_730" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('730')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>729</td>
					<td>VBM-12T</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,B0-0,210mm/275mm,手车式，729，18</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_729" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('729')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>728</td>
					<td>VBM Pro5-12</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,0F-0,275mm/310mm,手车式，728，3</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_728" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('728')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>727</td>
					<td>VBM-12T</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,BF-0-QY,210mm/275mm,手车式，727，18</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_727" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('727')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>726</td>
					<td>VBM8-40.5</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,00-0,400mm/400mm,固定式，726，33</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_726" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('726')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>725</td>
					<td>VBM5-12</td>
					<td>明及 / 中压元器件</td>
					<td>客户提供极柱,BF-0-Y0,275mm/310mm,手车式，725，22</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_725" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('725')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>724</td>
					<td>VBM Pro4-12</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,0F-0,210mm/275mm,固定式，724，2</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_724" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('724')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>723</td>
					<td>JT4-210</td>
					<td>阿斯博 / 中压元器件</td>
					<td>无,BF-0,210mm/275mm,固定式，723，15</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_723" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('723')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>722</td>
					<td>VBM-12T</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,0F-0,210mm/275mm,手车式  带程序锁，722，18</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_722" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('722')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>721</td>
					<td>VBM-12T</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,0F-2(5),210mm/275mm,手车式，721，18</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_721" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('721')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>720</td>
					<td>VBM5-12</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,BF-0,210mm/275mm,手车式，720，22</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_720" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('720')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>719</td>
					<td>JT4-210</td>
					<td>阿斯博 / 中压元器件</td>
					<td>无,B0-0,210mm/275mm,手车式，719，15</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_719" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('719')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>718</td>
					<td>VBM-12G</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,0F-0,210mm/275mm,手车式，718，38</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_718" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('718')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>717</td>
					<td>VBM-12G</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,0F-0,210mm/275mm,手车式，717，38</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_717" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('717')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>716</td>
					<td>VBM-12C</td>
					<td>明及 / 中压元器件</td>
					<td>固封极柱,0F-0,210mm/275mm,固定式，716，32</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_716" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('716')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>715</td>
					<td>VBM4-12</td>
					<td>明及 / 中压元器件</td>
					<td>陶瓷灭弧室,BF-2(2.5),210mm/275mm,固定式，715，20</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_715" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('715')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>714</td>
					<td>VBM-12T</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,00-0,210mm/275mm,手车式，714，18</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_714" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('714')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>713</td>
					<td>VBM10A-24</td>
					<td>阿斯博 / 中压元器件</td>
					<td>客户提供极柱,B0-0,275mm/310mm,手车式，713，10</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_713" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('713')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>712</td>
					<td>VBM10A-24</td>
					<td>阿斯博 / 中压元器件</td>
					<td>客户提供极柱,B0-0,275mm/310mm,手车式，712，10</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_712" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('712')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>711</td>
					<td>VBM-12T</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,B0-2(5),210mm/275mm,手车式，711，18</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_711" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('711')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>710</td>
					<td>VBM-12T</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,00-2(5),210mm/275mm,手车式，710，18</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_710" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('710')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
				<tr class="uk-text-small">
					<td>709</td>
					<td>VBM-12T</td>
					<td>阿斯博 / 中压元器件</td>
					<td>陶瓷灭弧室,00-2(5),210mm/275mm,手车式，709，18</td>
					<td>15000.00 / 台</td>
					<td>8800.00 / 台</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_709" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('709')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				
			</tbody>
		</table>
		<div class="uk-margin uk-margin-bottom"><div class="pagination"><div class="page-floatR"><span class="page-start right0"><span>上一页</span></span><span class="page-cur right0">1</span><a class="right0" href="http://www.mecan.net/ess/product.php?page=2">2</a><a class="right0" href="http://www.mecan.net/ess/product.php?page=3">3</a><a class="right0" href="http://www.mecan.net/ess/product.php?page=4">4</a><span class="page-break right0">...</span><a class="right0" href="http://www.mecan.net/ess/product.php?page=14">14</a><a class="right0" href="http://www.mecan.net/ess/product.php?page=15">15</a><a class="right0" href="http://www.mecan.net/ess/product.php?page=16">16</a><a href="http://www.mecan.net/ess/product.php?page=2" class="page-next right0"><span>下一页</span></a></div></div></div>
	</div>
</body>
</html><?php }
}
