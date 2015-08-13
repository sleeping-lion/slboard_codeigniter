<?php

class SLComment_Model extends CI_Model {
	public $category_model=null;
	protected $table;
	protected $table_content;
	protected $table_user='users';

	public function __construct() {
		$this -> pdo = $this -> load -> database('pdo', true);
	}

	public function get_count($id=null) {		
		if(isset($id)) {
			$this -> pdo -> where(array($this -> table . '.id' => $id));
		}
		
		return $this -> pdo -> count_all_results($this->table);
	}

	public function get_index($board_id, $per_page = 0, $page = 0, $order='id', $desc='desc') {
		$this -> pdo -> where(array($this->table.'.board_id'=>$board_id));
		$result['total'] = $this -> pdo -> count_all_results($this->table);

		if (!$result['total'])
			return $result;

		$this -> pdo -> select($this->table.'.*,'.$this->table_user.'.nickname,'.$this->table_user.'.photo');
		$this -> pdo -> join($this->table_user, $this->table.'.user_id = '.$this->table_user.'.id');
		$this -> pdo -> where(array($this->table.'.board_id'=>$board_id,$this->table.'.enable' => TRUE));
		$this -> pdo -> order_by($order, $desc);
		$query = $this -> pdo -> get($this->table, $per_page, $page);
		$result['list'] = $query -> result_array();
		return $result;
	}

	public function get_content($id) {
		$this -> pdo -> select($this->table.'.*,'.$this->table_content.'.content,'.$this->table_user.'.nickname');
		$this -> pdo -> from($this->table);
		$this -> pdo -> join($this->table_content, $this->table.'.id = '.$this->table_content.'.id');
		$this -> pdo -> join($this->table_user, $this->table.'.user_id = '.$this->table_user.'.id');
		$this -> pdo -> where(array($this->table.'.id' => $id));
		$query = $this -> pdo -> get();
		$result = $query -> result_array();
		return $result[0];
	}

	public function insert(Array $data) {
		$data['user_id']=$this->session->userdata('user_id');
		$data['created_at']=date("Y-m-d H:i:s");
		if ($this -> pdo -> insert($this->table, array('content' => $data['content'], 'board_id' => $data['board_id'], 'user_id' => $data['user_id'], 'created_at' => $data['created_at']))) {
			$id = $this -> pdo -> insert_id();
			if(!empty($this->table_content))
				$this -> pdo -> insert($this->table_content, array('id' => $id, 'content' => $_POST['content']));
			return $id;
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

