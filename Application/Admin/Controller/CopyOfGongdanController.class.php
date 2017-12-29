<?php
/*
 * 订单管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class GongdanController extends AdminbaseController{
public $db_user;
public $db_need;
public $db_photo;
public $db_m_library;
public $db_notificationk;
public $db_fxuser;
public $db_reward;
public $db_adviser;
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
    }
    
    /**
     * 列表待评定1、待支付2、待指派3，待验收4，待评价5，已删除-2
     */
	public function lists(){
		$status = array("1"=>"技术评审","2"=>"等待付款","3"=>"待施工指派","4"=>"待服务完成","5"=>"交易完成");
		$type = array("1"=>"线上","2"=>"线下");
		//搜索
		$status_g = trim ( $this->_get ( "status" ) );
		$no = trim ( $this->_get ( "no" ) );
		$where = "status > 0";
		if ($status_g) {
			$where .= " and status = $status_g ";
		}
		if ($no) {
			$where .= " and no LIKE '%$no%' ";
		}
		
		$count = $this->db_need->where($where)->count();
        $page = $this->page($count,20);
        $list = $this->db_need->field()->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("time"=>"desc"))->select();
        foreach($list as $k=>$v){
        	if(!$v['zhpf'] and $v['status']=="5"){
        		$v['status_name'] = "待评价";
        	}else{
        		$v['status_name'] = $status[$v['status']];
        	}
        	
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
		$this->assign('status',$status);
		$this->display();
	}
	/**
	 * 已取消订单
	 */
	public function cancel(){
		$type = array("1"=>"线上","2"=>"线下");
		$status_q = array("1"=>"需方操作取消了订单","2"=>"服务顾问取消了订单","3"=>"需方要求中止订单","4"=>"需方要求中止订单","5"=>"需方要求中止订单");
		//搜索
		$no = trim ( $this->_get ( "no" ) );
		$where = "status < 1";
		if ($no) {
			$where .= " and no LIKE '%$no%' ";
		}
	
		$count = $this->db_need->where($where)->count();
		$page = $this->page($count,60);
		$list = $this->db_need->field()->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("time"=>"desc"))->select();
		foreach($list as $k=>$v){
			$v['status_name'] = $status_q[$v['del_reason']];
			$v['type_name'] = $type[$v['n_type']];
			if($v['n_type'] == "2"){
				$v["n_payed_name"] = "不需要";
			}else{
				if($v["n_payed"] == "B" && $v["reimburse"] == ""){
					$v["n_payed_name"] = "退款中";
				}elseif($v["n_payed"] == "B" && $v["reimburse"] != ""){
					$v["n_payed_name"] = "已退款";
				}
			}
			 
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
		$status_q = array("1"=>"需方操作取消了订单","2"=>"服务顾问取消了订单","3"=>"需方要求中止订单","4"=>"需方要求中止订单","5"=>"需方要求中止订单");
		
		$id=$this->_get('id');
		$bk=$this->_get('bk');
		if(!$id)	$this->error("参数错误！");
		
		$info=$this->db_need->where("id={$id}")->find();
		if($info['del_reason']){
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
	 * 审核
	 */
	public function check(){
		if (isset ( $_POST ['dosubmit'] )) {
			$id = intval ( $this->_post ( 'id' ) );
			$no = $this->_post ( "no" );
			$uid_x = $this->_post ( "uid_x" );
			$checks = $this->_post ( "checks" );
			if (! $id)
				$this->error ( "参数错误！" );
			
			if($checks == "2"){
				$s_name = "您的订单".$no."已通过技术评审，请尽快完成支付。";
				$data = $_POST ['info'];

				$data["check_time"] = date("Y-m-d H:i:s");
				if($data["status"] == "3"){
					$data["pay_time"] = date("Y-m-d H:i:s");
					$data["pay_mode"] = "2";
					$data["n_payed"] = "Y";
				}
				$gw = explode("_",$data["gw_name"]);
				$data["gw_name"] = $gw["0"];
				$data["gw_number"] = $gw["1"];
				
			}else{
				$s_name = "您的订单".$no."未通过技术评审，订单已被取消。";
				$data["status"] = "-2";
				$data["del_reason"] = "2";
				$data["del_time"] = date("Y-m-d H:i:s");
			}
			
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
			
			$this->addLogs ( 'edit', $id, $s_name );
			$this->success ( $s_name, U ( 'Gongdan/lists' ) );
			
		}else{
			$id=$this->_get('id');	
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_need->where("id={$id}")->find();
			//查询订单款型
			$task=$this->db_m_library->where("id={$info['kuanxing']}")->find();
			$info["k_title"] = $task["title"];
			//查询发布用户信息
			$u_x=$this->db_user->where("uid={$info['uid_x']}")->field("mobile,name")->select();
			$info['u_x_name']   = $u_x[0]["name"];
			$info['u_x_mobile'] = $u_x[0]["mobile"];
			//获取订单图片
			$info_p=$this->db_photo->where("n_id={$id} and flag=1 and type=1")->field()->select();
			//获取描述视频
			$info_s=$this->db_photo->where("n_id={$id} and flag=1 and type=2")->field()->select();
			//服务用户
			$user_f = $this->db_user->where(array('flag'=>"0",'type'=>"1") )->field ("uid,mobile,name,city,task,company")->order(array("last_time"=>"desc"))->select ();
			//服务顾问
			$fw = $this->db_adviser->where(array('status'=>"2") )->field ("name,number")->order(array("time"=>"desc"))->select ();
	
			$this->assign('info',$info);
			$this->assign('info_p',$info_p);
			$this->assign('info_s',$info_s);
			$this->assign('user_f',$user_f);
			$this->assign('fw',$fw);
			$this->display();
		}
	}
	
	/*
	 * 删除订单
	*/
	public function deln(){
		import("Org.Jpush.Jpush_f"); //引入Jpush类文件
		$pushObj = new \Jpush_f();
		
		$id=$this->_get('id');
		if(!$id)	$this->error("参数错误！");
		//查询用户token,进行推送
		$n_u=$this->db_need->where("id={$id}")->field("no,uid_x,uid_f,status")->find();
		$no = $n_u["no"];
		$uid_x = $n_u["uid_x"];
		$uid_f = $n_u["uid_f"];
		$status = $n_u["status"];
		//需求方token
		$u_x_t=$this->db_user->where("uid={$uid_x}")->field("token")->find();
		$token_x = $u_x_t["token"];
		
		$data["status"] = "-2";
		$s_name = "您的订单".$no."已中止，感谢您的使用。";
		if($status != "2"){
			if($status == "3"){
				$data["status"] = "-5";
			}elseif ($status == "4"){
				$data["status"] = "-6";
			}
			$data["n_payed"] = "B";
			
			$s_name = "您的订单".$no."已中止，退款3个工作日内处理。";
			//服务方token
			$s_name_f = "【服务商】服务订单".$no."已被需方撤销，本次服务中止。";
			$u_t_f=$this->db_user->where("uid={$uid_f}")->field("token")->find();
			$token_f = $u_t_f["token"];
			//推送服务方
			if($token_f){
				//用户未读条数
				$count_n_f = $this->db_notificationk->where("ruid='{$uid_f}' and flag='1' and isread='0'")->count();
				//组装需要的参数
				$receive_f = array('registration_id'=>array($token_f));
				$title_f = "";
				$content_f = $s_name_f;
				$m_time_f = '86400';        //离线保留时间
				$count_n_f = $count_n_f + 1;
				$extras_f = array("type"=>"1","nid"=>$id,"not"=>$count_n_f,"aisle"=>"1");   //自定义数组
				//调用推送,并处理
				$result = $pushObj->push($receive_f,$title_f,$content_f,$extras_f,$m_time_f);
			}
			//记录消息
			$data_n_f['obj_id'] = $no;
			$data_n_f['ruid'] = $uid_f;
			$data_n_f['content'] = $s_name_f;
			$this->db_notificationk->add($data_n_f);
		}
		//推送需求方
		if($token_x){
			//用户未读条数
			$count_n = $this->db_notificationk->where("ruid='{$uid_x}' and flag='1' and isread='0'")->count();
			//组装需要的参数
			$receive = array('registration_id'=>array($token_x));
			$title = "";
			$content = $s_name;
			$m_time = '86400';        //离线保留时间
			$count_n = $count_n + 1;
			$extras = array("type"=>"1","nid"=>$id,"not"=>$count_n,"aisle"=>"0");   //自定义数组
			//调用推送,并处理
			$result = $pushObj->push($receive,$title,$content,$extras,$m_time);
		}
		//记录消息
		$data_n['obj_id'] = $no;
		$data_n['ruid'] = $uid_x;
		$data_n['content'] = $s_name;
		$this->db_notificationk->add($data_n);

		//更新订单
		$data["del_time"] = date("Y-m-d H:i:s");
		$this->db_need->where("id={$id}")->save($data);
		$this->addLogs('edit', $id,'取消订单');
		$this->success("操作成功！");
	}
	/*
	 * 订单补款
	*/
	public function bukuan(){
		if (isset ( $_POST ['dosubmit'] )) {
			$id   = $this->_post ( 'id' );
			if(!$id)	$this->error("参数错误！");
			
			$data = $_POST['info'];
			$this->db_need->where("id={$id}")->save($data);
			
			$this->addLogs('edit', $id,'订单补款');
			$this->success("操作成功！", U ( 'Gongdan/lists' ) );
		}else{
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_need->where("id={$id}")->find();
			
			$this->assign('info',$info);
			$this->display();
		}
	}
	/*
	 * 服务完成
	*/
	public function end(){
		$id=$this->_get('id');
		if(!$id)	$this->error("参数错误！");
		//查询用户token,进行推送
		$n_u=$this->db_need->where("id={$id}")->field("no,uid_f,get_reward")->find();
		$no = $n_u["no"];
		$uid_f = $n_u["uid_f"];
		$get_reward = $n_u["get_reward"];
	
		//查询用户token,进行推送
		if($uid_f){
			$s_name = "【服务商】服务订单".$no."需方已验收，本次服务完成，酬劳已入账。";
			$u_t=$this->db_user->where("uid={$uid_f}")->field("token,reward")->find();
			$token = $u_t["token"];
			$reward = $u_t["reward"];
			if($token){
				//用户未读条数
				$count_n = $this->db_notificationk->where("ruid='{$uid_f}' and flag='1' and isread='0'")->count();
					
				import("Org.Jpush.Jpush_f"); //引入Jpush类文件
				$pushObj = new \Jpush_f();
				//组装需要的参数
				$receive = array('registration_id'=>array($token));
				$title = "";
				$content = $s_name;
				$m_time = '86400';//离线保留时间
				$count_n = $count_n + 1;
				$extras = array("type"=>"1","nid"=>$id,"not"=>$count_n,"aisle"=>"1");   //自定义数组
				//调用推送,并处理
				$result = $pushObj->push($receive,$title,$content,$extras,$m_time);
			}
			//修改酬劳
			$data_u["reward"] = $reward + $get_reward;
			$this->db_user->where("uid={$uid_f}")->save($data_u);
			//酬劳明细
			$data_r["uid"]     = $uid_f;
			$data_r["contact"] = "+".$get_reward;
			$data_r["remark"]  = "服务酬劳";
			$data_r["n_no"]    = $no;
			$this->db_reward->add($data_r);
			//推送记录
			$data_n['obj_id'] = $no;
			$data_n['ruid'] = $uid_f;
			$data_n['content'] = $s_name;
			$this->db_notificationk->add($data_n);
		}
	
	
		//屏蔽
		$data['status'] = "5";
		$data["end_time"] = date("Y-m-d H:i:s");
		$this->db_need->where("id={$id}")->save($data);
		$this->addLogs('edit', $id,'服务完成');
		$this->success("操作成功！");
	}
	//图片上传处理
	public function uploadImg() {
		if (isset($_POST["PHPSESSID"])) {
			session_id($_POST["PHPSESSID"]);
		}
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
				print_r(__ROOT__.'/uploads/'.$file['savepath'].$file['savename']);
			}
		}
	}
	//删除图片
	public function del() {
		$src=".".$_GET['src'];
		if (file_exists($src)){
			unlink($src);
		}
		print_r($_GET['src']);
		exit();
	}
	/**
	 * 计算两点地理坐标之间的距离
	 * @param  Decimal $longitude1 起点经度
	 * @param  Decimal $latitude1  起点纬度
	 * @param  Decimal $longitude2 终点经度
	 * @param  Decimal $latitude2  终点纬度
	 * @param  Int     $unit       单位 1:米 2:公里
	 * @param  Int     $decimal    精度 保留小数位数
	 * @return Decimal
	 */
	public function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal="0"){
	
		$EARTH_RADIUS = 6370.996; // 地球半径系数
		$PI = 3.1415926;
	
		$radLat1 = $latitude1 * $PI / 180.0;
		$radLat2 = $latitude2 * $PI / 180.0;
	
		$radLng1 = $longitude1 * $PI / 180.0;
		$radLng2 = $longitude2 * $PI /180.0;
	
		$a = $radLat1 - $radLat2;
		$b = $radLng1 - $radLng2;
	
		$distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
		$distance = $distance * $EARTH_RADIUS * 1000;
	
		if($unit==2){
			$distance = $distance / 1000;
		}
		return round($distance, $decimal);
	}
	
	public function rand_string_only_number($lenght){
		$res_str='';
		//
		for($i=0;$i<$lenght;$i++){
			$res_str .= chr(mt_rand(48, 57));
		}
		return $res_str;
	}
	
}

?>
