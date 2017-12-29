<?php

namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Tree;
class MenuController extends AdminbaseController {


	/**
	* @access private
	*/

    protected $Menu;

    function _initialize() {
        parent::_initialize();
        $this->Menu = D("Fxmenu");
        $Menucache= D("Fxmenu")->Menulistarray();
       
        $this->assign("Menucache", $Menucache);
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
    	$Form = M('Fxmenu');
    	$array= $Form->where($where)->select();
    	foreach($array as $k=>$v){
    		$add=U("Menu/add",array("parentid"=>$v['id']));
    		$edit=U("Menu/edit",array("id"=>$v['id']));
    		$del=U("Menu/delete",array("id"=>$v['id']));
    	$v['str_manage'] = "<a href=\"$add\">添加子菜单</a> | <a href=\"$edit\">修改</a> | <a href=\"$del\" onclick=\"Menudelete(this);return false;\">删除</a>";
    	if($v['level']==3){
    		$v['str_manage'] = "<font color='#999999'>添加子菜单</font> | <a href=\"$edit\">修改</a> | <a href=\"$del\" onclick=\"Menudelete(this);return false;\">删除</a>";	
    		}
    	$array2[$v['id']]=	$v;
    	
    	}
    	$array=$array2;
    
    	$str  = "<tr>
					<td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input input-order'></td>
					<td align='center'>\$id</td>
					<td >\$spacer\$name</td>
					<td align='center'>\$str_manage</td>
				</tr>";
		$Tree->init($array);
		$categorys = $Tree->get_tree(0, $str);
    	$this->assign("categorys", $categorys);
        $this->display();
  

    }

    /**
     * 显示菜单导航
     */
    public function public_current_pos() {
        $parentid = $this->_get("parentid");
        import('@.ORG.Util.Tree');
        $Tree = new Tree();
        $data = array();
        $Tree->arr = $this->Cache['eMenu'];
        $categorys = $Tree->get_pos($parentid);
        foreach($categorys as $k=>$v){
            $html[] = $v['name'];
        }
        echo implode(">", $html);
    }

    /**
     *  添加
     */
    public function add() {
     if(isset($_POST['dosubmit'])){
       $Menu=D('Fxmenu');
       $date=array();
       $Form = M('Fxmenu');
    	if($_POST['parentid']){
    	$one = $Form->getById($_POST['parentid']); 
        $date['level']=$one['level']+1;
    	}
    	$where=array();
    	$where['app']=$_POST['app'];
    	$where['model']=$_POST['model'];
    	$where['action']=$_POST['action'];
    $is_one = $Form->where($where)->select();
    if($is_one)$this->error("项目,模块,方法 数据库已经存在");
       $date['parentid']=$_POST['parentid'];
       $date['app']=$_POST['app'];
       $date['model']=$_POST['model'];
       $date['action']=$_POST['action'];
       $date['status']=$_POST['status'];
       $date['name']=$_POST['name'];
     $date['remark']=$_POST['remark'];
     $date['listorder']=0;
      if(!$date['name'])$this->error("名称不能为空");
     if(!$date['model'])$this->error("模块不能为空");
     if(!$date['action'])$this->error("方法不能为空");
       if($Menu->create()){
		$status =	 $Menu->add($date);
       }
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
        $count = $this->Menu->where(array("parentid" => (int) $_GET['id']))->count();
        if ($count > 0) {
            $this->error("该菜单下还有子菜单，无法删除！");
        }
        $staus = parent::delete($this->Menu);
        if ($staus) {
            $this->success("删除菜单成功！");
        } else {
            $this->error($this->Menu->getError());
        }
    }

    /**
     *  编辑
     */
    public function edit() {
    	if(isset($_POST['dosubmit'])){
    	$date=array();
    	$Form = M('Fxmenu');
    	if($_POST['parentid']){
    	$one = $Form->getById($_POST['parentid']); 
        $date['level']=$one['level']+1;
    	}
		$where = " app = '$_POST[app]' and model = '$_POST[model]' and action = '$_POST[action]' and id != '$_POST[id]' ";
		
    $is_one = $Form->where($where)->find();
    if($is_one)$this->error("项目,模块,方法 数据库已经存在");
       $date['parentid']=$_POST['parentid'];
       $date['app']=$_POST['app'];
       $date['model']=$_POST['model'];
       $date['action']=$_POST['action'];
       $date['status']=$_POST['status'];
       $date['name']=$_POST['name'];
     $date['remark']=$_POST['remark'];
      if(!$date['name'])$this->error("名称不能为空");
     if(!$date['model'])$this->error("模块不能为空");
     if(!$date['action'])$this->error("方法不能为空");
      $staus=$Form->where(array('id' => $_POST['id']))->save($date);
    	 if ($staus) {
            $this->success("修改菜单成功！");
        } else {
            $this->error('操作失败');
        }	
    	}else{
        $id = (int) $_GET['id'];
        $pk = ucfirst($this->Menu->getPk()); //取得主键
        $do = 'getBy' . $pk;
        $vo = $this->Menu->$do($id); //TP 5.3.12
        $this->assign('Menudata', $vo);
        $this->display();
		}
    }

    public function listorders() {
        $status = parent::listorders($this->Menu);
        if ($status) {
            $this->Menu->Menucache();
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

}

?>