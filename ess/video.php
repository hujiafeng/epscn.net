
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.5,maximum-scale=0.5">
    <title>视频</title>
    <style>
        #wrap {position: relative; margin: 0 auto; width: 100%;}
        .videoW { width: 94%; margin: 20px auto;}
        .video { width: 100%;}
    </style>
    <script src="jquery/jquery-1.7.2.min.js"></script>
    <script>
        function changeVideoHeight(){
            var ww = $(window).width();
            var vh = parseInt(ww * 0.94 * 9 / 16);
            $(".video").css('height', vh);
        }
        $(function(){
            changeVideoHeight();
            $(window).bind('orientationchange', function(e){
                changeVideoHeight();
            });
        });
    </script>
</head>
<body>
<div id="wrap">
    <div class="videoW">
        <iframe class="video" src="img/intro.mp4" frameborder=0 allowfullscreen></iframe>
    </div>
</div>
</body>
</html>
