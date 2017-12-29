<?php
/**菜单 
*/
namespace Admin\Model;
use Admin\Model\CommonModel;
class FxmenuModel extends CommonModel {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '菜单名称不能为空！', 1, 'regex', 3),
        array('app', 'require', '应用不能为空！', 1, 'regex', 3),
        array('model', 'require', '模块名称不能为空！', 1, 'regex', 3),
        array('action', 'require', '方法名称不能为空！', 1, 'regex', 3),
    );
    //自动完成
    protected $_auto = array(
        //array(填充字段,填充内容,填充条件,附加规则)
        array("mode","index"),
        array("data","checkData_unserialize",3,"callback"),
    );
    //字段映射
    protected $_map = array(
            //'name'      =>'username',
    );
    //关联定义 5.3.22
    protected $_link = array(
    );

    /**
     *  使用拼装的方式，显示菜单关系
     * @param $type 类型
     */
    public function Menulistarray() {
        //顶级导航
     
        $Med = $this->where(array("parentid" => 0))->order(array("listorder"=>"asc","id"=>"desc"))->select();
        if(empty ($Med)){
            return ;
        }
        
        foreach ($Med as $key => $value) {
            $Med[$key]['lower'] = $this->MenuSet($value['id']);
        }
        foreach ($Med as $key => $value) {
            $data[$value['id']] = $value;
        }
		
        //生成缓存
        $this->Menucache($data);
        return $data;
    }
    /**
     * 根据菜单id 取得该菜单子菜单
     * @param int $id 菜单ID
     * @return array 数组
     */
    public function MenuSet($id){
        $da = $this->where(array("parentid" => (int)$id))->order("listorder asc")->select();
        foreach ($da as $key => $value) {
            $data[$value['id']] = $value;
			$data[$value['id']]['lower'] = $this->MenuSet($value['id']);
        }
        return $data;
    }
	
	
	
	public function roles_menu($roid,$id=0){
		$da = $this->where(array("parentid" => (int)$id,'status'=>1))->order("listorder asc")->select();
        foreach ($da as $key => $value) {
            $data[$value['id']] = $value;
			if($roid == '1'){
				   $data[$value['id']]['lower'] = $this->roles_menu($roid,$value['id']);
			}else{
				  if(D('fxadmin_role_priv')->where(array("roleid"=>$roid,'app'=>$value['app'],'model'=>$value['model'],'action'=>$value['action']))->find()){
					  $data[$value['id']]['lower'] = $this->roles_menu($roid,$value['id']);
				  }else{
					  unset($data[$value['id']]);
				  }
			}
        }
        return $data;
		
	}
	
	
	
    
    public function Menucache($data=null){
        if(empty($data)){
            F("Menu",$this->Menulistarray());
        }else{
            F("Menu",$data);
        }
        return  F("Menu");
    }
    
    /**
     *  参数转换 can=can1&can2=can2 转换为Array()
     */
    public function checkData($data){
        if(empty($data)){
            return array();
        }
        $data = explode("&", $data);
        foreach($data as $k=>$v){
            $da = explode("=", $v);
            $reda[$da[0]] = $da[1];
        }
        return $reda;
    }
    
    /**
     *  参数转换，从Array转换为URL形式参数字符
     */
    public function ArrayDataMenu($data=array()){
        foreach($data as $k=>$v){
            $url[].=$k."=".$v;
        }
        return implode("&",$url);
    }
    
    //自动完成，参数处理，返回序列化后的字符串
    public function checkData_unserialize($data){
        if(empty($data)){
            return "";
        }
        return serialize($this->checkData($data));
    }
    
    //把序列化的字符串，用unserialize还原
    public function Data_unserialize($data){
        if(empty ($data)){
            return false;
        }
        return unserialize($data);
    }
}

?>