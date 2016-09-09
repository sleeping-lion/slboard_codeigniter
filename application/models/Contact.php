<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Contact extends SL_Model {

	protected $table = 'contacts';


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
		$this -> pdo -> where(array('poll_community_id' => $id));
		$result['total'] = $this -> pdo -> count_all('poll_community_comments');

		if (!$result['total'])
			return $result;

		$this -> pdo -> select('poll_community_comments.*,polls.title,users.nickname,users.photo');
		$this -> pdo -> from('poll_community_comments');
		$this -> pdo -> join('polls', 'poll_community_comments.poll_id = polls.id');
		$this -> pdo -> join('users', 'poll_community_comments.user_id = users.id');
		$this -> pdo -> where(array('poll_community_comments.poll_community_id' => $id));
		$query = $this -> pdo -> get();
		$result['list'] = $query -> result_array();

		foreach ($result['list'] as $index => $value) {
			$result['list'][$index]['comments'] = $this -> get_comment_comments($value['id']);
		}

		return $result;
	}

	public function get_comment_comments($comment_id) {
		$this -> pdo -> where(array('poll_community_comment_id' => $comment_id));
		$result['total'] = $this -> pdo -> count_all('poll_community_comment_comments');

		if (!$result['total'])
			return $result;

		$this -> pdo -> select('poll_community_comment_comments.*,polls.title,users.nickname,users.photo');
		$this -> pdo -> from('poll_community_comment_comments');
		$this -> pdo -> join('polls', 'poll_community_comment_comments.poll_id = polls.id');
		$this -> pdo -> join('users', 'poll_community_comment_comments.user_id = users.id');
		$this -> pdo -> where(array('poll_community_comment_id' => $comment_id));
		$query = $this -> pdo -> get();
		$result['list'] = $query -> result_array();

		return $result;
	}

	public function get_content($id) {
		$this -> pdo -> select('poll_communities.*,poll_community_contents.content,users.nickname');
		$this -> pdo -> from('poll_communities');
		$this -> pdo -> join('poll_community_contents', 'poll_communities.id = poll_community_contents.id');
		$this -> pdo -> join('users', 'poll_communities.user_id = users.id');
		$this -> pdo -> where(array('poll_communities.id' => $id));
		$query = $this -> pdo -> get();
		$result = $query -> result_array();

		return $result[0];
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
