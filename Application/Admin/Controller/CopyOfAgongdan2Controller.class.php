<?php
/*
 * 添加订单
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class AgongdanController extends AdminbaseController{
public $db_user;
public $db_need;
public $db_photo;
public $db_region;
public $db_fxuser;
public $db_notificationk;
public $db_adviser;
public $db_clerk;
  function _initialize() {
        parent::_initialize();
         $this->db_user=D('user');
         $this->db_need=D('need');
         $this->db_photo=D('photo');
         $this->db_region=D('region');
         $this->db_fxuser=D('fxuser');
         $this->db_notificationk=D('notification');
         $this->db_adviser=D('adviser');
         $this->db_clerk=D('clerk');
    }
    /**
     * 添加订单
     */
	public function add(){
		if(isset($_POST['dosubmit'])){
			$data = $_POST ['info'];
			if (!$data["uid_x"])
				$this->error ( "需求方填写错误！" );
			if (!$data["uid_f"])
				$this->error ( "服务方填写错误！" );
			$data["no"] = date("yms").sprintf("%05d",mt_rand(1, 99999));
			//$data["biaoqian"] = $data["biaoqian"]?implode("|",$data["biaoqian"]):"";
			//地址处理
			$url="http://restapi.amap.com/v3/geocode/regeo?location=".$data["zuobiao"]."&key=784d53717fe3eb88eef967e069b8d2a3";
			$arr=file_get_contents($url);
			$newarr=json_decode($arr,true);
			
			if($newarr["regeocode"]["addressComponent"]["province"])
				$address .= $newarr["regeocode"]["addressComponent"]["province"];
			if($newarr["regeocode"]["addressComponent"]["city"])
				$address .= $newarr["regeocode"]["addressComponent"]["city"];
			if($newarr["regeocode"]["addressComponent"]["district"])
				$address .= $newarr["regeocode"]["addressComponent"]["district"];
			$data['city'] = $address;
			
			$data["time"] = $data["check_time"] = date("Y-m-d H:i:s");
			if($data["status"] == "3"){
				$data["pay_time"] = date("Y-m-d H:i:s");
				$data["pay_mode"] = "2";
				$data["n_payed"] = "Y";
			}
			
			$gw = explode("_",$data["gw_name"]);
			$data["gw_name"] = $gw["0"];
			$data["gw_number"] = $gw["1"];
			
			//查询需求方业务员
			$clerk_x=$this->db_user->where("uid={$data['uid_x']}")->find();
			$data["clerk_x"] = $clerk_x["clerk_x"];
			//查询服务方业务员
			$clerk_f=$this->db_user->where("uid={$data['uid_f']}")->find();
			$data["clerk_f"] = $clerk_f["clerk_f"];
			
			$id = $this->db_need->add($data);
			
			import("Org.Jpush.Jpush_f"); //引入Jpush类文件
			$pushObj = new \Jpush_f();
			//需求方推送
			$uid_x = $data["uid_x"];
			$cont_x = "已为您发布一则线下订单".$data["no"]."，请等待施工安排。";
			//查询用户token,进行推送
			$u_t=$this->db_user->where("uid={$uid_x}")->field("token")->select();
			$token = $u_t[0]["token"];
			if($token){
				//用户未读条数
				$count_n = $this->db_notificationk->where("ruid='{$uid_x}' and flag='1' and isread='0'")->count();
				//组装需要的参数
				$receive = array('registration_id'=>array($token));
				$title = "";
				$content = $cont_x;
				$m_time = '86400';        //离线保留时间
				$count_n = $count_n + 1;
				$extras = array("type"=>"1","nid"=>$id,"not"=>$count_n,"aisle"=>"0");   //自定义数组
				//调用推送,并处理
				$result = $pushObj->push($receive,$title,$content,$extras,$m_time);
				if($result){
					$res_arr = json_decode($result, true);
					if(isset($res_arr['error']) == FALSE){   //如果返回了error则证明失败
			
					}
				}
			}
			$data_n['obj_id'] = $data["no"];
			$data_n['ruid'] = $uid_x;
			$data_n['content'] = $cont_x;
			$this->db_notificationk->add($data_n);
			
			//记录订单消费记录
			if($data["reward"]){
				$data_con['uid'] = $uid_x;
				$data_con['contact'] = "+".$data["reward"];
				$data_con['remark'] = "订单消费";
				$data_con['n_no'] = $data["no"];
				$this->db_consumption->add($data_con);
			}
			
			//服务方推送
			$uid_f = $data["uid_f"];
			$cont_f = "【服务商】您有新的服务订单".$data["no"]."，请及时指定施工人员。";
			//查询用户token,进行推送
			$u_t_f=$this->db_user->where("uid={$uid_f}")->field("token")->select();
			$token_f = $u_t_f[0]["token"];
			if($token_f){
				//用户未读条数
				$count_n_f = $this->db_notificationk->where("ruid='{$uid_f}' and flag='1' and isread='0'")->count();
				//组装需要的参数
				$receive_f = array('registration_id'=>array($token_f));
				$title_f = "";
				$content_f = $cont_f;
				$m_time_f = '86400';        //离线保留时间
				$count_n_f = $count_n_f + 1;
				$extras_f = array("type"=>"1","nid"=>$id,"not"=>$count_n_f,"aisle"=>"1");   //自定义数组
				//调用推送,并处理
				$result_f = $pushObj->push($receive_f,$title_f,$content_f,$extras_f,$m_time_f);
				if($result_f){
					$res_arr_f = json_decode($result_f, true);
					if(isset($res_arr_f['error']) == FALSE){   //如果返回了error则证明失败
							
					}
				}
			}
			$data_n_f['obj_id'] = $data["no"];
			$data_n_f['ruid'] = $uid_f;
			$data_n_f['content'] = $cont_f;
			$this->db_notificationk->add($data_n_f);


			//图片处理
			$imgs = $_POST["s"];
			if($imgs){
				$data_p["n_id"] = $id;
				$data_p["type"] = "3";
				
				$imgs_arr = array_filter(explode('|',$imgs));
				foreach ($imgs_arr as $img){
					//大图
					$data_p["large"] = $img_b = substr($img,9);
					//小图
					$imgs_arr2 = explode('/',$img_b);
					$data_p["small"] = $img_s = $imgs_arr2["0"]."/".$imgs_arr2["1"]."/"."s_".$imgs_arr2["2"];
					//缩放小图
					$image = new \Think\Image();
					$image->open(".".$img);
					$image->thumb(80, 80)->save('./uploads/'.$img_s);
					
					$this->db_photo->add($data_p);
				}
			}
			$this->addLogs ( 'add', $id, '添加订单' . $data ['s_type'].$data["no"] );
			$this->success ( "操作成功！", U ( 'Agongdan/add') );
			
		}else{
			//需求用户
			$user_x = $this->db_user->where(array('flag'=>"0") )->field ("uid,mobile,name,khdw,city")->order(array("last_time"=>"desc"))->select ();
			//服务用户
			$user_f = $this->db_user->where(array('flag'=>"0",'type'=>"1") )->field ("uid,mobile,name,city,task,company")->order(array("last_time"=>"desc"))->select ();
			//服务顾问
			$fw = $this->db_adviser->where(array('status'=>"2") )->field ("name,number")->order(array("time"=>"desc"))->select ();

			$this->assign('user_x',$user_x);
			$this->assign('user_f',$user_f);
			$this->assign('fw',$fw);
			$this->display();
		}	
	}
	
	//图片上传处理
	public function uploadImg() {
		if (isset($_POST["PHPSESSID"])) {
			session_id($_POST["PHPSESSID"]);
		}
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      'uploads/'; // 设置附件上传根目录
        $upload->autoSub = true;
        $upload->subName = array('date','Y/m');

        $info=$upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getErrorMsg());
        }else{// 上传成功 获取上传文件信息
            foreach($info as $file){
                 print_r(__ROOT__.'/uploads/'.$file['savepath'].$file['savename']);
            }
        }
    }
    //删除图片
    public function del() {
    	$src=".".$_GET['src'];
    	if (file_exists($src)){
    		unlink($src);
    	}
    	print_r($_GET['src']);
    	exit();
    }
    
    //获取省市区
    public function getRegion(){
    	$map['pid']=$_REQUEST["pid"];
    	$map['type']=$_REQUEST["type"];
    	$list=$this->db_region->where($map)->select();
    	echo json_encode($list);
    }
	
}

?>
