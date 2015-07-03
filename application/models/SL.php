<?php

class SL_Model extends CI_Model {
	protected $table;
	protected $table_content;
	protected $table_user='users';

	public function __construct() {
		$this -> pdo = $this -> load -> database('pdo', true);
	}

	private function get_count() {
		$query = $this -> pdo -> get($this->table);
	}

	public function get_index($per_page = 0, $page = 0) {
		$result['total'] = $this -> pdo -> count_all($this->table);

		if (!$result['total'])
			return $result;

		$this -> pdo -> order_by("id", "desc");
		$query = $this -> pdo -> get($this->table, $per_page, $page);
		$result['list'] = $query -> result_array();
		return $result;
	}

	public function get_content($id) {
		$this -> pdo -> select($this->table.'.*',$this->table_content.'.content',$this->table_user.'.nickname');
		$this -> pdo -> from($this->table);
		$this -> pdo -> join($this->table_content, $this->table.'.id = '.$this->table_content.'.id');
		$this -> pdo -> join($this->table_user, $this->table.'.user_id = '.$this->table_user.'.id');
		$this -> pdo -> where(array($this->table.'.id' => $id));
		$query = $this -> pdo -> get();
		$result = $query -> result_array();

		return $result[0];
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

	public function insert(Array $data) {
		$data['user_id']=$this->session->userdata('user_id');
		$data['created_at']=date("Y-m-d H:i:s");
		if ($this -> pdo -> insert($this->table, $data)) {
			return $this -> pdo -> insert_id();
		} else {
			return false;
		}
	}

	public function delete($id) {
		if($this->pdo->delete($this->table, array('id' => $id))) {
			return true;
		} else {
			return false;
		}
	}
}

