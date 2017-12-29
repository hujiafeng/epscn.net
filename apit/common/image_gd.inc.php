<?php
/**
 *图像处理
 *@author shaohui <wsshh1314@outlook.com>
 *@version 1.0
 *
 */
/**
 * 
 * 缩放图片
 * @param string $src
 * @param string $saveas
 * @param int $new_w
 * @param int $new_h
 * @param boolean $scale
 * @param int $quality
 * @param int $crop_x 
 * @param int $crop_y
 * @param int $crop_w
 * @param int $crop_h
 * 
 * @return boolean 
 */
function image_gd_resize($src,$saveas,$new_w,$new_h,$byscale=false,$quality=75,$crop_x=0,$crop_y=0,$crop_w=0,$crop_h=0){
		//获取扩展
	  $r=true;
	  $ext = strtoupper(pathinfo($src, PATHINFO_EXTENSION)); 
	  if(is_file($src) && ($ext == "JPG" || $ext == "JPEG")) {
	  	$img_input=imagecreatefromjpeg($src);
	  } 
	  elseif(is_file($src) && $ext == "PNG"){
	  	$img_input=imagecreatefrompng($src);
	  }
	  elseif(is_file($src) && $ext == "GIF"){
	  	$img_input=imagecreatefromgif($src);
	  }
	 else{
	 	$r=false;
	 	return $r;
	 }
	 //create image out
	 list($src_w,$src_h)=getimagesize($src);
	 $img_out=imagecreatetruecolor($new_w, $new_h);
	 //直接缩放
	 if($byscale){ 	
	 	$r=imagecopyresampled($img_out, $img_input, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
		//echo "R=".$r;
	 }
	 else{//裁剪缩放
	 	if(($src_w-$crop_x) < $crop_w){
	 		$crop_new_w=$src_w-$crop_x;
	 	}
	 	else{
	 		$crop_new_w=$crop_w;
	 	}
	 	if(($src_h-$crop_y) <$crop_h){
	 		$crop_new_h=$src_h-$crop_y;
	 	}
	 	else{
	 		$crop_new_h=$crop_h;
	 	}
	 	$r=imagecopyresampled($img_out, $img_input, 0, 0, $crop_x, $crop_y, $new_w, $new_h, $crop_new_w, $crop_new_h);
	 }
	 //输出
	 if($r){

	 		if($ext=="JPG"|| $ext == "JPEG"){
	 			$r=imagejpeg($img_out,$saveas,$quality);
	 		}
	 		elseif($ext=="PNG"){
	 			$r=imagepng($img_out,$saveas);
	 		}
	 		elseif($ext=="GIF"){
	 			$r=imagegif($img_out,$saveas);
	 		}
	 }
	 @imagedestroy($img_input);
	 @imagedestroy($img_out);
	 //result
	 return $r;
}
/**
 * 
 * 中心裁剪 正方形图片
 * @param string $src 原图片路径
 * @param string $saveas 保存路径
 * @param int $size 裁剪大小，if w OR h < size 按最小的计算,size不起作用
 * @param int $quality 质量，for jpeg
 */
 function image_gd_center_crop($src,$saveas,$size,$quality=75){
 	
 	  $r=true;
	  $ext = strtoupper(pathinfo($src, PATHINFO_EXTENSION)); 
	 // if(is_file($src) && ($ext == "JPG" || $ext == "JPEG")) {
	  	$img_input=imagecreatefromjpeg($src);
	  //} 
	  /* elseif(is_file($src) && $ext == "PNG"){
	  	$img_input=imagecreatefrompng($src);
	  } */
// 	  elseif(is_file($src) && $ext == "GIF"){
// 	  	$img_input=imagecreatefromgif($src);
// 	  }
// 	 else{
// 	 	$r=false;
// 	 	return $r;
// 	 }
	 //create image out
	 list($src_w,$src_h)=getimagesize($src);
	
	if($src_w < $size || $src_h < $size){
		if($src_w >= $src_h){//w>h
			 $img_out=imagecreatetruecolor($src_h, $src_h);
			 $delta=($src_w-$src_h)/2;
			 $r=imagecopyresampled($img_out, $img_input, 0, 0, $delta, 0, $src_h, $src_h, $src_h, $src_h);
		}
		else{//w<h
			 $img_out=imagecreatetruecolor($src_w, $src_w);
			 $delta=($src_h-$src_w)/2;
			 $r=imagecopyresampled($img_out, $img_input, 0, 0, 0, $delta, $src_w, $src_w, $src_w, $src_w);
		}
	}
	else{//center crop to size
		$img_out=imagecreatetruecolor($size, $size);
		if($src_w >= $src_h ){ //w>h
			 $delta=($src_w-$src_h)/2;
			 $r=imagecopyresampled($img_out, $img_input, 0, 0, $delta, 0, $size, $size, $src_h, $src_h);
		}
		else{//w<h
			 $delta=($src_h-$src_w)/2;
			 $r=imagecopyresampled($img_out, $img_input, 0, 0, 0, $delta, $size, $size, $src_w, $src_w);
		}
	}
	 //输出
	 if($r){

	 		if($ext=="JPG"|| $ext == "JPEG"){
	 			$r=imagejpeg($img_out,$saveas,$quality);
	 		}
	 		elseif($ext=="PNG"){
	 			$r=imagepng($img_out,$saveas);
	 		}	
	 		elseif($ext=="GIF"){
	 			$r=imagegif($img_out,$saveas);
	 		}
	 }
	 @imagedestroy($img_input);
	 @imagedestroy($img_out);
	 //result
	 return $r;
 }
/**
 * 
 * 设置内存
 * @param string $filename
 * @return boolean
 */

function setMemoryForImage($filename) 
{ 
   $imageInfo    = getimagesize($filename); 
   $memoryNeeded = round(($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $imageInfo['channels'] / 8 + Pow(2, 16)) * 1.65); 
   
   $memoryLimit = (int) ini_get('memory_limit')*1048576; 

  if ((memory_get_usage() + $memoryNeeded) > $memoryLimit) 
   { 
     ini_set('memory_limit', ceil((memory_get_usage() + $memoryNeeded + $memoryLimit)/1048576).'M'); 
     return (true); 
   } 
   else return(false); 
} 


?>