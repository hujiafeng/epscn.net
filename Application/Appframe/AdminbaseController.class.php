<?php

namespace Appframe;
use Appframe\AppframeController;
 use Com\Util\Page;
class AdminbaseController extends AppframeController {

public $page_size=20;//每页多少条
    function _initialize() {
    	
        //定义是后台
        define('IN_ADMIN',true);
        parent::_initialize();
        //初始化当前登录用户信息
    
        
        //角色表名称
        C("RBAC_ROLE_TABLE", C("DB_PREFIX") . "role");
        //后台用户模型
        C("USER_AUTH_MODEL", "User");
        
        C("USER_AUTH_GATEWAY", U("Admin/Public/login"));
		$this->check_admin();
		
		$this->check_priv();
		
		$this->initUser();

        $this->initMenu();
     
    }

	/*去掉空格*/
public function funtrim(&$value,$key){
	$value=trim($value);
	
	}


	 /**
     * 写入操作日志
     * @param type $info 操作说明
     * @param type $status 状态,add为写入，edit为更新，del为删除
     * @param type $keysn 模块主键，例如文章 就是文章id
     * @param type $txt 操作备注
 
     */
     public function addLogs($status, $keysn,$txt, $data = array()) {

    	$appinfo = array(
            "action" => ACTION_NAME,
            "group" => CONTROLLER_NAME,
            "module" => MODULE_NAME
        );
            $action = ACTION_NAME;
            $app= CONTROLLER_NAME;
            $model=MODULE_NAME;
          $mvc =$model."#".$app."#".$action;
    	$uid = $this->Cache['uid'];
    	$username=$this->Cache['username'];

    	$mvcname=M('fxmenu')->where("app='{$model}' and model='{$app}' and action='{$action}' ")->getField('name');
        M("fxoperationlog")->add(array(
            "uid" => $uid,
            "username" => $username,
            "addtime" => time(),
            "ip" => get_client_ip(),
            "status" => $status,
            "keysn" => $keysn,
            "txt" => $txt,
            "mvcname" => $mvcname,
            "mvc" => $mvc
        ));
    }

	final public function check_admin() {

		if(MODULE_NAME =='Admin' && CONTROLLER_NAME =='Public' && in_array(ACTION_NAME, array('tologin','login','logout'))) {
			return true;
		} else {
			
		if(!isset($_SESSION['UserID']) || !isset($_SESSION['username']) || !$_SESSION['ShuiPanAdmin'] || !$_SESSION['roleid']){ 
		  $this->error('对不起，请先登录!',U("Admin/Public/login"));
		}
			
		}
	}

	/**
	 * 权限判断
	 */
	final public function check_priv() {
		if(MODULE_NAME =='Admin' && CONTROLLER_NAME =='Public' && in_array(ACTION_NAME, array('tologin','login','logout'))) return true;
		if($_SESSION['roleid'] == 1) return true;
		$action = ACTION_NAME;
		$Privdb = D('fxadmin_role_priv');
		if(preg_match('/^public_/',ACTION_NAME)) return true;
		if(preg_match('/^ajax_([a-z]+)_/',ACTION_NAME,$_match)) {
			$action = $_match[1];
			 return true;
		}
		
		$wh=array('app'=>MODULE_NAME,'model'=>CONTROLLER_NAME,'action'=>$action,'roleid'=>$_SESSION['roleid']);
		$r =$Privdb->where($wh)->find();
	
		if(!$r) $this->error('您没有权限操作该项');
	}

    /**
     *  初始化当前登录用户信息
     */
    final protected function initUser() {
        //当然登陆用户ID
        $usDb = service("Passport")->isLogged();

        if ($usDb == false) {
            return false;
        }
     
        $this->Cache['uid'] = $usDb['userid'];
        $this->Cache['username'] = $usDb['username'];
        $this->assign("uid", $this->Cache['uid']);
        $this->assign("username", $this->Cache['username']);
        $User = S("Admin_User_" . $this->Cache['uid']);
       
        if (!$User) {
            $User = M("fxuser")->where(array("id" => $this->Cache['uid']))->getField("id,username,nickname,last_login_time,last_login_ip,email,status");
            $User = $User[$this->Cache['uid']];
            S("Admin_User_" . $this->Cache['uid'], $User, 60);
        }

        $this->Cache['User'] = $User;
        $this->assign("User", $this->Cache['User']);
        unset($usDb);
        return true;
    }

		/**
	 * 
	 * 新闻添加弹框
	 */
	public function showmessage($msg, $url_forward = 'goback', $ms = 1250, $dialog = '', $returnjs = '') {
	
		$path = dirname ( __FILE__ ) . '/mess.php';

		include ($path);
		exit ();
	}

    /**
     * 消息提示
     * @param type $message
     * @param type $jumpUrl
     * @param type $ajax 
     */
    public function success($message, $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
     
    }

