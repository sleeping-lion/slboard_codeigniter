<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Tag extends SL_Model {
	protected $table='tags';
	
	public function get_cloud($className) {
		$this -> pdo -> from('taggings');
		$this -> pdo -> join('tags', 'taggings.tag_id=tags.id');
		$this -> pdo -> where(array('taggings.taggable_type'=>$className,'tags.taggins_count>1'));
		
		if ($this -> pdo -> count_all_results()) {
			$this -> pdo -> select('tags.name,taggings.taggable_id,taggings.taggable_type');
			$this -> pdo -> from('taggings');
			$this -> pdo -> join('tags', 'taggings.tag_id=tags.id');
			$this -> pdo -> group_by('tags.id');
			$this -> pdo -> order_by($this -> table . '.taggings_count', 'desc');
			$query = $this -> pdo -> get();
			
			return $query -> result_array();
		} else {
			return false;
		}		
	}
	
	public function get_index_by_taggable_id($taggable_id) {
		$this -> pdo -> from('taggings');
		$this -> pdo -> join('tags', 'taggings.tag_id=tags.id');
		$this -> pdo -> where(array('taggable_id' => $taggable_id));
		$this -> pdo -> group_by('tags.id');
		$query = $this -> pdo -> get();
		return $query -> result_array();
	}

	public function get_view($id) {
		$this -> pdo -> from('taggings');
		$this -> pdo -> join('tags', 'taggings.tag_id=tags.id');
		$this -> pdo -> where(array('taggable_id' => $id));
		$this -> pdo -> group_by('tags.id');
		$query = $this -> pdo -> get();
		$result[0]['tags'] = $query -> result_array();

		return $result[0];
	}

	public function insert(Array $data) {
		$className = $this -> router -> fetch_class();
		foreach ($data['tags'] as $index => $value) {
			$this -> pdo -> where(array('name' => $value));
			if ($this -> pdo -> count_all_results('tags')) {
				$query=$this -> pdo -> get_where('tags',array('name' => $value));
				$result=$query -> result_array();
				
				$id=$result[0]['id'];
				
				$this->pdo->where('id', $id);
				$this->pdo->update('tags',array('taggings_count'=>'taggings_count+1'));
			} else {
				if ($this -> pdo -> insert('tags', array('name' => $value, 'taggings_count' => 1))) {
					$id = $this -> pdo -> insert_id();
				}
			}
			$this -> pdo -> insert('taggings', array('tag_id' => $id, 'taggable_id' => $data['taggable_id'], 'taggable_type' => $className, 'context' => 'tags'));
		}
		return true;
	}

}
