<?php
/* Smarty version 3.1.30, created on 2017-09-07 16:39:35
  from "/www/mecan.net/ess/templates/project.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b105c7266728_17763674',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f9f784ac172da83992cba0c7b66ad49caa3984b8' => 
    array (
      0 => '/www/mecan.net/ess/templates/project.html',
      1 => 1504677998,
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
function content_59b105c7266728_17763674 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>项目-电气销售家</title>
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<link rel="stylesheet" href="css/page.css" />
<script src="jquery/jquery-1.7.2.min.js"></script>
<script src="uikit/js/uikit.min.js"></script>
<script src="uikit/js/uikit-icons.min.js"></script>
<style type="text/css">
</style>
<script>
	function search_project(o_status) {
		$("input[name='o_status']").val(o_status);
		$("form[name='schForm']").submit();
	}
	$(
			function() {
				$("[id^='check_project_']").click(
						function() {
							$("#project_id").val('0');
							$("input[name='refuse_reason']").val('');
							$("input[name='project_status']:eq(0)").attr(
									"checked", 'checked');
							var _data = $(this).attr('id');
							var project_id = _data.split("_")[2];
							$("#project_id").val(project_id);

						});

				$("#save_check")
						.click(
								function() {
									var project_status = $(
											"input[name='project_status']:checked")
											.val();
									var refuse_reason = $(
											"input[name='refuse_reason']")
											.val();
									var project_id = $("#project_id").val();
									if (project_status == 'REFUSED'
											&& refuse_reason.length == 0) {
										alert("请注明不通过的理由！");
									} else {
										$.post('project.php', {
											act : 'check',
											project_id : project_id,
											project_status : project_status,
											refuse_reason : refuse_reason
										}, function(data) {
											//alert(data);
											if (data == 1)
												setTimeout(function() {
													window.location.reload();
												}, 500);
											else
												alert("审核失败！");
										});
									}

								});

				$("[id^='view_detail_']").click(function() {
					var _data = $(this).attr('id');
					var project_id = _data.split("_")[2];
					$.post('project.php', {
						act : 'detail',
						project_id : project_id
					}, function(data) {
						$("#detail_table").html(data);
					});
				});
			})
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

				<li class="uk-active"><a href="project.php"><span
				class="ft18">项目申报</span>  <span
				class="uk-badge cnt">17</span> </a></li>  		<li><a href="product.php"><span class="ft18">产品</span></a></li>
				<li><a href="user.php"><span class="ft18">用户</span></a></li> 				<li><a href="feedback.php"><span class="ft18">用户反馈</span></a></li>
		
	</ul>
</div>
		<form class="uk-search uk-search-default" name="schForm"
			style="width: 400px;">
			<span uk-search-icon></span> <input
				class="uk-search-input uk-text-small" type="search"
				placeholder="项目名称、编号..." name="kw" value=""
				style="width: 400px;"> <input type="hidden" name="o_status"
				value='ALL' />
		</form>

		 		<button class="uk-button uk-button-default"
			onClick="search_project('ALL')">所有</button>
		  		<button class="uk-button uk-button-primary"
			onClick="search_project('DRAFT')">草稿</button>
		  		<button class="uk-button uk-button-default"
			onClick="search_project('PENDING')">待审核</button>
		  		<button class="uk-button uk-button-default"
			onClick="search_project('TRACKING')">跟踪中</button>
		  		<button class="uk-button uk-button-default"
			onClick="search_project('REFUSED')">审核不通过</button>
		  		<button class="uk-button uk-button-default"
			onClick="search_project('DONE')">完成</button>
		 

		<table class="uk-table uk-table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>项目编号、名称</th>
					<th>采购方</th>
					<th>项目状态</th>
					<th>申报人</th>
					<th>审核人</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
								<tr class="uk-text-small">
					<td>70</td>
					<td>P17090413561111<br />测试的项目0903-5
					</td>
					<td>厦门阿莫西林电气自动化</td>
					<td style="color:#CC0000">草稿</td>
					<td>安卓测试0904<br/>2017-09-04 13:56:20</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_70">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>65</td>
					<td>P17090410226359<br />测试180904
					</td>
					<td>常州风采电器公司</td>
					<td style="color:#CC0000">草稿</td>
					<td>flowers<br/>2017-09-04 10:22:18</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_65">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>60</td>
					<td>P17082816347463<br />项目082803
					</td>
					<td>保密</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-28 16:34:09</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_60">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>58</td>
					<td>P17082816305057<br />项目082801
					</td>
					<td>湖南电器</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-28 16:30:22</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_58">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>50</td>
					<td>P17082413370319<br />项目355000
					</td>
					<td>就不告诉你</td>
					<td style="color:#CC0000">草稿</td>
					<td>飞天狗狗的奇特之旅<br/>2017-08-24 13:37:11</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_50">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>48</td>
					<td>P17082409361919<br />方好怀念那年
					</td>
					<td>法国绘画好纠结</td>
					<td style="color:#CC0000">草稿</td>
					<td>飞天狗狗的奇特之旅<br/>2017-08-24 09:36:54</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_48">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>44</td>
					<td>P17082314499078<br />项目1222222
					</td>
					<td>暂时保密</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-23 14:49:59</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_44">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>42</td>
					<td>P17082309588896<br />项目20008
					</td>
					<td>北京化工一厂</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-23 09:58:45</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_42">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>41</td>
					<td>P17082309457145<br />沈阳造船厂车间改造
					</td>
					<td>沈阳造船厂</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-23 09:45:23</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_41">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>39</td>
					<td>P17082216207004<br />项目300001
					</td>
					<td>三一重工</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-22 16:20:21</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_39">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>38</td>
					<td>P17082216202737<br />项目30002
					</td>
					<td>徐州重工</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-22 16:20:19</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_38">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>20</td>
					<td>P17082116426395<br />新建项目200002
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_20">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>21</td>
					<td>P17082116426396<br />新建项目200002A
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_21">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>22</td>
					<td>P17082116426397<br />新建项目200002B
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_22">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>23</td>
					<td>P17082116426398<br />新建项目200002C
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_23">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>24</td>
					<td>P17082116426399<br />新建项目200002D
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_24">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>25</td>
					<td>P17082116426310<br />新建项目200002E
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_25">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>26</td>
					<td>P17082116426311<br />新建项目200002F
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_26">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>27</td>
					<td>P17082116426312<br />新建项目200002G
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_27">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>28</td>
					<td>P17082116426313<br />新建项目200002H
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_28">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>29</td>
					<td>P17082116426314<br />新建项目200002I
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_29">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>30</td>
					<td>P17082116426315<br />新建项目200002J
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_30">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>31</td>
					<td>P17082116426316<br />新建项目200002K
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_31">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>32</td>
					<td>P17082116426317<br />新建项目200002L
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_32">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>33</td>
					<td>P17082116426318<br />新建项目200002M
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_33">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>34</td>
					<td>P17082116426319<br />新建项目200002N
					</td>
					<td>这里是采购方280002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 16:42:42</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_34">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>19</td>
					<td>P17082112429832<br />我的项目申报20005
					</td>
					<td>我的采购方000002</td>
					<td style="color:#CC0000">草稿</td>
					<td>系统管理员<br/>2017-08-21 13:01:27</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_19">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>16</td>
					<td>P17082112429829<br />我的项目申报20002
					</td>
					<td>我的采购方000002</td>
					<td style="color:#CC0000">草稿</td>
					<td>系统管理员<br/>2017-08-21 13:01:07</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_16">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>15</td>
					<td>P17082112429828<br />我的项目申报20001
					</td>
					<td>我的采购方000002</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 12:42:46</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_15">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>14</td>
					<td>P17082112354602<br />我的项目000018
					</td>
					<td>项目采购方000018</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-21 12:35:03</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_14">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>13</td>
					<td>P17081814194644<br />我的项目申报
					</td>
					<td>美国微软公司</td>
					<td style="color:#CC0000">草稿</td>
					<td>系统管理员<br/>2017-08-18 14:19:49</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_13">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
								<tr class="uk-text-small">
					<td>3</td>
					<td>P17081516095983<br />我的项目申报0002
					</td>
					<td>地方地方的</td>
					<td style="color:#CC0000">草稿</td>
					<td>柯南你就是个死神<br/>2017-08-15 16:09:56</td>
					<td><br/></td>
					<td><a href="#modal-detail"
						class="uk-text-small uk-text-primary" uk-toggle
						id="view_detail_3">详情</a>&nbsp;&nbsp;  
						</td>
				</tr>
				
			</tbody>
		</table>

		<div class="uk-margin uk-margin-bottom">&nbsp;</div>
		<!-- 详情 -->
		<div id="modal-detail" uk-modal>
			<div class="uk-modal-dialog">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<div class="uk-modal-header">
					<h2>项目详情</h2>
				</div>
				<div class="uk-modal-body" uk-overflow-auto>
					<table class="uk-text-small" style="line-height: 35px;">
						<col width="80" />
						<col width="220" />
						<col width="80" />
						<col width="220" />
						<tbody id="detail_table">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- 审核 -->
	<div id="modal-center" class="uk-flex-top" uk-modal>
		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
			<form class="uk-form-horizontal uk-margin-large">
				<input type="hidden" id="project_id" value='0'>
				<div class="uk-margin">
					<div class="uk-form-label">项目审核：</div>
					<div class="uk-form-controls">
						<p>
							<input class="uk-radio" type="radio" name="project_status"
								checked value="TRACKING"> <span class="uk-text-small">通过</span>
						</p>
						<label><input class="uk-radio" type="radio"
							name="project_status" value="REFUSED"> <span
							class="uk-text-small">不通过</span></label>
						<p class="uk-margin-small">
							<input class="uk-input uk-form-width-larger uk-form-small"
								type="text" placeholder="不通过的理由..." name="refuse_reason" />
						</p>
					</div>
				</div>
				<p class="uk-text-right">
					<button class="uk-button uk-button-default uk-modal-close"
						type="button">取消</button>
					<button class="uk-button uk-button-primary" type="button"
						id="save_check">确定</button>
				</p>
			</form>
		</div>
	</div>
	</div>


</body>
</html><?php }
}
