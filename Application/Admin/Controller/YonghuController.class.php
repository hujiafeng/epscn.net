<?php
/*
 * 用户管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class YonghuController extends AdminbaseController{
public $db_user;
public $db_task;
public $db_reward;
public $db_notificationk;
public $db_region;
public $db_clerk;
  function _initialize() {
        parent::_initialize();
         $this->db_user=D('user');
         $this->db_task=D('task');
         $this->db_reward=D('reward');
         $this->db_notificationk=D('notification');
         $this->db_region=D('region');
         $this->db_clerk=D('clerk');
    }
    /*
     * 服务用户列表
    */
    public function lists(){
    	$type = array("0"=>"普通用户","1"=>"服务商");
    	//搜索
    	$title = trim ( $this->_get ( "title" ) );
    	$where = "1=1";
    	if ($title) {
    		$where .= " and (mobile LIKE '%$title%' OR name LIKE '%$title%' OR city LIKE '%$title%') ";
    	}
    	$count = $this->db_user->where($where)->count();
    	$page = $this->page($count,60);
    	$list = $this->db_user->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("reg_time"=>"desc"))->select();
    	foreach($list as $k=>$v){
    		$v['type_name'] = $type[$v['type']];
    		//查询需求方业务员
    		$clerk_x=$this->db_clerk->where("id={$v['clerk_x']}")->find();
    		$v["clerk_x_name"] = $clerk_x["name"];
    		//查询服务方业务员
    		$clerk_f=$this->db_clerk->where("id={$v['clerk_f']}")->find();
    		$v["clerk_f_name"] = $clerk_f["name"];
    
    		$list[$k] = $v;
    	}
    	$this->assign("Page",$page->show('Admin'));
    	$this->assign('list',$list);
    	$this->display();
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
		if (isset ( $_POST ['dosubmit'] )) {
			$uid    = $this->_post ( 'uid' );
			$data = $_POST["info"];
			if (! $uid)
				$this->error ( "参数错误！" );
			$this->db_user->where("uid={$uid}")->save($data);
			
			$this->addLogs ( 'edit', $uid, "修改客户单位" );
			$this->success ( "操作成功！", U ( 'Yonghu/lists' ) );
		}else{
			$id=$this->_get('id');	
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_user->where("uid={$id}")->find();
	
			$this->assign('info',$info);
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
	 * 解绑业务员
	*/
	public function clerk(){
		if (isset ( $_POST ['dosubmit'] )) {
			$uid    = $this->_post ( 'uid' );
			$data = $_POST["info"];
			if (! $uid)
				$this->error ( "参数错误！" );
			$this->db_user->where("uid={$uid}")->save($data);
				
			$this->addLogs ( 'edit', $uid, "解绑业务员" );
			$this->success ( "操作成功！", U ( 'Yonghu/lists' ) );
		}else{
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_user->where("uid={$id}")->find();
			//查询业务员
			$clerk=$this->db_clerk->where("status=2")->field()->select();
	
			$this->assign('info',$info);
			$this->assign('clerk_x',$info["clerk_x"]);
			$this->assign('clerk_f',$info["clerk_f"]);
			$this->assign('clerk',$clerk);
			$this->display();
		}
	}

}

?>
