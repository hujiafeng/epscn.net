<?php
/**图片上传
*/
define('ROOT_PATH', './'); 
class Uploadimg
{
    var $error_no    = 0;
    var $error_msg   = '';
    var $images_dir  = 'imageuploads';
    var $data_dir    = 'imageuploads';
    var $bgcolor     = '';
    var $type_maping = array(1 => 'image/gif', 2 => 'image/jpeg', 3 => 'image/png');
	var $allow_file_types = '';
	var $allow_file_sizes ='';

	/*初始化*/
	function __construct($bgcolor='') {        
        $this->cls_image($bgcolor);
	
		
    }

    function cls_image($bgcolor='')
    {
        if ($bgcolor)
        {
            $this->bgcolor = $bgcolor;
        }
        else
        {
            $this->bgcolor = "#FFFFFF";
        }
    }

    /**
     * 图片上传的处理函数
     *
     * @access      public
     * @param       array       upload       包含上传的图片文件信息的数组
     * @param       array       dir          文件要上传在$this->data_dir下的目录名。如果为空图片放在则在$this->images_dir下以当月命名的目录下
     * @param       array       img_name     上传图片名称，为空则随机生成
     * @return      mix         如果成功则返回文件名，否则返回false
     */
    function upload_image($upload, $dir = '', $img_name = '')
    {
	
	    if(empty($upload['name']))
	    {
	       return false;
	    }
        /* 没有指定目录默认为根目录images */
        if (empty($dir))
        {
            /* 创建当月目录 */
            $dir = date('Ym');
            $dir = ROOT_PATH . $this->images_dir . '/' . $dir . '/';
        }
        else
        {
            /* 创建目录 */
         	$every_dir = date('Ym');
            $dir = './' . $this->data_dir . '/' . $dir . '/' . $every_dir . '/';
            if ($img_name)
            {
                $img_name = $dir . $img_name; // 将图片定位到正确地址
            }
        }


        /* 如果目标目录不存在，则创建它 */
        if (!file_exists($dir))
        {
            if (!mkdir($dir))
            {
                /* 创建目录失败 */
                $this->error_msg('javascript:history.go(-1)','目录不存在或不可写');
                return false;
            }
        }

        if (empty($img_name))
        {
            $img_name = time().rand(10000,99999);
            $img_name = $dir . $img_name . $this->get_filetype($upload['name']);
        }

        /* 允许上传的文件类型 */
		if($this->allow_file_types){
			 $allow_file_type = $this->allow_file_types;
		}else{
             $allow_file_type = '|GIF|JPG|JEPG|PNG|BMP|SWF|';
		}
		
		
        if (!$this->check_file_type($upload['tmp_name'], $img_name, $allow_file_type))
        {
		    $this->error_msg('javascript:history.go(-1)','不是允许的文件格式');
		    return false;
        }
		
		$file_size = $upload["size"];
		
		if($this->allow_file_sizes){
			 $allow_file_size = ($this->allow_file_sizes)*1024;
		}else{
             $allow_file_size = 1024*3000; //3000k
		}
		
		if ($file_size > $allow_file_size)
        {
		    $this->error_msg('javascript:history.go(-1)','文件大小超过限制！');
		    return false;
        }		

        if ($this->move_file($upload, $img_name))
        {
           return str_replace(ROOT_PATH, '/', $img_name);
        }
        else
        {
		    $this->error_msg('javascript:history.go(-1)','文件上传失败');
            return false;
        }
    }

