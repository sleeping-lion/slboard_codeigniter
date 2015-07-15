<?php

class SLCategory_Model extends CI_Model {
	protected $table;	

	public function __construct() {
		$this -> pdo = $this -> load -> database('pdo', true);
	}

	private function get_count() {
		$query = $this -> pdo -> get($this->table);
	}
		
	public function get_index($per_page = 0, $page = 0, $order='id', $desc='desc') {
		$result['total'] = $this -> pdo -> count_all_results($this -> table);

		if (!$result['total'])
			return $result;

		$this -> pdo -> order_by($this -> table . '.id', 'desc');
		$this -> pdo -> where(array($this -> table . '.enable' => 1));
		$query = $this -> pdo -> get($this -> table, $per_page, $page);
		$result['list'] = $query -> result_array();
		return $result;
	}
}

