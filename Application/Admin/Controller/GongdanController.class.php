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
		$count_0 = $this->db_need->where("status > 0")->count();
		$count_1 = $this->db_need->where("status = 11")->count();
		$count_2 = $this->db_need->where("status = 12")->count();
		$count_3 = $this->db_need->where("status = 13")->count();
		$count_4 = $this->db_need->where("status = 14")->count();
		$count_5 = $this->db_need->where("status = 15")->count();
		$count_6 = $this->db_need->where("status = 16")->count();
		/* $count_7 = $this->db_need->where("status > 13 and get_reward = ''")->count();
		$count_8 = $this->db_need->where("get_reward != '' and reward_m_f = '0'")->count(); */
		
		$status = array("11"=>"待确认需求($count_1)","12"=>"待指派人员($count_2)","13"=>"待服务完成($count_3)","14"=>"待确认完工($count_4)","15"=>"待支付费用($count_5)","16"=>"交易完成($count_6)");
		//搜索
		$status_g   = trim ( $this->_get ( "status" ) );
		$start_time = $this->_get('start_time');
		$end_time   = $this->_get('end_time');
		$info_x     = trim ( $this->_get ( "info_x" ) );
		$info_f     = trim ( $this->_get ( "info_f" ) );

		if ($status_g) {
			$where = "n.status = $status_g ";
		}else{
			$where = "n.status > 0";
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
	/**
	 * 已取消订单
	 */
	public function cancel(){
		//搜索
		$no = trim ( $this->_get ( "no" ) );
		$where = "status = '-2'";
		if ($no) {
			$where .= " and no LIKE '%$no%' ";
		}
	
		$count = $this->db_need->where($where)->count();
		$page = $this->page($count,60);
		$list = $this->db_need->field()->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("time"=>"desc"))->select();
		foreach($list as $k=>$v){
			//查询订单类型
			$task=$this->db_m_library->where("id={$v['kuanxing']}")->find();
			$v["k_title"] = $task["title"];
			 
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
		$this->display();
	}
	/*
	 * 查看
	 */
	public function show(){
		$status = $this->status;

		$id=$this->_get('id');
		$bk=$this->_get('bk');
		$bz=$this->_get('bz');
		if(!$id)	$this->error("参数错误！");
		
		$info=$this->db_need->where("id={$id}")->find();
		
		$info['status_name'] = $status[$info['status']];
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
		$this->assign('bz',$bz);
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
	 * 审核
	 */
	public function check(){
		if (isset ( $_POST ['dosubmit'] )) {
			$id = intval ( $this->_post ( 'id' ) );
			$no = $this->_post ( "no" );
			$uid_x = $this->_post ( "uid_x" );
			if (! $id)
				$this->error ( "参数错误！" );

			$data = $_POST ['info'];
			if (!$data["uid_f"])
				$this->error ( "服务方填写错误！" );
			$data["check_time"] = date("Y-m-d H:i:s");
			$data["status"] = "12";
			//顾问处理
			$gw = explode("_",$data["gw_name"]);
			$data["gw_name"] = $gw["0"];
			$data["gw_number"] = $gw["1"];
			//查询服务方业务员
			$clerk_f=$this->db_user->where("uid={$data['uid_f']}")->find();
			$data["clerk_f"] = $clerk_f["clerk_f"];
			
			//更新订单状态
			$this->db_need->where ( "id={$id}" )->save ( $data );
			
			//图片处理
			$imgs = $_POST["s"];
			if($imgs){
				$data_p["n_id"] = $id;
				$data_p["type"] = "3";
			
				$imgs_arr = array_filter(explode('|',$imgs));
				foreach ($imgs_arr as $img){
					//大图
					$data_p["large"] = $img_b = substr($img,9);
					//小图
					$imgs_arr2 = explode('/',$img_b);
					$data_p["small"] = $img_s = $imgs_arr2["0"]."/".$imgs_arr2["1"]."/"."s_".$imgs_arr2["2"];
					//缩放小图
					$image = new \Think\Image();
					$image->open(".".$img);
					$image->thumb(80, 80)->save('./uploads/'.$img_s);
					$this->db_photo->add($data_p);
				}
			}

			//需求方推送
			$s_name = "您的订单".$no."需求已确认，请等待服务完成。";
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
			
			//服务方推送
			$cont_f = "【服务商】您有新的订单".$no."，请及时指派人员。";
			$u_t_f=$this->db_user->where("uid={$data['uid_f']}")->field("token")->select();
			$token_f = $u_t_f[0]["token"];
			if($token_f){
				//用户未读条数
				$count_n_f = $this->db_notificationk->where("ruid={$data['uid_f']} and flag='1' and isread='0'")->count();
				//组装需要的参数
				$receive_f = array('registration_id'=>array($token_f));
				$title_f = "";
				$content_f = $cont_f;
				$m_time_f = '86400';        //离线保留时间
				$count_n_f = $count_n_f + 1;
				$extras_f = array("type"=>"1","nid"=>$id,"not"=>$count_n_f,"aisle"=>"1");   //自定义数组
				//调用推送,并处理
				$result_f = $pushObj->push($receive_f,$title_f,$content_f,$extras_f,$m_time_f);
			}
			$data_n_f['obj_id'] = $no;
			$data_n_f['ruid'] = $data['uid_f'];
			$data_n_f['content'] = $cont_f;
			$this->db_notificationk->add($data_n_f);
			
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
			$u_x=$this->db_user->where("uid={$info['uid_x']}")->field("mobile,khdw")->select();
			$info['u_x_mobile']   = $u_x[0]["mobile"];
			$info['u_x_khdw'] = $u_x[0]["khdw"];
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
		$id=$this->_get('id');
		if(!$id)	$this->error("参数错误！");
		$data["status"] = "-2";
		$data["del_time"] = date("Y-m-d H:i:s");
		$this->db_need->where("id={$id}")->save($data);

		$this->addLogs('edit', $id,'取消订单');
		$this->success("操作成功！");
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
			$this->db_need->where("id={$id}")->save($data);
			
			$this->addLogs('edit', $id,'确认需方费用');
			$this->success("操作成功！", 'javascript:history.go(-2);' );
		}
	}
	/*
	 * 提交执行备注
	*/
	public function inform(){
		if (isset ( $_POST ['dosubmit'] )) {
			//提交参数
			$id    = $this->_post ( 'id' );
			if(!$id)	$this->error("参数错误！");
				
			$data = $_POST['info'];
			$data["nid"] = $id;
			$this->db_inform->add($data);
				
			$this->addLogs('add', $id,'提交执行备注');
			$this->success("操作成功！");
		}
	}
	/*
	 * 完工报告
	*/
	public function endbg(){
		if (isset ( $_POST ['dosubmit'] )) {
			$data = $_POST ['info'];
			$id = intval ( $this->_post ( 'id' ) );
			$no = $this->_post ( "no" );
			$uid_x = $this->_post ( "uid_x" );
			if (! $id)
				$this->error ( "参数错误！" );
				
			//图片处理
			$imgs = $_POST["s"];
			if($imgs){
				$data_p["n_id"] = $id;
				$data_p["type"] = "5";
			
				$imgs_arr = array_filter(explode('|',$imgs));
				foreach ($imgs_arr as $img){
					//大图
					$data_p["large"] = $img_b = substr($img,9);
					//小图
					$imgs_arr2 = explode('/',$img_b);
					$data_p["small"] = $img_s = $imgs_arr2["0"]."/".$imgs_arr2["1"]."/"."s_".$imgs_arr2["2"];
					//缩放小图
					$image = new \Think\Image();
					$image->open(".".$img);
					$image->thumb(80, 80)->save('./uploads/'.$img_s);
					
					$this->db_photo->add($data_p);
				}
			}
			$data["nid"] = $id;

			//生成完工报告
			$this->db_report->add($data);
			
			$this->addLogs('add', $id,'生成完工报告');
			$this->success ( "操作成功！", 'javascript:history.go(-2);' );
				
		}else{
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_need->where("id={$id}")->find();
			//查询订单款型
			$task=$this->db_m_library->where("id={$info['kuanxing']}")->find();
			$info["k_title"] = $task["title"];
			//查询发布用户信息
			$u_x=$this->db_user->where("uid={$info['uid_x']}")->field("mobile,khdw")->select();
			$info['u_x_mobile']   = $u_x[0]["mobile"];
			$info['u_x_khdw'] = $u_x[0]["khdw"];
			//服务方
			$u_f=$this->db_user->where("uid={$info['uid_f']}")->field("mobile,company")->select();
			$info['u_f_mobile']   = $u_f[0]["mobile"];
			$info['u_f_company'] = $u_f[0]["company"];

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
		$n_u=$this->db_need->where("id={$id}")->field("no,uid_x")->find();
		$no = $n_u["no"];
		$uid_x = $n_u["uid_x"];
	
		//查询用户token,进行推送
		if($uid_x){
			$s_name = "您的订单".$no."服务已完成，请支付订单费用。";
			$u_t=$this->db_user->where("uid={$uid_x}")->field("token")->find();
			$token = $u_t["token"];
			if($token){
				//用户未读条数
				$count_n = $this->db_notificationk->where("ruid='{$uid_x}' and flag='1' and isread='0'")->count();
					
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
			//推送记录
			$data_n['obj_id'] = $no;
			$data_n['ruid'] = $uid_x;
			$data_n['content'] = $s_name;
			$this->db_notificationk->add($data_n);
		}

		$data['status'] = "15";
		$data["end_time"] = date("Y-m-d H:i:s");
		$this->db_need->where("id={$id}")->save($data);
		$this->addLogs('edit', $id,'服务完成');
		$this->success("操作成功！");
	}
	/*
	 * 线下支付
	*/
	public function pay(){
		$id=$this->_get('id');
		if(!$id)	$this->error("参数错误！");
		$data["pay_mode"] = "2";
		$this->db_need->where("id={$id}")->save($data);
	
		$this->addLogs('edit', $id,'选择线下支付');
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
