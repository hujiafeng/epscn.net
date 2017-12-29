<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh_CN" style="overflow: hidden;">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="renderer" content="webkit">
<meta charset="utf-8">
<title>管理系统</title>
<link href="/statics/simpleboot/themes/flat/theme.min.css" rel="stylesheet">
<link href="/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
<link href="/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
<!--[if IE 7]>
	<link rel="stylesheet" href="/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
<![endif]-->
<link rel="stylesheet" href="/statics/simpleboot/themes/flat/simplebootadminindex.min.css?">
<!--[if lte IE 8]>
	<link rel="stylesheet" href="/statics/simpleboot/css/simplebootadminindex-ie.css?" />
<![endif]-->
<style>
.navbar .nav_shortcuts .btn{margin-top: 5px;}

/*-----------------导航hack--------------------*/
.nav-list>li.open{position: relative;}
.nav-list>li.open .back {display: none;}
.nav-list>li.open .normal {display: inline-block !important;}
.nav-list>li.open a {padding-left: 7px;}
.nav-list>li .submenu>li>a {background: #fff;}
.nav-list>li .submenu>li a>[class*="fa-"]:first-child{left:20px;}
.nav-list>li ul.submenu ul.submenu>li a>[class*="fa-"]:first-child{left:30px;}
/*----------------导航hack--------------------*/
</style>


<script>
//全局变量
var GV = {
	HOST:"<?php echo ($_SERVER['HTTP_HOST']); ?>",
    DIMAUB: "/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<?php function getsubmenu($submenus){ $i=0; ?>
<?php foreach($submenus as $menu){ if($i==0)$menu[icon]='cogs'; if($i==1)$menu[icon]='group'; if($i==2)$menu[icon]='list'; if($i==3)$menu[icon]='cloud'; if($i==4)$menu[icon]='th'; if($i==5)$menu[icon]='star'; if($i==6)$menu[icon]='gear'; if($i==7)$menu[icon]='inbox'; if($i==8)$menu[icon]='flag'; if($i==9)$menu[icon]='tag'; if($i==10)$menu[icon]='book'; if($i==11)$menu[icon]='leaf'; if($i==12)$menu[icon]='plane'; if($i==13)$menu[icon]='random'; if($i==14)$menu[icon]='retweet'; if($i>=15)$menu[icon]='gift'; $i++; ?>
					<li>
						<?php if(empty($menu[lower])){ ?>
							<a href="javascript:openapp('/<?php echo ($menu["app"]); ?>/<?php echo ($menu["model"]); ?>/<?php echo ($menu["action"]); ?>','<?php echo ($menu["id"]); ?>','<?php echo ($menu["name"]); ?>');">
								<i class="fa fa-<?php echo ((isset($menu["icon"]) && ($menu["icon"] !== ""))?($menu["icon"]):'desktop'); ?>"></i>
								<span class="menu-text"><?php echo ($menu["name"]); ?></span>
							</a>
						<?php }else{ ?>
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-<?php echo ((isset($menu["icon"]) && ($menu["icon"] !== ""))?($menu["icon"]):'desktop'); ?> normal"></i>
								<span class="menu-text normal"><?php echo ($menu["name"]); ?></span>
								<b class="arrow fa fa-angle-right normal"></b>
								<i class="fa fa-reply back"></i>
								<span class="menu-text back">返回</span>
								
							</a>
							
							<ul  class="submenu">
									<?php getsubmenu1($menu[lower]) ?>
							</ul>	
						<?php } ?>
						
					</li>
					
				<?php } ?>
<?php } ?>

<?php function getsubmenu1($submenus){ ?>
<?php foreach($submenus as $menu){ ?>
					<li>
						<?php if(empty($menu[lower])){ ?>
							<a href="javascript:openapp('/<?php echo ($menu["app"]); ?>/<?php echo ($menu["model"]); ?>/<?php echo ($menu["action"]); ?>','<?php echo ($menu["id"]); ?>','<?php echo ($menu["name"]); ?>');">
								<i class="fa fa-caret-right"></i>
								<span class="menu-text"><?php echo ($menu["name"]); ?></span>
							</a>
						<?php }else{ ?>
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-caret-right"></i>
								<span class="menu-text"><?php echo ($menu["name"]); ?></span>
								<b class="arrow fa fa-angle-right"></b>
							</a>
							<ul  class="submenu">
									<?php getsubmenu2($menu[lower]) ?>
							</ul>	
						<?php } ?>
						
					</li>
					
				<?php } ?>
<?php } ?>

<?php function getsubmenu2($submenus){ ?>
<?php foreach($submenus as $menu){ ?>
					<li>
						<a href="javascript:openapp('/<?php echo ($menu["app"]); ?>/<?php echo ($menu["model"]); ?>/<?php echo ($menu["action"]); ?>','<?php echo ($menu["id"]); ?>','<?php echo ($menu["name"]); ?>');">
								&nbsp;<i class="fa fa-angle-double-right"></i>
								<span class="menu-text"><?php echo ($menu["name"]); ?></span>
							</a>
					</li>
					
				<?php } ?>
<?php } ?>


<?php if(APP_DEBUG): ?><style>
#think_page_trace_open{left: 0 !important;
right: initial !important;}
.nav_shortcuts span{line-height:30px;}
.nav_shortcuts span a{text-decoration:none}
</style><?php endif; ?>

