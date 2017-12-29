<?php

/* * 项目扩展函数库 * Edit date：20120703
 * Author：旅行者
 */
	function editor_safe_replace($content){
	$tags = array(
		"'<iframe[^>]*?>.*?</iframe>'is",
		"'<frame[^>]*?>.*?</frame>'is",
		"'<script[^>]*?>.*?</script>'is",
		"'<head[^>]*?>.*?</head>'is",
		"'<title[^>]*?>.*?</title>'is",
		"'<meta[^>]*?>'is",
		"'<link[^>]*?>'is",
	);
	return preg_replace($tags, "", $content);
}

/**
	 * 检查管理员密码合法性
	 * @param string $password 密码
	 */
	function checkpasswd($password){
		if (!is_password($password)){
			return false;
		}
		return true;
	}
	
/**
 * 检查密码长度是否符合规定
 *
 * @param STRING $password
 * @return 	TRUE or FALSE
 */
function is_password($password) {
	$strlen = strlen($password);
	if($strlen >= 6 && $strlen <= 20) return true;
	return false;
}

/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function password($password, $encrypt='') {
	$pwd = array();
	$pwd['encrypt'] =  $encrypt ? $encrypt : create_randomstr();	
	$pwd['password'] = md5(md5(trim($password)).$pwd['encrypt']);
	return $encrypt ? $pwd['password'] : $pwd;
}
/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function create_randomstr($lenth = 6) {
	return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}
/**
* 产生随机字符串
*
* @param    int        $length  输出长度 
* @param    string     $chars   可选的 ，默认为 0123456789
* @return   string     字符串
*/
function random($length, $chars = '0123456789') {
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

/**
 * 检查用户名是否符合规定
 *
 * @param STRING $username 要检查的用户名
 * @return 	TRUE or FALSE
 */
function is_username($username) {
	$strlen = strlen($username);
	if(is_badword($username) || !preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $username)){
		return false;
	} elseif ( 20 <= $strlen || $strlen < 2 ) {
		return false;
	}
	return true;
}

 /**
 * 检测输入中是否含有错误字符
 *
 * @param char $string 要检查的字符串名称
 * @return TRUE or FALSE
 */
function is_badword($string) {
	$badwords = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n","#");
	foreach($badwords as $value){
		if(strpos($string, $value) !== FALSE) {
			return TRUE;
		}
	}
	return FALSE;
}


/**
 * 判断email格式是否正确
 * @param $email
 */
function is_email($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}







// 调用接口服务
function X($name, $params = array(), $domain = 'Service') {
    //创建一个静态变量，用于缓存实例化的对象
    static $_service = array();
    $app = C('DEFAULT_APP');
    //如果已经实例化过，则返回缓存实例化对象
    if (isset($_service[$domain . '_' . $app . '_' . $name]))
        return $_service[$domain . '_' . $app . '_' . $name];
    //载入文件
    $class = $name . $domain;
    import("Com.{$domain}.{$name}{$domain}");
    //服务不可用时 记录日志 或 抛出异常
    if (class_exists($class)) {
        $obj = new $class($params);
        $_service[$domain . '_' . $app . '_' . $name] = $obj;
        return $obj;
    } else {
        return false;
    }
}

// 实例化服务
function service($name, $params = array()) {
    return X($name, $params = array(), 'Service');
}

//调用TagLib类
function TagLib($name, $params = array()) {
    return X($name, $params = array(), 'TagLib');
}


/**
 * 截取字符串
 *
 * @author 旅行者 qq:844745349
 * @sourcestr    原字符串
 * @startlength  开始位置
 * @cutlength    截取长度
 */