    /**
     * 创建图片的缩略图
     *
     * @access  public
     * @param   string      $img    原始图片的路径
     * @param   int         $thumb_width  缩略图宽度
     * @param   int         $thumb_height 缩略图高度
     * @param   strint      $path         指定生成图片的目录名
     * @return  mix         如果成功返回缩略图的路径，失败则返回false
     */
    function make_thumb($img, $thumb_width = 0, $thumb_height = 0, $path = '', $bgcolor='')
    {
         $gd = $this->gd_version(); //获取 GD 版本。0 表示没有 GD 库，1 表示 GD 1.x，2 表示 GD 2.x
         if ($gd == 0)
         {
		     $this->error_msg('javascript:history.go(-1)','没有安装GD库');
             return false;
         }

        /* 检查缩略图宽度和高度是否合法 */
        if ($thumb_width == 0 && $thumb_height == 0)
        {
            return str_replace(ROOT_PATH, '', str_replace('\\', '/', realpath($img)));
        }

        /* 检查原始文件是否存在及获得原始文件的信息 */
        $org_info = @getimagesize($img);
        if (!$org_info)
        {
		    $this->error_msg('javascript:history.go(-1)','找不到原始图片');
            return false;
        }

        if (!$this->check_img_function($org_info[2]))
        {
		    $this->error_msg('javascript:history.go(-1)','不支持该图像格式');
            return false;
        }

        $img_org = $this->img_resource($img, $org_info[2]);

        /* 原始图片以及缩略图的尺寸比例 */
        $scale_org      = $org_info[0] / $org_info[1];
        /* 处理只有缩略图宽和高有一个为0的情况，这时背景和缩略图一样大 */
        if ($thumb_width == 0)
        {
            $thumb_width = $thumb_height * $scale_org;
        }
        if ($thumb_height == 0)
        {
            $thumb_height = $thumb_width / $scale_org;
        }

        /* 创建缩略图的标志符 */
        if ($gd == 2)
        {
            $img_thumb  = imagecreatetruecolor($thumb_width, $thumb_height);
        }
        else
        {
            $img_thumb  = imagecreate($thumb_width, $thumb_height);
        }

        /* 背景颜色 */
        if (empty($bgcolor))
        {
            $bgcolor = $this->bgcolor;
        }
        $bgcolor = trim($bgcolor,"#");
        sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
        $clr = imagecolorallocate($img_thumb, $red, $green, $blue);
        imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $clr);

        if ($org_info[0] / $thumb_width > $org_info[1] / $thumb_height)
        {
            $lessen_width  = $thumb_width;
            $lessen_height  = $thumb_width / $scale_org;
        }
        else
        {
            /* 原始图片比较高，则以高度为准 */
            $lessen_width  = $thumb_height * $scale_org;
            $lessen_height = $thumb_height;
        }

        $dst_x = ($thumb_width  - $lessen_width)  / 2;
        $dst_y = ($thumb_height - $lessen_height) / 2;

        /* 将原始图片进行缩放处理 */
        if ($gd == 2)
        {
            imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
        }
        else
        {
            imagecopyresized($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
        }

        /* 创建当月目录 */
        if (empty($path))
        {
            $dir = ROOT_PATH . $this->images_dir .'/thumb/' . date('Ym').'/';
        }
        else
        {
             $dir = ROOT_PATH . $this->images_dir .'/'.$path.'/thumb/' . date('Ym').'/';
        }


        /* 如果目标目录不存在，则创建它 */
        if (!file_exists($dir))
        {
            if (!mkdir($dir))
            {
                /* 创建目录失败 */
				$this->error_msg('javascript:history.go(-1)','目录不存在或不可写');
                return false;
            }
        }
		
        $filename = time();

        /* 生成文件 */
        if (function_exists('imagejpeg'))
        {
            $filename .= '.jpg';
            imagejpeg($img_thumb, $dir . $filename);
        }
        elseif (function_exists('imagegif'))
        {
            $filename .= '.gif';
            imagegif($img_thumb, $dir . $filename);
        }
        elseif (function_exists('imagepng'))
        {
            $filename .= '.png';
            imagepng($img_thumb, $dir . $filename);
        }
        else
        {
		    $this->error_msg('javascript:history.go(-1)','创建图片失败');
            return false;
        }

        imagedestroy($img_thumb);
        imagedestroy($img_org);

        //确认文件是否生成
        if (file_exists($dir . $filename))
        {
            return str_replace(ROOT_PATH, '/', $dir) . $filename;
        }
        else
        {
		    $this->error_msg('javascript:history.go(-1)','图片写入失败');
            return false;
        }
    }

