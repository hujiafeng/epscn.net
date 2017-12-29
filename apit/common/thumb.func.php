<?php
/**
 * 缩略图.
 * @author wushihong
 * @param string $sImg 源图
 * @param string $dImg 新图
 * @param int $dwh 新图宽高
 * @param int $way 缩图方式
 * @param int $quality 图片质量
 * @param string $pos 坐标
 * @return array
 */
function thumb($sImg, $dImg, $dwh=100, $way=1, $quality=85, $pos='0,0,100,100')
{
    list($sWidth, $sHeight, $sExt) = getimagesize($sImg);
    switch ($way) {
        //截取源图中间区域正方形缩略
        case 2:
            if ($sWidth >= $sHeight) {
                $sx = intval(($sWidth - $sHeight) / 2);
                $sy = 0;
                $sWidth = $sHeight;
            } else {
                $sy = intval(($sHeight - $sWidth) / 2);
                $sx = 0;
                $sHeight = $sWidth;
            }
            $dWidth = $dHeight = $dwh;
            break;
        //按宽等比缩放
        case 3:
            if ($sWidth > $dwh) {
                $dWidth = $dwh;
                $dHeight = intval($sHeight * $dWidth / $sWidth);
            } else {
                $dWidth = $sWidth;
                $dHeight = $sHeight;
            }
            $sx = $sy = 0;
            break;
        //按区域位置,需要$pos
        case 4:
            $arr = explode(',', $dwh);
            if (count($arr) > 1) {
                $dWidth = intval($arr[0]);
                $dHeight = intval($arr[1]);
            } else {
                $dWidth = $dHeight = intval($dwh);
            }
            $arr = explode(',', $pos);
            $sWidth = intval($arr[2] - $arr[0]);
            $sHeight = intval($arr[3] - $arr[1]);
            $sx = intval($arr[0]);
            $sy = intval($arr[1]);
            break;
        //按限定宽高等比放到最大裁剪再按限定宽高进行缩略
        case 5:
            $arr = explode(',', $dwh);
            $dWidth = $arr[0];
            $dHeight = $arr[1];
            $xh = $sWidth * $dHeight / $dWidth;
            if ($xh > $sHeight) {
                $xw = $sHeight * $dWidth / $dHeight;
                $sx = intval(($sWidth - $xw) / 2);
                $sy = 0;
                $sWidth = $xw;
            } else {
                $sx = 0;
                $sy = intval(($sHeight - $xh) / 2);
                $sHeight = $xh;
            }
            break;
        //$way=1，宽高在正方形之内
        default:
            if ($sWidth <= $dwh && $sHeight <= $dwh) {
                $p = 1;
            } else {
                if ($sWidth < $sHeight) {
                    $p = $dwh / $sHeight;
                } else {
                    $p = $dwh / $sWidth;
                }
            }
            $dWidth = intval($sWidth * $p);
            $dHeight = intval($sHeight * $p);
            $sx = $sy = 0;
            break;
    }
    $img = createFrom($sExt, $sImg);
    //imagesavealpha($img,true);
    $thumb = imagecreatetruecolor($dWidth, $dHeight);
    //imagealphablending($thumb,false); //imagesavealpha($thumb,true);
    if (function_exists("imagecreatetruecolor")) {
        imagecopyresampled($thumb, $img, 0, 0, $sx, $sy, $dWidth, $dHeight, $sWidth, $sHeight);
    } else {
        imagecopyresized($thumb, $img, 0, 0, $sx, $sy, $dWidth, $dHeight, $sWidth, $sHeight);
    }
    image($sExt, $thumb, $dImg, $quality);
    imagedestroy($img);
    imagedestroy($thumb);
    return array($dImg, $dWidth, $dHeight, $sWidth, $sHeight);
}

function createFrom($sExt, $sImg){
    switch($sExt){
        case 1:
            $img = imagecreatefromgif($sImg);
            break;
        case 2:
            $img = imagecreatefromjpeg($sImg);
            break;
        case 3:
            $img = imagecreatefrompng($sImg);
            break;
        default:
            $img = imagecreatefromjpeg($sImg);
            break;
    }
    return $img;
}

function image($sExt, $thumb, $dImg, $quality){
    switch($sExt){
        case 1:
            imagegif($thumb, $dImg, $quality);
            break;
        case 2:
            imagejpeg($thumb, $dImg, $quality);
            break;
        case 3:
            imagepng($thumb, $dImg);
            break;
        default:
            imagejpeg($thumb, $dImg, $quality);
            break;
    }
}