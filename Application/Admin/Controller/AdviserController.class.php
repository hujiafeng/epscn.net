<?php
/*
 * 服务顾问管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class AdviserController extends AdminbaseController{
public $db_adviser;
  function _initialize() {
        parent::_initialize();
         $this->db_adviser=D('adviser');
    }
    
    /*
     * 列表
     */
	public function lists(){
		
		$where .= " 1=1 and status = 2 ";
		
		$count = $this->db_adviser->count();
        $page = $this->page($count,60);
        $list = $this->db_adviser->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("time"=>"desc"))->select();
        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 添加
	*/
	public function add(){
		if (isset ( $_POST ['dosubmit'] )) {
			$data = $_POST ['info'];
			$data["time"] = date("Y-m-d H:i:s");
			//增加记录
			$id = $this->db_adviser->add ( $data );
				
			$this->addLogs ( 'add', $id, "增加服务顾问".$data["name"] );
			$this->success ( "操作成功！", U('Adviser/lists'));
		}else{
				
			$this->display();
		}
	}
	/*
	 * 修改
	*/
	public function edit(){
		if (isset ( $_POST ['dosubmit'] )) {
			$id = intval ( $this->_post ( 'id' ) );
			if (! $id)
				$this->error ( "参数错误！" );
			
			$data = $_POST ['info'];
			//修改记录
			$this->db_adviser->where ( "id={$id}" )->save ( $data );
	
			$this->addLogs ( 'add', $id, "修改服务顾问".$data["name"] );
			$this->success ( "操作成功！", U('Adviser/lists'));
		}else{
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info = $this->db_adviser->where ( array('id'=>$id) )->find ();
			
			$this->assign('info',$info);
			$this->display();
		}
	}
	/*
	 * 已读
	 */
	public function del(){
	$id=$this->_get('id');
	$data['status'] = "-2";
	if(!$id)	$this->error("参数错误！");
	$this->db_adviser->where("id={$id}")->save($data);	
	$this->success("操作成功！",U('Adviser/lists'));
	}
	
	
	
}

?>