    /**
     * 为图片增加水印
     *
     * @access      public
     * @param       string      filename            原始图片文件名，包含完整路径
     * @param       string      target_file         需要加水印的图片文件名，包含完整路径。如果为空则覆盖源文件
     * @param       string      $watermark          水印完整路径
     * @param       int         $watermark_place    水印位置代码
     * @return      mix         如果成功则返回文件路径，否则返回false
     */
    function add_watermark($filename, $target_file='', $watermark='', $watermark_place='', $watermark_alpha = 0.65)
    {
        // 是否安装了GD
        $gd = $this->gd_version();
        if ($gd == 0)
        {
		    $this->error_msg('javascript:history.go(-1)','没有安装GD库');
            return false;
        }

        // 文件是否存在
        if ((!file_exists($filename)) || (!is_file($filename)))
        {
		    $this->error_msg('javascript:history.go(-1)','找不到原始图片');
            return false;
        }

        /* 如果水印的位置为0，则返回原图 */
        if ($watermark_place == 0 || empty($watermark))
        {
            return str_replace(ROOT_PATH, '', str_replace('\\', '/', realpath($filename)));
        }

        if (!$this->validate_image($watermark))
        {
            /* 已经记录了错误信息 */
            return false;
        }

        // 获得水印文件以及源文件的信息
        $watermark_info     = @getimagesize($watermark);
        $watermark_handle   = $this->img_resource($watermark, $watermark_info[2]);

        if (!$watermark_handle)
        {
		    $this->error_msg('javascript:history.go(-1)','创建水印图片资源失败。水印图片类型不对');
            return false;
        }

        // 根据文件类型获得原始图片的操作句柄
        $source_info    = @getimagesize($filename);
        $source_handle  = $this->img_resource($filename, $source_info[2]);
        if (!$source_handle)
        {
		    $this->error_msg('javascript:history.go(-1)','创建原始图片资源失败。原始图片类型'.$this->type_maping[$source_info[2]]);
            return false;
        }

        // 根据系统设置获得水印的位置
        switch ($watermark_place)
        {
            case '1':
                $x = 0;
                $y = 0;
                break;
            case '2':
                $x = $source_info[0] - $watermark_info[0];
                $y = 0;
                break;
            case '4':
                $x = 0;
                $y = $source_info[1] - $watermark_info[1];
                break;
            case '5':
                $x = $source_info[0] - $watermark_info[0];
                $y = $source_info[1] - $watermark_info[1];
                break;
            default:
                $x = $source_info[0]/2 - $watermark_info[0]/2;
                $y = $source_info[1]/2 - $watermark_info[1]/2;
        }

        if (strpos(strtolower($watermark_info['mime']), 'png') !== false)
        {
            imageAlphaBlending($watermark_handle, true);
            imagecopy($source_handle, $watermark_handle, $x, $y, 0, 0,$watermark_info[0], $watermark_info[1]);
        }
        else
        {
            imagecopymerge($source_handle, $watermark_handle, $x, $y, 0, 0,$watermark_info[0], $watermark_info[1], $watermark_alpha);
        }
        $target = empty($target_file) ? $filename : $target_file;

        switch ($source_info[2] )
        {
            case 'image/gif':
            case 1:
                imagegif($source_handle,  $target);
                break;

            case 'image/pjpeg':
            case 'image/jpeg':
            case 2:
                imagejpeg($source_handle, $target);
                break;

            case 'image/x-png':
            case 'image/png':
            case 3:
                imagepng($source_handle,  $target);
                break;

            default:
			    $this->error_msg('javascript:history.go(-1)','创建图片失败');
                return false;
        }

        imagedestroy($source_handle);

        $path = realpath($target);
		
        if ($path)
        {
            return str_replace(ROOT_PATH, '', str_replace('\\', '/', $path));
        }
        else
        {
		    $this->error_msg('javascript:history.go(-1)','图片写入失败');

            return false;
        }
    }

