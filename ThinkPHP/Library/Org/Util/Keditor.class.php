<?php
/*
 * +---------------------------
 * kindeitor扩展类。
 * +---------------------------
 */
class Keditor{
	
	protected $config=array();
	protected $jsscript=array();
	public $form="form1";
	
		//获得后台编辑器编辑框
	 function create_admin_keditor($input_name)
     {
		  
		  $BasePath = '/Public/kindeditor/';
		  $phpwsd_keditor = "<link rel=\"stylesheet\" href=\"$BasePath/themes/default/default.css\" />
		  <link rel=\"stylesheet\" href=\"$BasePath/plugins/code/prettify.css\" />
		  <script charset=\"utf-8\" src=\"$BasePath/kindeditor.js\"></script>
		  <script charset=\"utf-8\" src=\"$BasePath/lang/zh_CN.js\"></script>
		  <script charset=\"utf-8\" src=\"$BasePath/plugins/code/prettify.js\"></script>
		  <script>
		  var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name=\"$input_name\"]', {
					allowFileManager : true
				});
			});
		  </script>";
		  return $phpwsd_keditor;
		  
    } 

	
	//获得前台编辑器编辑框
    function create_html_keditor($input_name)
    {
		  $BasePath = '/Public/kindeditor/';
		  $phpwsd_keditor = "<link rel=\"stylesheet\" href=\"$BasePath/themes/default/default.css\" />
		  <link rel=\"stylesheet\" href=\"$BasePath/plugins/code/prettify.css\" />
		  <script charset=\"utf-8\" src=\"$BasePath/kindeditor.js\"></script>
		  <script charset=\"utf-8\" src=\"$BasePath/lang/zh_CN.js\"></script>
		  <script charset=\"utf-8\" src=\"$BasePath/plugins/code/prettify.js\"></script>
		  <script>
		  var editor;			
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name=\"$input_name\"]]', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : true,
					items : ['source', '|', 'undo', 'redo', '|', 'template','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline','removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist','insertunorderedlist', '|', 'emoticons', 'image', 'multiimage', 'link', 'baidumap']
				});
			});

		  </script>";
		  return $phpwsd_keditor;
     }

		  

}