function truncate($sourcestr,$cutlength) 
{ 
    $startlength=0;
	$returnstr=''; 
	$i=0; 
	$n=0; 
	$str_length=strlen($sourcestr);            //字符串的字节数 
	while (($n<$cutlength) and ($i<=$str_length))
	{ 
	$temp_str=substr($sourcestr,$i,1); 
	$ascnum=Ord($temp_str);               //得到字符串中第$i位字符的ascii码 
	if ($ascnum>=224) {                  //如果ASCII位高与224，
	   $returnstr=$returnstr.substr($sourcestr,$i,3);  //根据UTF-8编码规范，将3个连续的字符计为单个字符         
	   $i=$i+3;                           //实际Byte计为3
	   $n++;                             //字串长度计1
	} elseif ($ascnum>=192){              //如果ASCII位高与192，
	   $returnstr=$returnstr.substr($sourcestr,$i,2);  //根据UTF-8编码规范，将2个连续的字符计为单个字符 
	   $i=$i+2;                           //实际Byte计为2
	   $n++;                            //字串长度计1
	} elseif ($ascnum>=65 && $ascnum<=90){       //如果是大写字母，
	   $returnstr=$returnstr.substr($sourcestr,$i,1); 
	   $i=$i+1;                           //实际的Byte数仍计1个
	   $n++;                            //但考虑整体美观，大写字母计成一个高位字符
	} else {                              //其他情况下，包括小写字母和半角标点符号，
	   $returnstr=$returnstr.substr($sourcestr,$i,1); 
	   $i=$i+1;                           //实际的Byte数计1个
	   $n=$n+0.5;                        //小写字母和半角标点等与半个高位字符宽...
	} 
	
	if ($n <= $startlength){
	  $returnstr = '';
	  continue;
	}
	}
	
	if ($str_length>$cutlength){
	 $returnstr = $returnstr . "...";          //超过长度时在尾处加上省略号
	}
	return $returnstr; 
 }

/**
 * 取得文件扩展
 * 
 * @param $filename 文件名
 * @return 扩展名
 */
function fileext($filename) {
    return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}
/**
 * 安全过滤函数
 *
 * @param $string
 * @return string
 */
function safe_replace($string) {
    $string = str_replace('%20', '', $string);
    $string = str_replace('%27', '', $string);
    $string = str_replace('%2527', '', $string);
    $string = str_replace('*', '', $string);
    $string = str_replace('"', '&quot;', $string);
    $string = str_replace("'", '', $string);
    $string = str_replace('"', '', $string);
    $string = str_replace(';', '', $string);
    $string = str_replace('<', '&lt;', $string);
    $string = str_replace('>', '&gt;', $string);
    $string = str_replace("{", '', $string);
    $string = str_replace('}', '', $string);
    return $string;
}

/**
 * 返回经stripslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string) {
    if (!is_array($string))
        return stripslashes($string);
    foreach ($string as $key => $val)
        $string[$key] = new_stripslashes($val);
    return $string;
}

/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string) {
    if (!is_array($string))
        return addslashes($string);
    foreach ($string as $key => $val)
        $string[$key] = new_addslashes($val);
    return $string;
}

/**
 *  用于前台模板检测 
 * @param type $templateFile
 * @return boolean|string 
 */
function parseTemplateFile($templateFile = '') {
    $config = F("Config");
    if ('' == $templateFile) {
        // 如果模板文件名为空 按照默认规则定位
        $templateFile = C('TEMPLATE_NAME');
    } elseif (false === strpos($templateFile, C('TMPL_TEMPLATE_SUFFIX'))) {
        // 解析规则为 模板主题:模块:操作 不支持 跨项目和跨分组调用
        $path = explode(':', $templateFile);
        $action = array_pop($path);
        $module = !empty($path) ? array_pop($path) : MODULE_NAME;
        $path = TEMPLATE_PATH . $config['theme'] . "/Contents/";
        $depr = defined('GROUP_NAME') ? C('TMPL_FILE_DEPR') : '/';
        $templateFile = $path . $module . $depr . $action . C('TMPL_TEMPLATE_SUFFIX');
    }
    if (!file_exists_case($templateFile)) {
        return false;
    }
    return $templateFile;
}

/**
 * 分页输出
 * @param type $Total_Size 总记录数
 * @param type $Page_Size 分页大小
 * @param type $Current_Page 当前页
 * @param type $listRows 显示页数
 * @param type $PageParam 分页参数
 * @param type $PageLink 分页链接
 * @param type $Static 是否(伪)静态
 * @return \Page 
 * 其他说明 ：当开启静态的时候 $PageLink 传入的是数组，数组格式

 */
