<?php
/*
 * 意见反馈
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class YijianController extends AdminbaseController{
public $db_yijian;
  function _initialize() {
        parent::_initialize();
         $this->db_yijian=D('feedback');
    }
    
    /**
     * 列表
     */
	public function index(){
		$count = $this->db_yijian->count();
        $page = $this->page($count,60);
        $list = $this->db_yijian->limit($page->firstRow.','.$page->listRows)->order(array("read"=>"desc","submit_time"=>"desc"))->select();
        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 已读
	 */
	public function del(){
	$id=$this->_get('id');
	$data['read'] = "-2";
	if(!$id)	$this->error("参数错误！");
	$this->db_yijian->where("id={$id}")->save($data);	
	$this->success("操作成功！",U('Yijian/index'));
	}
	
	
	
}

?>
