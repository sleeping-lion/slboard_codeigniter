<?php

class SLComment_Model extends CI_Model {
	public $category_model=null;
	protected $table;
	protected $table_content;
	protected $table_user='users';
	protected $table_user_photo='user_photos';
	protected $accepted_attributes=array('title','content','parent_id','user_id','created_at','updated_at');

	public function __construct() {
		$this -> pdo = $this -> load -> database('pdo', true);
	}

	public function get_index($board_id, $per_page = 0, $page = 0, $order='id', $desc='desc') {
		$this -> pdo -> where(array($this->table.'.'.$this->parent_table_id=>$board_id));
		$result['total'] = $this -> pdo -> count_all_results($this->table);

		if (!$result['total'])
			return $result;

		$this -> pdo -> select($this->table.'.*,'.$this->table_user.'.nickname,'.$this->table_user_photo.'.photo_url');
		$this -> pdo -> join($this->table_user, $this->table.'.user_id = '.$this->table_user.'.id','left');
		$this -> pdo -> join($this->table_user_photo, $this->table_user_photo.'.user_id = '.$this->table_user.'.id','left');
		$this -> pdo -> where(array($this->table.'.'.$this->parent_table_id=>$board_id));
		//$this -> pdo -> where(array($this->table.'.'.$this->parent_table_id=>$board_id,$this->table.'.enabled' => TRUE));
		$this -> pdo -> order_by($order, $desc);
		$query = $this -> pdo -> get($this->table, $per_page, $page);
		$result['list'] = $query -> result_array();
		return $result;
	}
	
	public function insert(Array $data) {
		echo '1';
		$data['user_id'] = $this -> session -> userdata('user_id');
		$date=date('Y-m-d H:i:s');
		$data['created_at'] = $date;
		$data['updated_at'] = $date;
		
		foreach($data as $key=>$value) {
			if(in_array($key,$this->accepted_attributes))
				$filtered_data[$key]=$value;
		}
		echo $this -> table;
		if ($this -> pdo -> insert($this -> table,$filtered_data)) {
			$id = $this -> pdo -> insert_id();
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

