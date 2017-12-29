<?php
/*
 * 临时工管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class TemporaryController extends AdminbaseController{
public $db_temporary;
public $db_region;
public $db_tem_photo;
  function _initialize() {
        parent::_initialize();
         $this->db_temporary=D('temporary');
         $this->db_region=D('region');
         $this->db_tem_photo=D('tem_photo');
         $this->type = array("1"=>"中压断路器","2"=>"中压开关柜","3"=>"低压开关柜","4"=>"预装式变电站","5"=>"微机综保及智能仪表");
    }
    
    /*
     * 列表
     */
	public function index(){
		//搜索参数
		$province = trim ( $this->_get ( "province" ) );
		$city = trim ( $this->_get ( "city" ) );
		$n_type = trim ( $this->_get ( "n_type" ) );
		
		$where = "1=1 and status=2";
		if($city){
			//地区处理
			$sheng = $this->db_region->where ( array('id'=>$province) )->field ("name")->find ();
			$shi   = $this->db_region->where ( array('id'=>$city) )->field ("name")->find ();
			$sheng = $sheng["name"];
			$shi   = $shi["name"];
			
			$where .= " and city LIKE '%$sheng%' and city LIKE '%$shi%'";
		}else{
			if ($province) {
				//地区处理
				$sheng = $this->db_region->where ( array('id'=>$province) )->field ("name")->find ();
				$sheng = $sheng["name"];
				
				$where .= " and city LIKE '%$sheng%'";
			}
		}
		if ($n_type) {
			$where .= " and n_type LIKE '%$n_type%'";
		}
		
		$count = $this->db_temporary->where($where)->count();
        $page = $this->page($count,60);
        $list = $this->db_temporary->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("time"=>"desc"))->select();
        //省市区显示
        $province = $this->db_region->where ( array('pid'=>1) )->select ();

        $this->assign('type',$this->type);
        $this->assign('sheng',$sheng);
        $this->assign('shi',$shi);
        $this->assign('province',$province);
        $this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->display();
	}
	/*
	 * 添加
	*/
	public function add(){
		if (isset ( $_POST ['dosubmit'] )) {
			$data = $_POST ['info'];
			
			$data["n_type"] = implode(" ",$data["n_type"]);
			$data["qualification"] = $data["qualification"]?implode(" ",$data["qualification"]):"";
			$data["time"] = date("Y-m-d H:i:s");
			//增加记录
			$id = $this->db_temporary->add ( $data );
			
			//图片处理
			$imgs = $_POST["s"];
			if($imgs){
				$data_p["gid"] = $id;
			
				$imgs_arr = array_filter(explode('|',$imgs));
				foreach ($imgs_arr as $img){
					//大图
					$data_p["large"] = $img_b = substr($img,9);
					$this->db_tem_photo->add($data_p);
				}
			}
				
			$this->addLogs ( 'add', $id, "增加临时工".$data["name"] );
			$this->success ( "操作成功！", U('Temporary/index'));
		}else{
			//省市区显示
			$province = $this->db_region->where ( array('pid'=>1) )->select ();
			$this->assign('province',$province);
			$this->assign('type',$this->type);
			$this->display();
		}
	}
	/*
	 * 添加
	*/
	public function edit(){
		if (isset ( $_POST ['dosubmit'] )) {
			$id = intval ( $this->_post ( 'id' ) );
			if (! $id)
				$this->error ( "参数错误！" );
			
			$data = $_POST ['info'];
			$data["n_type"] = implode(" ",$data["n_type"]);
			$data["qualification"] = $data["qualification"]?implode(" ",$data["qualification"]):"";
			$data["time"] = date("Y-m-d H:i:s");
			//修改记录
			$this->db_temporary->where("id={$id}")->save($data);
				
			//图片处理
			$imgs = $_POST["s"];
			if($imgs){
				//删除原图
				$data_p_d['flag'] = "0";
				$this->db_tem_photo->where("gid={$id}")->save($data_p_d);
				
				$data_p["gid"] = $id;
				$imgs_arr = array_filter(explode('|',$imgs));
				foreach ($imgs_arr as $img){
					//大图
					$data_p["large"] = $img_b = substr($img,9);
					$this->db_tem_photo->add($data_p);
				}
			}
	
			$this->addLogs ( 'edit', $id, "修改临时工".$data["name"] );
			$this->success ( "操作成功！", U('Temporary/index'));
		}else{
			$type = $this->type;
			
			$id=$this->_get('id');
			if(!$id)	$this->error("参数错误！");
			$info=$this->db_temporary->where("id={$id}")->find();
			//获取图片
			$p=$this->db_tem_photo->where("gid={$id} and flag=1 and type=1")->field()->select();
			
			foreach ($type as $k=>$v){
				if(stripos($info["n_type"],$v) !== false){
				    $type_new[$k]["name"] = $v;
				    $type_new[$k]["check"] = "1";
				}else{
					$type_new[$k]["name"] = $v;
					$type_new[$k]["check"] = "0";
				}
			}

			//省市区显示
			$province = $this->db_region->where ( array('pid'=>1) )->select ();
			$this->assign('province',$province);
			$this->assign('info',$info);
			$this->assign('p',$p);
			$this->assign('type',$type_new);
			$this->display();
		}
	}
	/*
	 * 删除
	 */
	public function del_t(){
		$id=$this->_get('id');
		
		$data['status'] = "-2";
		if(!$id)	$this->error("参数错误！");
		$this->db_temporary->where("id={$id}")->save($data);	
		
		$this->success("操作成功！",U('Temporary/index'));
	}
	/*
	 * 查看
	*/
	public function show(){
		$id=$this->_get('id');
		if(!$id)	$this->error("参数错误！");
		$info=$this->db_temporary->where("id={$id}")->find();
		
		//获取图片
		$p=$this->db_tem_photo->where("gid={$id} and flag=1 and type=1")->field()->select();
	
		$this->assign('info',$info);
		$this->assign('p',$p);
		$this->display();
	}
	
	//图片上传处理
	public function addphoto() {
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
	
	
}

?>
