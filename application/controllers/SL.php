<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SL_Controller extends CI_Controller {
	protected $use_category = false;
	protected $use_comment = false;
	protected $use_file_upload = false;
	protected $use_image_upload = false;
	protected $model;
	protected $category_model = null;
	protected $comment_model = null;
	protected $return_data;
	protected $comment = true;
	protected $show_first_category=false;
	protected $upload_directory=null;
	protected $ad=true;
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();

		/* i18n locale */
		$locale = 'ko_KR.UTF-8';

		if (!function_exists('_'))
			echo '없어!!';

		putenv("LC_ALL=" . $locale);
		setlocale(LC_ALL, $locale);
		bindtextdomain('messages', APPPATH . DIRECTORY_SEPARATOR . 'language');
		textdomain('messages');
		bind_textdomain_codeset('messages', 'UTF-8');

		$this -> load -> helper('sl');
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> helper('inflector');
		$this -> load -> library('session');
		$this -> load -> library('layout', array('title_for_layout' => 'default'));
		$this -> layout -> add_css('/css/bootstrap.min.css');
		$this -> layout -> add_css('/css/index.css');
		$this -> layout -> add_js('/js/jquery-2.1.1.min.js');
		$this -> layout -> add_js('/js/bootstrap.min.js');
		$this -> layout -> add_js('/js/plugin/jquery.tagcanvas.min.js');
		$this -> layout -> add_js('/js/common.js');
		
		$common_data['meta_title']=$this->config->item('seo_title');
		$common_data['meta_description']=$this->config->item('seo_desc');
		$common_data['model'] = ucfirst($this -> model);
		
		// 광고 보이기가 따로 지정되어 있지 않으면 보이기로 사용
		if(isset($this->ad)) {
			$common_data['ad']=$this->ad;
		} else {
			$common_data['ad']=true;
		}

		$this -> load -> model('Blogcategory');
		$common_data['blogCategories'] = $this -> Blogcategory -> get_index();

		$this -> load -> model('Tag');
		$tags = $this -> Tag -> get_cloud('Blog');

		if ($tags)
			$common_data['tags'] = $tags;

		$this -> layout -> title_for_layout = _('Homepage Title');

		$common_data['title'] = _($common_data['model']);
				

		$this -> return_data = array('common_data' => $common_data);
	}

	public function get_menu($menu=null) {

	}

	public function get_category($category_model) {
		$this -> load -> model($category_model);
		$category = $this -> $category_model -> get_index();
		$categoryId = null;

		$category_name = lcfirst($this -> model) . '_category_id';
		if ($this -> input -> get($category_name)) {
			$categoryId = $this -> input -> get($category_name);
		} else {			
			if ($category['total']) {
				if($this->show_first_category) {
					$categoryId = $category['list'][0]['id'];
				} 
			}
		}

		$category['current_category_id'] = $categoryId;
		return $category;
	}

	public function index() {
		$this -> load -> model($this -> model);
		
		if(empty($this->per_page)) {
			$config['per_page'] = 10;
		} else {
			$config['per_page'] = $this->per_page;
		}

		if (isset($_GET['page'])) { 
			$page = ($_GET['page']-1)*$config['per_page'];
		} else {
			$page=0;
		}

		if (isset($this -> {$this -> model} -> category_model)) {
			$category = $this -> get_category($this -> {$this -> model} -> category_model);
			$categoryId = $category['current_category_id'];
		} else {
			$categoryId = null;
		}

		$data = $this -> {$this -> model} -> get_index($config['per_page'], $page, $categoryId);
		$config['total_rows'] = $data['total'];

		if ($this -> input -> get('id')) {
			if (!$this -> {$this -> model} -> get_count($id))
				show_404();

			$data['content'] = $this -> {$this -> model} -> get_content($id);
		} else {
			if ($data['total'])
				$data['content'] = $data['list'][0];
		}

		$this -> return_data['data'] = $data;
		
		if (isset($category))
			$this -> return_data['data']['category'] = $category;
		
		//$this -> output -> cache(1200);
		$this -> setting_pagination($config);
		$this -> layout -> render($this -> router -> fetch_class() . '/index', $this -> return_data);
	}


	public function add() {
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('title', _('title'), 'required|min_length[3]|max_length[60]');
		//$this -> form_validation -> set_rules('content',_('content'), 'required]');
		
		$this -> load -> model($this -> model);
		if (isset($this -> {$this -> model} -> category_model)) {
			$category = $this -> get_category($this -> {$this -> model} -> category_model);
			$categoryId = $category['current_category_id'];
			
			if ($category['total'])
				$this -> return_data['data']['category'] = $category;
		} else {
			$categoryId = null;
		}		

		if ($this -> form_validation -> run() == FAlSE) {
			if($this->session->userdata('user_id')) {			
				$this -> layout -> add_js('/ckeditor/ckeditor.js');
				$this -> layout -> add_js('/js/boards/add.js');
			}
			$this -> layout -> render($this -> router -> fetch_class() . '/add', $this -> return_data);
		} else {
			$data = $this -> input -> post(NULL, TRUE);

			if ($id = $this -> {$this -> model} -> insert($data)) {
				if (isset($this -> {$this -> model} -> category_model)) {
					$this->load->model($this -> {$this -> model} -> category_model);
					
					$this->{$this -> {$this -> model} -> category_model}->update_count_plus($data[$this->{$this->model}->category_id_name]);
				}

				$this -> session -> set_flashdata('message', array('type' => 'success', 'message' => _('Successfully Created Article')));
				redirect($this -> router -> fetch_class().'/'.$id);
			} else {
				redirect($this -> router -> fetch_class() . '/add');
			}
		}
	}

	public function edit($id) {
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('title', _('title'), 'required|min_length[3]|max_length[60]');
		//$this -> form_validation -> set_rules('content',_('content'), 'required]');
		
		$this -> load -> model($this -> model);
		if (isset($this -> {$this -> model} -> category_model)) {
			$category = $this -> get_category($this -> {$this -> model} -> category_model);
			$categoryId = $category['current_category_id'];
			
			if ($category['total'])
				$this -> return_data['data']['category'] = $category;
		} else {
			$categoryId = null;
		}
		
		$data=array();
		$data['content'] = $this -> {$this -> model} -> get_content($id);

		if ($this -> form_validation -> run() == FALSE) {
			$this -> return_data['data']['content']=$data['content'];
			
			if($this->session->userdata('user_id')) {			
				$this -> layout -> add_js('/ckeditor/ckeditor.js');
				$this -> layout -> add_js('/js/boards/add.js');
			}
			$this -> layout -> render($this -> router -> fetch_class() . '/edit', $this -> return_data);
		} else {
			$data = $this -> input -> post(NULL, TRUE);
			$data['id']= $id;
			
			$result=$this -> {$this -> model} -> update($data);
			if ($result) {
				
				if (isset($this -> {$this -> model} -> category_model)) {
					$this->load->model($this -> {$this -> model} -> category_model);
					
					$this->{$this -> {$this -> model} -> category_model}->update_count_minus($data['content'][$this->{$this->model}->category_id_name]);
					$this->{$this -> {$this -> model} -> category_model}->update_count_plus($data[$this->{$this->model}->category_id_name]);
				}				
				
				$this -> session -> set_flashdata('message', array('type' => 'success', 'message' => _('Successfully Edited Article')));
				redirect($this -> router -> fetch_class().'/'.$id);
			} else {
				redirect($this -> router -> fetch_class() . '/edit');
			}
		}
	}

	public function view($id) {
		$this -> load -> model($this -> model);

		if (!$this -> {$this -> model} -> get_count($id))
			show_404();

		$data['content'] = $this -> {$this -> model} -> get_content($id);

		if ($this -> comment_model) {
			$this -> load -> model($this -> comment_model);
			$data['comments'] = $this -> {$this -> comment_model} -> get_index($data['content']['id']);
		}
				
		$this -> return_data['data']=$data;

		if ($this -> addImpression($id)) {
			$this -> {$this -> model} -> id = $id;
			$this -> {$this -> model} -> update_count_plus($id);
		}

		// $this -> output -> cache(1200);
		$this -> layout -> add_js('/js/boards/view.js');
		$this -> layout -> render($this -> router -> fetch_class() . '/view', $this -> return_data);
	}
	
	public function confirm_delete($id) {
		$this -> return_data['data']['id']=$id;
		$this -> layout -> render($this -> router -> fetch_class() . '/confirm_delete', $this -> return_data);
	}
	
	public function delete($id) {
		if(!$this->session->userdata('admin')) {
			if($this->session->userdata('delete_auth')) {
				
			} else {
				throw new Exception("Error Processing Request", 1);
			}
		}
		
		$this -> load -> model($this -> model);
		if($this -> {$this -> model} -> delete($id)) {
			
				if (isset($this -> {$this -> model} -> category_model)) {
					$this->load->model($this -> {$this -> model} -> category_model);
					
					$this->{$this -> {$this -> model} -> category_model}->update_count_minus($data[$this->{$this->model}->category_id_name]);
				}			
			
			redirect($this -> router -> fetch_class());
		} else {
			throw new Exception("Error Processing Request", 1);
		}
	}
	
	protected function getImpressionCount($id) {
		$this -> load-> model('Impression');
		return $this -> Impression -> get_count_impression(array('impressionable_type' => $this -> model,'controller_name' => $this ->router->fetch_class(), 'action_name' => $this ->router->fetch_method(), 'ip_address' => $this -> input-> ip_address(),'impressionable_id' => $id));
	}	
	
	protected function addImpression($id) {
		if ($this -> getImpressionCount($id)) {
			return false;
		} else {
			$this -> load -> model('Impression');
			if (!$this -> Impression -> insert(
			array('impressionable_type' => $this -> model, 
			'controller_name' => $this ->router->fetch_class(), 
			'action_name' => $this ->router->fetch_method(), 
			'ip_address' => $this -> input-> ip_address(),
			'request_hash'=>hash_hmac("sha512",time().rand(0,10000),'sleepinglion'),
			'session_hash'=>session_id(),
			'impressionable_id' => $id, 'referrer' => $_SERVER['HTTP_REFERER'])
			)) {
				$this -> session -> set_flashdata('message', array('type' => 'error', 'message' => _('The post could not be saved. Please, try again.')));
			}
			return true;
		}
	}
	
	public function setting_pagination(Array $config) {
		$this -> load -> library('pagination');

		$config['base_url'] = base_url() . $this -> router -> fetch_class();
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'page';

		$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';

		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '▶';
		$config['prev_link'] = '◀';
		// $config['display_pages'] = FALSE;
		//
		$config['anchor_class'] = 'follow_link';

		$query_string = $_GET;
		if (isset($query_string['page'])) {
			unset($query_string['page']);
		}

		if (count($query_string) > 0) {
			$config['suffix'] = '&' . http_build_query($query_string, '', "&");
			$config['first_url'] = $config['base_url'] . '?' . http_build_query($query_string, '', "&");
		}
		$this -> pagination -> initialize($config);
	}

}
