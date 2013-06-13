<?php

class Upload {

	// If you want to ignore the uploaded files, 
	// set $demo_mode to true;

	private static $demo_mode = false;
	private static $allowed_ext = array('jpg','jpeg','png','gif','webp');

	public static function receive($files)
	{
		Log::info(json_encode($files));

		$success = false;

		if (array_key_exists('pic',$files) && $files['pic']['error'] == 0 ){
			
			$pic = $files['pic'];

			$file = UploadedFile::findOrCreate($pic['tmp_name'],$pic['name']);

			if ($file) {
				Log::info('File uploaded: '.$pic['name'].' to '.$file->fullName);

				if (empty($file->id)) {
					$file->save();
					if (move_uploaded_file($pic['tmp_name'], $file->fullName)) 
					{
						chmod($file->fullName, 0644);
						
						Log::info('Generating all other resolutions...');
						$file->generateAllResolutions();
						$success = true;
					} else {
						$file->delete();
					}
				} else {
					$success = true;
				}

				if ($success) {
					$userFile = new UserFile($file, ActiveSession::user()); /// will be saved automatically
				}
			}
		}

		if ($success) 	$return = ['success' => 'true', 'file' => $file->checksum];
		else 			$return = ['success' => 'false'];	
		
		return Response::json($return);
	}

	private static function exitStatus($str){
		Log::info($str);

		return json_encode(array('status'=>$str));
	}

	private static function getExtension($file_name)
	{
		$ext = explode('.', $file_name);
		$ext = array_pop($ext);
		return strtolower($ext);
	}

	private static function uploadDir()
	{
		return base_path().'/public'.static::$upload_dir;
	}

}