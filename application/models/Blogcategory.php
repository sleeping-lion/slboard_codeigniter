<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Blogcategory extends SL_Model {

	protected $table = 'blog_categories';

	public function get_index($per_page = 0, $page = 0) {
		$this -> pdo -> order_by($this -> table . '.id', 'asc');
		$this -> pdo -> where(array($this -> table . '.enable' => 1));
		$query = $this -> pdo -> get($this -> table, $per_page, $page);
		$result['list'] = $query -> result_array();
		return $result;
	}

	public function update_count_plus($id) {
		$this -> pdo -> set('count', 'count+1', FALSE);
		$this -> pdo -> where('id', $id);
		$this -> pdo -> update($this -> table);
	}

	public function update_count_minus($id) {
		$this -> pdo -> set('count', 'count-1', FALSE);
		$this -> pdo -> where('id', $id);
		$this -> pdo -> update($this -> table);
	}

	public function update_comment_count_plus($id) {
		$this -> pdo -> set('comment_count', 'comment_count+1', FALSE);
		$this -> pdo -> where('id', $id);
		$this -> pdo -> update($this -> table);
	}

	public function update_comment_count_minus($id) {
		$this -> pdo -> set('comment_count', 'comment_count-1', FALSE);
		$this -> pdo -> where('id', $id);
		$this -> pdo -> update($this -> table);
	}

}
