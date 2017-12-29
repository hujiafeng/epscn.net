<?php
/*
 * 工作模式
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class GongzuoController extends AdminbaseController{
public $db_work;
  function _initialize() {
        parent::_initialize();
         $this->db_work=D('work_mode');
    }
    
    /**
     * 列表
     */
	public function lists(){
		$count = $this->db_work->count();
        $page = $this->page($count,60);
        $list = $this->db_work->limit($page->firstRow.','.$page->listRows)->order(array("type"=>"asc","days"=>"asc"))->select();
        foreach($list as $k=>$v){
	        if($v['type'] == "1"){
		    	$v['type_name'] = "个人";
		    }else{
		    	$v['type_name'] = "企业";
		    }
		    $list[$k] = $v;
        }
        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	
	/*
	 * 添加
	 */
	public function add(){
		if(isset($_POST['dosubmit'])){
			$data=array();
			$data = $_POST ['info'];
			$id=$this->db_work->add($data);
			$this->addLogs('index', $id,'添加工作模式');
			$this->success("操作成功！",U('Gongzuo/lists'));
		}else{	
			$this->display();
		}	
	}
	
	/*
	 * 修改
	 */
	public function edit(){
	if(isset($_POST['dosubmit'])){
	$id=$this->_post('id');
	if(!$id)	$this->error("参数错误！");
	
	$data=array();
	$data = $_POST ['info'];
	$this->db_work->where("id={$id}")->save($data);
	$this->addLogs('edit', $id,'修改工作模式');
	$this->success("操作成功！",U('Gongzuo/lists'));
	}else{
	$id=$this->_get('id');	
	if(!$id)	$this->error("参数错误！");
	$info=$this->db_work->where("id={$id}")->find();
	$this->assign('info',$info);
	$this->display();
	}	
	}
	/*
	 * 删除
	 */
	public function del(){
	$id=$this->_get('id');	
	if(!$id)	$this->error("参数错误！");
	$this->db_work->where("id={$id}")->delete();	
	$this->addLogs('del', $id,'删除工作模式');
	$this->success("删除操作成功！",U('Gongzuo/lists'));
	}
	
	
	
}

?>
