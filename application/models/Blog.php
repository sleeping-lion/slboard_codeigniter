<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Blog extends SL_Model {
	public $category_model='Blogcategory';	
	protected $table = 'blogs';
	protected $table_content ='blog_contents';
}
