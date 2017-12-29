<?php

 namespace Admin\Controller;
 use Appframe\AdminbaseController;
class PublicController extends AdminbaseController {

    //后台登陆界面
    public function login(){
		if(!isset($_SESSION['UserID']) || !isset($_SESSION['username']) || !$_SESSION['ShuiPanAdmin'] || !$_SESSION['roleid']){ 
             $this->display();
		}else{
			
			$this->redirect("Admin/Index/index");
			 //$this->success("您已经登录！",U("Admin/Index/index"));
		}
    }

    //后台登陆验证
    public function tologin() {
        $username = $this->_post("username");
        $password = $this->_post("password");
        $code = $this->_post("code");
		
        if(empty($username) || empty($password)){
            $this->error("用户名或者密码不能为空，请从新输入！",U("Public/login"));
        }
        if(empty($code)){
            $this->error("请输入验证码！",U("Public/login"));
        }
        //验证码开始验证
        if(!$this->verify($code)){
            $this->error("验证码错误，请重新输入！",U("Public/login"));
        }

        if(service("Passport")->loginAdmin($username,$password)){
			if($_SESSION['roleid']!=1 && !M('fxadmin_role_priv')->where(array("roleid"=>$_SESSION['roleid']))->find()){
                    service("Passport")->logoutLocal();
					$this->error("暂无任何权限，请联超级系管理员！",U("Admin/Public/login"));
			}
			$data = M("fxuser")->where(" username  = '$username' ")->limit(1)->find();
			cookie('admin',$username);
            $this->redirect("Admin/Index/index");
        }else{
            $this->error("用户名或者密码错误，登陆失败！",U("Public/login"));
        }
    }
    
    //退出登陆
    public function logout() {
        if(service("Passport")->logoutLocal()){
            $this->assign("jumpUrl", U("Admin/Public/login"));
            $this->success('登出成功！');
        }
        
    }
    
}

?>
