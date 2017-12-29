<?php

namespace Appframe;
use Appframe\AppframeController;
use Com\Util\Page;
class BaseController extends AppframeController {
	public $page_size=10;//每页多少条
    function _initialize() {
        parent::_initialize();
		$this->assign('CSS_PATH',"/statics/home/css/");
		$this->assign('IMG_PATH',"/statics/home/images/");
		$this->assign('JS_PATH',"/statics/home/js/");
		
 
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
    
    
    
}

?>
