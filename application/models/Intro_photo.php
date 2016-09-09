<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Intro_photo extends SL_Model {
	protected $table = 'intro_photos';
	
	public function get_photo_index($intro_id) {
		$this -> pdo -> where(array($this->table.'.enable' => TRUE,$this->table.'.intro_id' => $intro_id));
		$result['total'] = $this -> pdo -> count_all_results($this->table);
				
		$this -> pdo -> select($this->table.'.*');
		$this -> pdo -> where(array($this->table.'.enable' => TRUE,$this->table.'.intro_id' => $intro_id));
		$query = $this -> pdo -> get($this->table);
		$result['list'] = $query -> result_array();
		return $result;
	}			
}
