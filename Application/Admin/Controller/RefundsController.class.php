<?php
/*
 * 退款管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class RefundsController extends AdminbaseController{
public $db_user;
public $db_need;
public $db_photo;
public $db_m_library;
public $db_notificationk;
  function _initialize() {
        parent::_initialize();
         $this->db_user=D('user');
         $this->db_need=D('need');
         $this->db_photo=D('photo');
         $this->db_m_library=D('m_library');
         $this->db_notificationk=D('notification');
    }
    
    /*
     * 未退款列表
     */
	public function n_list(){
		$type = array("1"=>"线上","2"=>"线下");
		$status_q = array("-5"=>"需方要求中止订单","-6"=>"需方要求中止订单");
		//搜索
		$where = " n_payed = 'B' and reimburse = '' ";
		$no = trim ( $this->_get ( "no" ) );
		if ($no) {
			$where .= " and no LIKE '%$no%' ";
		}
		
		$count = $this->db_need->where($where)->count();
        $page = $this->page($count,20);
        $list = $this->db_need->field()->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("del_time"=>"desc"))->select();
        foreach($list as $k=>$v){
	        $v['status_name'] = $status_q[$v['status']];
	        $v['type_name'] = $type[$v['n_type']];
	        
	        //查询订单类型
	        $task=$this->db_m_library->where("id={$v['kuanxing']}")->find();
	        $v["k_title"] = $task["title"];

	        //查询发布用户信息
	        $u=$this->db_user->where("uid={$v['uid_x']}")->field("uid,name,mobile")->select();
	        $v['u_mobile'] = $u[0]["mobile"];
	        
	        //查询接单用户信息
	        $u2=$this->db_user->where("uid={$v['uid_f']}")->field("uid,name,company")->select();
	        $v['u_company'] = $u2[0]["company"];

		    $list[$k] = $v;
        }
        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 已退款列表
	 */
	public function lists(){
		$type = array("1"=>"线上","2"=>"线下");
		$status_q = array("-5"=>"需方要求中止订单","-6"=>"需方要求中止订单");
		//搜索
		$where = " n_payed = 'B' and reimburse != '' ";
		$no = trim ( $this->_get ( "no" ) );
		if ($no) {
			$where .= " and no LIKE '%$no%' ";
		}
	
		$count = $this->db_need->where($where)->count();
		$page = $this->page($count,20);
		$list = $this->db_need->field()->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("del_time"=>"desc"))->select();
		foreach($list as $k=>$v){
			$v['status_name'] = $status_q[$v['status']];
			$v['type_name'] = $type[$v['n_type']];
			 
			//查询订单类型
			$task=$this->db_m_library->where("id={$v['kuanxing']}")->find();
			$v["k_title"] = $task["title"];
	
			//查询发布用户信息
			$u=$this->db_user->where("uid={$v['uid_x']}")->field("uid,name,mobile")->select();
			$v['u_mobile'] = $u[0]["mobile"];
			 
			//查询接单用户信息
			$u2=$this->db_user->where("uid={$v['uid_f']}")->field("uid,name,company")->select();
			$v['u_company'] = $u2[0]["company"];
	
			$list[$k] = $v;
		}
		$this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 查看
	 */
	public function show(){
		$status = array("1"=>"技术评审","2"=>"等待付款","3"=>"待施工指派","4"=>"待服务完成","5"=>"交易完成","-2"=>"已取消");
		$type = array("1"=>"线上","2"=>"线下");
		$status_q = array("-2"=>"需方操作取消了订单","-3"=>"服务顾问取消了订单","-4"=>"需方要求中止订单","-5"=>"需方要求中止订单","-6"=>"需方要求中止订单");
		
		$id=$this->_get('id');
		$bk=$this->_get('bk');
		if(!$id)	$this->error("参数错误！");
		
		$info=$this->db_need->where("id={$id}")->find();
		if($info['status'] < 1){
			$info['status_name'] = $status_q[$info['status']];
		}else{
			$info['status_name'] = $status[$info['status']];
		}
		
		$info['type_name'] = $type[$info['n_type']];
		//查询订单款型
		$task=$this->db_m_library->where("id={$info['kuanxing']}")->find();
		$info["k_title"] = $task["title"];

		//查询发布用户信息
		$u_x=$this->db_user->where("uid={$info['uid_x']}")->field("mobile,name")->select();
		$info['u_x_name']   = $u_x[0]["name"];
		$info['u_x_mobile'] = $u_x[0]["mobile"];
		//查询接单用户信息
		$u_f=$this->db_user->where("uid={$info['uid_f']}")->field("mobile,name,company")->select();
		$info['u_f_name']   = $u_f[0]["name"];
		$info['u_f_mobile'] = $u_f[0]["mobile"];
		$info['u_f_company'] = $u_f[0]["company"];
		
		//是否支付酬劳
		if($info['n_payed'] == "Y"){
			if($info['pay_mode'] == "2"){
				$info['n_payed_name'] = "线下支付";
			}else{
				$info['n_payed_name'] = $info['pay_mode']."/已支付";
			}
		}elseif($info['n_payed'] == "N"){
			$info['n_payed_name'] = "未支付";
		}elseif($info['n_payed'] == "B"){
			$info['n_payed_name'] = "退款";
		}
		
		if($info["status"] < 1){
			$info["status_q"] = "是";
			$info["status_q_y"] = $status_q[$info['del_reason']];
		}else{
			$info["status_q"] = "否";
		}
		$info["maoli"] = $info["reward"] - $info["get_reward"];

		//获取描述图片
		$info_m=$this->db_photo->where("n_id={$id} and flag=1 and type=1")->field()->select();
		//获取描述视频
		$info_s=$this->db_photo->where("n_id={$id} and flag=1 and type=2")->field()->select();
		//获取评审图片
		$info_p=$this->db_photo->where("n_id={$id} and flag=1 and type=3")->field()->select();
		//获取评价图片
		$info_j=$this->db_photo->where("n_id={$id} and flag=1 and type=4")->field()->select();

		$this->assign('bk',$bk);
		$this->assign('info',$info);
		$this->assign('info_m',$info_m);
		$this->assign('info_s',$info_s);
		$this->assign('info_p',$info_p);
		$this->assign('info_j',$info_j);
		$this->display();
	}
	
	/*
	 * 退款
	*/
	public function tuikuan(){
		if (isset ( $_POST ['dosubmit'] )) {
			$id = intval ( $this->_post ( 'id' ) );
			$no = intval ( $this->_post ( 'no' ) );
			$uid_x = intval ( $this->_post ( 'uid_x' ) );
			
			$data = $_POST ['info'];
			if (! $id)
				$this->error ( "参数错误！" );
			$s_name = "您的订单".$no."已完成退款￥".$data["reimburse"]."，请及时查收。";
			$data["re_time"] = date("Y-m-d H:i:s");
			//更新订单状态
			$this->db_need->where ( "id={$id}" )->save ( $data );
			
			//查询用户token,进行推送
			$u_t=$this->db_user->where("uid={$uid_x}")->field("token")->select();
			$token = $u_t[0]["token"];
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
			
			$this->addLogs('edit', $id,$s_name);
			$this->success ( "操作成功！", U ( 'Refunds/n_list' ) );
		}else{
			$type = array("1"=>"线上","2"=>"线下");
			$status_q = array("-5"=>"需方要求中止订单","-6"=>"需方要求中止订单");
				
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_need->where("id={$id}")->find();

			$info['status_name'] = $status_q[$info['status']];
			
			$info['type_name'] = $type[$info['n_type']];
			//查询订单款型
			$task=$this->db_m_library->where("id={$info['kuanxing']}")->find();
			$info["k_title"] = $task["title"];
	
			//查询发布用户信息
			$u_x=$this->db_user->where("uid={$info['uid_x']}")->field("mobile,name")->select();
			$info['u_x_name']   = $u_x[0]["name"];
			$info['u_x_mobile'] = $u_x[0]["mobile"];
			//查询接单用户信息
			$u_f=$this->db_user->where("uid={$info['uid_f']}")->field("mobile,name,company")->select();
			$info['u_f_name']   = $u_f[0]["name"];
			$info['u_f_mobile'] = $u_f[0]["mobile"];
			$info['u_f_company'] = $u_f[0]["company"];
			
			//是否支付酬劳
			if($info['n_payed'] == "Y"){
				if($info['pay_mode'] == "2"){
					$info['n_payed_name'] = "线下支付";
				}else{
					$info['n_payed_name'] = $info['pay_mode']."/已支付";
				}
			}elseif($info['n_payed'] == "N"){
				$info['n_payed_name'] = "未支付";
			}
			if($info["status"] < 1){
				$info["status_q"] = "是";
				$info["status_q_y"] = $status_q[$info['del_reason']];
			}else{
				$info["status_q"] = "否";
			}
			$info["maoli"] = $info["reward"] - $info["get_reward"];
	
			//获取描述图片
			$info_m=$this->db_photo->where("n_id={$id} and flag=1 and type=1")->field()->select();
			//获取描述视频
			$info_s=$this->db_photo->where("n_id={$id} and flag=1 and type=2")->field()->select();
			//获取评审图片
			$info_p=$this->db_photo->where("n_id={$id} and flag=1 and type=3")->field()->select();

			$this->assign('info',$info);
			$this->assign('info_m',$info_m);
			$this->assign('info_s',$info_s);
			$this->assign('info_p',$info_p);
			$this->display();
		}
	}
	
}

?>
