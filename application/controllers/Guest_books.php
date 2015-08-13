<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'SL.php';

class Guest_books extends SL_Controller {
	protected $model='Guestbook';
	protected $has_content=true;
}
