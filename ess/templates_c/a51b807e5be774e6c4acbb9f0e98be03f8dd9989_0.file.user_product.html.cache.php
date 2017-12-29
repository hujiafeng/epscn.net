<?php
/* Smarty version 3.1.30, created on 2017-09-19 15:46:40
  from "E:\www\eps\ess\templates\user_product.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c0cb600f1686_46652117',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a51b807e5be774e6c4acbb9f0e98be03f8dd9989' => 
    array (
      0 => 'E:\\www\\eps\\ess\\templates\\user_product.html',
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
function content_59c0cb600f1686_46652117 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '2701559c0cb5fea1509_81280958';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户产品配置-电气销售家</title>
<link rel="stylesheet" href="css/page.css" />
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<?php echo '<script'; ?>
 src="jquery/jquery-1.7.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="uikit/js/uikit.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="uikit/js/uikit-icons.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
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
		<form action="user.php" method="get" id="search_form">
		<input type="hidden" name="act" value="user_product"/>
		<input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
"/>
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
				<input type="hidden" id="user_id" value='<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
' /> <input
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
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'temp');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['temp']->value) {
?>
			<tr class="uk-text-small">
				<td><input class="uk-checkbox" type="checkbox"
					name="productIds" value="<?php echo $_smarty_tpl->tpl_vars['temp']->value['product_id'];?>
">
					<?php echo $_smarty_tpl->tpl_vars['temp']->value['product_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['model_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['brand_name'];?>
/<?php echo $_smarty_tpl->tpl_vars['temp']->value['category_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['specification'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['market_price'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['min_price'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['last_price'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['temp']->value['measure_name'];?>
</td>
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
