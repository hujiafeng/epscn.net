<?php
/*
 * 结算酬劳
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class RebateController extends AdminbaseController{
public $db_rebate;
public $db_user;
public $db_notificationk;
public $db_reward;
  function _initialize() {
        parent::_initialize();
         $this->db_rebate=D('rebate');
         $this->db_user=D('user');
         $this->db_notificationk=D('notification');
         $this->db_reward=D('reward');
    }
    
    /**
     * 列表
     */
	public function index(){
		$count = $this->db_rebate->count();
        $page = $this->page($count,60);
        $list = $this->db_rebate->limit($page->firstRow.','.$page->listRows)->order(array("read"=>"desc","submit_time"=>"desc"))->select();
        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 已处理
	 */
	public function del(){
	$id=$this->_get('id');
	$uid=$this->_get('uid');
	$reward=$this->_get('reward');

	$s_name = "提现金额（".$reward."元）已转入您的收款账户。";
	//查询用户token,进行推送
	$u_t=$this->db_user->where("uid={$uid}")->field("token,freeze")->select();
	$token = $u_t[0]["token"];
	if($token){
		import("Org.Jpush.Jpush_f"); //引入Jpush类文件
		$pushObj_f = new \Jpush_f();
		//用户未读条数
		$count_n = $this->db_notificationk->where("ruid='{$uid}' and source='2' and flag='1' and isread='0'")->count();
		//组装需要的参数
		$receive = array('registration_id'=>array($token));
		$title = "";
		$content = $s_name;
		$m_time = '86400';        //离线保留时间
		$count_n = $count_n + 1;
		$extras = array("type"=>"0","nid"=>"","not"=>$count_n);   //自定义数组
		//调用推送,并处理
		$result = $pushObj_f->push($receive,$title,$content,$extras,$m_time);
	}
	//插入推送记录
	$data['obj_id'] = "0";
	$data['ruid'] = $uid;
	$data['content'] = $s_name;
	$data['source'] = 2;
	$this->db_notificationk->add($data);

	//申请提现信息已处理
	$data1['read'] = "-2";
	if(!$id)	$this->error("参数错误！");
	$this->db_rebate->where("id={$id}")->save($data1);
	
	//用户冻结金额处理
	$data2["freeze"] = $u_t[0]["freeze"] - $reward;
	$this->db_user->where("uid={$uid}")->save($data2);
	
	//记录提现明细
	$data3["uid"] = $uid;
	$data3["contact"] = "-".$reward;
	$data3["remark"] = "提现";
	$this->db_reward->add($data3);
	
	$this->success("操作成功！",U('Rebate/index'));
	}
	
	
	
}

?>