function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE, $TP = "") {
    static $_pageCache = array();
    $cacheIterateId = md5($Total_Size . $Page_Size . $Current_Page . $listRows . $PageParam);
    if (isset($_pageCache[$cacheIterateId]))
        return $_pageCache[$cacheIterateId];

    import('Com.Util.Page');
    if ($Page_Size == 0) {
        $Page_Size = C("PAGE_LISTROWS");
    }
    if (empty($PageParam)) {
        $PageParam = C("VAR_PAGE");
    }
    //生成静态，需要传递一个常量URLRULE，来生成对应规则
    if (empty($PageLink) && $Static == true) {
        $P = explode("~", URLRULE);
        $PageLink = array();
        $PageLink['index'] = $P[0];
        $PageLink['list'] = $P[1];
    }
    if (empty($TP)) {
        $TP = '共有{recordcount}条信息&nbsp;{pageindex}/{pagecount}&nbsp;{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}';
    }
    $Page = new Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
    $Page->SetPager('default', $TP, array("listlong" => "6", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));

    $_pageCache[$cacheIterateId];
    return $Page;
}

/**
 * 取得URL地址中域名部分
 * @param type $url 
 * @return \url 返回域名
 */
function urlDomain($url){
    if(preg_match_all('#https?://(.*?)($|/)#m', $url, $Domain)){
        return $Domain[0][0];
    }
    return false;
}

/**
 * 分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $pageurls 链接地址
 * @return 分页
 */
function content_pages($num, $curr_page,$pageurls) {

	$multipage = '';
	$page = 11;
	$offset = 4;
	$pages = $num;
	$from = $curr_page - $offset;
	$to = $curr_page + $offset;
	$more = 0;
	if($page >= $pages) {
		$from = 2;
		$to = $pages-1;
	} else {
		if($from <= 1) {
			$to = $page-1;
			$from = 2;
		} elseif($to >= $pages) {
			$from = $pages-($page-2);
			$to = $pages-1;
		}
		$more = 1;
	}
	
	if($curr_page>0) {
		$perpage = $curr_page == 1 ? 1 : $curr_page-1;
		if($curr_page!=1)$multipage .= '<a class="a1" href="'.$pageurls[$perpage][0].'">上一页</a>';
		if($curr_page==1) {
			$multipage .= ' <span>1</span>';
		} elseif($curr_page>6 && $more) {
			$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>..';
		} else {
			$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>';
		}
	}
	for($i = $from; $i <= $to; $i++) {
		if($i != $curr_page) {
			$multipage .= ' <a href="'.$pageurls[$i][0].'">'.$i.'</a>';
		} else {
			$multipage .= ' <span>'.$i.'</span>';
		}
	}
	if($curr_page<$pages) {
		if($curr_page<$pages-5 && $more) {
			$multipage .= ' ..<a href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a class="a1" href="'.$pageurls[$curr_page+1][0].'">下一页</a>';
		} else {
			$multipage .= ' <a href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a class="a1" href="'.$pageurls[$curr_page+1][0].'">下一页</a>';
		}
	} elseif($curr_page==$pages) {
		//$multipage .= ' <span>'.$pages.'</span> <a class="a1" href="'.$pageurls[$curr_page][0].'">下一页</a>';
		$multipage .= ' <span>'.$pages.'</span>';
	}
	
	return $multipage;
}

/**
 * 字符截取 支持UTF8/GBK
 * @param $string
 * @param $length
 * @param $dot
 */
function str_cut($string, $length, $dot = '...') {
	$charset='utf-8';
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	$string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
	$strcut = '';
	if($charset == 'utf-8') {
		$length = intval($length-strlen($dot)-$length/3);
		$n = $tn = $noc = 0;
		while($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);
		$strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
	} else {
		$dotlen = strlen($dot);
		$maxi = $length - $dotlen - 1;
		$current_str = '';
		$search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
		$replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
		$search_flip = array_flip($search_arr);
		for ($i = 0; $i < $maxi; $i++) {
			$current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			if (in_array($current_str, $search_arr)) {
				$key = $search_flip[$current_str];
				$current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
			}
			$strcut .= $current_str;
		}
	}
	return $strcut.$dot;
}
?>
