<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'SL.php';

class User extends SL_Model {
	protected $table='users';
	
	public function insert(Array $data) {
		unset($data['password_confirm']);
		
		$data['password']=crypt($data['password'].$this->config->item('encryption_key'), '$2a$10$'.substr(md5(time()),0,22));
		
		if($this->pdo->insert($this->table,$data)) { 
			return $this->pdo->insert_id();
		} else {
			return false;
		}
	}
	
	public function check_email($email) {
		$this -> pdo -> where(array('email'=>$email));
		
		if($this->pdo->count_all_results('users')) {
			return true;
		} else {
			return false;
		}
	}
	
	public function update(Array $data) {
		
	}
	
	public function login($email,$password) {
		$this -> pdo -> where(array('email'=>$email));

		if(!$this->pdo->count_all_results('users')) {
			return false;
		}
		
		$query=$this -> pdo -> get_where('users',array('email'=>$email));
		$result=$query -> result_array();
		
		$encrypted_password=crypt($password.$this->config->item('encryption_key'), substr($result[0]['password'], 0, 29));
		
		if (strcmp($result[0]['password'], $encrypted_password))
			return false;
		
		return $result[0];
	}
}
