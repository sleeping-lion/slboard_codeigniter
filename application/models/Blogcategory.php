<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SLCategory.php';

class Blogcategory extends SLCategory_Model {
	protected $table = 'blog_categories';
	protected $desc=FALSE;
}
