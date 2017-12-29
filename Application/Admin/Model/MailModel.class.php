<?php
	/*	站内信Model
	 *  Edit date：20120713
 	 *	Author：小金
 	 */	

	class MailModel extends CommonModel{
		//自动验证
	    protected $_validate = array(
	        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
	        array('recipient','require','收件人必须填写',1,'regex',3),
	        array('title','require','站内信标题必须填写',1,'regex',3),
	        array('content','require','站内信正文必须填写',1,'regex',3),
	    );
	    //自动完成
	    protected $_auto = array(
	        //array(填充字段,填充内容,填充条件,附加规则)
	        array('send_time','getTime',3,'callback'),
	        array('addresser','getAddresser',3,'callback'),
	    );
		
		public function getTime(){
			return time();
		}
		
		public function getAddresser(){
			if('IN_ADMIN'==TRUE){
				return "Admin";
			}//else
		}
	
	}
?>