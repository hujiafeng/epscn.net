<?php

/**通行证服务 * Edit date：20120703
 * Author：旅行者
 */
class PassportService {
    
    /**
     * 检验用户是否已经登陆
     */
    public function isLogged(){
        if(session(C("USER_AUTH_KEY"))){
            return $this->isLoggedAdmin();
        }else  if ($uid = $this->getCookieUid()){
            return $uid;
        }else{
            return false;
        }
    }
    
    /**
     *根据提示符(username)和未加密的密码(密码为空时不参与验证)获取本地用户信息
     * @param type $identifier 为数字时，表示uid，其他为用户名
     * @param type $password 
     * @return 成功返回用户信息array()，否则返回布尔值false
     */
    public function getLocalUser($identifier, $password = null){
    	
        if(empty($identifier)){
            return false;
        }
        $map = array();
        $map['username'] = $identifier;
        $UserMode = D('Fxuser');
        $user = $UserMode->where($map)->find();
        
        if(!$user){
            return false;
        }elseif($password && $UserMode->encryption($identifier,$password,$user['verify'])!=$user['password']){
            return false;
        }else{
            //去除敏感信息
            unset($user['password']);
            unset($user['verify']);
            return $user;
        }
    }
    
    /**
     * 使用本地账号登陆 (密码为null时不参与验证)
     * @param type $identifier 用户标识，用户uid或者用户名
     * @param type $password 用户密码，未加密，如果为空，不参与验证
     * @param type $is_remember_me cookie有效期
     */
    public function loginLocal($identifier, $password = null,$is_remember_me = false){
        
    }
    
    /**
     * 注册用户的登陆状态 (即: 注册cookie + 注册session + 记录登陆信息)
     * @param array $user 用户相信信息
     * @param type $is_remeber_me 有效期
     * @return type 成功返回布尔值
     */
    public function registerLogin(array $user, $is_remeber_me = false){
        return true;
    }
    
    /**
     * 注销登陆
     */
    public function logoutLocal(){
        // 注销session
        session(null);
        // 注销cookie
        cookie(null); 
        return true;
    }
    
    /**
      获取cookie中记录的用户ID
     * @return type 成功返回用户ID，失败返回false
     */
    public function getCookieUid(){
        
        return false;
    }
    
    /**
     *获取后台登陆信息
     * @return type  已经登陆返回true，否则返回false
     */
    public function isLoggedAdmin(){
        if(session(C("USER_AUTH_KEY"))){
            return array(
                "username"=>  session("username"),
                "userid"=>  session(C("USER_AUTH_KEY")),
            );
        }
        return false;
    }
    
    /**
     * 登陆后台
     * @param type $identifier 用户ID,或者用户名
     * @param type $password 用户密码，不能为空
     * @return type 成功返回true，否则返回false
     */
    public function loginAdmin($identifier, $password){
    	 
        if(empty($identifier) || empty($password)){
            return false;
        }
        if (!($user = $this->getLocalUser($identifier, $password))) {
            $this->recordLoginAdmin($identifier,$password,0,"帐号密码错误");
            return false;
        }
        //判断帐号状态
        if($user['status']==0){
            //记录登陆日志
            $this->recordLoginAdmin($identifier,$password,0,"帐号被禁止");
            return false;
        }
        //设置标记
        session(C('USER_AUTH_KEY'),$user['id']);
        //设置用户名
        session("username",$user['username']);
        //标记为后台登陆
        session("ShuiPanAdmin",true);
        //角色
        session("roleid",$user['role_id']);
        //特权。创始人
        if($user['role_id']==1){
            session("administrator",true);
        }
      
        //记录登陆日志
        $this->recordLoginAdmin($identifier,$password,1);
        M("Fxuser")->where(array("id"=>$user['id']))->save(array(
            "last_login_time"=>time(),
            "last_login_ip"=>get_client_ip()
        ));
        return true;
    }
    
    /**
     * 记录登陆信息
     * @param type $uid 用户ID
     */
    public function recordLogin($uid){
        
    }
    
    /**
     * 记录后台登陆信息
     * @param type $uid 用户ID
     */
    public function recordLoginAdmin($identifier,$password,$status,$info=""){
        $date = array();
        M("Fxloginlog")->add(array(
            "username"=>$identifier,
            "logintime"=>date("Y-m-d H:i:s"),
            "loginip"=>get_client_ip(),
            "status"=>$status,
            "password"=>substr($password,0,4)."***",
            "info"=>$info
        ));
    }
}
?>
