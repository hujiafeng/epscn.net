<?php

namespace Admin\Controller;
use Appframe\AdminbaseController;
class LogsController extends AdminbaseController {
    
    /**
     * 后台登陆日志查看
     */
    public function loginlog(){
        $username = $this->_get("username");
        //$logintime = $this->_get("logintime");
        $start_time = $this->_get('start_time');
        $end_time = $this->_get('end_time');
        $loginip = $this->_get("loginip");
        $status = $this->_get("status");
        if(!empty($username)){
            $data['username'] = array('like', '%'.$username.'%');
        }
        if(!empty($start_time) && !empty($end_time)){
            $data['_string'] = " `logintime` >'$start_time' AND  `logintime`<'$end_time' ";
        }
        if(!empty($loginip )){
            $data['loginip '] = array('like', '%'.$loginip.'%');
        }
        if(!empty($status) || $status=='0'){
            $data['status'] = array('eq',$status);
        }
        if(is_array($data)){
            $data['_logic'] = 'or';
            $map['_complex'] = $data;
        }else{
            $map = array();
        }
        $count = M("fxloginlog")->where($map)->count();
        $page = $this->page($count,20);
        $Logs = M("fxloginlog")->where($map)->limit($page->firstRow.','.$page->listRows)->order(array("loginid"=>"desc"))->select();
        $this->assign("Page",$page->show('Admin'));
        $this->assign("logs",$Logs);
        $this->display();
    }
    
    /**
     * 删除一个月前的登陆日志
     */
    public function deleteloginlog(){
        $t = date("Y-m-d H:i:s",  time()-259200);
        if(D("fxloginlog")->where(array("logintime"=>array("lt",$t)))->delete()){
            $this->success("删除登陆日志成功！");
        }else{
            $this->error("删除登陆日志失败！");
        }
    }
    
    /**
     * 操作日志查看
     */
    public function  index(){
        $username = $this->_get("username");
        $start_time = $this->_get('start_time');
        $end_time = $this->_get('end_time');
        $ip = $this->_get("ip");
        $status = $this->_get("status");
        $data=array();
        if(!empty($username)){
            $data['username'] = array('eq', $username);
        }
        if(!empty($start_time) && !empty($end_time)){
            $data['_string'] = " `addtime` >'$start_time' AND  `addtime`<'$end_time' ";
        }
        if(!empty($ip )){
            $data['ip '] = array('like', '%'.$ip.'%');
        }
        if(!empty($status)){
            $data['status'] = array('eq',$status);
        }
        
        $count = M("fxoperationlog")->where($data)->count();
        $page = $this->page($count,20);
        $Logs = M("fxoperationlog")->where($data)->limit($page->firstRow.','.$page->listRows)->order(array("id"=>"desc"))->select();
        $this->assign("Page",$page->show('Admin'));
        $this->assign("logs",$Logs);
        $this->display();
    }
    
    /**
     * 删除一个月前的操作日志
     */
    public function deletelog(){
        $t = date("Y-m-d H:i:s",  time()-259200);
        if(D("fxoperationlog")->where(array("time"=>array("lt",$t)))->delete()){
            $this->success("删除操作日志成功！");
        }else{
            $this->error("删除操作日志失败！");
        }
    }
}
?>
