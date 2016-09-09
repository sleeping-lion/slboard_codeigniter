<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Guestbook extends SL_Model {
	protected $table = 'guest_books';
	protected $table_content = 'guest_book_contents';
	protected $accepted_attributes=array('title','name','encrypted_password','salt','secret','user_id','created_at','updated_at');	
}
