<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:46:47
  from "E:\www\eps\ess\templates\user_product.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0cb67e24507_92621821',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a51b807e5be774e6c4acbb9f0e98be03f8dd9989' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\user_product.html',
      1 => 1505803958,
      2 => 'file',
    ),
    '0a925040523a0ac5dcf123b8512936343c774fd6' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\top.html',
      1 => 1505803958,
      2 => 'file',
    ),
    '26ae1aee85cb6d9f2097548b3349283637b5c86c' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\header.html',
      1 => 1505803958,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 0,
),true)) {
function content_59c0cb67e24507_92621821 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户产品配置-电气销售家</title>
<link rel="stylesheet" href="css/page.css" />
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<script src="jquery/jquery-1.7.2.min.js"></script>
<script src="uikit/js/uikit.min.js"></script>
<script src="uikit/js/uikit-icons.min.js"></script>
<script>
	$(function() {
		$("input[name='productIds']").prop('checked', false);
		$("#checkAll").prop('checked', false);
		$("#checkAll").click(function() {
			var v = $(this).prop('checked');
			$("input[name='productIds']").prop('checked', v);
		});

		$("#set_price").click(function() {
			//检查是否选择了产品
			var str = "";
			$("input[name='productIds']:checked").each(function() {
				str += ',' + $(this).val();
			});
			if (str) {
				$("#agioProductIds").val(str);
				$("#agio").val('');
				$("#modal-price").show();
			} else {
				$("#modal-price").hide();
				alert("请选择产品!");
			}
		});

		$("#save_agio").click(function() {
			var user_id = $("#user_id").val();
			var productIds = $("#agioProductIds").val();
			var agio = $("#agio").val();
			if (productIds.length == 0) {
				alert("请选择产品！");
			} else if (isNaN(agio)) {
				alert("折扣请输入数字！");
			} else {
				$.post('user.php', {
					act : 'save_agio',
					user_id : user_id,
					productIds : productIds,
					agio : agio
				}, function(data) {
					if (data == 1)
						setTimeout(function() {
							window.location.reload();
						}, 500);
					else
						alert("折扣设置失败！");
				});
			}
		});

		//brand
		/*$("#brand")
				.change(
						function() {
							var brand = $(this).children('option:selected')
									.val();
							var user_id = $("#user_id").val();
							if (brand.length > 0)
								window.location.href = "user.php?act=user_product&user_id="
										+ user_id + "&brand=" + brand;
						});
		//category
		$("#category")
				.change(
						function() {
							var category = $(this).children('option:selected')
									.val();
							var user_id = $("#user_id").val();
							if (category.length > 0)
								window.location.href = "user.php?act=user_product&user_id="
										+ user_id + "&category=" + category;
						});
		//model
		$("#model")
				.change(
						function() {
							var model = $(this).children('option:selected')
									.val();
							var user_id = $("#user_id").val();
							if (model.length > 0)
								window.location.href = "user.php?act=user_product&user_id="
										+ user_id + "&model=" + model;
						});*/

		$("#brand").change(function() {
			$("#sp").html('款型');
			$("#model").val('');
			var brand_id = $(this).val();
			var category_id = $("#category").val();
			$.post('index.php', {
				act : 'getModel',
				brand_id : brand_id,
				category_id : category_id
			}, function(data) {
				$("#model").html(data);

			});
		});

		$("#category").change(function() {
			$("#sp").html('款型');
			$("#model").val('');
			var brand_id = $("#brand").val();
			var category_id = $(this).val();
			$.post('index.php', {
				act : 'getModel',
				brand_id : brand_id,
				category_id : category_id
			}, function(data) {
				$("#model").html(data);

			});
		});
	});
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

				<li><a href="project.php"><span class="ft18">项目申报</span> <span class="uk-badge cnt">18</span>
				</a></li>  		<li><a href="product.php"><span class="ft18">产品</span></a></li>
				<li class="uk-active"><a href="user.php"><span class="ft18">用户</span></a></li>
						<li><a href="feedback.php"><span class="ft18">用户反馈</span></a></li>
		
	</ul>
</div>
		<div>
		<form action="user.php" method="get" id="search_form">
		<input type="hidden" name="act" value="user_product"/>
		<input type="hidden" name="user_id" value="6"/>
			<div class="uk-inline">
				<span class="uk-form-icon" uk-icon="icon: search"></span> <input
					class="uk-input" type="text" placeholder="产品ID、规格..." name="kw"
					value="" style="width: 400px;" id="kw">
			</div>
			<div uk-form-custom="target: > * > span:first">
				<select id="brand" name="brand">
					<option value="">品牌</option>  					<option value="2">明及</option>
					  					<option value="3">阿斯博</option>
					 
				</select>
				<button class="uk-button uk-button-default" type="button"
					tabindex="-1">
					<span></span> <span uk-icon="icon: chevron-down"></span>
				</button>
			</div>

			<div uk-form-custom="target: > * > span:first">
				<select id="category" name="category">
					<option value="">品类</option>  					<option value="1">中压元器件</option>
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
					<option value="">款型</option>  					<option value="1">VBM SmartEX-12</option>
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
					tabindex="-1">
					<span id="sp"></span> <span uk-icon="icon: chevron-down"></span>
				</button>
			</div>
			<button class="uk-button uk-button-primary uk-margin-small-right"
				type="submit">搜索</button>

			<span style="float: right;"><button
					class="uk-button uk-button-primary uk-margin-small-right"
					type="button" uk-toggle="target: #modal-price" id="set_price">设置结算价格</button></span>
		</form>
	</div>


	<div id="modal-price" class="uk-flex-top" uk-modal>
		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
			<form class="uk-form-horizontal uk-margin-large">
				<input type="hidden" id="user_id" value='6' /> <input
					id="agioProductIds" type="hidden" value="" />
				<div class="uk-margin">
					<label class="uk-form-label" for="agio">设置折扣（例：0.75）：</label>
					<div class="uk-form-controls">
						<input class="uk-input" type="text" name="agio" id="agio" />
					</div>
				</div>
				<p class="uk-text-right">
					<button class="uk-button uk-button-default uk-modal-close"
						type="button">取消</button>
					<button class="uk-button uk-button-primary" type="button"
						id="save_agio">确定</button>
				</p>
			</form>
		</div>
	</div>

	<table class="uk-table uk-table-striped">
		<thead>
			<tr>
				<th><input class="uk-checkbox" type="checkbox" name="checkAll"
					id="checkAll"> ID</th>
				<th>型号</th>
				<th>品牌/类</th>
				<th>规格</th>
				<th>面价(元)</th>
				<th>最低价(元)</th>
				<th>结算价(元)</th>
				<th>计量单位</th>

			</tr>
		</thead>
		<tbody>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="758">
					758</td>
				<td>MSH150</td>
				<td>阿斯博/中压元器件</td>
				<td>抽出式,100A，758，47</td>
				<td>3000.00</td>
				<td>2400.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="757">
					757</td>
				<td>MSH100</td>
				<td>阿斯博/中压元器件</td>
				<td>,抽出式,100A，757，46</td>
				<td>2600.00</td>
				<td>2080.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="756">
					756</td>
				<td>MSH100</td>
				<td>阿斯博/中压元器件</td>
				<td>,抽出式,100A，756，46</td>
				<td>2200.00</td>
				<td>1760.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="755">
					755</td>
				<td>VBM-12G</td>
				<td>明及/中压元器件</td>
				<td>客户提供极柱,BF-0,210mm/275mm,手车式，755，38</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="754">
					754</td>
				<td>VBM4-12</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,BF-0-QY,275mm/275mm,手车式，754，20</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="753">
					753</td>
				<td>VBM4-12</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,BF-0,275mm/275mm,手车式，753，20</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="752">
					752</td>
				<td>VBM-12G</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,00-0,210mm/275mm,手车式，752，38</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="751">
					751</td>
				<td>VBM-12G</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,00-0,210mm/275mm,手车式，751，38</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="750">
					750</td>
				<td>VBM4-12</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,00-0,210mm/275mm,手车式，750，20</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="749">
					749</td>
				<td>VDS4-12</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,BF-0,210mm/275mm,手车式，749，31</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="748">
					748</td>
				<td>VDS4-12</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,BF-0,210mm/275mm,手车式，748，31</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="747">
					747</td>
				<td>VBM4-12</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,BF-2(5),210mm/275mm,手车式，747，20</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="746">
					746</td>
				<td>JT5-150</td>
				<td>阿斯博/中压元器件</td>
				<td>无,BF-0,150mm/275mm,手车式，746，45</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="745">
					745</td>
				<td>VBM5-12</td>
				<td>明及/中压元器件</td>
				<td>客户提供极柱,B0-0,210mm/205mm,手车式，745，22</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="744">
					744</td>
				<td>VBM1-12</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,BF-2(2.5),210mm/275mm,手车式，744，29</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="743">
					743</td>
				<td>JT5-210</td>
				<td>阿斯博/中压元器件</td>
				<td>无,BF-3(5),210mm/205mm,手车式，743，16</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="742">
					742</td>
				<td>VBM-12T</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,B0-0,210mm/275mm,固定式，742，18</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="741">
					741</td>
				<td>隔离车-24KV</td>
				<td>阿斯博/中压元器件</td>
				<td>无,B0-0,275mm/310mm,---，741，44</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="740">
					740</td>
				<td>VBM-12G</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,0F-0,275mm/310mm,手车式  带程序锁，740，38</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="739">
					739</td>
				<td>VBM-12G</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,0F-0,275mm/310mm,手车式，739，38</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="738">
					738</td>
				<td>VBM-12G</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,0F-0,210mm/275mm,手车式，738，38</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="737">
					737</td>
				<td>VBM5-12</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,BF-0,210mm/275mm,手车式，737，22</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="736">
					736</td>
				<td>VBM9-40.5</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,0F-0,300mm/400mm,手车式，736，25</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="735">
					735</td>
				<td>VBM1-12</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,BF-0-Y0,210mm/275mm,手车式，735，29</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="734">
					734</td>
				<td>VBM Pro7A-12</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,00-0-QY,210mm/275mm,固定式，734，4</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="733">
					733</td>
				<td>GNM-12隔离开关操作机构</td>
				<td>明及/中压元器件</td>
				<td>无,---,210mm/275mm,---，733，37</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="732">
					732</td>
				<td>JN15-12接地开关</td>
				<td>阿斯博/中压元器件</td>
				<td>无,---,210mm/275mm,---，732，43</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="731">
					731</td>
				<td>GNM-12上隔离开关</td>
				<td>明及/中压元器件</td>
				<td>无,---,210mm/275mm,---，731，35</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="730">
					730</td>
				<td>GNM-12上隔离开关</td>
				<td>明及/中压元器件</td>
				<td>无,---,210mm/275mm,---，730，35</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="729">
					729</td>
				<td>VBM-12T</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,B0-0,210mm/275mm,手车式，729，18</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="728">
					728</td>
				<td>VBM Pro5-12</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,0F-0,275mm/310mm,手车式，728，3</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="727">
					727</td>
				<td>VBM-12T</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,BF-0-QY,210mm/275mm,手车式，727，18</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="726">
					726</td>
				<td>VBM8-40.5</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,00-0,400mm/400mm,固定式，726，33</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="725">
					725</td>
				<td>VBM5-12</td>
				<td>明及/中压元器件</td>
				<td>客户提供极柱,BF-0-Y0,275mm/310mm,手车式，725，22</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="724">
					724</td>
				<td>VBM Pro4-12</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,0F-0,210mm/275mm,固定式，724，2</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="723">
					723</td>
				<td>JT4-210</td>
				<td>阿斯博/中压元器件</td>
				<td>无,BF-0,210mm/275mm,固定式，723，15</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="722">
					722</td>
				<td>VBM-12T</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,0F-0,210mm/275mm,手车式  带程序锁，722，18</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="721">
					721</td>
				<td>VBM-12T</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,0F-2(5),210mm/275mm,手车式，721，18</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="720">
					720</td>
				<td>VBM5-12</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,BF-0,210mm/275mm,手车式，720，22</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="719">
					719</td>
				<td>JT4-210</td>
				<td>阿斯博/中压元器件</td>
				<td>无,B0-0,210mm/275mm,手车式，719，15</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="718">
					718</td>
				<td>VBM-12G</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,0F-0,210mm/275mm,手车式，718，38</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="717">
					717</td>
				<td>VBM-12G</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,0F-0,210mm/275mm,手车式，717，38</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="716">
					716</td>
				<td>VBM-12C</td>
				<td>明及/中压元器件</td>
				<td>固封极柱,0F-0,210mm/275mm,固定式，716，32</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="715">
					715</td>
				<td>VBM4-12</td>
				<td>明及/中压元器件</td>
				<td>陶瓷灭弧室,BF-2(2.5),210mm/275mm,固定式，715，20</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="714">
					714</td>
				<td>VBM-12T</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,00-0,210mm/275mm,手车式，714，18</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="713">
					713</td>
				<td>VBM10A-24</td>
				<td>阿斯博/中压元器件</td>
				<td>客户提供极柱,B0-0,275mm/310mm,手车式，713，10</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="712">
					712</td>
				<td>VBM10A-24</td>
				<td>阿斯博/中压元器件</td>
				<td>客户提供极柱,B0-0,275mm/310mm,手车式，712，10</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="711">
					711</td>
				<td>VBM-12T</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,B0-2(5),210mm/275mm,手车式，711，18</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="710">
					710</td>
				<td>VBM-12T</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,00-2(5),210mm/275mm,手车式，710，18</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
						<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="709">
					709</td>
				<td>VBM-12T</td>
				<td>阿斯博/中压元器件</td>
				<td>陶瓷灭弧室,00-2(5),210mm/275mm,手车式，709，18</td>
				<td>15000.00</td>
				<td>8800.00</td>
				<td></td>
				<td>台</td>
			</tr>
			
		</tbody>
	</table>
	<div class="uk-margin uk-margin-bottom"><div class="pagination"><div class="page-floatR"><span class="page-start right0"><span>上一页</span></span><span class="page-cur right0">1</span><a class="right0" href="http://www.eps.com/ess/user.php?act=user_product&user_id=6&page=2">2</a><a class="right0" href="http://www.eps.com/ess/user.php?act=user_product&user_id=6&page=3">3</a><a class="right0" href="http://www.eps.com/ess/user.php?act=user_product&user_id=6&page=4">4</a><span class="page-break right0">...</span><a class="right0" href="http://www.eps.com/ess/user.php?act=user_product&user_id=6&page=14">14</a><a class="right0" href="http://www.eps.com/ess/user.php?act=user_product&user_id=6&page=15">15</a><a class="right0" href="http://www.eps.com/ess/user.php?act=user_product&user_id=6&page=16">16</a><a href="http://www.eps.com/ess/user.php?act=user_product&user_id=6&page=2" class="page-next right0"><span>下一页</span></a></div></div></div>
	</div>
</body>
</html><?php }
}
