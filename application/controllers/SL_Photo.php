<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'SL.php';

class SL_Photo_Controller extends SL_Controller {
	protected $server_type = 'ftp';
	// local,ftp,
	protected $max_width = 1280;
	protected $max_height = 1024;
	protected $thumb_array = array('large_thumb' => array('width' => 400, 'height' => 300), 'medium_thumb' => array('width' => 200, 'height' => 200), 'small_thumb' => array('width' => 100, 'height' => 100));

	public function photo_upload($id, $makeThumbnail = true) {
		$upload_data = $this -> _photo_upload($id);

		if ($makeThumbnail) {
			$photos = $this -> _makeThumbnail($upload_data);
		} else {
			$photos=array();
			$photos['origin']=array('file_name'=>$upload_data['file_name'],'file_path'=>$upload_data['file_path'],'full_path'=>$upload_data['file_path'].$upload_data['file_name']);
		}

		switch($this->server_type) {
			case 'ftp' :
				$upload_data['full_url']=$this -> _upToFTP($id,$photos);
				break;
			case 'S3' :
				$upload_data['full_url']=$this -> _upToS3($id,$photos);
				break;
		}

		return $upload_data;
	}

	protected function check_and_make_directory($uploads_directory, Array $directory_array) {
		if (!count($directory_array))
			throw new Exception('upload directory not exists', 1);

		$check_directory = $uploads_directory;
		foreach ($directory_array as $value) {
			$check_directory .= DIRECTORY_SEPARATOR . $value;

			if (!file_exists($check_directory)) {
				if (!mkdir($check_directory)) {
					throw new Exception($check_directory . ' can not make', 1);
				}
			}
		}
		return $check_directory;
	}
	
	protected function ftp_check_and_make_directory($conn_id,$uploads_directory, Array $directory_array) {
		if (!count($directory_array))
			throw new Exception('upload directory not exists', 1);

		$check_directory = $uploads_directory;
			if (!ftp_chdir($conn_id,$check_directory)) {
				if (!ftp_mkdir($conn_id,$check_directory)) {					
					throw new Exception($check_directory . ' can not make', 1);
				}
			}
			
		foreach ($directory_array as $value) {
			if (!ftp_chdir($conn_id,$value)) {
				if (!ftp_mkdir($conn_id,$value)) {					
					throw new Exception($value . ' can not make', 1);
				} else {
					if (!ftp_chdir($conn_id,$value)) {
						throw new Exception($check_directory . ' can not move', 1);
					}
				}
			}
		}
		
		return $uploads_directory.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $directory_array);
	}

	protected function _upToS3($id,Array $files) {
		$s3 = $this -> config -> item('s3');

		if (!$s3)
			throw new Exception("Error Processing Request", 1);

		$this -> load -> library('S3');
		$s3 = new S3();

		$bucket = $this -> config -> item('bucket');

		foreach ($files as $key => $value) {
			if ($s3 -> putObjectFile($config['upload_path'] . DIRECTORY_SEPARATOR . $key.'_'. $value['file_name'], $bucket, $directory . DIRECTORY_SEPARATOR . 'photo' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $key.'_'. $value['file_name'], S3::ACL_PUBLIC_READ)) {
				//echo "We successfully uploaded your file.";
			} else {
				//echo "Something went wrong while uploading your file... sorry.";
			}
		}
	}

	protected function _upToFTP($id,Array $files) {
		$this->config->load('ftp');
		
		$ftp_server = $this-> config -> item('ftp_server');
		$ftp_user_name = $this-> config -> item('ftp_user');
		$ftp_user_pass = $this-> config -> item('ftp_password');
		$base_uploads_directory = $this -> config -> item('ftp_uploads_directory');
		
		$conn_id = ftp_connect($ftp_server);
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		$directory = lcfirst($this -> model);
		$directory_array = array($directory, 'photo', $id);
		
		$upload_directory=$this->ftp_check_and_make_directory($conn_id,$base_uploads_directory,$directory_array);

		foreach ($files as $index => $value) {		
			$fp = fopen($value['full_path'], 'r');
			
			if (ftp_fput($conn_id, $upload_directory.DIRECTORY_SEPARATOR.$value['file_name'], $fp, FTP_BINARY)) {
				//echo 'Successfully uploaded '.$value['file_name']."\n";
			} else {
				//echo 'There was a problem while uploading '.$value['file_name']."\n";
			}
		}

		ftp_close($conn_id);
		fclose($fp);
		
		return str_replace($base_uploads_directory, 'http://'.$ftp_server, $upload_directory.DIRECTORY_SEPARATOR.$value['file_name']);
	}

	protected function _photo_upload($id) {
		$uploads_directory = $this -> config -> item('uploads_directory');

		$directory = lcfirst($this -> model);

		if (!file_exists($uploads_directory))
			throw new Exception('upload directory not exists', 1);

		if ($this -> server_type == 'localhost') {
			$directory_array = array($directory, 'photo', $id);
		} else {
			$directory_array = array('tmp', $directory, $id);
		}

		$config['upload_path'] = $this -> check_and_make_directory($uploads_directory, $directory_array);

		if (!$config['upload_path']) {
			throw new Exception('upload directory not exists', 1);
		}

		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['encrypt_name'] = true;
		$config['max_width'] = $this -> max_width;
		$config['max_height'] = $this -> max_height;

		$this -> load -> library('upload', $config);
		$this -> upload -> initialize($config);

		if (!$this -> upload -> do_upload('photo')) {
			$this -> error = $this -> upload -> display_errors();
			return false;
		}

		return $this -> upload -> data();
	}

	protected function _makeThumbnail(Array $file) {
		$config['image_library'] = 'gd2';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = FALSE;
		$config['thumb_marker'] = '';
		$config['source_image'] = $file['full_path'];
		$this -> load -> library('image_lib', $config);

		foreach ($this->thumb_array as $key => $value) {
			$config['new_image'] = $key . '_' . $file['file_name'];
			$config['width'] = $value['width'];
			$config['height'] = $value['height'];
			$this -> image_lib -> initialize($config);
			if ($this -> image_lib -> resize()) {
				$data[$key]=array('file_name'=>$config['new_image'],'file_path'=>$file['file_path'],'full_path'=>$file['file_path'].$config['new_image']);
			}
		}

		$data['origin']=array('file_name'=>$file['file_name'],'file_path'=>$file['file_path'],'full_path'=>$file['file_path'].$file['file_name']);

		return $data;
	}

}