    /**
     * 初始化后台菜单
     */
    private function initMenu() {
        $Menu = F("Menu");
    
        if (!$Menu) {
            $Menu = D("Fxmenu")->Menucache();
           
            //数组
            $eMenu = D("Fxmenu")->select();
       
            foreach ($eMenu as $k => $v) {
                $data[$v['id']] = $v;
            }
            F("eMenu", $data);
        }
        $this->Cache['Menu'] = $Menu;
        $this->Cache['eMenu'] = F("eMenu");
    
    }

    /**
     *  添加
     */
    protected function add() {
        $this->display();
    }

    protected function insert($model) {
        if (!is_object($model)) {
            return false;
        }
        if ($model->create()) {
            if ($model->add()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     *  编辑
     */
    protected function edit($model) {
        if (!is_object($model)) {
            return false;
        }
        $pk = ucfirst($model->getPk()); //取得主键
        $id = (int) $_REQUEST[$model->getPk()];
        if (empty($id)) {
            return false;
        }
        $do = 'getBy' . $pk;
        $vo = $model->$do($id); //TP 5.3.12
        return $vo;
    }

    protected function updata($model) {
        if (!is_object($model)) {
            return false;
        }
        if ($model->create()) {
            if ($model->save()) {
                return true;
            } else {
                $this->error("更新失败！");
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     *  删除
     *  通过getPk获取表的主键，根据主键名称取得(post/get)的值，去删除数据库中的记录
     */
    protected function delete($model) {
        if (!is_object($model)) {
            return false;
        }
        $pk = $model->getPk(); //获取主键名称
        $id = (int) $_REQUEST[$pk];
        if (isset($id)) {
            if (false !== $model->delete($id)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     *  排序 排序字段为listorders数组 POST 排序字段为：listorder
     */
    protected function listorders($model) {
        if (!is_object($model)) {
            return false;
        }
        $pk = $model->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $model->where(array($pk => $key))->save($data);
        }
        return true;
    }



	 protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {

        if ($Page_Size == 0) {
            $Page_Size = C("PAGE_LISTROWS");
        }
        if (empty($PageParam)) {
            $PageParam = C("VAR_PAGE");
        }
		
        $Page = new Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
        $Page->SetPager('Admin', '共有{recordcount}条&nbsp;{pageindex}/{pagecount}&nbsp;{first}{prev}{liststart}{list}{listend}{next}{last}&nbsp;', array("listlong" => "6", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
 
		return $Page;
    }
    
    /**
     *  开发语言
     */
    public function get_language(){
    	return array(1=>'C',2=>'JAVA',3=>'PHP',4=>'C++',5=>'C#',6=>'Objective-C',7=>'Visual Basic',8=>'Python',9=>'Perl',10=>'Ruby',11=>'JavaScript',12=>'Delphi',13=>'Lisp',14=>'Visual Basic.Net',
    	15=>'Transact-SQL',16=>'Pascal',17=>'Lua',18=>'Ada',19=>'PL/SQL',20=>'MATLAB',21=>'PHP+JAVA',22=>'PHP+JAVA+C++',23=>'SQL',24=>'PHP+JavaScript+SQL');
    }
    
     /**
     *  运行环境
     */
    public function get_environmental(){
    	return array(1=>'Windows',2=>'Linux',3=>'Unix',4=>'Mac');
    }
	
    /**
     *  开发工具
     */
    public function get_tool(){
    	return array(1=>'Zend Studio',2=>'PHPedi',3=>'Eclipsephp',4=>'Notepad++'
    	,5=>'Editplu',6=>'Dreamweaver',7=>'PHPdesigner',8=>'Zend Development Environment',9=>'PHPED',10=>'PHP EXPERT EDITOR',
    	11=>'NetBeans',12=>'Eclipse',13=>'PHPedit',14=>'EasyPHP',15=>'Jcreator',16=>'MyEclipse',17=>'Snippet Compiler',18=>'JDK',
    	19=>'JavaWorkshop',20=>'NetBeans',21=>'SunJavaStudio5',22=>'Borland',23=>'JBuilder',24=>'JDeveloper',25=>'VisualAgeforJava'
    	,26=>'WebLogicWorkshop',27=>'VisualCafeforJavaVisualCafe',28=>'JRUN',29=>'MicrosoftVJ++',30=>'Ant',31=>'IntelliJ',32=>'Borland C++'
    	,33=>'Visual C++',34=>'Visual C++',35=>'Intel C++',36=>'Digital Mars C++');
    }
    
     /**
     *  业务领域
     */
    public function get_areas(){
    	
    }
    
    /**
     *  开发阶段
     */
    public function get_stage(){
    	return array(1=>'问题的定义及规划',2=>'需求分析',3=>'软件设计',4=>'程序编码',5=>'软件测试',6=>'后期维护');
    }
 
    
}

?>
