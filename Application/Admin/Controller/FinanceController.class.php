<?php
/*
 * 财务管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class FinanceController extends AdminbaseController{
public $db_user;
public $db_need;
public $db_mailing;
public $db_notificationk;
public $db_reward;
  function _initialize() {
        parent::_initialize();
         $this->db_user=D('user');
         $this->db_need=D('need');
         $this->db_mailing=D('mailing');
         $this->db_notificationk=D('notification');
         $this->db_reward=D('reward');
    }
    /*
     * 开票管理
    */
    public function lists(){
    	$billing = array("0"=>"待开票","1"=>"待邮寄","2"=>"已完成");
    	//搜索参数
    	$no = trim ( $this->_get ( "no" ) );
		$d_reward = 0;
    	
    	$where = "n.status > 14 and n.pay_mode > 0";
    	if ($no) {
    		$where .= " and (n.no LIKE '%$no%' or u.mobile like '%$no%' or u.khdw like '%$no%')";
    	}
    	$count = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->count();
    	$page = $this->page($count,20);
    	$list = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("n.billing"=>"asc","n.end_time"=>"asc"))->field ("n.*,u.mobile,u.khdw")->select();
    	foreach($list as $k=>$v){
    		$v['billing_v'] = $billing[$v['billing']];
    		//收款状态
    		if($v['pay_mode'] == "2"){
    			$v["pay_status"] = "线下未结算";
    		}elseif($v['pay_mode'] == "3"){
    			$v["pay_status"] = "线下已结算";
    		}elseif($v['pay_mode'] == "4"){
				$v['pay_status'] = "支付宝";
			}elseif($v['pay_mode'] == "5"){
				$v['pay_status'] = "微信支付";
			}
    		
			if($v["billing"] == "0"){
				$d_reward = $v["reward"] + $d_reward;
			}
    		$list[$k] = $v;
    	}
    	
		$reward = $this->db_need->where("status > 14 and pay_mode > 0 and billing='0'")->field("sum(reward) as reward")->find();

    	$this->assign("Page",$page->show('Admin'));
    	$this->assign('list',$list);
		$this->assign("d_reward",$d_reward);
		$this->assign("reward",$reward["reward"]);
    	$this->display();
    }
    /*
     * 待开票
     */
	public function billing(){
		//处理已开票
		$id = $_GET ['id'];
		if ($id) {
			$data["billing"] = "1";
			//更新订单
			$this->db_need->where ( "id={$id}" )->save ( $data );
			$this->addLogs ( 'edit', $id, "确认已开票" );
		}
		
		//搜索参数
		$no = trim ( $this->_get ( "no" ) );
		$where = "n.status > 14 and n.pay_mode > 0 and n.billing = '0'";
		if ($no) {
			$where .= " and (n.no LIKE '%$no%' or u.mobile like '%$no%' or u.khdw like '%$no%')";
		}
		$count = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->count();
        $page = $this->page($count,20);
        $list = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("n.billing"=>"asc","n.end_time"=>"asc"))->field ("n.*,u.mobile,u.khdw")->select();
        foreach($list as $k=>$v){
        	//收款状态
        if($v['pay_mode'] == "2"){
    			$v["pay_status"] = "线下未结算";
    		}elseif($v['pay_mode'] == "3"){
    			$v["pay_status"] = "线下已结算";
    		}elseif($v['pay_mode'] == "4"){
				$v['pay_status'] = "支付宝";
			}elseif($v['pay_mode'] == "5"){
				$v['pay_status'] = "微信支付";
			}
        	$list[$k] = $v;
        }

        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 待邮寄
	*/
	public function mailing(){
		//处理已邮寄
		$id = $_GET ['id'];
		if ($id) {
			$data["billing"] = "2";
			//更新订单
			$this->db_need->where ( "id={$id}" )->save ( $data );
			$this->addLogs ( 'edit', $id, "确认已邮寄" );
		}
	
		//搜索参数
		$no = trim ( $this->_get ( "no" ) );
		$where = "n.status > 14 and n.pay_mode > 0 and n.billing = '1'";
		if ($no) {
			$where .= " and (n.no LIKE '%$no%' or u.mobile like '%$no%' or u.khdw like '%$no%')";
		}
		$count = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->count();
		$page = $this->page($count,20);
		$list = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("n.billing"=>"asc","n.end_time"=>"asc"))->field ("n.*,u.mobile,u.khdw")->select();
		foreach($list as $k=>$v){
			//收款状态
			if($v['pay_mode'] == "2"){
    			$v["pay_status"] = "线下未结算";
    		}elseif($v['pay_mode'] == "3"){
    			$v["pay_status"] = "线下已结算";
    		}elseif($v['pay_mode'] == "4"){
				$v['pay_status'] = "支付宝";
			}elseif($v['pay_mode'] == "5"){
				$v['pay_status'] = "微信支付";
			}
			$list[$k] = $v;
		}
	
		$this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 待邮寄处理
	*/
	public function mailing_add(){
		if(isset($_POST['dosubmit'])){
			$data = $_POST ['info'];
			$id = intval ( $this->_post ( 'id' ) );
			$no = $this->_post ( "no" );
			$uid_x = $this->_post ( "uid_x" );
			if (! $id)
				$this->error ( "参数错误！" );
			
			$data_n["billing"] = "2";
			//更新订单
			$this->db_need->where ( "id={$id}" )->save ( $data_n );
			
			//记录邮寄信息
			$data["nid"] = $id;
			$this->db_mailing->add($data);

			$this->success ( "操作成功！", U ( 'Finance/mailing' ) );
		}else{
			$id = $_GET ['id'];
			if (! $id)
				$this->error ( "参数错误！" );
			$info=$this->db_need->where("id={$id}")->find();
			
			$this->assign('info',$info);
			$this->display();
		}
		
	}
	/*
	 * 已完成
	*/
	public function completed(){
		//搜索参数
		$no = trim ( $this->_get ( "no" ) );
		$where = "n.status > 14 and n.pay_mode > 0 and n.billing = '2'";
		if ($no) {
			$where .= " and (n.no LIKE '%$no%' or u.mobile like '%$no%' or u.khdw like '%$no%')";
		}
		$count = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->count();
		$page = $this->page($count,20);
		$list = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("n.billing"=>"asc","n.end_time"=>"asc"))->field ("n.*,u.mobile,u.khdw")->select();
		foreach($list as $k=>$v){
			//收款状态
			if($v['pay_mode'] == "2"){
    			$v["pay_status"] = "线下未结算";
    		}elseif($v['pay_mode'] == "3"){
    			$v["pay_status"] = "线下已结算";
    		}elseif($v['pay_mode'] == "4"){
				$v['pay_status'] = "支付宝";
			}elseif($v['pay_mode'] == "5"){
				$v['pay_status'] = "微信支付";
			}
			$list[$k] = $v;
		}
	
		$this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 确认已收款
	*/
	public function shoukuan(){
		$id=$this->_get('id');
		$reward_m=$this->_get('reward_m');
		if(!$id)	$this->error("参数错误！");
		//结算处理
		$data['pay_mode'] = 3;
		$data["pay_time"] = date("Y-m-d H:i:s");
		$data['reward_m'] = $reward_m;
		$data['status'] = "16";
		$this->db_need->where("id={$id}")->save($data);
			
		//查询订单信息
		$n_u=$this->db_need->where("id={$id}")->field("no,uid_x,reward")->find();
		$no = $n_u["no"];
		$uid_x = $n_u["uid_x"];
		$reward = $n_u["reward"];
			
		//记录订单消费记录
		$data_con['uid'] = $uid_x;
		$data_con['contact'] = $reward;
		$data_con['remark'] = "订单消费";
		$data_con['n_no'] = $no;
		$data_con['type'] = "1";
		$this->db_reward->add($data_con);
		
		//查询用户token,进行推送
		$u_t=$this->db_user->where("uid={$uid_x}")->field("token")->select();
		$token = $u_t[0]["token"];
		$s_name = "已收到您的订单".$no."汇款，本次交易完成。";
		if($token){
			//用户未读条数
			$count_n = $this->db_notificationk->where("ruid='{$uid_x}' and flag='1' and isread='0'")->count();
				
			import("Org.Jpush.Jpush_f"); //引入Jpush类文件
			$pushObj = new \Jpush_f();
			//组装需要的参数
			$receive = array('registration_id'=>array($token));
			$title = "";
			$content = $s_name;
			$m_time = '86400';        //离线保留时间
			$count_n = $count_n + 1;
			$extras = array("type"=>"1","nid"=>$id,"not"=>$count_n,"aisle"=>"0");   //自定义数组
			//调用推送,并处理
			$result = $pushObj->push($receive,$title,$content,$extras,$m_time);
		}
		$data_n['obj_id'] = $no;
		$data_n['ruid'] = $uid_x;
		$data_n['content'] = $s_name;
		$this->db_notificationk->add($data_n);

		$this->success("操作成功！");
	}
	
}

?>
