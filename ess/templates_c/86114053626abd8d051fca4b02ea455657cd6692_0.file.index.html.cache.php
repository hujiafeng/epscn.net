<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:42:02
  from "E:\www\eps\ess\templates\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0ca4a857f04_61033734',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '86114053626abd8d051fca4b02ea455657cd6692' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\index.html',
      1 => 1505803958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:top.html' => 1,
    'file:header.html' => 1,
  ),
),false)) {
function content_59c0ca4a857f04_61033734 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '823459c0ca4a6ae287_52187163';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>产品-电气销售家</title>
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<link rel="stylesheet" href="css/page.css" />
<?php echo '<script'; ?>
 src="jquery/jquery-1.7.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="uikit/js/uikit.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="uikit/js/uikit-icons.min.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" type="text/css"
	href="jquery/autocomplete/jquery.autocomplete.css" />
<?php echo '<script'; ?>
 type="text/javascript"
	src="jquery/autocomplete/jquery.autocomplete.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>


</head>
<body>
	<?php $_smarty_tpl->_subTemplateRender("file:top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<div class="uk-container">
		<?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<div>
			<form action="product.php" method="get" id="search_form">
				<div class="uk-inline">
					<span class="uk-form-icon" uk-icon="icon: search"></span> <input
						class="uk-input" type="text" placeholder="产品ID、规格..." name="kw"
						value="<?php echo $_smarty_tpl->tpl_vars['kw']->value;?>
" style="width: 400px;" id="kw">
				</div>
				<div uk-form-custom="target: > * > span:first">
					<select id="brand" name="brand">
						<option value="">品牌</option> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['brand']->value, 'brand_temp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['brand_temp']->value) {
?> <?php if ($_smarty_tpl->tpl_vars['brand_id']->value == $_smarty_tpl->tpl_vars['brand_temp']->value['brand_id']) {?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['brand_temp']->value['brand_id'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['brand_temp']->value['name'];?>
</option>
						<?php } else { ?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['brand_temp']->value['brand_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['brand_temp']->value['name'];?>
</option>
						<?php }?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</select>
					<button class="uk-button uk-button-default" type="button"
						tabindex="-1">
						<span></span> <span uk-icon="icon: chevron-down"></span>
					</button>
				</div>

				<div uk-form-custom="target: > * > span:first">
					<select id="category" name="category">
						<option value="">品类</option> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category']->value, 'category_temp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category_temp']->value) {
?> <?php if ($_smarty_tpl->tpl_vars['category_id']->value == $_smarty_tpl->tpl_vars['category_temp']->value['cid']) {?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['category_temp']->value['cid'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['category_temp']->value['name'];?>
</option>
						<?php } else { ?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['category_temp']->value['cid'];?>
"><?php echo $_smarty_tpl->tpl_vars['category_temp']->value['name'];?>
</option>
						<?php }?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</select>
					<button class="uk-button uk-button-default" type="button"
						tabindex="-1">
						<span></span> <span uk-icon="icon: chevron-down"></span>
					</button>
				</div>

				<div uk-form-custom="target: > * > span:first">
					<select id="model" name="model">
						<option value="">款型</option> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['model']->value, 'model_temp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['model_temp']->value) {
?> <?php if ($_smarty_tpl->tpl_vars['model_id']->value == $_smarty_tpl->tpl_vars['model_temp']->value['model_id']) {?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['model_temp']->value['model_id'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['model_temp']->value['name'];?>
</option>
						<?php } else { ?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['model_temp']->value['model_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['model_temp']->value['name'];?>
</option>
						<?php }?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

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
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'temp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['temp']->value) {
?>

				<tr class="uk-text-small">
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['product_id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['model_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['brand_name'];?>
 / <?php echo $_smarty_tpl->tpl_vars['temp']->value['category_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['specification'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['market_price'];?>
 / <?php echo $_smarty_tpl->tpl_vars['temp']->value['measure_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['min_price'];?>
 / <?php echo $_smarty_tpl->tpl_vars['temp']->value['measure_name'];?>
</td>
					<td><a href="#modal-center"
						class="uk-text-small uk-text-primary"
						id="edit_pro_<?php echo $_smarty_tpl->tpl_vars['temp']->value['product_id'];?>
" uk-toggle>修改</a> &nbsp;&nbsp; <a
						href="javascript:del('<?php echo $_smarty_tpl->tpl_vars['temp']->value['product_id'];?>
')"
						class="uk-text-small uk-text-primary">删除</a></td>
				</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</tbody>
		</table>
		<div class="uk-margin uk-margin-bottom"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</div>
	</div>
</body>
</html><?php }
}
