<?php
 namespace Home\Controller;
use Appframe\BaseController;

class IndexController extends BaseController {
	 function _initialize() {
        parent::_initialize();

    }
    function index() {
		$this->display ();
	}
	
	function s(){

	}
 function uploadImg() {
 $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      'uploads/'; // 设置附件上传根目录
        $upload->autoSub = true;
        $upload->subName = array('date','Y/m');

        $info=$upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getErrorMsg());
        }else{// 上传成功 获取上传文件信息
            foreach($info as $file){
                 print_r('/uploads/'.$file['savepath'].$file['savename']);
            }
        }
    }

	function del() {
		$src=str_replace(__ROOT__.'/', '', str_replace('//', '/', $_GET['src']));
		if (file_exists($src)){
			unlink($src);
		}
		print_r($_GET['src']);
		exit();
	}
}