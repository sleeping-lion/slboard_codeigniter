<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'SL.php';

class Galleries extends SL_Controller {
	protected $model='Gallery';
	
	public function add() {
		$this -> load -> library('form_validation');

		if ($this -> form_validation -> run() == FALSE) {
			$this -> layout -> render('galleries/add',array('common_data'=>$this->common_data));
		} else {
			if ($upload_data = $this -> _photo_upload()) {
				$data = $this -> input -> post(NULL, TRUE);
				$data['photo'] = $upload_data['file_name'];
			} else {
				$this -> layout -> render('galleries/add', array('error' => $this -> upload -> display_errors()));
				return true;
			}
			$this -> load -> model('Gallery');
			if ($id = $this -> Gallery -> insert($data)) {
				redirect('users/index');
			} else {
				//$this -> session -> set_flashdata('error', array('type' => 'alert', 'message' => 'gg'));
				$this -> layout -> render('users/add',array('common_data'=>$this->common_data));

			}
		}
	}	
}
