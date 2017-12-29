<?php

namespace Admin\Model;
use Admin\Model\CommonModel;
class CustomtempModel extends CommonModel {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('tempname', 'require', '自定义模板名称不能为空！', 1, 'regex', 3),
        array('temppath', 'require', '路径不能为空！', 1, 'regex', 3),
        array('temptext', 'require', '页面内容不能为空！', 1, 'regex', 3),
        array('tempname','checkPname','自定义页面文件名称有误！',1,'callback'),
    );
    //自动完成
    protected $_auto = array(
        //array(填充字段,填充内容,填充条件,附加规则)
    );
    
    public function checkPname($data){
        $name = explode('.',$data);
        if(count($name)==2){
            return true;
        }else{
            return false;
        }
    }

}

?>
