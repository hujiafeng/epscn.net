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
			
			$data["time"] = date("Y-m-d H:i:s");
			$data["status"] = "11";
			//查询需求方业务员
			$clerk_x=$this->db_user->where("uid={$data['uid_x']}")->find();
			$data["clerk_x"] = $clerk_x["clerk_x"];
			//添加订单
			$id = $this->db_need->add($data);
			//图片处理
			$imgs = $_POST["s"];
			if($imgs){
				$data_p["n_id"] = $id;
				
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
			
			$this->assign('user_x',$user_x);
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
