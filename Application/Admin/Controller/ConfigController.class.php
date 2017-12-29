<?php

namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Input;
class ConfigController extends AdminbaseController {

    protected $site_config,$user_config,$Config;

    function _initialize() {
        parent::_initialize();
        $this->Config = D("fxconfig");

    }

    public function index() {
		if(isset($_POST['dosubmit'])){
			  if (!$this->Config->autoCheckToken($_POST)){
				  $this->error("令牌验证失败！");
			  }
			  unset ($_POST[C("TOKEN_NAME")]);
			  foreach ($_POST as $key => $value) {
				  $data["value"] = trim($value);
				  $this->Config->where(array("varname"=>$key))->save($data);
			  }
			  F("Config",NULL);
			  $this->success("更新成功！");
			  
		}else{
		
			  $config = $this->Config->select();
			  
			  
			  foreach ($config as $key => $r) {
				  if ($r['groupid'] == 1)
					  $this->user_config[$r['varname']] = Input::forShow($r['value']);
				  if ($r['groupid'] == 2)
					  $this->site_config[$r['varname']] = Input::forShow($r['value']);
			  }
			  $this->assign('Site', $this->site_config);
			 
			  $this->assign("indextp",$indextp);
			  $this->display();
		}
    }
    
}

?>
