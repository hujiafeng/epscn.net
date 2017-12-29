<?php
/*
 * 服务商订单管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class FgongdanController extends AdminbaseController{
public $db_user;
public $db_need;
public $db_photo;
public $db_m_library;
public $db_notificationk;
public $db_fxuser;
public $db_reward;
public $db_adviser;
public $db_report;
public $db_mailing;
public $db_clerk;
public $db_evaluate;
public $db_inform;
  function _initialize() {
        parent::_initialize();
         $this->db_user=D('user');
         $this->db_need=D('need');
         $this->db_photo=D('photo');
         $this->db_m_library=D('m_library');
         $this->db_notificationk=D('notification');
         $this->db_fxuser=D('fxuser');
         $this->db_reward=D('reward');
         $this->db_adviser=D('adviser');
         $this->db_report=D('report');
         $this->db_mailing=D('mailing');
         $this->db_clerk=D('clerk');
         $this->db_evaluate=D('evaluate');
         $this->db_inform=D('inform');
         
         $this->status = array("-2"=>"已取消","11"=>"待确认需求","12"=>"待指派人员","13"=>"待服务完成","14"=>"待确认完工","15"=>"待支付费用","16"=>"交易完成");
    }
    
    /**
     * 列表
     */
	public function lists(){
		//状态订单统计
		$count_0 = $this->db_need->where("status > 13")->count();
		$count_4 = $this->db_need->where("status > 13 and get_reward = ''")->count();
		$count_5 = $this->db_need->where("status > 13 and reward_time = '' and get_reward != ''")->count();
		$count_6 = $this->db_need->where("status > 13 and get_reward != '' and reward_time != ''")->count();
		
		$status = array("14"=>"待完工审核($count_4)","15"=>"待酬劳结算($count_5)","16"=>"交易完成($count_6)");
		//搜索
		$status_g   = trim ( $this->_get ( "status" ) );
		$start_time = $this->_get('start_time');
		$end_time   = $this->_get('end_time');
		$info_x     = trim ( $this->_get ( "info_x" ) );
		$info_f     = trim ( $this->_get ( "info_f" ) );

		if($status_g == "14"){
			$where = "n.status > 13 and n.get_reward = '' ";
		}elseif($status_g == "15"){
			$where = "n.status > 13 and n.reward_time = '' and n.get_reward != '' ";
		}elseif($status_g == "16"){
			$where = "n.status > 13 and n.get_reward != '' and n.reward_time != ''  ";
		}else{
			$where = "n.status > 13";
		}
		if ($start_time) {
			$where .= " and n.time >= '$start_time' ";
		}
		if ($end_time) {
			$where .= " and n.time <= '$end_time' ";
		}

		if ($info_f == "服务方") {
			$where .= " and (n.no LIKE '%$info_x%' or u.mobile like '%$info_x%' or u.company like '%$info_x%') ";
			$count = M()->table('d_need as n')->join('d_user as u on n.uid_f=u.uid')->where($where)->count();
			$page = $this->page($count,20);
			$list = M()->table('d_need as n')->join('d_user as u on n.uid_f=u.uid')->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("n.time"=>"desc"))->field ("n.*")->select();
			
		}else{
			$where .= " and (n.no LIKE '%$info_x%' or u.mobile like '%$info_x%' or u.khdw like '%$info_x%') ";
			$count = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->count();
			$page = $this->page($count,20);
			$list = M()->table('d_need as n')->join('d_user as u on n.uid_x=u.uid')->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("n.time"=>"desc"))->field ("n.*")->select();
		}

		foreach($list as $k=>$v){
	        //查询订单类型
	        $task=$this->db_m_library->where("id={$v['kuanxing']}")->find();
	        $v["k_title"] = $task["title"];
	        
	        //确认需方费用
	        if($v["status"] > 11 && $v["status"] < 15 and !$v["reward"]){
	        	$v["xffy"] = "1";
	        }else{
	        	$v["xffy"] = "0";
	        }
	        
	        //查询是否已出完工报告
	        $report = $this->db_report->where("nid={$v['id']}")->find();
	        $v["report"] = $report["id"]?1:0;

	        //查询发布用户信息
	        $u=$this->db_user->where("uid={$v['uid_x']}")->field("uid,name,mobile,khdw")->select();
	        $v['u_mobile'] = $u[0]["mobile"];
	        $v['khdw'] = $u[0]["khdw"];
	        
	        //查询接单用户信息
	        $u2=$this->db_user->where("uid={$v['uid_f']}")->field("uid,name,company")->select();
	        $v['u_company'] = $u2[0]["company"];

		    $list[$k] = $v;
        }

        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->assign('status',$status);
		$this->assign('count_0',$count_0);
		$this->display();
	}
	/*
	 * 查看
	 */
	public function show(){
		$status = $this->status;
		
		$bk=$this->_get('bk');
		$id=$this->_get('id');
		if(!$id)	$this->error("参数错误！");
		
		$info=$this->db_need->where("id={$id}")->find();
		
		if($info["get_reward"] == ""){
			$info['status_name'] = "待完工审核";
		}else{
			if($info["reward_time"] == ""){
				$info['status_name'] = "待酬劳结算";
			}else{
				$info['status_name'] = "交易完成";
			}
		}
		
		//查询订单款型
		$task=$this->db_m_library->where("id={$info['kuanxing']}")->find();
		$info["k_title"] = $task["title"];

		//查询发布用户信息
		$u_x=$this->db_user->where("uid={$info['uid_x']}")->field("mobile,name,khdw")->select();
		$info['u_x_name']   = $u_x[0]["name"];
		$info['u_x_mobile'] = $u_x[0]["mobile"];
		$info['u_x_khdw'] = $u_x[0]["khdw"];
		//查询接单用户信息
		$u_f=$this->db_user->where("uid={$info['uid_f']}")->field("mobile,name,company")->select();
		$info['u_f_name']   = $u_f[0]["name"];
		$info['u_f_mobile'] = $u_f[0]["mobile"];
		$info['u_f_company'] = $u_f[0]["company"];
		
		//是否支付酬劳
		if($info['pay_mode'] == "2"){
			$info['n_payed_name'] = "线下结算";
		}elseif($info['pay_mode'] == "3"){
			$info['n_payed_name'] = "线下结算";
		}elseif($info['pay_mode'] == "4"){
			$info['n_payed_name'] = "支付宝";
		}elseif($info['pay_mode'] == "5"){
			$info['n_payed_name'] = "微信支付";
		}
		//订单毛利
		$info["maoli"] = $info["reward"] - $info["get_reward"];

		//获取描述图片
		$info_m=$this->db_photo->where("n_id={$id} and flag=1 and type=1")->field()->select();
		//获取描述视频
		$info_s=$this->db_photo->where("n_id={$id} and flag=1 and type=2")->field()->select();
		//获取评审图片
		$info_p=$this->db_photo->where("n_id={$id} and flag=1 and type=3")->field()->select();
		//获取评价图片
		$info_j=$this->db_photo->where("n_id={$id} and flag=1 and type=4")->field()->select();
		//获取完工报告图片
		$info_b=$this->db_photo->where("n_id={$id} and flag=1 and type=5")->field()->select();
		
		//查询是否已出完工报告
		$report = $this->db_report->where("nid={$id}")->find();
		
		//查询是否评价
		$evaluate = $this->db_evaluate->where("nid={$id}")->find();
		
		//查询是否有执行报告
		$inform = $this->db_inform->where("nid={$id}")->field()->order(array("time"=>"desc"))->select();
		
		//查看是否邮寄
		if($info["billing"] == "2"){
			$mailing=$this->db_mailing->where("nid={$id}")->find();
		}
		
		//查询需求方业务员
		$clerk_x=$this->db_clerk->where("id={$info['clerk_x']}")->find();
		$info["clerk_x_name"] = $clerk_x["name"];
		//查询服务方业务员
		$clerk_f=$this->db_clerk->where("id={$info['clerk_f']}")->find();
		$info["clerk_f_name"] = $clerk_f["name"];

		$this->assign('bk',$bk);
		$this->assign('info',$info);
		$this->assign('info_m',$info_m);
		$this->assign('info_s',$info_s);
		$this->assign('info_p',$info_p);
		$this->assign('info_j',$info_j);
		$this->assign('info_b',$info_b);
		$this->assign('report',$report);
		$this->assign('evaluate',$evaluate);
		$this->assign('mailing',$mailing);
		$this->assign('inform',$inform);
		$this->display();
	}
	/*
	 * 确认需方费用
	*/
	public function bukuan(){
		if (isset ( $_POST ['dosubmit'] )) {
			//提交参数
			$id    = $this->_post ( 'id' );
			if(!$id)	$this->error("参数错误！");
			
			$data = $_POST['info'];
			$data["end_time_f"] = date("Y-m-d H:i:s");
			$this->db_need->where("id={$id}")->save($data);
			
			//查询订单信息
			$n_u=$this->db_need->where("id={$id}")->field("no,uid_f")->find();
			$no = $n_u["no"];
			$uid_f = $n_u["uid_f"];
			
			//查询用户token,进行推送
			$u_t=$this->db_user->where("uid={$uid_f}")->field("token")->select();
			$token = $u_t[0]["token"];
			$s_name = "【服务商】您的订单".$no."已审核完工，请等待打款。";
			if($token){
				//用户未读条数
				$count_n = $this->db_notificationk->where("ruid='{$uid_f}' and flag='1' and isread='0'")->count();
			
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
			$data_n['ruid'] = $uid_f;
			$data_n['content'] = $s_name;
			$this->db_notificationk->add($data_n);
			
			$this->addLogs('edit', $id,'确认酬劳费用');
			$this->success("操作成功！", U ( 'Fgongdan/lists' ) );
		}
	}
	
	/*
	 * 确认已打款
	*/
	public function dakuan(){
		$id=$this->_get('id');
		$reward_m_f=$this->_get('reward_m');
		if(!$id)	$this->error("参数错误！");
		//结算处理
		$data["reward_time"] = date("Y-m-d H:i:s");
		$data['reward_m_f'] = $reward_m_f;
		$this->db_need->where("id={$id}")->save($data);
			
		//查询订单信息
		$n_u=$this->db_need->where("id={$id}")->field("no,uid_f,get_reward")->find();
		$no = $n_u["no"];
		$uid_f = $n_u["uid_f"];
		$get_reward = $n_u["get_reward"];
			
		//记录订单消费记录
		$data_con['uid'] = $uid_f;
		$data_con['contact'] = $get_reward;
		$data_con['remark'] = "服务酬劳";
		$data_con['n_no'] = $no;
		$data_con['type'] = "2";
		$this->db_reward->add($data_con);
		
		//查询用户token,进行推送
		$u_t=$this->db_user->where("uid={$uid_f}")->field("token")->select();
		$token = $u_t[0]["token"];
		$s_name = "【服务商】您的订单".$no."酬劳 ¥n 已打款，请查收。";
		if($token){
			//用户未读条数
			$count_n = $this->db_notificationk->where("ruid='{$uid_f}' and flag='1' and isread='0'")->count();
				
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
		$data_n['ruid'] = $uid_f;
		$data_n['content'] = $s_name;
		$this->db_notificationk->add($data_n);

		$this->success("操作成功！");
	}
	
}

?>
