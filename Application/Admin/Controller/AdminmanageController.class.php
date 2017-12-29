<?php

namespace Admin\Controller;
use Appframe\AdminbaseController;
class AdminmanageController extends AdminbaseController{
    
    /**
     * 修改当前登陆状态下的用户个人信息
     */
    public function myinfo(){
        if($this->isPost()){
            $User = D("fxuser");
            $data = $User->create();
            //判断是否修改的是否本人
            if($data['username'] != $this->Cache['User']['username']){
                $this->error("只能修改本人！");
            }
            if($data){
				$data['linktel'] = $_POST['linktel'];
                //过滤数据，防止自己修改自己信息给自己提权，比如，角色提升
                $noq = array("password","last_login_time","last_login_ip","login_count","role_id","verify");
                foreach ($noq as $key => $value) {
                        unset ($data[$value]);
                }
                if($User->save($data)){
                    $this->assign("jumpUrl", U("Adminmanage/myinfo"));
                    $this->success("资料修改成功！");
                }else{
                    $this->error("更新失败！");
                }
            }else{
                $this->error($User->getError());
            }
        }else{
			
            $data = M("fxuser")->where(array("id"=>$this->Cache['uid']))->find();
		
            $this->assign("data",$data);
            $this->display();
        }
    }
    
    /**
     * 后台登陆状态下修改当前登陆人密码
     */
    public function chanpass(){
        $pass = $this->_post("new_password");
        $username = $this->Cache['User']['username'];
        $userid = $this->Cache['uid'];
        if(empty($pass)){
            $this->display();
        }else{
            if($this->_post("password")==""){
                $this->error("请输入旧密码！");
            }
            //检验原密码是否正确
            $user = service("Passport")->getLocalUser($username,$this->_post("password"));
            if($user==false){
                $this->error("旧密码输入错误！");
            }
            if($pass!=$this->_post("new_pwdconfirm")){
                $this->error("两次密码不相同！");
            }
            $up = D("fxuser")->ChangePassword($userid,$pass);
            if($up){
                $this->assign("jumpUrl", U("Admin/Public/login"));
                //退出登陆
                service("Passport")->logoutLocal();
                $this->success("密码已经更新！");
            }else{
                $this->error("密码更新失败！");
            }
        }
    }
    
    /**
     * 验证密码是否正确
     */
    public function public_verifypass(){
        $pass = $this->_get("password");
        $username = $this->Cache['User']['username'];
        if(empty($pass)){
            $this->error("密码不能为空！");
        }
        $user = service("Passport")->getLocalUser($username,$pass);
        if($user!=false){
            $this->success("密码正确！");
        }else{
            $this->error("密码错误！");
        }
    }
}
?>
