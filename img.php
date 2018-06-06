<?php 
	//php-simple-thumb by UserGhost411

	error_reporting(0);
	function check_security($source_img){
	$word_denied = "Access denied";
	if (strpos($source_img , '..') !== false) {
	die($word_denied);
	}
	if (strpos($source_img , '/') !== false) {
	die($word_denied);
	}
	if (strpos($source_img , '//') !== false) {
	die($word_denied);
	}
	if (strpos($source_img , '.php') !== false) {
	die($word_denied);
	}
	if (strpos($source_img , 'php://') !== false) {
	die($word_denied);
	}
	if (file_exists($source_img)) {
	} else {
    die("404 File Not Found");
	}
	}
	
	function compress($source, $destination, $quality) {
		$info = getimagesize($source);
		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);
		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);
		imagejpeg($image, $destination, $quality);
		return $destination;
	}
	
	function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
    return $randomString;
	}
	
	$source_img = $_GET['image'];
	$quality_img = $_GET['quality'];
	
	
	check_security($source_img);
		if (empty($quality_img) or $quality_img==null){
			$quality_img=10;
		}
	$destination_img = generateRandomString();
	$d = compress($source_img, $destination_img, $quality_img);
	makeThumbnails($destination_img);
	
	function makeThumbnails($updir){
    $thumb_beforeword = "thumb";
    $arr_image_details = getimagesize("$updir");
    $original_width = $arr_image_details[0];
    $original_height = $arr_image_details[1];
	if (empty($_GET['size'])){
	$thumbnail_width = $original_width / 2;
    $thumbnail_height = $original_height / 2;
    }else{
	$siz = explode("x",$_GET['size']);
	$thumbnail_width =  $siz[0];
    $thumbnail_height = $siz[1];
	}
	if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);
    if ($arr_image_details[2] == IMAGETYPE_GIF) {
        $imgt = "ImageGIF";
		$extx = "gif";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == IMAGETYPE_JPEG) {
        $imgt = "ImageJPEG";
		$extx = "jpg";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == IMAGETYPE_PNG) {
        $imgt = "ImagePNG";
		$extx = "png";
        $imgcreatefrom = "ImageCreateFromPNG";
    }
    if ($imgt) {
        $old_image = $imgcreatefrom("$updir");
        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
		$destination_img_thumb="$updir" . '_'  ."thumb.". "$extx";
        $imgt($new_image, "$updir" . '_' ."thumb.". "$extx");
    }

	$remoteImage = $destination_img_thumb;
	$imginfo = getimagesize($remoteImage);
	header("Content-type: {$imginfo['mime']}");
	readfile($remoteImage);
	unlink($destination_img_thumb);
										}
										
	unlink($destination_img);
 ?>