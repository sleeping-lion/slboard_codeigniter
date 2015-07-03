<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'SL.php';

class Blogs extends SL_Controller {
	protected $model='Blog';

	public function edit($id) {
		if(!$this->session->userdata('admin')) {
			redirect('/');
		}
		
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('title', _('title'), 'required|min_length[3]|max_length[60]');
		//$this -> form_validation -> set_rules('content',_('content'), 'required]');

		if ($this -> form_validation -> run() == FAlSE) {
			$this -> load -> model('Community');
			$data['content'] = $this -> Community -> get_content($id);
			
			$this -> layout -> add_js('/ckeditor/ckeditor.js');
			$this -> layout -> add_js('/js/boards/new.js');
			$this -> layout -> render('communities/edit',array('data'=>$data));
		} else {
			$this->load->model('Community');
			$data = $this -> input -> post(NULL, TRUE);
			$data['user_id']=$this->session->userdata('user_id');
			if ($id = $this -> Community -> update($data)) {
			
				$clean['tag'] = explode(',', $data['tag']);
				foreach ($clean['tag'] as $index => $value) {
					$clean['tag'][$index] = trim($value);
				}
				
				$this->load->model('Tag');
				$this -> Tag -> update(array('taggable_id'=>$id,'tags'=>$clean['tag']));
				
				$this->load->model('Poll');
				$this -> Poll -> update(array('poll_community_id'=>$id,'polls'=>$data['poll_title']));
				
				$this -> session -> set_flashdata('message', array('type' => 'success', 'message' => 'gg'));
				redirect('communities');
			} else {
				redirect('communities/edit');
			}
		}
	}

	public function add() {
		if(!$this->session->userdata('admin')) {
			redirect('/');
		}
		
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('title', _('title'), 'required|min_length[3]|max_length[60]');
		//$this -> form_validation -> set_rules('content',_('content'), 'required]');

		if ($this -> form_validation -> run() == FAlSE) {
			$this -> layout -> add_js('/ckeditor/ckeditor.js');
			$this -> layout -> add_js('/js/boards/new.js');
			$this -> layout -> render('communities/add');
		} else {
			$this->load->model('Community');
			$data = $this -> input -> post(NULL, TRUE);
			$data['user_id']=$this->session->userdata('user_id');
			if ($id = $this -> Community -> insert($data)) {
			
				$clean['tag'] = explode(',', $data['tag']);
				foreach ($clean['tag'] as $index => $value) {
					$clean['tag'][$index] = trim($value);
				}
				
				$this->load->model('Tag');
				$this -> Tag -> insert(array('taggable_id'=>$id,'tags'=>$clean['tag']));
				
				$this->load->model('Poll');
				$this -> Poll -> insert(array('poll_community_id'=>$id,'polls'=>$data['poll_title']));
				
				$this -> session -> set_flashdata('message', array('type' => 'success', 'message' => 'gg'));
				redirect('communities');
			} else {
				redirect('communities/add');
			}
		}
	}

	public function confirm_delete($id) {
		$this -> layout -> render('communities/confirm_delete',array('id'=>$id));
	}
	
	public function delete($id) {
		$this->load->model('Community');
		if($this->Community->delete($id)) {
			$this -> session -> set_flashdata('message', array('type' => 'success', 'message' => 'delete'));
			redirect('communities');
		} else {
			$this -> session -> set_flashdata('message', array('type' => 'alert', 'message' => 'delete'));
			redirect('communities');
		}
	}
}
