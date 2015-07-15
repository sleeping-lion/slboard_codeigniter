<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Faq extends SL_Model {
	public $category_model='Faqcategory';
	protected $table = 'faqs';
}
