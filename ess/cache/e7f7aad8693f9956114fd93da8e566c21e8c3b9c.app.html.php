<?php
/* Smarty version 3.1.30, created on 2017-09-18 13:26:05
  from "/www/mecan.net/ess/templates/app.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59bf58ed3a8ca0_39954005',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6c607c96dda990965a27fcdcad57ff637bb6f034' => 
    array (
      0 => '/www/mecan.net/ess/templates/app.html',
      1 => 1504605143,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 0,
),true)) {
function content_59bf58ed3a8ca0_39954005 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>电气销售家-下载</title>
<meta name="viewport"
	content="width=device-width, initial-scale=0.5, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<link rel="stylesheet" href="css/common.css" />
<script src="jquery/jquery-1.7.2.min.js"></script>
<script src="uikit/js/uikit.min.js"></script>
<script>
	function adjust() {
		var width = $(".video").width();
		var height = width * 0.56;
		//alert(width);
		//alert(height);
		$(".video").height(height);
		$("#video").height(height);
		$("#video").width(width);
		//alert($(".video").offset().top);
		var h = $(".video").offset().top + height * 0.5;
		$(".uk-position-center").css("top", h);
	}
	window.onload = function() {
		window.onresize = adjust;
		adjust();
	}

	$(function() {
		$("#apple_d").hover(function() {
			$(this).attr("src", "img/ic-apple-hover.png");
		}, function() {
			$(this).attr("src", "img/ic-apple-normal.png");
		});

		$("#android_d").hover(function() {
			$(this).attr("src", "img/ic-android-hover.png");
		}, function() {
			$(this).attr("src", "img/ic-android-normal.png");
		});

		/*var videoEl = document.getElementById('video');
		var playEl = document.getElementById('playBtn');

		videoEl.addEventListener('pause', function() {
			if (videoEl.paused) {
				playEl.style.display = 'inline-block';
				videoEl.controls = false;
			}
		})
		videoEl.addEventListener('playing', function() {
			videoEl.controls = true;
		})*/
		$('#video').click(function() {
			if ($(this).hasClass('pause')) {
				$("#video").trigger("play");
				$("#playBtn").hide();
				$(this).removeClass('pause');
				$(this).addClass('play');
			} else {
				$("#video").trigger("pause");
				$("#playBtn").show();
				$(this).removeClass('play');
				$(this).addClass('pause');
			}
		})
	});

	function onPlayClick() {
		/*var videoEl = document.getElementById('video');
		var playEl = document.getElementById('playBtn');
		videoEl.play();
		playEl.style.display = 'none';*/
		if ($('#video').hasClass('pause')) {
			$("#video").trigger("play");
			$("#playBtn").hide();
			$('#video').removeClass('pause');
			$('#video').addClass('play');
		} else {
			$("#video").trigger("pause");
			$("#playBtn").show();
			$('#video').removeClass('play');
			$('#video').addClass('pause');
		}
	}
</script>
<style type="text/css">
body {
	
	font-family: 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei',
		sans-serif;
}

.part {
	background-image: linear-gradient(to top, #2196f3, #03a9f4);
	padding: 30px;
}

.video {
	padding-bottom: 75px;
	width: 95%;
	min-width: 480px;
	min-width: 270px;
	margin: 0 auto;
	text-align: center;
	max-width: 960px;
	min-width: 480px;
	margin: 0 auto;
}

.title {
	text-align: center;
	margin-top: 35px;
	margin-right: 186px;
}

.title img {
	min-width: 350px;
	min-height: 57px;
}

.download_div {
	width: 60%;
	min-width: 609px;
	margin: 0 auto;
}

.center {
	text-align: center;
}

.download {
	cursor: pointer;
	text-align: center;
}

.download_div img {
	min-width: 25%;
	max-height: 23%;
}

.uk-column-1-3 {
	-webkit-column-gap: 0px;
	-moz-column-gap: 0px;
	column-gap: 0px;
}

.line {
	height: 1px;
	background: #E0E3E3;
}

.ft14 {
	font-size: 14px;
	color: #333;
}

#playBtn {
	cursor: pointer;
}

#video{
background:#BABABA;}
img{
-webkit-tap-highlight-color:transparent;
-moz-tap-highlight-color:transparent;
-ms-tap-highlight-color:transparent;
-o-tap-highlight-color:transparent
}
</style>
</head>
<body>
	<div class="part uk-margin-bottom">
		<img src="img/logo.png" width="186" height="64" class="uk-align-left" />
		<p class="title">
			<img src="img/title.png" width="526" height="86" />
		</p>
		<div class="video">
			<video id="video" src="img/intro.mp4" poster=""
				controlsList="nodownload" class="pause"></video>
			<div class="uk-overlay uk-position-center" id="playBtn"
				onclick="onPlayClick()">
				<img src="img/ic_play.png" width="106" height="106" />
			</div>
			<!--  <embed src="img/intro.mp4" class="video">-->

		</div>
	</div>
	<div class="uk-container uk-margin-medium " style="clear: both;">
		<div class="uk-margin-medium-bottom center">
			<img src="img/subtitle.png" width="360" height="130" />
		</div>

		<div
			class=" uk-margin uk-column-1-3 uk-column-1-3 uk-column-1-3   uk-margin-xlarge-bottom download download_div">
			<p>
				<a href="http://www.mecan.net/ess/app/" target="_blank"> <img
					src="img/ic-apple-normal.png" id="apple_d" width="240" height="118" />
				</a>
			</p>
			<p>
				<img src="img/ic-qrcode-normal.png" id="code_d" width="240"
					height="118" />
			</p>
			<p>
			<a href="http://www.mecan.net/ess/Android_app/Ess.apk" target="_blank">
				<img src="img/ic-android-normal.png" id="android_d" width="240"
					height="118" /></a>
			</p>
		</div>
		<div class="uk-margin uk-margin-bottom">
			<p class="line"></p>
			<p class="center uk-margin uk-margin-bottom ft14">@电气销售家</p>
		</div>
	</div>

</body>
</html><?php }
}
