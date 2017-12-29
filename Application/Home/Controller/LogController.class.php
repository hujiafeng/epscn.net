<?php
 namespace Home\Controller;
use Appframe\BaseController;

class LogController extends BaseController {
	 function _initialize() {
        parent::_initialize();

    }
    //首页
    public function index(){
    	$data = M('log')->order(array("id"=>"desc"))->select ();
    	
    	echo '<style>
	.new_t td{ border:1px solid #aaa;line-height:30px;font-size:14px;}
	</style>
	<table width="100%" class="new_t" cellspacing="0" cellpadding="">';
    	foreach($data as $k=>$v){
    	
    		echo "<tr><td width='5%'>".$v['id']."</td><td width='55%'>";
    		print_r( unserialize($v['requests']));
    	
    		echo "</td>
	<td width='40%'>".$v['text']."</td>
	</tr>";
    	
    	}
    	echo "</table>";
    	$this->display();
    }
   
}