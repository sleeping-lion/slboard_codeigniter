<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Intromodel extends SL_Model {
	protected $table = 'intros';
	protected $accepted_attributes=array('title','alternate_name','gender','birth_date','job_title','height','weight','created_at','updated_at');	
	
	public function get_index($per_page = 0, $page = 0, $category_id=NULL, $order='id', $desc='desc', $enable=TRUE) {
		if(isset($category_id)) {
			$this -> pdo -> where(array($this->table.'.'.singular($this->table).'_category_id'=> $category_id));
			$result['total'] = $this -> pdo -> count_all_results($this->table);
		} else {
			$result['total'] = $this -> pdo -> count_all($this->table);
		}

		if (!$result['total'])
			return $result;
		
		$this -> pdo -> select($this->table.'.*');
		$this -> pdo -> where(array($this->table.'.enable' => TRUE));
		$this -> pdo -> order_by($order, $desc);
		$query = $this -> pdo -> get($this->table, $per_page, $page);
		$result['list'] = $query -> result_array();
		return $result;
	}	
}
