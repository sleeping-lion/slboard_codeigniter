<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'SL.php';

class Home extends SL_Controller {
	protected $model='Home';
	
	public function index($page=0)
	{
		$this -> load -> model('Gallery');
		$this -> return_data['data']['galleries'] = $this -> Gallery -> get_index(30, 0);

		$this -> load -> model('Blog');
		$this -> return_data['data']['blogs'] = $this -> Blog -> get_photo_index(6, 0);

		$this -> load -> model('Notice');
		$this -> return_data['data']['notices'] = $this -> Notice -> get_index(5, 0);

		$this -> load -> model('Question');
		$this -> return_data['data']['questions'] = $this -> Question -> get_index(5, 0);

		$this -> layout -> add_js('/js/plugin/jquery.tagcanvas.min.js');
		$this -> layout -> add_js('/js/index.js');

		$this -> output -> cache(1200);
		$this -> layout -> render('home/index', $this -> return_data);
	}
	
	public function popup() {
		$this -> load -> view('home/popup');
	}	
}
