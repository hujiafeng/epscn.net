<?php
/*
 * 设备管理
 * */
namespace Admin\Controller;
use Appframe\AdminbaseController;
use Com\Util\Dir;
class DeviceController extends AdminbaseController{
public $db_user;
public $db_device;
public $db_device_goods;
public $db_device_photo;

  function _initialize() {
        parent::_initialize();
         $this->db_user=D('user');
         $this->db_device=D('device');
         $this->db_device_goods=D('device_goods');
         $this->db_device_photo=D('device_photo');
    }
    /*
     * 分组列表
    */
    public function Clists(){
    	//搜索
    	$uid = trim ( $this->_get ( "uid" ) );
    	$where = "1=1";
    	if ($uid) {
    		$where .= " and d.uid=$uid ";
    	}
    	$count = M()->table('d_device as d')->join('d_user as u on d.uid=u.uid')->where($where)->count();
    	$page = $this->page($count,60);
    	$list = M()->table('d_device as d')->join('d_user as u on d.uid=u.uid')->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("d.id"=>"desc"))->field ("d.*,u.mobile")->select();
    	foreach($list as $k=>$v){
    		$d_goods = $this->db_device_goods->where("did={$v['id']}")->count();
    		$v["d_goods"] = $d_goods;
    
    		$list[$k] = $v;
    	}
    	$this->assign("Page",$page->show('Admin'));
    	$this->assign('list',$list);
    	$this->assign('uid',$uid);
    	$this->display();
    }
    /*
     * 添加分组
    */
    public function Cadd(){
    	if(isset($_POST['dosubmit'])){
    		$uid=$this->_post('uid');
    		if(!$uid)	$this->error("参数错误！");
    		
    		$data=array();
    		$data = $_POST ['info'];
    		$data["uid"] = $uid;
    		
    		$id=$this->db_device->add($data);
    		$this->addLogs('index', $id,'添加设备分组');
    		$this->success("操作成功！",U('Device/Clists',array('uid'=>$uid)));
    	}else{
    		$uid = trim ( $this->_get ( "uid" ) );
    		if(!$uid)	$this->error("参数错误！");
    		
    		$info=$this->db_user->where("uid={$uid}")->find();
			$this->assign('info',$info);
	
    		$this->display();
    	}
    }
    /*
     * 修改分组
    */
    public function Cedit(){
    	if(isset($_POST['dosubmit'])){
    		$id=$this->_post('id');
    		$uid=$this->_post('uid');
    		if(!$id || !$uid)	$this->error("参数错误！");
    		$data = $_POST ['info'];
    
    		$id=$this->db_device->where("id={$id}")->save($data);
    		$this->addLogs('index', $id,'修改设备分组');
    		$this->success("操作成功！",U('Device/Clists',array('uid'=>$uid)));
    	}else{
    		$id = trim ( $this->_get ( "id" ) );
    		if(!$id)	$this->error("参数错误！");
    
    		$info = M()->table('d_device as d')->join('d_user as u on d.uid=u.uid')->where("d.id=$id")->find();
    		 
    		$this->assign('info',$info);
    		$this->display();
    	}
    }
	/*
	 * 删除设备分组
	 */
	public function Cdel(){
		$id=$this->_get('id');
		$sum=$this->_get('sum');
		$uid=$this->_get('uid');
    	if(!$id || !$uid)	$this->error("参数错误！");
		if($sum)	$this->error("该设备下有产品,禁止删除！");
		
		$this->db_device->where("id={$id}")->delete();	
		$this->addLogs('del', $id,'删除设备分组');
		$this->success("操作成功！",U('Device/Clists',array('uid'=>$uid)));
	}
	/*
	 * 设备列表
	*/
	public function Glists(){
		//搜索
		$id=$this->_get('id');
		if(!$id)	$this->error("参数错误！");
		//查询分组名称
		$d = $this->db_device->where("id=$id")->find();

		$where = "did=$id";
		$count = $this->db_device_goods->where($where)->count();
		$page = $this->page($count,60);
		$list = $this->db_device_goods->where($where)->limit($page->firstRow.','.$page->listRows)->order(array("time"=>"desc"))->select();
		
		foreach($list as $k=>$v){
	
			$list[$k] = $v;
		}
		$this->assign("Page",$page->show('Admin'));
		$this->assign('list',$list);
		$this->assign('d',$d);
		$this->display();
	}
	/*
     * 添加设备
    */
    public function Gadd(){
    	if(isset($_POST['dosubmit'])){
    		$did=$this->_post('did');
    		$uid=$this->_post('uid');
    		if(!$did || !$uid)	$this->error("参数错误！");

    		$data=array();
    		$data = $_POST ['info'];
    		$data["did"] = $did;
    		$data["uid"] = $uid;
    		$data["no"] = date("s").sprintf("%06d",mt_rand(1, 99999));
    		
    		$gid=$this->db_device_goods->add($data);
    		
    		//图片处理
    		$imgs = $_POST["s"];
    		if($imgs){
    			$data_p["gid"] = $gid;
    		
    			$imgs_arr = array_filter(explode('|',$imgs));
    			foreach ($imgs_arr as $img){
    				//大图
    				$data_p["large"] = $img_b = substr($img,9);
    				$this->db_device_photo->add($data_p);
    			}
    		}
    		
    		//图片处理标题
    		$name = $data["name"];
    		$no = $data["no"];
    		
    		//文字图片
    		$dst_path = __ROOT__.'statics/images/saoma.png';
    		//创建图片的实例
    		$dst = imagecreatefromstring(file_get_contents($dst_path));
    		//打上文字
    		$font = __ROOT__.'statics/images/lantingxihei.ttf';//字体路径
    		$black = imagecolorallocate($dst, 0x32, 0x32, 0x33);//字体颜色
    		$black2 = imagecolorallocate($dst, 0x97, 0x97, 0x98);//字体颜色
    		imagefttext($dst, 16, 0, 85, 70, $black, $font, $name);
    		imagefttext($dst, 12, 0, 85, 96, $black2, $font, $no);
    		//输出图片
    		imagepng($dst,__ROOT__."uploads/erweima/$no.png");
    		imagedestroy($dst);
    		//header( "Content-Type: image/png" );
    		
    		//生成二维码图片
    		Vendor('phpqrcode.phpqrcode');
    		$object = new \QRcode();
    		$errorCorrectionLevel =intval(3) ;//容错级别
    		$matrixPointSize = intval(17);//生成图片大小
    		$object->png($no, __ROOT__."uploads/erweima/".$no."_1.png", $errorCorrectionLevel, $matrixPointSize, 0);
    		
    		//二维码图片再次合成
    		$dst_path2 = __ROOT__."uploads/erweima/$no.png";
    		$src_path = __ROOT__."uploads/erweima/".$no."_1.png";
    		//创建图片的实例
    		$dst2 = imagecreatefromstring(file_get_contents($dst_path2));
    		$src = imagecreatefromstring(file_get_contents($src_path));
    		//获取水印图片的宽高
    		list($src_w, $src_h) = getimagesize($src_path);
    		//将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
    		imagecopymerge($dst2, $src, 80, 150, 0, 0, $src_w, $src_h, 100);
    		//输出图片
    		header( "Content-Type: image/png" );
    		imagepng($dst2,__ROOT__."uploads/erweima/$no.png");
    		imagedestroy($dst2);
    		imagedestroy($src);
    		
    		$this->addLogs('index', $gid,'添加设备');
    		$this->success("操作成功！",U('Device/Glists',array('id'=>$did)));
    	}else{
    		$id = $this->_get('id');
			if(!$id)	$this->error("参数错误！");
    		
    		$d = $this->db_device->where("id=$id")->find();
			$this->assign('d',$d);
	
    		$this->display();
    	}
    }
    /*
     * 修改设备
    */
    public function Gedit(){
    	if(isset($_POST['dosubmit'])){
    		$gid=$this->_post('gid');
    		$did=$this->_post('did');
    		if(!$gid || !$did)	$this->error("参数错误！");
    
    		$data=array();
    		$data = $_POST ['info'];
    		//修改设备
    		$this->db_device_goods->where("gid={$gid}")->save($data);
    		//删除原设备图片
    		$this->db_device_photo->where("gid={$gid}")->delete();
    		//添加新设备图片
    		$imgs = $_POST["s"];
    		if($imgs){
    			$data_p["gid"] = $gid;
    
    			$imgs_arr = array_filter(explode('|',$imgs));
    			foreach ($imgs_arr as $img){
    				//大图
    				$data_p["large"] = $img_b = substr($img,9);
    				$this->db_device_photo->add($data_p);
    			}
    		}
    
    		$this->addLogs('index', $gid,'修改设备');
    		$this->success("操作成功！",U('Device/Glists',array('id'=>$did)));
    	}else{
    		$gid = $this->_get('gid');
    		if(!$gid)	$this->error("参数错误！");
    		$g = $this->db_device_goods->where("gid=$gid")->find();
    		$d = $this->db_device->where("id={$g['did']}")->find();

    		$this->assign('g',$g);
    		$this->assign('d',$d);
    		$this->display();
    	}
    }
    /*
     * 复制设备
    */
    public function Gcopy(){
    	if(isset($_POST['dosubmit'])){
    		$did=$this->_post('did');
    		$uid=$this->_post('uid');
    		if(!$did || !$uid)	$this->error("参数错误！");

    		$data=array();
    		$data = $_POST ['info'];
    		$data["did"] = $did;
    		$data["uid"] = $uid;
    		$data["no"] = date("s").sprintf("%06d",mt_rand(1, 99999));
    		
    		$gid=$this->db_device_goods->add($data);
    		//添加新设备图片
    		$imgs = $_POST["s"];
    		if($imgs){
    			$data_p["gid"] = $gid;
    
    			$imgs_arr = array_filter(explode('|',$imgs));
    			foreach ($imgs_arr as $img){
    				//大图
    				$data_p["large"] = $img_b = substr($img,9);
    				$this->db_device_photo->add($data_p);
    			}
    		}
    		
    		
    		//图片处理标题
    		$name = $data["name"];
    		$no = $data["no"];
    		
    		//文字图片
    		$dst_path = __ROOT__.'statics/images/saoma.png';
    		//创建图片的实例
    		$dst = imagecreatefromstring(file_get_contents($dst_path));
    		//打上文字
    		$font = __ROOT__.'statics/images/lantingxihei.ttf';//字体路径
    		$black = imagecolorallocate($dst, 0x32, 0x32, 0x33);//字体颜色
    		$black2 = imagecolorallocate($dst, 0x97, 0x97, 0x98);//字体颜色
    		imagefttext($dst, 16, 0, 85, 70, $black, $font, $name);
    		imagefttext($dst, 12, 0, 85, 96, $black2, $font, $no);
    		//输出图片
    		imagepng($dst,__ROOT__."uploads/erweima/$no.png");
    		imagedestroy($dst);
    		//header( "Content-Type: image/png" );
    		
    		//生成二维码图片
    		Vendor('phpqrcode.phpqrcode');
    		$object = new \QRcode();
    		$errorCorrectionLevel =intval(3) ;//容错级别
    		$matrixPointSize = intval(17);//生成图片大小
    		$object->png($no, __ROOT__."uploads/erweima/".$no."_1.png", $errorCorrectionLevel, $matrixPointSize, 0);
    		
    		//二维码图片再次合成
    		$dst_path2 = __ROOT__."uploads/erweima/$no.png";
    		$src_path = __ROOT__."uploads/erweima/".$no."_1.png";
    		//创建图片的实例
    		$dst2 = imagecreatefromstring(file_get_contents($dst_path2));
    		$src = imagecreatefromstring(file_get_contents($src_path));
    		//获取水印图片的宽高
    		list($src_w, $src_h) = getimagesize($src_path);
    		//将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
    		imagecopymerge($dst2, $src, 80, 150, 0, 0, $src_w, $src_h, 100);
    		//输出图片
    		header( "Content-Type: image/png" );
    		imagepng($dst2,__ROOT__."uploads/erweima/$no.png");
    		imagedestroy($dst2);
    		imagedestroy($src);
    
    		$this->addLogs('index', $gid,'修改设备');
    		$this->success("操作成功！",U('Device/Glists',array('id'=>$did)));
    	}else{
    		$gid = $this->_get('gid');
    		if(!$gid)	$this->error("参数错误！");
    		$g = $this->db_device_goods->where("gid=$gid")->find();
    		$d = $this->db_device->where("id={$g['did']}")->find();
    
    		$this->assign('g',$g);
    		$this->assign('d',$d);
    		$this->display();
    	}
    }
    /*
     * 查看设备
    */
    public function Gshow(){
    	$gid = $this->_get('gid');
    	if(!$gid)	$this->error("参数错误！");
    	$g = $this->db_device_goods->where("gid=$gid")->find();
    	$d = $this->db_device->where("id={$g['did']}")->find();
    	//获取图片
    	$p=$this->db_device_photo->where("gid={$gid} and flag=1 and type=1")->field()->select();
    
    	$this->assign('g',$g);
    	$this->assign('d',$d);
    	$this->assign('p',$p);
    	$this->display();
    }
    /*
     * 删除设备
    */
    public function Gdel(){
    	$gid=$this->_get('gid');
    	$id = $this->_get('id');
    	if(!$gid || !$id)	$this->error("参数错误！");
    
    	$this->db_device_goods->where("gid={$gid}")->delete();
    	$this->addLogs('del', $gid,'删除设备');
    	$this->success("操作成功！",U('Device/Glists',array('id'=>$id)));
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
