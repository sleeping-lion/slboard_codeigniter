<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'SL.php';

class Users extends SL_Controller {
	protected $model='User';
	
	public function agree() {
		$this -> load -> library('form_validation');

		$this -> form_validation -> set_rules('agree1', 'Agree', 'required');
		$this -> form_validation -> set_rules('agree2', 'Agree', 'required');

		if ($this -> form_validation -> run() == FALSE) {
			$this -> layout -> render('users/agree',array('common_data'=>$this->common_data));
		} else {
			redirect('users/add');
		}
	}

	public function index($page=0) {
		$this -> layout -> render('users/index');
	}
	
	public function view($id) {
		$this -> layout -> render('users/view');
	}

	public function add() {
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('name', 'Name', 'required|min_length[5]|max_length[60]');
		$this -> form_validation -> set_rules('password', 'Password', 'required|matches[password_confirm]');
		$this -> form_validation -> set_rules('password_confirm', 'Password Confirmation', 'required');
		$this -> form_validation -> set_rules('email', 'Email', 'required|valid_email');

		if ($this -> form_validation -> run() == FALSE) {
			$this -> layout -> add_js('/js/users/add.js');
			$this -> layout -> render('users/add',array('common_data'=>$this->common_data));
		} else {
			if ($upload_data = $this -> _photo_upload()) {
				$data = $this -> input -> post(NULL, TRUE);
				$data['photo'] = $upload_data['file_name'];
			} else {
				$this -> layout -> render('users/add', array('error' => $this -> upload -> display_errors()));
				return true;
			}
			$this -> load -> model('User');
			if ($id = $this -> User -> insert($data)) {
				redirect('users/complete');
			} else {
				//$this -> session -> set_flashdata('error', array('type' => 'alert', 'message' => 'gg'));
				$this -> layout -> render('users/add',array('common_data'=>$this->common_data));

			}
		}
	}

	public function edit($id = null) {
		$this -> load -> model('User');
		$data['content'] = $this -> User -> get_content($this -> session -> userdata('user_id'));

		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('name', 'Name', 'required|min_length[5]|max_length[60]');
		$this -> form_validation -> set_rules('description', 'Description', 'required');

		if ($this -> form_validation -> run() == FALSE) {
			$this -> layout -> render('users/edit', array('data' => $data,'common_data'=>$this->common_data));
		} else {
			if ($upload_data = $this -> _photo_upload()) {
				$data = $this -> input -> post(NULL, TRUE);
				$data['photo'] = $upload_data['file_name'];
			} else {
				$this -> layout -> render('users/edit', array('data' => $data,'common_data'=>$this->common_data, 'error' => $this -> upload -> display_errors()));
				return true;
			}
			$this -> load -> model('User');
			if ($id = $this -> User -> update($data)) {
				redirect('users/edit');
			} else {
				//$this -> session -> set_flashdata('error', array('type' => 'alert', 'message' => 'gg'));
				$this -> layout -> render('users/edit', array('data' => $data,'common_data'=>$this->common_data));
			}
		}
	}

	public function complete() {
		$this -> layout -> render('users/complete',array('common_data'=>$this->common_data));
	}

	public function login() {
		$this -> load -> library('form_validation');

		$this -> form_validation -> set_rules('email', 'Email', 'required|min_length[5]|max_length[255]');
		$this -> form_validation -> set_rules('password', 'Password', 'required|min_length[5]|max_length[255]');

		if ($this -> form_validation -> run() == TRUE) {
			$this -> load -> model('User');
			if ($user = $this -> User -> login($this -> input -> post('email'), $this -> input -> post('password'))) {
				$this -> session -> set_userdata(array('user_id' => $user['id'], 'nickname' => $user['nickname'], 'admin' => $user['admin']));

				if ($this -> input -> post('json')) {
					echo json_encode(array('result' => 'success'));
					return TRUE;
				} else {
					redirect('/');
				}
			} else {
				if ($this -> input -> post('json')) {
					echo json_encode(array('result' => 'error', 'message' => '아이디 또는 비밀번호가 맞지 않습니다.'));
					return TRUE;
				} else {
					$this -> session -> set_flashdata('message', array('type' => 'warning', 'message' => '아이디 또는 비밀번호가 맞지 않습니다.'));
					redirect('/login');
				}
			}
		}

		$this -> layout -> add_js('/js/jquery-2.1.1.min.js');
		$this -> layout -> add_js('/js/users/login.js');
		$this -> layout -> render('users/login',array('common_data'=>$this->common_data));
	}

	public function logout() {
		$this -> session -> sess_destroy();
		redirect('/');
	}
	
	public function check_email($email) {
		$this -> pdo -> where(array('email'=>$email));
		
		if($this->pdo->count_all_results('users')) {
			return true;
		} else {
			return false;
		}
	}

	private function _photo_upload() {
		$config['upload_path'] = './uploads/users/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['encrypt_name'] = true;
		//$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';

		$this -> load -> library('upload', $config);
		$this -> upload -> initialize($config);

		if ($this -> upload -> do_upload()) {
			$data = $this -> upload -> data();

			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['full_path'];
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 100;
			$config['height'] = 100;
			$config['thumb_marker'] = '';
			$config['new_image'] = 'thumb_' . $data['file_name'];

			$this -> load -> library('image_lib', $config);
			$this -> image_lib -> resize();
			$this -> session -> set_flashdata('message', array('type' => 'success', 'message' => '회원가입 되었습니다.'));

			return $data;
		} else {
			return false;
		}
	}

}
