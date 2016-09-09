<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class User extends SL_Model {
	protected $table = 'users';
	protected $accepted_attributes=array('email','name','nickname','description');

	public function get_content($id) {
		$this -> pdo -> select($this -> table . '.*');
		$this -> pdo -> from($this -> table);
		$this -> pdo -> where(array($this -> table . '.id' => $id));
		$query = $this -> pdo -> get();
		$result = $query -> result_array();

		return $result[0];
	}

	public function insert(Array $data) {
		unset($data['password_confirm']);

		$data['password'] = crypt($data['password'] . $this -> config -> item('encryption_key'), '$2a$10$' . substr(md5(time()), 0, 22));

		if ($this -> pdo -> insert($this -> table, $data)) {
			return $this -> pdo -> insert_id();
		} else {
			return false;
		}
	}

	public function check_email($email) {
		$this -> pdo -> where(array('email' => $email));

		if ($this -> pdo -> count_all_results('users')) {
			return true;
		} else {
			return false;
		}
	}

	public function update(Array $data) {
		if(!$this->session->userdata('admin')) {
			unset($data['user_id']);
		}
		
		$date=date('Y-m-d H:i:s');
		$data['updated_at'] = $date;
		
		foreach($data as $key=>$value) {
			if(in_array($key,$this->accepted_attributes))
				$filtered_data[$key]=$value;
		}
		
		if ($this -> pdo -> update($this -> table, $filtered_data, array('id' => $this->session->userdata('user_id')))) {
			if(isset($this->table_content) and isset($data['content']))
				$this -> pdo -> update($this -> table_content, array('content' => $data['content']), array('id' => $this->session->userdata('user_id')));
			return true;
		} else {
			return false;
		}
	}

	public function login($email, $password) {
		$this -> pdo -> where(array('email' => $email));

		if (!$this -> pdo -> count_all_results('users')) {
			return false;
		}

		$query = $this -> pdo -> get_where('users', array('email' => $email));
		$result = $query -> result_array();

		$encrypted_password = crypt($password . $this -> config -> item('encryption_key'), substr($result[0]['encrypted_password'], 0, 29));

		if (strcmp($result[0]['encrypted_password'], $encrypted_password))
			return false;

		return $result[0];
	}

}
