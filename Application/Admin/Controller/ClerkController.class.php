<?php
/*
 * 业绩管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class ClerkController extends AdminbaseController{
public $db_user;
public $db_need;
public $db_clerk;
  function _initialize() {
        parent::_initialize();
         $this->db_user=D('user');
         $this->db_need=D('need');
         $this->db_clerk=D('clerk');
    }
    
    /*
     * 业务员列表
     */
	public function lists(){
		$where .= " 1=1";
		
		$count = $this->db_clerk->count();
        $page = $this->page($count,60);
        $list = $this->db_clerk->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("time"=>"desc"))->select();
        foreach($list as $k=>$v){
        	//需求方未完订单数
        	$v["count_clerk_x"] = $this->db_need->where("clerk_x={$v['id']} and status < 16")->count();
        	//服务方未完订单数
        	$v["count_clerk_f"] = $this->db_need->where("clerk_f={$v['id']} and reward_time = ''")->count();
        	
        	$list[$k] = $v;
        }
        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 添加业务员
	*/
	public function add(){
		if (isset ( $_POST ['dosubmit'] )) {
			$data = $_POST ['info'];
			$data["time"] = date("Y-m-d H:i:s");
			//增加记录
			$id = $this->db_clerk->add ( $data );
				
			$this->addLogs ( 'add', $id, "添加业务员".$data["name"] );
			$this->success ( "操作成功！", U('Clerk/lists'));
		}else{
				
			$this->display();
		}
	}
	/*
	 * 修改业务员
	*/
	public function edit(){
		if (isset ( $_POST ['dosubmit'] )) {
			$id = intval ( $this->_post ( 'id' ) );
			if (! $id)
				$this->error ( "参数错误！" );
			
			$data = $_POST ['info'];
			//修改记录
			$this->db_clerk->where ( "id={$id}" )->save ( $data );
	
			$this->addLogs ( 'add', $id, "修改业务员".$data["name"] );
			$this->success ( "操作成功！", U('Clerk/lists'));
		}else{
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info = $this->db_clerk->where ( array('id'=>$id) )->find ();
			
			$this->assign('info',$info);
			$this->display();
		}
	}
	/*
	 * 业绩列表
	 */
	public function performance(){
		$where = " n.status=16 ";
		//搜索
		$clerk      = $this->_get ( "clerk" );
		$start_time = $this->_get('start_time');
		$end_time   = $this->_get('end_time');
		
		if ($clerk) {
			$where .= " and n.clerk_x = $clerk ";
		}
		if ($start_time) {
			$where .= " and n.pay_time >= '$start_time' ";
		}
		if ($end_time) {
			$where .= " and n.pay_time <= '$end_time' ";
		}
		
		$count = M()->table('d_need n')->join('d_clerk c on n.clerk_x = c.id')->where($where)->count();
		$page = $this->page($count,20);
		$list = M()->table('d_need n')->join('d_clerk c on n.clerk_x = c.id')->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("n.time"=>"desc"))->field ("n.id,n.no,n.uid_x,n.reward,n.time,n.pay_time,c.name")->select();
		foreach($list as $k=>$v){
			//查询发布用户信息
			$u=$this->db_user->where("uid={$v['uid_x']}")->field("mobile,khdw")->select();
			$v['mobile'] = $u[0]["mobile"];
			$v['khdw'] = $u[0]["khdw"];
			
			$list[$k] = $v;
		}
        //业务员列表
        $clerk=$this->db_clerk->where("status=2")->field("id,name")->select();

        //当前总计
		$sum = M()->table('d_need n')->join('d_clerk c on n.clerk_x = c.id')->where($where)->field("sum(reward) as sum_reward")->find();
		$sum_reward = $sum["sum_reward"];

		$this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->assign('clerk',$clerk);
		$this->assign('sum_reward',$sum_reward);
		$this->display();
	}
	/*
	 * 业绩列表-服务端
	*/
	public function performance_f(){
		$where = " n.reward_time != '' ";
		//搜索
		$clerk      = $this->_get ( "clerk" );
		$start_time = $this->_get('start_time');
		$end_time   = $this->_get('end_time');
	
		if ($clerk) {
			$where .= " and n.clerk_f = $clerk ";
		}
		if ($start_time) {
			$where .= " and n.reward_time >= '$start_time' ";
		}
		if ($end_time) {
			$where .= " and n.reward_time <= '$end_time' ";
		}
	
		$count = M()->table('d_need n')->join('d_clerk c on n.clerk_f = c.id')->where($where)->count();
		$page = $this->page($count,20);
		$list = M()->table('d_need n')->join('d_clerk c on n.clerk_f = c.id')->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("n.time"=>"desc"))->field ("n.id,n.no,n.uid_f,n.get_reward,n.time,n.reward_time,c.name")->select();
		foreach($list as $k=>$v){
			//查询发布用户信息
			$u=$this->db_user->where("uid={$v['uid_f']}")->field("mobile,company")->select();
			$v['mobile'] = $u[0]["mobile"];
			$v['company'] = $u[0]["company"];
				
			$list[$k] = $v;
		}
		//业务员列表
		$clerk=$this->db_clerk->where("status=2")->field("id,name")->select();
		
		//当前总计
		$sum = M()->table('d_need n')->join('d_clerk c on n.clerk_f = c.id')->where($where)->field("sum(get_reward) as sum_reward")->find();
		$sum_reward = $sum["sum_reward"];

		$this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->assign('clerk',$clerk);
		$this->assign('sum_reward',$sum_reward);
		$this->display();
	}
	
	
	
}

?>
