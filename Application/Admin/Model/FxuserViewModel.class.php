<?php

/**后台管理员视图模型 
 * 
 */
class FxuserViewModel extends ViewModel {
    
    public $viewFields = array(
        "fxuser"=>array("*"),
        "Role"=>array("id"=>"role_id","name"=>"role_name","status"=>"role_status","_on"=>"fxuser.role_id=Role.id"),
    );
}
?>
