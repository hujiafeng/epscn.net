<?php
namespace Admin\Controller;
use Appframe\AdminbaseController;
class ManagementController extends AdminbaseController{
    protected $UserMod;
    
    function _initialize(){
        parent::_initialize();
        $this->UserMod = D("fxuser");
    }
    
    /**
     * 管理员列表
     */
    public function manager(){
        $role_id = $this->_get("role_id");
        $UserView = D("Fxuser");
        if(empty($role_id)){
            $count = $UserView->count();
            $page = $this->page($count,20);
            $User = $UserView->limit($page->firstRow.','.$page->listRows)->select();
        }else{
            $count = $UserView->where(array("role_id"=>$role_id))->count();
            $page = $this->page($count,20);
            $User = $UserView->limit($page->firstRow.','.$page->listRows)->where(array("role_id"=>$role_id))->select();
        }
        foreach($User as $k=>$v){
        	if($v['departmentid'])$User[$k]['departmentname']=M('department')->where("id={$v['departmentid']}")->getField('name');
        	if($v['role_id'])$User[$k]['role_name']=M('fxrole')->where("id={$v['role_id']}")->getField('name');
        }
   
        $this->assign("Userlist",$User);
        $this->assign("Page",$page->show('Admin'));
        $this->display();
    }
    
    /**
     * 编辑信息
     */
    public function edit() {
    	 $this->Department = D("Department");
        $Departmentlistarray= $this->Departmentlistarray();
        $this->assign("datalist", $Departmentlistarray);
        $id = (int)$this->_get("id")==0?(int)$this->_post("id"):(int)$this->_get("id");
		
        if($id<1){
            $this->error("信息有误！");
        }
        if($id==1){
            $this->error("该帐号不支持非本人修改！");
        }
        //判断是否修改本人，在此方法，不能修改本人相关信息
         if($this->Cache['uid'] == $id){
            $this->error("操作非法！");
        }
		
        if($this->isPost()){
            $role_id = (int)$this->_post("role_id");
            if($this->_post("password") != $this->_post("pwdconfirm")){
                $this->error("两次输入的密码不一样！");
            }
            $data = $this->UserMod->create();
            if ($data) {
                $r = $this->UserMod->where(array("id"=>$data['id']))->getField('id,verify');
                $password = $this->_post("password");
                if(!empty($password)){
                    $pass =$this->UserMod->encryption($id,$this->_post("password"),$r[$data['id']]);
                    $data = array_merge($data,array("password"=>$pass));
                }else{
                    unset ($data['password']);
                }
				
				
               	$data['departmentid']=$this->_post('departmentid');
				
                 if ($this->UserMod->save($data)) {
                     M("fxrole_user")->where(array("user_id"=>$id))->save(array("role_id"=>$role_id,"user_id"=>$id));
                     $jumpUrl = U("Management/manager");
                     $this->assign("jumpUrl",$jumpUrl);
                     $this->success("更新成功！");
                 }else{
                     $this->error("更新失败！");
                 }
            }else{
                $this->error($this->UserMod->getError());
            }
        }else{
			
			
		
            $data = $this->UserMod->where(array("id"=>$id))->find();
            $role = M("fxrole")->select();
            $this->assign("role",$role);
            $this->assign("data",$data);
		
	
		
            $this->display();
		
        }
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
     * 添加管理员
     */
    public function adminadd(){
    	 $this->Department = D("Department");
        $Departmentlistarray= $this->Departmentlistarray();
        $this->assign("data", $Departmentlistarray);
        if($this->isPost()){
            $data = $this->UserMod->create();
			$data['departmentid']=$this->_post('departmentid');
            if($data){
                //生成随机认证码
                $data['verify'] = create_randomstr(6);
                //利用认证码和明文密码加密得到加密后的
                $data['password'] = $this->UserMod->encryption(0,$data['password'],$data['verify']);
                $id = $this->UserMod->add($data);
      

                if($id){
                    $role_id = $this->_post("role_id");
                    M("fxrole_user")->add(array("role_id"=>$role_id,"user_id"=>$id));
                    $this->assign("jumpUrl", U('Management/manager'));
                    $this->success("添加管理员成功！");
                }else{
                    $this->error("添加管理员失败！");
                }
            }else{
                $this->error($this->UserMod->getError());
            }
        }else{
            $data = M("fxrole")->select();
            $this->assign("role",$data);
			
			
            $this->display();
        }
    }
    
    /**
     *管理员删除
     */
    public function delete(){
        $id = $this->_get("id");
        if(empty($id)){
            $this->error("没有指定删除对象！");
        }
        if((int)$id==1){
            $this->error("该管理员不能被删除！");
        }
        if((int)$id==$this->Cache["uid"]){
            $this->error("你不能删除你自己！");
        }
        $status = parent::delete($this->UserMod);
        if($status){
            //M("Role_user")->where(array("user_id"=>$id))->delete();
            $this->assign("jumpUrl",U("Management/manager"));
            $this->success("删除成功！");
            exit;
        }else{
            $this->error("删除失败！");
        }
    }
    
    public function create_randomstr($lenth = 6) {
    	return $this->random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
    }
    
    
    function random($length, $chars = '0123456789') {
    	$hash = '';
    	$max = strlen($chars) - 1;
    	for($i = 0; $i < $length; $i++) {
    		$hash .= $chars[mt_rand(0, $max)];
    	}
    	return $hash;
    }
    
    /**
     * 对明文密码，进行加密，返回加密后的密码
     * @param $identifier 为数字时，表示uid，其他为用户名
     * @param type $pass 明文密码，不能为空
     * @return type 返回加密后的密码
     */
    public function encryption($identifier,$pass,$verify=""){
    	$v = array();
    	if(is_numeric($identifier)){
    		$v["id"] = $identifier;
    	}else{
    		$v["username"] = $identifier;
    	}
    	$pass = md5($pass.md5($verify));
    	return $pass;
    }
}
?>
