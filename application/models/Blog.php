<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Blog extends SL_Model {
	public $category_model = 'Blogcategory';
	protected $table = 'blogs';
	protected $table_content = 'blog_contents';
	protected $accepted_attributes=array('blog_category_id','title','user_id','description','photo','photo_url','created_at','updated_at');

	public function get_photo_index($per_page = 0, $page = 0, $category_id = NULL, $order = NULL, $desc = NULL, $enable = TRUE) {
		if (isset($category_id)) {
			$this -> pdo -> where(array($this -> table . '.' . singular($this -> table) . '_category_id' => $category_id));
			$this -> pdo -> where($this -> table . '.photo IS NOT NULL');
			$result['total'] = $this -> pdo -> count_all_results($this -> table);
		} else {
			$this -> pdo -> where($this -> table . '.photo IS NOT NULL');
			$result['total'] = $this -> pdo -> count_all($this -> table);
		}

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

		if (!is_bool($desc))
			throw new Exception("Error Processing Request", 1);

		if ($desc) {
			$desc = 'desc';
		} else {
			$desc = 'asc';
		}

		if (!$result['total'])
			return $result;

		$this -> pdo -> select($this -> table . '.*,' . $this -> table_user . '.nickname');
		$this -> pdo -> join($this -> table_user, $this -> table . '.user_id = ' . $this -> table_user . '.id', 'left');
		if (isset($category_id))
			$this -> pdo -> where(array($this -> table . '.' . singular($this -> table) . '_category_id' => $category_id));

		$this -> pdo -> where(array($this -> table . '.enable' => TRUE));

		$this -> pdo -> where($this -> table . '.photo IS NOT NULL');
		$this -> pdo -> order_by($order, $desc);
		$query = $this -> pdo -> get($this -> table, $per_page, $page);
		$result['list'] = $query -> result_array();
		return $result;
	}
}
