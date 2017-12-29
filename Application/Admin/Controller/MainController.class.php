<?php

namespace Admin\Controller;
use Appframe\AdminbaseController;
class MainController extends AdminbaseController {

    public function public_index() {
     
        //服务器信息
		
        $info = array(
            '操作系统' => PHP_OS,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            'MYSQL版本' => mysql_get_server_info(),
        );
       
        $this->assign('server_info', $info);
        //会员信息
        $userinfos = $this->Cache['User'];

        $userinfo = array(
            '会员名' => $userinfos['username']."&nbsp;&nbsp;&nbsp;<a href='".U("Admin/Adminmanage/myinfo")."'> 修改资料</a>",
            '所属会员组' => $userinfos['role_name'],
            '最后登陆时间' => date("Y-m-d H:i:s", $userinfos['last_login_time']),
            '上次登陆IP' => $userinfos['last_login_ip'],
            '本次登陆IP' => get_client_ip()
        );
        $this->assign('userinfo', $userinfo);
        $Model = F('Model');
        foreach ($Model as $rw) {
            $molule = M(ucwords($rw['tablename']));
            $rw['counts'] = $molule->count();
            $moduledata[] = $rw;
        }
        $login=M("fxloginlog")->order("loginid desc")->limit("0,5")->select();
        $this->assign("login",$login);
        $this->assign("moduledata",$moduledata);
        $this->display('index');
    }
    
    public function public_main(){
    	//用户数
	    $count1=M('user')->where("1=1")->count();
	    //服务商数量
	    $count2=M('user')->where("1=1 and type='1'")->count();	
	    //总订单数量
	    $count3=M('need')->where("1=1")->count();
	    //总销售额
	    $count4=M('need')->where("status='16'")->field("sum(reward) as reward")->find();
	    //总支出额	
	    $count5=M('need')->where("reward_time != ''")->field("sum(get_reward) as reward")->find();
	    //总账外支
	    $count6=M('need')->where("reward_time != '' and reward_m_f=1")->field("sum(get_reward) as reward")->find();
	    //需方确认完工以后，确认收款之前（应收款）
	    $count7=M('need')->where("status='15'")->field("sum(reward) as reward")->find();
	    //服务方确认完工以后，确认打款之前（应付款）
	    $count8=M('need')->where("status > 13 and get_reward != '' and reward_time = ''")->field("sum(get_reward) as reward")->find();
	    
	    $wh="username='{$_SESSION['username']}' ";
	    $Logs = M("fxloginlog")->where("")->limit(0,10)->order(array("loginid"=>"desc"))->select();

	    for($i=11;$i>0;$i--){
	    	$t_y[$i] = date('Y-m',strtotime("-$i month"));
	    	$b_k_time = date('Y-m',strtotime("-$i month"))."-01";
	    	$b_j_time = date('Y-m',strtotime("-$i month"))."-31";
	    	//营收额
	    	$yse = M('need')->where("status='16' and end_time>'$b_k_time' and end_time<'$b_j_time'")->field("sum(reward) as reward")->find();
	    	$t_yse[$i] = $yse["reward"]?$yse["reward"]:0;
	    	//支出额
	    	$zce = M('need')->where("reward_time != '' and end_time>'$b_k_time' and end_time<'$b_j_time'")->field("sum(get_reward) as reward")->find();
	    	$t_zce[$i] = $zce["reward"]?$zce["reward"]:0;
	    	//账外支出额
	    	$zwzce=M('need')->where("reward_time != '' and reward_m_f=1 and end_time>'$b_k_time' and end_time<'$b_j_time'")->field("sum(get_reward) as reward")->find();
	    	$t_zwzce[$i] = $zwzce["reward"]?$zwzce["reward"]:0;
	    }
	    $t_y["0"] = date('Y-m');
	    
	    $b_k_time = date('Y-m')."-01";
	    $b_j_time = date('Y-m')."-31";
	    //本月营收额
	    $yse0 = M('need')->where("status='16' and end_time>'$b_k_time' and end_time<'$b_j_time'")->field("sum(reward) as reward")->find();
	    $t_yse["0"] = $yse0["reward"]?$yse0["reward"]:0;
	    //本月支出额
	    $zce = M('need')->where("reward_time != '' and end_time>'$b_k_time' and end_time<'$b_j_time'")->field("sum(get_reward) as reward")->find();
	    $t_zce["0"] = $zce["reward"]?$zce["reward"]:0;
	    //本月账外支出额
	    $zwzce = M('need')->where("reward_time != '' and reward_m_f=1 and end_time>'$b_k_time' and end_time<'$b_j_time'")->field("sum(get_reward) as reward")->find();
	    $t_zwzce["0"] = $zwzce["reward"]?$zwzce["reward"]:0;

		$this->assign("Logs",$Logs);
		$this->assign("count1",$count1);
		$this->assign("count2",$count2);
		$this->assign("count3",$count3);
		$this->assign("count4",$count4["reward"]);
		$this->assign("count5",$count5["reward"]);
		$this->assign("count6",$count6["reward"]);
		$this->assign("count7",$count7["reward"]);
		$this->assign("count8",$count8["reward"]);
		$this->assign("t_y",$t_y);
		$this->assign("t_yse",$t_yse);
		$this->assign("t_zce",$t_zce);
		$this->assign("t_zwzce",$t_zwzce);

    	$this->display('index');
    }
    

    /**
     *  显示后台左侧导航
     */
    public function public_leftmain() {
        $parentid = (int) $this->_get("parentid");
		$menuGroupList = D('Menu')->roles_menu($_SESSION['roleid']);
        if ($parentid == 0) {
            $arid = current($menuGroupList);
            $Mune = $menuGroupList[$arid['id']]['lower'];
        } else {
            $Mune = $menuGroupList[$parentid]['lower'];
        }
        $this->assign("leftmain", $Mune);
        $this->display('leftmain');
    }

}

?>
