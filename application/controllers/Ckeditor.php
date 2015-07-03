<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'SL.php';

class Ckeditor extends SL_Controller {
	public function upload_test() {
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('upload', 'upload', 'required');

		if ($this -> form_validation -> run() == FALSE) {
			$this -> layout -> render('ckeditor/upload_test');
		}
	}
	
	public function upload() {
		if ($upload_data = $this -> _photo_upload()) {
			$this->load->view('ckeditor/upload',array('data'=>array('CKEditorFuncNum'=>1,'url'=>'/uploads/ckeditor/'.$upload_data['file_name'])));
		} else {
			$this -> layout -> render('ckeditor/upload_test', array('error' => $this -> upload -> display_errors()));
			return true;
		}
	}
	
	private function _photo_upload() {
		$config['upload_path'] = './uploads/ckeditor/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['encrypt_name'] = true;
		//$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';

		$this -> load -> library('upload', $config);
		$this -> upload -> initialize($config);

		if ($this -> upload -> do_upload('upload')) {
			$data = $this -> upload -> data();

			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['full_path'];
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 50;
			// $config['height'] = 0;

			$this -> load -> library('image_lib', $config);
			$this -> image_lib -> resize();

			return $data;
		} else {
			return false;
		}
	}	
}
