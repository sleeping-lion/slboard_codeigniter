<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SL_Controller extends CI_Controller {
		
	protected $model;
	protected $category_model=null;
	protected $common_data;
	protected $comment=true;	
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
		$locale = 'ko_KR';

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
		$this -> load -> library('session');
		$this -> load -> library('layout', array('title_for_layout' => 'default'));
		$this -> layout -> add_css('/css/bootstrap.min.css');
		$this -> layout -> add_css('/css/index.css');
		$this -> layout -> add_js('/js/jquery-2.1.1.min.js');
		$this -> layout -> add_js('/js/bootstrap.min.js');
		$this -> layout -> add_js('/js/plugin/jquery.tagcanvas.min.js');
		$this -> layout -> add_js('/js/common.js');
		
		
		$this->common_data['controller']=ucfirst($this -> model);
		
		$this->load->model('Blogcategory');
		$this->common_data['blogCategories']=$this->Blogcategory->get_index(0,0,'id','asc');
		
		$this->load->model('Tag');
		$tags=$this->Tag->get_cloud('blogs');
		
		if($tags)
			$this->common_data['tags']=$tags;
		
		$this -> layout -> title_for_layout = _('Homepage Title');
	}
	
	public function index($page = 0) {				
		$this -> load -> model($this->model);
		
		$config['per_page']=10;
		$data = $this -> {$this->model} -> get_index($config['per_page'], $page);
		$config['total_rows'] = $data['total'];
		
		if(isset($this->{$this->model}->category_model)) {
			$this -> load -> model($this->{$this->model}->category_model);
			$data['category']=$this->{$this->{$this->model}->category_model}->get_index();
			
			if($this->input->get('category_id')) {
				$categoryId=$this->input->get('category_id');
			} else {
				$categoryId=$data['category']['list'][0]['id'];
			}
		} else {
			$categoryId=null;
		}
		
		
				
		$this->setting_pagination($config);
		$this -> layout -> render( $this -> router -> fetch_class().'/index', array('common_data'=>$this->common_data,'data' => $data,'categoryId'=>$categoryId));
	}

  
	public function edit($id) {
		if(!$this->session->userdata('admin')) {
			redirect('/');
		}
		
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('title', _('title'), 'required|min_length[3]|max_length[60]');
		//$this -> form_validation -> set_rules('content',_('content'), 'required]');

		if ($this -> form_validation -> run() == FAlSE) {
			$this -> load -> model('Community');
			$data['content'] = $this -> Community -> get_content($id);
			
			$this -> layout -> add_js('/ckeditor/ckeditor.js');
			$this -> layout -> add_js('/js/boards/new.js');
			$this -> layout -> render('communities/edit',array('data'=>$data));
		} else {
			$this->load->model('Community');
			$data = $this -> input -> post(NULL, TRUE);
			$data['user_id']=$this->session->userdata('user_id');
			if ($id = $this -> Community -> update($data)) {
			
				$clean['tag'] = explode(',', $data['tag']);
				foreach ($clean['tag'] as $index => $value) {
					$clean['tag'][$index] = trim($value);
				}
				
				$this->load->model('Tag');
				$this -> Tag -> update(array('taggable_id'=>$id,'tags'=>$clean['tag']));
				
				$this->load->model('Poll');
				$this -> Poll -> update(array('poll_community_id'=>$id,'polls'=>$data['poll_title']));
				
				$this -> session -> set_flashdata('message', array('type' => 'success', 'message' => 'gg'));
				redirect('communities');
			} else {
				redirect('communities/edit');
			}
		}
	}
  
	public function add() {
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('title', _('title'), 'required|min_length[3]|max_length[60]');
		//$this -> form_validation -> set_rules('content',_('content'), 'required]');

		if ($this -> form_validation -> run() == FAlSE) {
			$this -> layout -> add_js('/ckeditor/ckeditor.js');
			$this -> layout -> add_js('/js/boards/new.js');
			$this -> layout -> render($this -> router -> fetch_class().'/add',array('common_data'=>$this->common_data));
		} else {
			$this->load->model($this->model);
			$data = $this -> input -> post(NULL, TRUE);
			
			if ($id = $this -> {$this->model} -> insert($data)) {
				
				$this -> session -> set_flashdata('message', array('type' => 'success', 'message' => 'gg'));
				redirect($this -> router -> fetch_class());
			} else {
				redirect($this -> router -> fetch_class().'/add');
			}
		}
	}  
  
  public function view($id) {
		$this->load->helper('sl');
		
		$this -> load -> model($this->model);
		$data['content'] = $this -> {$this->model} -> get_content($id);
		
		if($this->comment)
			$data['comments'] = $this -> {$this->model} -> get_comments($data['content']['id']);

		$this -> layout -> add_css('/css/plugin/jquery.fancybox-1.3.4.css');
		$this -> layout -> add_js('/js/plugin/jquery.uri.js');
		$this -> layout -> add_js('/js/plugin/jquery.fancybox.1.3.4.js');
		$this -> layout -> add_js('/js/boards/view.js');
		$this -> layout -> render($this -> router -> fetch_class().'/view', array('common_data'=>$this->common_data,'data' => $data));  	
  }  
	
	public function setting_pagination(Array $config) {			
		$this -> load -> library('pagination');


		$config['base_url'] = base_url() . $this -> router -> fetch_class();


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
		
		if (count($_GET) > 0) {
			$config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		}
		$this -> pagination -> initialize($config);
	}	
}