    /**
     *  检查水印图片是否合法
     *
     * @access  public
     * @param   string      $path       图片路径
     *
     * @return boolen
     */
    function validate_image($path)
    {
        if (empty($path))
        {
		    $this->error_msg('javascript:history.go(-1)','水印文件参数不能为空');

            return false;
        }

        /* 文件是否存在 */
        if (!file_exists($path))
        {
		    $this->error_msg('javascript:history.go(-1)','找不到水印文件');
            return false;
        }

        // 获得文件以及源文件的信息
        $image_info     = @getimagesize($path);

        if (!$image_info)
        {
		    $this->error_msg('javascript:history.go(-1)','无法识别水印图片');
            return false;
        }

        /* 检查处理函数是否存在 */
        if (!$this->check_img_function($image_info[2]))
        {
		    $this->error_msg('javascript:history.go(-1)','不支持该图像格式');
            return false;
        }

        return true;
    }

    /**
     * 返回错误信息
     *
     * @return  string   错误信息
     */

	function error_msg($url,$show)
	{
		if($show == 'javascript:history.go(-1)'){
			echo "<script>
			       alert(\"$show\");
			       history.go(-1);
			     </script>";
		}else{
			echo "<script>
			       alert(\"$show\");
				   location.href = \"$url\";
			     </script>";
		}
		
	}

    /*------------------------------------------------------ */
    //-- 工具函数
    /*------------------------------------------------------ */

    /**
     * 检查图片类型
     * @param   string  $img_type   图片类型
     * @return  bool
     */
    function check_img_type($img_type)
    {
        return $img_type == 'image/pjpeg' ||
               $img_type == 'image/x-png' ||
               $img_type == 'image/png'   ||
               $img_type == 'image/gif'   ||
               $img_type == 'image/jpeg';
    }

    /**
     * 检查图片处理能力
     *
     * @access  public
     * @param   string  $img_type   图片类型
     * @return  void
     */
    function check_img_function($img_type)
    {
        switch ($img_type)
        {
            case 'image/gif':
            case 1:

                if (PHP_VERSION >= '4.3')
                {
                    return function_exists('imagecreatefromgif');
                }
                else
                {
                    return (imagetypes() & IMG_GIF) > 0;
                }
            break;

            case 'image/pjpeg':
            case 'image/jpeg':
            case 2:
                if (PHP_VERSION >= '4.3')
                {
                    return function_exists('imagecreatefromjpeg');
                }
                else
                {
                    return (imagetypes() & IMG_JPG) > 0;
                }
            break;

            case 'image/x-png':
            case 'image/png':
            case 3:
                if (PHP_VERSION >= '4.3')
                {
                     return function_exists('imagecreatefrompng');
                }
                else
                {
                    return (imagetypes() & IMG_PNG) > 0;
                }
            break;

            default:
                return false;
        }
    }

    /**
     * 生成随机的数字串
     *
     * @author: weber liu
     * @return string
     */
    function random_filename()
    {
        $str = '';
        for($i = 0; $i < 9; $i++)
        {
            $str .= mt_rand(0, 9);
        }

        return time() . $str;
    }



    /**
     *  返回文件后缀名，如‘.php’
     *
     * @access  public
     * @param
     *
     * @return  string      文件后缀名
     */
    function get_filetype($path)
    {
        $pos = strrpos($path, '.');
        if ($pos !== false)
        {
            return substr($path, $pos);
        }
        else
        {
            return '';
        }
    }

     /**
     * 根据来源文件的文件类型创建一个图像操作的标识符
     *
     * @access  public
     * @param   string      $img_file   图片文件的路径
     * @param   string      $mime_type  图片文件的文件类型
     * @return  resource    如果成功则返回图像操作标志符，反之则返回错误代码
     */
    function img_resource($img_file, $mime_type)
    {
        switch ($mime_type)
        {
            case 1:
            case 'image/gif':
                $res = imagecreatefromgif($img_file);
                break;

            case 2:
            case 'image/pjpeg':
            case 'image/jpeg':
                $res = imagecreatefromjpeg($img_file);
                break;

            case 3:
            case 'image/x-png':
            case 'image/png':
                $res = imagecreatefrompng($img_file);
                break;

            default:
                return false;
        }

        return $res;
    }

    /**
     * 获得服务器上的 GD 版本
     *
     * @access      public
     * @return      int         可能的值为0，1，2
     */
    function gd_version()
    {
        static $version = -1;

        if ($version >= 0)
        {
            return $version;
        }

        if (!extension_loaded('gd'))
        {
            $version = 0;
        }
        else
        {
            // 尝试使用gd_info函数
            if (PHP_VERSION >= '4.3')
            {
                if (function_exists('gd_info'))
                {
                    $ver_info = gd_info();
                    preg_match('/\d/', $ver_info['GD Version'], $match);
                    $version = $match[0];
                }
                else
                {
                    if (function_exists('imagecreatetruecolor'))
                    {
                        $version = 2;
                    }
                    elseif (function_exists('imagecreate'))
                    {
                        $version = 1;
                    }
                }
            }
            else
            {
                if (preg_match('/phpinfo/', ini_get('disable_functions')))
                {
                    /* 如果phpinfo被禁用，无法确定gd版本 */
                    $version = 1;
                }
                else
                {
                  // 使用phpinfo函数
                   ob_start();
                   phpinfo(8);
                   $info = ob_get_contents();
                   ob_end_clean();
                   $info = stristr($info, 'gd version');
                   preg_match('/\d/', $info, $match);
                   $version = $match[0];
                }
             }
        }

        return $version;
     }

    /**
     *
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function move_file($upload, $target)
    {
        if (isset($upload['error']) && $upload['error'] > 0)
        {
            return false;
        }

        if (!move_uploaded_file($upload['tmp_name'], $target))
        {
            return false;
        }

        return true;
    }
	
	
	/**
 * 检查文件类型
 *
 * @access      public
 * @param       string      filename            文件名
 * @param       string      realname            真实文件名
 * @param       string      limit_ext_types     允许的文件类型
 * @return      string
 */
function check_file_type($filename, $realname = '', $limit_ext_types = '')
{
    if ($realname)
    {
        $extname = strtolower(substr($realname, strrpos($realname, '.') + 1));
    }
    else
    {
        $extname = strtolower(substr($filename, strrpos($filename, '.') + 1));
    }

    if ($limit_ext_types && stristr($limit_ext_types, '|' . $extname . '|') === false)
    {
        return '';
    }		
	if($extname=='docx')return $extname;	
    $str = $format = '';

    $file = @fopen($filename, 'rb');
  
    if ($file)
    {
    	
         $str= @fread($file, 0x400); // 读取前 1024 个字节
        @fclose($file);
       
    }
    else
    {
    	
        if (stristr($filename, ROOT_PATH) === false)
        {
            if ($extname == 'jpg' || $extname == 'jpeg' || $extname == 'gif' || $extname == 'png' || $extname == 'doc' ||
                $extname == 'xls' || $extname == 'txt'  || $extname == 'zip' || $extname == 'rar' || $extname == 'ppt' ||
                $extname == 'pdf' || $extname == 'rm'   || $extname == 'mid' || $extname == 'wav' || $extname == 'bmp' ||
                $extname == 'swf' || $extname == 'chm'  || $extname == 'sql' || $extname == 'cert')
            {
                $format = $extname;
            }
        }
        else
        {
            return '';
        }
    }

    if ($format == '' && strlen($str) >= 2 )
    {
        if (substr($str, 0, 4) == 'MThd' && $extname != 'txt')
        {
            $format = 'mid';
        }
        elseif (substr($str, 0, 4) == 'RIFF' && $extname == 'wav')
        {
            $format = 'wav';
        }
        elseif (substr($str ,0, 3) == "\xFF\xD8\xFF")
        {
            $format = 'jpg';
        }
        elseif (substr($str ,0, 4) == 'GIF8' && $extname != 'txt')
        {
            $format = 'gif';
        }
        elseif (substr($str ,0, 8) == "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A")
        {
            $format = 'png';
        }
        elseif (substr($str ,0, 2) == 'BM' && $extname != 'txt')
        {
            $format = 'bmp';
        }
        elseif ((substr($str ,0, 3) == 'CWS' || substr($str ,0, 3) == 'FWS') && $extname != 'txt')
        {
            $format = 'swf';
        }
        elseif (substr($str ,0, 4) == "\xD0\xCF\x11\xE0")
        {   // D0CF11E == DOCFILE == Microsoft Office Document
            if (substr($str,0x200,4) == "\xEC\xA5\xC1\x00" || $extname == 'doc')
            {
                $format = 'doc';
            }
            elseif (substr($str,0x200,2) == "\x09\x08" || $extname == 'xls')
            {
                $format = 'xls';
            } elseif (substr($str,0x200,4) == "\xFD\xFF\xFF\xFF" || $extname == 'ppt')
            {
                $format = 'ppt';
            }
        } elseif (substr($str ,0, 4) == "PK\x03\x04")
        {
            $format = 'zip';
        } elseif (substr($str ,0, 4) == 'Rar!' && $extname != 'txt')
        {
            $format = 'rar';
        } elseif (substr($str ,0, 4) == "\x25PDF")
        {
            $format = 'pdf';
        } elseif (substr($str ,0, 3) == "\x30\x82\x0A")
        {
            $format = 'cert';
        } elseif (substr($str ,0, 4) == 'ITSF' && $extname != 'txt')
        {
            $format = 'chm';
        } elseif (substr($str ,0, 4) == "\x2ERMF")
        {
            $format = 'rm';
        } elseif ($extname == 'sql')
        {
            $format = 'sql';
        } elseif ($extname == 'txt')
        {
            $format = 'txt';
        }
    }

    if ($limit_ext_types && stristr($limit_ext_types, '|' . $format . '|') === false)
    {
        $format = '';
    }

    return $format;
    }

	/**
	   * 文件上传的处理函数
	   *
	*/
  function upload_file($upload, $dir = '')
	{
		  
		 $thumb_dir = $dir;
		 if(empty($upload['name']))
		 {
		  return false;
		 }
		  /* 没有指定目录默认为根目录 data */
		  if (empty($dir))
		  {
			  $dir = date('Ym'); /* 创建当月目录 */
			  $dir = ROOT_PATH . $this->images_dir . '/' . $dir . '/';
		  }
		  else
		  {
			  $every_dir = date('Ym');/* 创建目录 */
			  $dir = ROOT_PATH . $this->data_dir . '/' . $dir . '/' . $every_dir . '/';
		  }
  
  
		  /* 如果目标目录不存在，则创建它 */
		  if (!file_exists($dir))
		  {
			  if (!mkdir($dir))
			  {
				  /* 创建目录失败 */
				  $this->error_msg('javascript:history.go(-1)','目录不存在或不可写');
				  return false;
			  }
		  }
		  if (empty($file_name))
		  {
			  $file_name = $this->random_filename();
			  $file_name = $dir . $file_name . $this->get_filetype($upload['name']);
		  }
		  
		  /* 允许上传的文件类型 */
		 //$allow_file_types = '|GIF|JPG|JEPG|PNG|BMP|SWF|RAR|ZIP|DOC|DOCX|xls|rm|chm|wav|pdf|flv|';
			$allow_file_types = '|GIF|JPG|JEPG|PNG|DOC|DOCX|';	
		  if (!$this->check_file_type($upload['tmp_name'], $file_name, $allow_file_types))
		  {
			  $this->error_msg('javascript:history.go(-1)','不是允许的格式');
			  return false;
		  }
		  if ($this->move_file($upload, $file_name))
		  {			  
			  return str_replace(ROOT_PATH, '/', $file_name);
		  }
		  else
		  {
			  $this->error_msg('javascript:history.go(-1)','文件上传失败');
			  return false;
		  }
	  }

	
	



}

?>