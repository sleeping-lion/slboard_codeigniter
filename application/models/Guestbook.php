<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Guestbook extends SL_Model {
	protected $table = 'guest_books';
}
