<?php

class Image {


	static function store() {
		
		// $edit_file = $_edit_id.'_'.basename($_FILES['edit_imagename']['name']);
		// $uploadfile = $orig_uploaddir . $edit_file;
		// if (move_uploaded_file($_FILES['edit_imagename']['tmp_name'], $uploadfile)) 
		// {
		// //---resize image to regular and thumbnail-----------------------------------b
		// $src = imagecreatefromjpeg($uploadfile);
		// $image_info=getimagesize($uploadfile);
		// list($width,$height)=$image_info;
		// //---create 400x400 fullsize--------------b
		// $newwidth=400;
		// $newheight=round(($height/$width)*$newwidth);
		// if ($newheight>400)
		// {
		// 	$newheight=400;
		// 	$newwidth=round(($width/$height)*$newheight);
		// }
		// $tmp=imagecreatetruecolor($newwidth,$newheight);
		// imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		// $filename = $uploaddir . $_edit_id.'_400_'.basename($_FILES['edit_imagename']['name']);
		// imagejpeg($tmp,$filename,100);
		// //---create 400x400 fullsize--------------e
		// //---create 200x200 thumbnail--------------b
		// $tn_width=200;
		// $tn_height=round(($height/$width)*$tn_width);
		// if ($tn_height>200)
		// {
		// 	$tn_height=200;
		// 	$tn_width=round(($width/$height)*$tn_height);
		// }
		// $tmp=imagecreatetruecolor($tn_width,$tn_height);
		// imagecopyresampled($tmp,$src,0,0,0,0,$tn_width,$tn_height,$width,$height);
		// $filename = $uploaddir . $_edit_id.'_200_'.basename($_FILES['edit_imagename']['name']);
		// imagejpeg($tmp,$filename,100);
		// //---create 200x200 thumbnail--------------e
		// imagedestroy($tmp); 



		// /////////////////////


		// $image = file_get_contents('https://graph.facebook.com/100003027438870/picture'); // sets $image to the contents of the url
		// file_put_contents('/path/image.gif', $image); // places the contents in the file /path/image.gif


	}

	public static function url($picture) {
		if (!isset($picture)) {
			return URL::to('assets/img/no-picture.webp');
		} else {
			return URL::to('/').'/'.$picture->getFileName();
		}
	}

}