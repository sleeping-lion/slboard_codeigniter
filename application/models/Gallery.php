<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Gallery extends SL_Model {
	public $category_model='Gallerycategory';		
	protected $table = 'galleries';
}
