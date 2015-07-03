<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Blog extends SL_Model {

	protected $table = 'blogs';
	protected $table_content ='blog_contents';

	private function get_tag_search() {
		$this -> pdo -> select($this->table.'.*,tags.name,tags.taggings_count');
		$this -> pdo -> join('taggings', 'taggings.taggable_id=' . $this -> table . '.id');
		$this -> pdo -> join('tags', 'tags.id=taggings.tag_id');
		$this -> pdo -> where(array('tags.name' => $this -> input -> get('tag'), 'taggings.taggable_type' => $this -> router -> fetch_class()));
		$this -> pdo -> group_by($this->table.'.id');		
	}

	private function get_search() {
		$result['search_type_title'] = _('label_title');
		switch($this -> input -> get('search_type')) {
			case 'title' :
				if ($this -> input -> get('search_word'))
					$this -> pdo -> like($this -> table . '.title', $this -> input -> get('search_word'));
				break;
			case 'content' :
				if ($this -> input -> get('search_word')) {
					$this -> pdo -> join('poll_community_contents', 'poll_communities.id=poll_community_contents.id');
					$this -> pdo -> like('poll_community_contents.content', $this -> input -> get('search_word'));
				}
				$result['search_type_title'] = _('label_content');
				break;
			case 'titlencontent' :
				if ($this -> input -> get('search_word')) {
					$this -> pdo -> join('poll_community_contents', 'poll_communities.id=poll_community_contents.id');
					$this -> pdo -> like('poll_communities.title', $this -> input -> get('search_word'));
					$this -> pdo -> or_like('poll_community_contents', $this -> input -> get('search_word'));
					$query_where = 'WHERE (b.title LIKE CONCAT("%",:title,"%") OR bc.content LIKE CONCAT("%",:content,"%")) AND b.enable=1';
				}
				$result['search_type_title'] = _('label_title+content');
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

	public function get_index($per_page = 0, $page = 0) {
		if ($this -> input -> get('tag')) {
			$this -> get_tag_search();
		}

		if ($this -> input -> get('search_type')) {
			$result=$this -> get_search();
		}

		$result['total'] = $this -> pdo -> count_all_results($this -> table);

		if (!$result['total'])
			return $result;

		if ($this -> input -> get('tag')) {
			$this -> get_tag_search();
		}
		
		$result['search_type_title'] = _('label_title');
		if ($this -> input -> get('search_type')) {
			$this -> get_search();
		}
		$this -> pdo -> order_by($this -> table . '.id', 'desc');
		$this -> pdo -> where(array($this -> table . '.enable' => 1));
		$query = $this -> pdo -> get($this -> table, $per_page, $page);
		$result['list'] = $query -> result_array();
		return $result;
	}

	public function get_comments($id) {
		$this -> pdo -> where(array('blog_id' => $id));
		$result['total'] = $this -> pdo -> count_all('blog_comments');

		if (!$result['total'])
			return $result;

		$this -> pdo -> select('blog_comments.*,users.nickname,users.photo');
		$this -> pdo -> from('blog_comments');
		$this -> pdo -> join('users', 'blog_comments.user_id = users.id');
		$this -> pdo -> where(array('blog_comments.blog_id' => $id));
		$query = $this -> pdo -> get();
		$result['list'] = $query -> result_array();

		foreach ($result['list'] as $index => $value) {
			$result['list'][$index]['comments'] = $this -> get_comment_comments($value['id']);
		}

		return $result;
	}

	public function insert(Array $data) {
		if ($this -> pdo -> insert('poll_communities', array('title' => $data['title'], 'user_id' => $data['user_id'], 'created_at' => date("Y-m-d H:i:s")))) {
			$id = $this -> pdo -> insert_id();
			$this -> pdo -> insert('poll_community_contents', array('id' => $id, 'content' => $_POST['content']));
			return $id;
		} else {
			return false;
		}
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
