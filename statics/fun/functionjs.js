$(function(){  
/*
上传发票附件
*/
	$('#invoice').uploadify({
		'auto'     : true,//关闭自动上传
		'removeTimeout' : 1,//文件队列上传完成1秒后删除
		'swf'      : '/Public/js_uploadify/uploadify.swf',
		'uploader' : : '{:U("Device/ajax_upload",array("session_id"=>session_id()))}',
		'method'   : 'post',//方法，服务端可以用$_POST数组获取数据
		'buttonText' : '+',//设置按钮文本
		"height"          : 80,
		 "width"           : 20,
		'multi'    : false,//允许同时上传多张图片
		'uploadLimit' : 20,//一次最多只允许上传1张图片
		'fileTypeDesc' : 'Image Files',//只允许上传图像
		'fileTypeExts' : '*.gif; *.jpg;*.png;',//限制允许上传的图片后缀
		'fileSizeLimit' : 3*1024,//限制上传的图片不得超过3000K
		'onUploadSuccess':function(file,data,response){
			if(data=='-1'){
				var txt=  "图片上传失败！";
			   alert(txt);
			}else{
			$("#license").val(data);
			$('#yycodeimg').html('');
			var  htmlimg="<img  src='"+data+"'   >"; 
			$('#yycodeimg').html(htmlimg);
			}
			
		}
	});
    
});
