<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Gallery extends SL_Model {
	public $category_model = 'Gallerycategory';
	protected $table = 'galleries';
	protected $accepted_attributes=array('gallery_category_id','title','user_id','content','photo','photo_url','created_at','updated_at');
	
	protected function get_search($search_type,$search_word=null) {
		$search_type_title=array('title'=>_('label_title'),'content'=>_('label_content'),'titlencontent'=>_('label_title+content'));
		
		if(array_key_exists($search_type,$search_type_title)) {
			$result['search_type_title'] = $search_type_title[$search_type];
		} else {
			$result['search_type_title'] = _('label_title');
			return $result;
		}
		
		if (empty($search_word)) {
			return $result;
		}
		
		switch($search_type) {
			case 'title' :
				$this -> pdo -> like($this -> table . '.title', $search_word);
				break;
			case 'content' :
				$this -> pdo -> like($this -> table . '.content',$search_word);
				break;
			case 'titlencontent' :
				$this -> pdo -> like($this -> table . '.title', $search_word);
				$this -> pdo -> or_like($this -> table.'.content', $search_word);
				$query_where = 'WHERE (b.title LIKE CONCAT("%",:title,"%") OR bc.content LIKE CONCAT("%",:content,"%"))';
				break;
			/*	case 'nickname' :
			 if($this -> input -> get('search_word')) {
			 $this -> pdo -> join('users', 'poll_communities.user_id=users.id');
			 $this -> pdo -> like('users.nickname',$this -> input -> get('search_word'));
			 }
			 $result['search_type_title'] = _('label_nickname');
			 break; */
		}
		return $result;
	}		
	
	public function get_content($id) {
		$this -> pdo -> select($this -> table . '.*,' . $this -> table_user . '.nickname');
		$this -> pdo -> from($this -> table);
		$this -> pdo -> join($this -> table_user, $this -> table . '.user_id = ' . $this -> table_user . '.id');
		$this -> pdo -> where(array($this -> table . '.id' => $id));
		$query = $this -> pdo -> get();
		$result = $query -> result_array();
		return $result[0];
	}
}
