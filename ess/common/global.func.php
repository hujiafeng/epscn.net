<?php
/**
 * 全局常用函数.
 * @author wushihong
 * @version 1.1
 */

/**
 * set cookie
 * @param string $name
 * @param string $value
 * @param int $life
 * @param string $path
 * @param string $domain
 */
function cookie($name, $value, $life = 0, $path = '/', $domain = '')
{
    $S = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
    setcookie($name, $value, $life ? time() + $life : 0, $path, $domain, $S);
}

/**
 * clear cookie
 * @param string $name
 * @param string $path
 * @param string $domain
 */
function clearCookie($name, $path = '/', $domain = '')
{
    cookie($name, '', -86400 * 365, $path, $domain);
}

/**
 * html字符串格式化.
 * 替换掉html中的特殊字符
 * @param string $sHtml 需要处理的html
 * @return string
 */
function toHtmlChars($sHtml)
{
    $chars = array(
        '&' => '&amp;', '<' => '&lt;', '>' => '&gt;', '\'' => '&apos;',
        '"' => '&quot;', "\n"=>'<br />', ' '=>'&nbsp;'
    );
    return strtr($sHtml, $chars);
}

/**
 * 获取文件扩展名
 * @param $fileName
 * @return string
 */
function getFileExt($fileName)
{
    return strtolower(substr(strrchr($fileName, '.'), 1, 10));
}

/**
 * 随机字符串
 * @param int $len 字符串长度
 * @param int $type 0默认混合 1仅数字 2仅字母
 * @param int $upper 是否大写字母
 * @param int $repeat 重复次数
 * @return string
 */
function random($len, $type = 0, $upper = 0, $repeat = 0)
{
    $s1 = '1234567890';
    $s2 = 'abcdefghijklmnopqrstuvwxyz';
    $s = ($type==1)? $s1: (($type==2)? $s2: $s1.$s2);
    if ($upper) $s = strtoupper($s);
    if ($repeat) $s = str_repeat($s, $repeat);
    return substr(str_shuffle($s), 0, $len);//打乱字符
}

/**
 * alert 弹错框
 * @param string $str
 * @param string $url
 */
function alert($str, $url = '')
{
    if ($url) $script = "location='$url'";
    else $script = "history.back()";
    $script = '<script type="text/javascript">alert("'.$str.'");'.$script.';</script>';
    echo $script;
    exit;
}

/**
 * 跳转连接
 * @param string $url
 */
function location($url)
{
    header("location: $url"); exit;
}

/**
 * 多少时间前
 * @param $past
 * @return string
 */
function timeAgo($past)
{
    $time = time() - $past;
    $year = floor($time / 60 / 60 / 24 / 365);
    $time -= $year * 60 * 60 * 24 * 365;
    $month = floor($time / 60 / 60 / 24 / 30);
    $time -= $month * 60 * 60 * 24 * 30;
    $week = floor($time / 60 / 60 / 24 / 7);
    $time -= $week * 60 * 60 * 24 * 7;
    $day = floor($time / 60 / 60 / 24);
    $time -= $day * 60 * 60 * 24;
    $hour = floor($time / 60 / 60);
    $time -= $hour * 60 * 60;
    $minute = floor($time / 60);
    $time -= $minute * 60;
    $second = $time;
    $elapse = '';
    $unitArr = array('年' => 'year', '个月' => 'month', '周' => 'week', '天' => 'day',
        '小时' => 'hour', '分钟' => 'minute', '秒' => 'second');
    foreach ($unitArr as $cn => $u) {
        if ($$u > 0) {
            $elapse = $$u . $cn; break;
        }
    }
    return $elapse;
}

/**
 * 两个YYYY-MM-DD格式日期相差天数
 * @param string $date1 YYYY-MM-DD
 * @param string $date2 YYYY-MM-DD
 * @return float
 */
function getDiffDay($date1, $date2)
{
    $Date_List_a1 = explode("-", $date1);
    $Date_List_a2 = explode("-", $date2);
    $d1 = mktime(0, 0, 0, $Date_List_a1[1], $Date_List_a1[2], $Date_List_a1[0]);
    $d2 = mktime(0, 0, 0, $Date_List_a2[1], $Date_List_a2[2], $Date_List_a2[0]);
    $Days = round(($d1 - $d2) / 3600 / 24);
    return $Days;
}

/**
 * file_get_contents发送http get请求
 * @param $url
 * @return string
 */
function fgc($url)
{
    $opts = array(
        'http' => array(
            'method' => "GET",
            'timeout' => 2,
        )
    );
    $s = @file_get_contents("$url", false, stream_context_create($opts));
    return $s;
}


/**
 * 获取远程图片，可用系统 copy函数。
 * @param string $url 远程图片
 * @param string $file 拷贝为本地新图片
 * @return bool
 */
function getRemotePhoto($url, $file) {
    if(!$url) return false;
    ob_start();
    readfile($url);
    $img = ob_get_contents();
    ob_end_clean();
    $fp2 = @fopen($file, "a");
    fwrite($fp2, $img);
    fclose($fp2);
    return true;
}

/**
 * 获取来访客户端类型(iphone、ipad、android、pc)
 * @return string
 */
function getAgent(){
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if(strpos($agent, 'iphone')) return 'iphone';
    elseif(strpos($agent, 'ipad')) return 'ipad';
    elseif(strpos($agent, 'android')) return 'android';
    else return 'pc';
}

/**
 * 来源是否是本站
 * @return bool
 */
function isRefererLocal(){
    $arr = array('www.dailyfashion.cn', 'dailyfashion.cn', 'dailyfashion');
    $host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    if(in_array($host, $arr)) return true;
    else return false;
}

/**
 * 是否微信浏览器访问
 * @return bool
 */
function isWeiXin(){
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if(strpos($agent, 'micromessenger')) return true;
    else return false;
}

/**
 * 判断是否是手机访问
 * @return bool
 */
function isMobile(){
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$agent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($agent,0,4)))
        return true;
    else return false;
}

/**
 * 根据生日输出星座
 * @param $date
 * @param $echo_id
 * @return string
 */
function horoscope($date, $echo_id = 0)
{
    $arrDate = explode('-', $date);
    $month = intval($arrDate[1]);
    $day = intval($arrDate[2]);
    if ($month < 1 || $month > 12 || $day < 1 || $day > 31) return false;
    $arrHoroscope = array('水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座', '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '摩羯座');
    $arr = array(
        array("20" => 1), array("19" => 2), array("21" => 3), array("20" => 4), array("21" => 5), array("22" => 6),
        array("23" => 7), array("23" => 8), array("23" => 9), array("24" => 10), array("22" => 11), array("22" => 12)
    );
    list($start, $id) = each($arr[(int)$month - 1]);
    if ($day < $start) list($start, $id) = each($arr[($month - 2 < 0) ? $month = 11 : $month -= 2]);
    if ($echo_id == 0) $horoscope = $arrHoroscope[$id-1];
    else $horoscope = $id;
    return $horoscope;
}
