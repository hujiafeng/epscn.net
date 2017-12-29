<?php
/*
 * $type缓存类型：
 * 自定义分类
 * 
 * */
class Filecache {
	
	/*缓存默认配置*/
	public $_setting = array(
								'suf' => '.php',	/*缓存文件后缀*/
								'type' => 'array',		/*缓存格式：array数组，serialize序列化，null字符串*/
							);
	
	/*缓存路径*/
	public $filepath = '';
	public $lock_ex=0;
	public $cache_times=60;//缓存时间

	
	/**
	 * 写入缓存
	 * @param	string	$type		缓存类型news, baike
	 * @param	mixed	$ym		     年月
	 * @param	string	$id		缓存文件id
	 * @param	string	$data		缓存数据 为数组
	 */

	public function set($type, $ym,$id, $data) {
		
		if(!$type || !$ym  || !$id  || !$data)exit('缓存文件不能为空');
		$filepath = FCACHE_PATH."$type".'/'."$ym".'/';
		$filename = 'cache'.$id.$this->_setting['suf'];
	    if(!is_dir($filepath)) {
			mkdir($filepath, 0777, true);
	    }
	    
	    if($this->_setting['type'] == 'array') {
	    	$data = "<?php\nreturn ".var_export($data, true).";\n?>";
	    } elseif($this->_setting['type'] == 'serialize') {
	    	$data = serialize($data);
	    }
	    
	    
	    //是否开启互斥锁
		if($this->lock_ex) {
			$file_size = file_put_contents($filepath.$filename, $data, $this->lock_ex);
		} else {
			$file_size = file_put_contents($filepath.$filename, $data);
		}
	    
	    return $file_size ? $file_size : 'false';
	}
	
	/**
	 * 获取缓存
	 * @param	string	$type		缓存类型
	 * @param	mixed	$ym		     年月
	 * @param	string	$id		缓存文件id
	 */
	public function get($type, $ym,$id) {
		if(!$type || !$ym  || !$id )exit('缓存文件不能为空');
        $filepath = FCACHE_PATH."$type".'/'."$ym".'/';
		$filename = 'cache'.$id.$this->_setting['suf'];
		if (!file_exists($filepath.$filename)) {
			return false;
		} else {
		    if($this->_setting['type'] == 'array') {
		    	$data = @require($filepath.$filename);
		    } elseif($this->_setting['type'] == 'serialize') {
		    	$data = unserialize(file_get_contents($filepath.$filename));
		    }
		    
		    return $data;
		}
	}
	/*
	 * 判断缓存文件是否存在
	 * 
	 * */
	public function is_cache($type, $ym,$id) {
	   if(!$type || !$ym  || !$id )exit('缓存文件不能为空');
        $filepath = FCACHE_PATH."$type".'/'."$ym".'/';
		$filename = 'cache'.$id.$this->_setting['suf'];
		if (!file_exists($filepath.$filename)) {
			return false;
		} else {
			return filesize($filepath.$filename);	
		}
			
		}
	/*
	 * 判断缓存文件是否过期
	 * @param	string	$type		缓存类型
	 * @param	mixed	$ym		     年月
	 * @param	string	$id		缓存文件id
	 */
	public function is_oldtime($type, $ym,$id){
		 if(!$type || !$ym  || !$id )exit('缓存文件不能为空');
		$info=$this->cacheinfo($type, $ym,$id);
		if (time() - $info['filemtime'] <= $this->cache_times) {
		return  true;
	   } else{
	   	return false;
	   	
	   }
		
	}	
		
	/**
	 * 删除缓存
	 * @param	string	$type		缓存类型
	 * @param	mixed	$ym		     年月
	 * @param	string	$id		缓存文件id
	 * @return  bool
	 */
	public function delete($type, $ym,$id) {
		if(!$type || !$ym  || !$id )exit('缓存文件不能为空');
        $filepath = FCACHE_PATH."$type".'/'."$ym".'/';
		$filename = 'cache'.$id.$this->_setting['suf'];
		if(file_exists($filepath.$filename)) {
			return @unlink($filepath.$filename) ? true : false;
		} else {
			return false;
		}
	}

	
	/**
	 * 和系统缓存配置对比获取自定义缓存配置
	 * @param	string	$type		缓存类型
	 * @param	mixed	$ym		     年月
	 * @param	string	$id		缓存文件id
	 */
	public function cacheinfo ($type, $ym,$id) {
	  if(!$type || !$ym  || !$id )exit('缓存文件不能为空');
        $filepath = FCACHE_PATH."$type".'/'."$ym".'/';
		$filename = 'cache'.$id.$this->_setting['suf'];
		if(file_exists($filepath)) {
			$res['filename'] = 'cache'.$id.$this->_setting['suf'];
			$res['filepath'] = $filepath;
			$res['filectime'] = filectime($filename);//指定文件的上次 inode 修改时间
			$res['filemtime'] = filemtime($filename);//取得文件修改时间
			$res['filesize'] = filesize($filename);
			return $res;
		} else {
			return false;
		}
	}

}

?>