</head>

<body style="min-width:900px;" screen_capture_injected="true">
	<div id="loading"><i class="loadingicon"></i><span>正在加载...</span></div>
	<div id="right_tools_wrapper">
		<span id="right_tools_clearcache" title="清除缓存" onClick="javascript:openapp('<?php echo u('Admin/Index/public_deletecache');?>','right_tool_clearcache','清除缓存');"><i class="fa fa-trash-o right_tool_icon"></i></span>
		<span id="refresh_wrapper" title="刷新当前页" ><i class="fa fa-refresh right_tool_icon"></i></span>
		 

	</div>
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<div class="pull-left nav_shortcuts" >
					<span><a><img src="/statics/images/icon/logo-18.png">&nbsp;&nbsp;EPS—后台管理系统</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo U('Index/index');?>" style="cursor:pointer" title="后台首页">后台首页</a></span>
				</div>
				<ul class="nav simplewind-nav pull-right">
					<li class="light-blue">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="/statics/images/icon/logo-18.png" alt="<?php echo ($admin["user_login"]); ?>">
							<span class="user-info">
								<small>欢迎,</small><?php echo ((isset($admin["user_nicename"]) && ($admin["user_nicename"] !== ""))?($admin["user_nicename"]):$admin[user_login]); ?>
							</span>
							<i class="fa fa-caret-down"></i>
						</a>
						<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
							
							<li><a href="javascript:openapp('<?php echo u('Adminmanage/chanpass');?>','index_userinfo','个人资料');"><i class="fa fa-user"></i> 个人资料</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo U('Public/logout');?>"><i class="fa fa-sign-out"></i> 退出</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

</style>
	<div class="main-container container-fluid">

		<div class="sidebar" id="sidebar"  >
     
			<div id="nav_wraper" >
			<ul class="nav nav-list">
					<?php echo getsubmenu($menuGroupList);?>
			</ul>
			</div>
          

		
		</div>
       <style>
            
.cat-menu {
    margin: 10px 8px 0 0;
    width: 180px;
}
.col-1 {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #f4f6f5;
}
.lf {
    float: left;
}
            </style>
  
		<div class="main-content"  >
			<div class="breadcrumbs" id="breadcrumbs" >
            <div class="col-1 lf cat-menu" id="display_center_id" style=" width:160px; display:none;  ">
   
      <iframe name="center_frame" id="center_frame" src="" frameborder="false" scrolling="auto" style="border:none;height: 100%;" width="100%" height="auto" allowtransparency="true"></iframe>
 
  </div>
				<a id="task-pre" class="task-changebt">←</a>
				<div id="task-content">
				<ul class="macro-component-tab" id="task-content-inner">
					<li class="macro-component-tabitem noclose" app-id="0" app-url="<?php echo u('Main/public_main');?>" app-name="首页">
						<span class="macro-tabs-item-text">后台首页</span>
					</li>
				</ul>
				<div style="clear:both;"></div>
				</div>
				<a id="task-next" class="task-changebt">→</a>
			</div>
     
   
	<div class="page-content" id="content" style="position:relative; overflow:hidden">
          
				<iframe src="<?php echo U('Main/public_main');?>" style="width:100%;height: 100%;" frameborder="0"  class="appiframe" name="right" id="rightMain"></iframe>
			</div>
            
            
		</div>
	</div>
	
	<script src="/statics/js/jquery.js"></script>
	<script src="/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/st/css/dialog.css" />
<script type="text/javascript" src="/st/js/dialog.js"></script>
	<script>
	

	var b = $("#sidebar").hasClass("menu-min");
	var a = "ontouchend" in document;
	$(".nav-list").on(
			"click",
			function(g) {
				var f = $(g.target).closest("a");
				if (!f || f.length == 0) {
					return
				}
				if (!f.hasClass("dropdown-toggle")) {
					if (b && "click" == "tap"
							&& f.get(0).parentNode.parentNode == this) {
						var h = f.find(".menu-text").get(0);
						if (g.target != h && !$.contains(h, g.target)) {
							return false
						}
					}
					return
				}
				var d = f.next().get(0);
				if (!$(d).is(":visible")) {
					var c = $(d.parentNode).closest("ul");
					if (b && c.hasClass("nav-list")) {
						return
					}
					c.find("> .open > .submenu").each(
							function() {
								if (this != d
										&& !$(this.parentNode).hasClass(
												"active")) {
									$(this).slideUp(150).parent().removeClass(
											"open")
								}
							})
				} else {
				}
				if (b && $(d.parentNode.parentNode).hasClass("nav-list")) {
					return false;
				}
				$(d).slideToggle(150).parent().toggleClass("open");
				return false;
			});
	</script>
	<script src="/assets/js/index.js"></script>





</body>
</html>