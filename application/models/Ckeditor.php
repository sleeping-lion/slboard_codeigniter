<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Ckeditor extends SL_Model {
	protected $table = 'ckeditor_assets';
	protected $accepted_attributes=array('data_file_name','data_content_type','width','height','type','assetable_type','assetable_id','data_file_size','created_at','updated_at');
	
	public function insert(Array $data) {
		$date=date('Y-m-d H:i:s');
		$data['created_at'] = $date;
		$data['updated_at'] = $date;
		
		foreach($data as $key=>$value) {
			if(in_array($key,$this->accepted_attributes))
				$filtered_data[$key]=$value;
		}
		
		if ($this -> pdo -> insert($this -> table,$filtered_data)) {
			$id = $this -> pdo -> insert_id();
			
			return $id;
		} else {
			return false;
		}
	}
}
