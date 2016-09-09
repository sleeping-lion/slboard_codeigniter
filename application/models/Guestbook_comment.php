<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SLComment.php';

class Guestbook_comment extends SLComment_Model{
	protected $table = 'guest_book_comments';
	protected $parent_table_id='guest_book_id';
}
