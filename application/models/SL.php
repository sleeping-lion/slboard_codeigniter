<?php

class SL_Model extends CI_Model {
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

	public function get_index($per_page = 0, $page = 0, $order='id', $desc='desc') {		
		if($this -> input -> get('search_type') AND $this -> input -> get('search_word'))
			$result=$this->get_search();
		
		$result['total'] = $this -> pdo -> count_all_results($this->table);

		if (!$result['total'])
			return $result;
		
		$this -> pdo -> select($this->table.'.*,'.$this->table_user.'.nickname');
		$this -> pdo -> join($this->table_user, $this->table.'.user_id = '.$this->table_user.'.id');
		$this -> pdo -> where(array($this->table.'.enable' => TRUE));
		
		if($this -> input -> get('search_type') AND $this -> input -> get('search_word'))
			$this->get_search();
		
		$this -> pdo -> order_by($order, $desc);
		$query = $this -> pdo -> get($this->table, $per_page, $page);
		$result['list'] = $query -> result_array();
		
		return $result;
	}
	
	protected function get_search() {
		$result['search_type_title'] = _('label_title');
		switch($this -> input -> get('search_type')) {
			case 'title' :
				if ($this -> input -> get('search_word'))
					$this -> pdo -> like($this -> table . '.title', $this -> input -> get('search_word'));
				break;
			case 'content' :
				if ($this -> input -> get('search_word')) {
					$this -> pdo -> join($this -> content_table, $this->table.'.id='.$this->content_table.'.id');
					$this -> pdo -> like($this -> content_table . '.content', $this -> input -> get('search_word'));
				}
				$result['search_type_title'] = _('label_content');
				break;
			case 'titlencontent' :
				if ($this -> input -> get('search_word')) {
					$this -> pdo -> join($this -> content_table, $this->table.'.id='.$this->content_table.'.id');
					$this -> pdo -> like($this -> table . '.title', $this -> input -> get('search_word'));
					$this -> pdo -> or_like($this -> content_table.'.content', $this -> input -> get('search_word'));
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
		if ($this -> pdo -> insert($this->table, array('title' => $data['title'], 'user_id' => $data['user_id'], 'created_at' => $data['created_at']))) {
			$id = $this -> pdo -> insert_id();
			if(!empty($this->table_content))
				$this -> pdo -> insert($this->table_content, array('id' => $id, 'content' => $_POST['content']));
			return $id;
		} else {
			return false;
		}
	}
	
	public function update(Array $data) {
		if ($this -> pdo -> update($this -> table,array('title' => $data['title'],'created_at'=>date("Y-m-d H:i:s")),array('id'=>$data['id']))) {
			$this -> pdo -> update($this -> table_content, array('content' => $_POST['content']),array('id' => $data['id']));
			return true;
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
	
	public function update_fie_count($id,$count) {
		return  $this->pdo->update($this -> table, array('file_count'=>$count), array('id' => $id));
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
}

