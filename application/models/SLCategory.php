<?php

class SLCategory_Model extends CI_Model {
	protected $table;
	protected $order='id';
	protected $desc=TRUE;
	protected $count_name=null;

	public function __construct() {
		if(empty($this->count_name)) {
			$et=explode('_',$this->table);
		
			$this->count_name=plural($et[0]).'_count';
		}
		
		$this -> pdo = $this -> load -> database('pdo', true);
	}

	private function get_count() {
		$query = $this -> pdo -> get($this->table);
	}
		
	public function get_index($per_page = 0, $page = 0, $order=NULL, $desc=NULL, $enable = TRUE) {
		$result['total'] = $this -> pdo -> count_all_results($this -> table);

		if (!$result['total'])
			return $result;
		
		if (empty($order)) {
			if (empty($this -> order)) {
				$order = $this -> order;
			} else {
				$order = 'id';
			}
		}

		if (empty($desc)) {
			if (empty($this -> desc)) {
				$desc = $this -> desc;
			} else {
				$desc = TRUE;
			}
		}
		
		if(!is_bool($desc))
			throw new Exception("Error Processing Request", 1);
		
		if($desc) {
			$desc='desc';
		}	else {
			$desc='asc';
		}
		
		$this -> pdo -> order_by($this -> table . '.'.$order, $desc);
		$this -> pdo -> where(array($this -> table . '.enable' => $enable));
		$query = $this -> pdo -> get($this -> table, $per_page, $page);
		$result['list'] = $query -> result_array();
		return $result;
	}
	
	public function update_count_plus($id) {
		$this -> pdo -> set($this->count_name, $this->count_name.'+1', FALSE);
		$this -> pdo -> where('id', $id);
		$this -> pdo -> update($this -> table);
	}

	public function update_count_minus($id) {
		$this -> pdo -> set($this->count_name, $this->count_name.'-1', FALSE);
		$this -> pdo -> where('id', $id);
		$this -> pdo -> update($this -> table);
	}	
}

