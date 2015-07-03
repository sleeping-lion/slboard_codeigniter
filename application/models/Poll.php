<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Poll extends SL_Model {
	protected $table = 'polls';	

	public function get_index_by_community_id($community_id) {
		$this -> pdo -> where(array('poll_community_id' => $community_id));
		$result['total'] = $this -> pdo -> count_all_results('polls');

		if (!$result['total'])
			return $result;

		$this -> pdo -> order_by("id", "desc");
		$query = $this -> pdo -> get_where('polls', array('poll_community_id' => $community_id));
		$result['list'] = $query -> result_array();
		return $result;
	}

	public function get_view($id) {
		$this -> pdo -> select('poll_communities.*,poll_community_contents.content,users.nickname');
		$this -> pdo -> from('poll_communities');
		$this -> pdo -> join('poll_community_contents', 'poll_communities.id = poll_community_contents.id');
		$this -> pdo -> join('users', 'poll_communities.user_id = users.id');
		$this -> pdo -> where(array('poll_communities.id' => $id));
		$query = $this -> pdo -> get();
		$result = $query -> result_array();

		return $result[0];
	}

	public function update_count_plus($id) {
		$this -> pdo -> set('count', 'count+1', FALSE);
		$this -> pdo -> where('id', $id);
		$this -> pdo -> update('polls');
	}

	public function update_count_minus($id) {
		$this -> pdo -> set('count', 'count-1', FALSE);
		$this -> pdo -> where('id', $id);
		$this -> pdo -> update('polls');
	}

	public function insert(Array $data) {
		foreach ($data['polls'] as $index => $value) {
			$this -> pdo -> where(array('poll_community_id' => $data['poll_community_id'], 'title' => $value));
			if ($this -> pdo -> count_all_results('polls'))
				continue;

			if ($this -> pdo -> insert('polls', array('poll_community_id' => $data['poll_community_id'], 'title' => $value, 'created_at' => date("Y-m-d H:i:s")))) {
				$id = $this -> pdo -> insert_id();
			}
		}
		return true;
	}

}
