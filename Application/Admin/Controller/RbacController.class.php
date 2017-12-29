<?php

namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Tree;
class RbacController extends AdminbaseController {

    protected $User, $Role, $Access, $Node, $Role_user;

    function _initialize() {
        parent::_initialize();
        $this->Role = D("fxrole");
  
        $this->Admin_role_priv = D("fxadmin_role_priv");
		$this->Menu = D("fxmenu");
    }

    /**
     * 角色管理，有add添加，edit编辑，delete删除
     */
    public function rolemanage() {
        $data = $this->Role->order(array("listorder" => "asc", "id" => "desc"))->select();
        
        $this->assign("data", $data);
        $this->display();
    }

    /**
     * 添加角色
     */
    public function roleadd() {
        if ($this->isPost()) {
            if ($this->Role->create()) {
                if ($this->Role->add()) {
                    $jumpUrl = U("Rbac/rolemanage");
                    $this->assign("jumpUrl", $jumpUrl);
                    $this->success("添加角色成功！");
                } else {
                    $this->error("添加失败！");
                }
            } else {
                $this->error($this->Role->getError());
            }
        } else {
            $this->display();
        }
    }

    /**
     * 删除角色
     */
    public function roledelete() {
        $id = (int) $this->_get("id");
        if ($id == 1) {
            $this->error("超级管理员角色不能被删除！");
        }
        $status = $this->delete($this->Role);
        if ($status) {
            $this->assign("jumpUrl", U('Rbac/rolemanage'));
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 编辑角色
     */
    public function roleedit() {
        $id = (int) $this->_get("id");
        if ($id == 0) {
            $id = (int) $this->_post("id");
        }
        if ($id == 1) {
            $this->error("超级管理员角色不能被修改！");
        }
        if ($this->isPost()) {
            $status = $this->updata($this->Role);
            if ($status) {
                $this->assign("jumpUrl", U('Rbac/rolemanage'));
                $this->success("修改成功！");
                exit;
            } else {
                $this->error($this->Role->getError());
            }
        }
        $data = $this->edit($this->Role);
        if ($data == false) {
            $this->error("该角色不存在！");
        }
        $this->assign("data", $data);
        $this->display();
    }

    /**
     * 角色授权
     */
    public function authorize() {
        if ($this->isPost()) {
			
            //角色ID
            $roid = $this->_post("roid");
            $aids = $_POST[aid];
			
			$this->Admin_role_priv->where(array("roleid"=>$roid))->delete();
			
			foreach($aids as $rid){
				$one = $this->Menu->where(" id = '$rid' ")->find();
				$this->Admin_role_priv->roleid = $roid;
				$this->Admin_role_priv->app    = $one['app'];
				$this->Admin_role_priv->model  = $one['model'];
				$this->Admin_role_priv->action = $one['action'];
				$this->Admin_role_priv->data   = $one['data'];
				$this->Admin_role_priv->add();
			}
			    $this->assign("jumpUrl", U('Rbac/rolemanage'));
                $this->success("权限设置成功！");
                exit; 
			
        } else {
            $roid = $this->_get("id");
            if (empty($roid)) {
                $this->error("参数不正确！");
            }
            $this->assign("roid", $roid);
			
			
                $Tree = new Tree();
				$Tree->icon = array('│ ','├─ ','└─ ');
				$Tree->nbsp = '&nbsp;&nbsp;&nbsp;';
				
				$result = $this->Menu->select();
				foreach ($result as $n=>$t) {
					$result[$n]['checked'] = (D('fxadmin_role_priv')->where(array("roleid"=>$roid,'app'=>$t['app'],'model'=>$t['model'],'action'=>$t['action']))->find())? ' checked' : '';
					$result[$n]['level']   =  $t['level'];
					$result[$n]['parentid_node'] = ($t['parentid'])? ' class="child-of-node-'.$t['parentid'].'"' : '';
				}
				
				$str  = "<tr id='node-\$id' \$parentid_node>
				           <td style='padding-left:30px;'>\$spacer<input type='checkbox' name='aid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td><td>\$app</td><td>\$model</td><td>\$action</td>
						</tr>";
			
				$Tree->init($result);
				$categorys = $Tree->get_tree(0, $str);
			    $this->assign("categorys", $categorys);
			
			
                 $this->display();
        }
    }

    public function listorders() {
        $status = parent::listorders($this->Role);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

}

?>
