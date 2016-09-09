<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'SL_Photo.php';

class Tags extends SL_Photo_Controller {
	protected $model = 'Tag';

	public function index_by_tag($tag) {
		$config['per_page'] = 10;

		if (isset($_GET['page'])) {
			$page = ($_GET['page'] - 1) * $config['per_page'];
		} else {
			$page = 0;
		}

		$data = $this -> {$this -> model} -> get_index_by_tagname($config['per_page'], $page, urldecode($tag));
		$config['total_rows'] = $data['total'];

		$this -> return_data['data'] = $data;
		if (isset($category))
			$this -> return_data['data']['category'] = $category;

		$this -> setting_pagination($config);
		$this -> layout -> render($this -> router -> fetch_class() . '/index', $this -> return_data);
	}
}
