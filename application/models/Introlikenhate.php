<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Introlikenhate extends SL_Model {
	protected $table = 'intro_like_n_hates';
	
	public function get_like_n_hate_index($intro_id) {
		$this -> pdo -> where(array($this->table.'.enable' => TRUE,$this->table.'.intro_id' => $intro_id));
		$result['total'] = $this -> pdo -> count_all_results($this->table);
				
		$this -> pdo -> select($this->table.'.*');
		$this -> pdo -> where(array($this->table.'.enable' => TRUE,$this->table.'.intro_id' => $intro_id));
		$query = $this -> pdo -> get($this->table);
		$result['list'] = $query -> result_array();
		return $result;
	}			
}
