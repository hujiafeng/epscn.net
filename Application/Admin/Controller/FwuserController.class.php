<?php
/*
 * 服务端用户管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class FwuserController extends AdminbaseController{
public $db_user;
public $db_task;
public $db_reward;
public $db_notificationk;
public $db_region;
  function _initialize() {
        parent::_initialize();
         $this->db_user=D('user');
         $this->db_task=D('task');
         $this->db_reward=D('reward');
         $this->db_notificationk=D('notification');
         $this->db_region=D('region');
    }
    /*
     * 服务用户列表
    */
    public function index(){
    	$type = array("0"=>"普通用户","1"=>"服务商");
    	//搜索
    	$title = trim ( $this->_get ( "title" ) );
    	$where = "1=1 and type=1";
    	if ($title) {
    		$where .= " and (mobile LIKE '%$title%' OR name LIKE '%$title%' OR city LIKE '%$title%') ";
    	}
    	$count = $this->db_user->where($where)->count();
    	$page = $this->page($count,60);
    	$list = $this->db_user->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("reg_time"=>"desc"))->select();
    	foreach($list as $k=>$v){
    		$v['type_name'] = $type[$v['type']];
    
    		$list[$k] = $v;
    	}
    	$this->assign("Page",$page->show('Admin'));
    	$this->assign('list',$list);
    	$this->display();
    }
	/*
	 * 创建用户
	*/
	public function add(){
		
		if (isset ( $_POST ['dosubmit'] )) {
			$data = $_POST ['info'];
			if (! $data["mobile"])
				$this->error ( "参数错误！" );
			
			//地区处理
			$sheng = $this->db_region->where ( array('id'=>$_POST['province']) )->field ("name")->find ();
			$shi   = $this->db_region->where ( array('id'=>$_POST['city']) )->field ("name")->find ();
			$qu    = $this->db_region->where ( array('id'=>$_POST['town']) )->field ("name")->find ();
				
			$data['city'] = $sheng['name'].$shi['name'].$qu['name'];
			$data["last_time"] = $data["reg_time"] = date("Y-m-d H:i:s");
			$data['passwd'] = md5($data['passwd']);
			
			//增加用户
			$id = $this->db_user->add ( $data );
			
			
			$this->addLogs ( 'add', $id, "增加用户".$data["mobile"] );
			$this->success ( "操作成功！", U ( 'Fwuser/index' ) );
		}else{
			//省市区显示
			$province = $this->db_region->where ( array('pid'=>1) )->select ();
			$this->assign('province',$province);
			
			$this->display();
		}
	}
	/*
	 * 重置密码
	*/
	public function reset(){
		$id=$this->_get('id');
		if(!$id)	$this->error("参数错误！");
		//查询用户手机号
		$u=$this->db_user->where("uid={$id}")->find();
		//重置保持
		$data['passwd'] = md5('88888888');
		$this->db_user->where("uid={$id}")->save($data);
	
		$this->addLogs('edit', $id,"重置密码".$u['mobile']);
		$this->success("操作成功！");
	}
	/*
	 * 查看
	 */
	public function show(){
		$id=$this->_get('id');	
		if(!$id)	$this->error("参数错误！");
		$info=$this->db_user->where("uid={$id}")->find();

		$this->assign('info',$info);
		$this->display();
	}
	/*
	 * 设置类型
	*/
	public function task(){
		if (isset ( $_POST ['dosubmit'] )) {
			$uid = intval ( $this->_post ( 'uid' ) );
			if(!$uid)	$this->error("参数错误！");
			
			$data["task"] = implode("|",$_POST["task"]);
			$name = $_POST["name"];
			
			//修改类型
			$this->db_user->where("uid={$uid}")->save($data);
			$this->addLogs ( 'edit', $uid, $name."设置类型" );
			$this->success ( "操作成功！", U ( 'Fwuser/index' ) );
			
		}else{
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_user->where("uid={$id}")->find();
		
			//查看当前类型
			$task=$this->db_task->field()->select();
			if($info["task"]){
				$arr_task = explode("|", $info["task"]);
				foreach ($task as $k=>$v){
					if(in_array($v["title"],$arr_task)){
						$v["checked"] = "checked";
						$task[$k] = $v;
					}
				}
			}

			$this->assign('info',$info);
			$this->assign('task_n',$task);
			$this->display();
		}
	}
	/*
	 * 屏蔽
	 */
	public function del(){
	$id=$this->_get('id');	
	if(!$id)	$this->error("参数错误！");
	//查询用户手机号
	$u=$this->db_user->where("uid={$id}")->find();
	//屏蔽
	$data['flag'] = 1;
	$this->db_user->where("uid={$id}")->save($data);
	$this->addLogs('edit', $id,'屏蔽用户'.$u['mobile']);
	$this->success("操作成功！");
	}
	/*
	 * 查看用户酬劳详情
	*/
	public function reward(){
		$id=$this->_get('id');
		if(!$id)	$this->error("参数错误！");
		$info=$this->db_user->where("uid={$id}")->find();
	
		//积分详情
		$info_i=$this->db_reward->where("uid={$id}")->field()->order(array("time"=>"desc"))->select();
	
		$this->assign('info',$info);
		$this->assign('info_i',$info_i);
		$this->display();
	}
	/*
	 * 服务用户认证
	*/
	public function request(){
		if (isset ( $_POST ['dosubmit'] )) {
			$id           = $this->_post ( 'id' );
			$mobile       = $this->_post ( "mobile" );
			if (! $id)
				$this->error ( "参数错误！" );
			$data = $_POST ['info'];
			
			$data ['type'] = "1";
			$this->db_user->where ( "uid={$id}" )->save ( $data );
			
			$s_name = "您已成功签约为EPS服务商，请重新登录开启新旅程。";
			/*推送开始**************************************************************************************/
			//查询用户token,进行推送
			$u_t=$this->db_user->where("uid={$id}")->field("token")->find();
			$token = $u_t["token"];
			if($token){
				//用户未读条数
				$count_n = $this->db_notificationk->where("ruid='{$id}' and flag='1' and isread='0'")->count();
					
				import("Org.Jpush.Jpush_f"); //引入Jpush类文件
				$pushObj = new \Jpush_f();
				//组装需要的参数
				$receive = array('registration_id'=>array($token));
				$title = "";
				$content = $s_name;
				$m_time = '86400';//离线保留时间
				$count_n = $count_n + 1;
				$extras = array("type"=>"0","nid"=>"","not"=>$count_n,"aisle"=>"1");   //自定义数组
				//调用推送,并处理
				$result = $pushObj->push($receive,$title,$content,$extras,$m_time);
				if($result){
					$res_arr = json_decode($result, true);
					if(isset($res_arr['error']) == FALSE){   //如果返回了error则证明失败
							
					}
				}
			}
			//插入推送记录
			$data2['obj_id'] = "0";
			$data2['ruid'] = $id;
			$data2['content'] = $s_name;
			$this->db_notificationk->add($data2);
			/**************************************************************************************推送结束*/
			
			$this->addLogs ( 'edit', $id, $mobile."升级服务商" );
			$this->success ( "操作成功！", U ( 'Fwuser/index' ) );
		} else {
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_user->where("uid={$id}")->find();
			
			//省市区显示
			$province = $this->db_region->where ( array('pid'=>1) )->select ();
			$this->assign('province',$province);

			$this->assign('info',$info);
			$this->display();
		}
	}
	//打款处理
	public function dakuan(){
		if (isset ( $_POST ['dosubmit'] )) {
			$uid    = $this->_post ( 'uid' );
			$reward = $this->_post ( "reward" );
			$reward_n = $this->_post ( "reward_n" );
			$token = $this->_post ( "token" );
			if (! $uid)
				$this->error ( "参数错误！" );
			//用户金额处理
			$data1["reward"] = $reward - $reward_n;
			$this->db_user->where("uid={$uid}")->save($data1);
			//记录提现明细
			$data3["uid"] = $uid;
			$data3["contact"] = "-".$reward_n;
			$data3["remark"] = "结算";
			$this->db_reward->add($data3);
			
			$s_name = "【服务商】您有一笔 ¥".$reward_n."的服务酬劳已结算办款，请查收。";
			if($token){
				//用户未读条数
				$count_n = $this->db_notificationk->where("ruid='{$uid}' and flag='1' and isread='0'")->count();
					
				import("Org.Jpush.Jpush_f"); //引入Jpush类文件
				$pushObj = new \Jpush_f();
				//组装需要的参数
				$receive = array('registration_id'=>array($token));
				$title = "";
				$content = $s_name;
				$m_time = '86400';//离线保留时间
				$count_n = $count_n + 1;
				$extras = array("type"=>"0","nid"=>"","not"=>$count_n,"aisle"=>"1");   //自定义数组
				//调用推送,并处理
				$result = $pushObj->push($receive,$title,$content,$extras,$m_time);
				if($result){
					$res_arr = json_decode($result, true);
					if(isset($res_arr['error']) == FALSE){   //如果返回了error则证明失败
							
					}
				}
			}
			//插入推送记录
			$data['obj_id'] = "0";
			$data['ruid'] = $uid;
			$data['content'] = $s_name;
			$this->db_notificationk->add($data);
			
			$this->success("操作成功！",U ( 'Fwuser/reward',array('id'=>$uid)));
		} else {
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_user->where("uid={$id}")->find();

			$this->assign('info',$info);
			$this->display();
		}
	}
	
	//获取省市区
	public function getRegion(){
		$map['pid']=$_REQUEST["pid"];
		$map['type']=$_REQUEST["type"];
		$list=$this->db_region->where($map)->select();
		echo json_encode($list);
	}
}

?>
