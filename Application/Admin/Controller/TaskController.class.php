<?php
/*
 * 订单类型
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class TaskController extends AdminbaseController{
public $db_task;
  function _initialize() {
        parent::_initialize();
         $this->db_task=D('task');
    }
    
    /**
     * 列表
     */
	public function index(){
		$count = $this->db_task->count();
        $page = $this->page($count,60);
        $list = $this->db_task->field()->limit($page->firstRow.','.$page->listRows)->order(array("seq"=>"asc"))->select();

        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
}

?>
