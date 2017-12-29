<?php

namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Tree;
class DepartmentController extends AdminbaseController {


	/**
	* @access private
	*/

    protected $Department;

    function _initialize() {
        parent::_initialize();
        $this->Department = D("Department");
        $Departmentlistarray= $this->Departmentlistarray();
       
        $this->assign("data", $Departmentlistarray);
    }
    
    
 /**
     *  使用拼装的方式，显示关系
     * @param $type 类型
     */
    public function Departmentlistarray() {
        //顶级导航
     
        $Med = $this->Department->where(array("parentid" => 0))->order(array("listorder"=>"asc","id"=>"desc"))->select();
        if(empty ($Med)){
            return ;
        }
        
        foreach ($Med as $key => $value) {
            $Med[$key]['lower'] = $this->MenuSet($value['id']);
        }
        foreach ($Med as $key => $value) {
            $data[$value['id']] = $value;
        }
		
      
        return $data;
    }
    /**
     * 根据菜单id 取得该菜单子菜单
     * @param int $id 菜单ID
     * @return array 数组
     */
    public function MenuSet($id){
        $da = $this->Department->where(array("parentid" => (int)$id))->order("listorder asc")->select();
        foreach ($da as $key => $value) {
            $data[$value['id']] = $value;
			$data[$value['id']]['lower'] = $this->MenuSet($value['id']);
        }
        return $data;
    }


    /**
     *  显示菜单
     */
    public function index() {
        //import('@.ORG.Util.Tree');
        $Tree = new Tree();
        $Tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$Tree->nbsp = '&nbsp;&nbsp;&nbsp;';
    	$where=array();
    	$Form = M('department');
    	$array= $Form->where($where)->select();
    
    	foreach($array as $k=>$v){
    		$add=U("Department/add",array("parentid"=>$v['id']));
    		$edit=U("Department/edit",array("id"=>$v['id']));
    		$del=U("Department/delete",array("id"=>$v['id']));
    	$v['str_manage'] = "<a href=\"$add\">添加子部门</a> | <a href=\"$edit\">修改</a> | <a href=\"$del\" onclick=\"Menudelete(this);return false;\">删除</a>";
    	if($v['level']==3){
    		$v['str_manage'] = "<font color='#999999'>添加子部门</font> | <a href=\"$edit\">修改</a> | <a href=\"$del\" onclick=\"Menudelete(this);return false;\">删除</a>";	
    		}
    	$array2[$v['id']]=	$v;
    	
    	}
    	$array=$array2;
    
    	$str  = "<tr>
					<td align='center'><input name='listorders[\$id]' type='text' size='3' value='' style= 'border:0px;width:3px;' class='input input-order'></td>
					<td align='center'>\$id</td>
					<td >\$spacer\$name</td>
					<td >\$codesn</td>
					<td >\$address</td>
					<td align='center'>\$str_manage</td>
				</tr>";
		$Tree->init($array);
		$categorys = $Tree->get_tree(0, $str);
    	$this->assign("categorys", $categorys);
        $this->display();
  

    }

 

    /**
     *  添加
     */
    public function add() {
     if(isset($_POST['dosubmit'])){
       $date=array();
       $Form = M('Department');
    	if($_POST['parentid']){
    	$one = $Form->getById($_POST['parentid']); 
        $date['level']=$one['level']+1;
    	}
   
       $date['parentid']=$_POST['parentid'];
       $date['codesn']=$_POST['codesn'];
       $date['address']=$_POST['address'];
       $date['type']=$_POST['type'];
       $date['name']=$_POST['name'];
       $date['addtime']=time();
     $date['listorder']=0;
      if(!$date['name'])$this->error("单位名称不能为空");
      	$status =	 $Form->add($date);
        if ($status) {
            $this->success("添加成功！");
        } else {
            $this->error("添加失败");
        }
     }else{
     	
     	       $this->display();
     }
 
    }
    
    /**
     *  删除
     */
    public function delete() {
        $count = $this->Department->where(array("parentid" => (int) $_GET['id']))->count();
        if ($count > 0) {
            $this->error("该菜单下还有子菜单，无法删除！");
        }
        $staus = parent::delete($this->Department);
        if ($staus) {
            $this->success("删除菜单成功！");
        } else {
            $this->error($this->Department->getError());
        }
    }

    /**
     *  编辑
     */
    public function edit() {
    	if(isset($_POST['dosubmit'])){
    	$date=array();
    	$Form = M('Department');
    	if($_POST['parentid']){
    	$one = $Form->getById($_POST['parentid']); 
        $date['level']=$one['level']+1;
    	}
		$date['parentid']=$_POST['parentid'];
       $date['codesn']=$_POST['codesn'];
       $date['address']=$_POST['address'];
       $date['type']=$_POST['type'];
       $date['name']=$_POST['name'];
        $date['addtime']=time();
      if(!$date['name'])$this->error("单位名称不能为空");
      $staus=$Form->where(array('id' => $_POST['id']))->save($date);
    	 if ($staus) {
            $this->success("修改成功！");
        } else {
            $this->error('操作失败');
        }	
    	}else{
        $id = (int) $_GET['id'];
        $info=$this->Department->where("id={$id}")->find();

        if(!$info)$this->error('操作失败');
        $this->assign('info', $info);
        $this->display();
		}
    }

    public function listorders() {
        $status = parent::listorders($this->Department);
        if ($status) {
            $this->Department->Menucache();
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

}

?>