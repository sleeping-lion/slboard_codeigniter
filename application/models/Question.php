<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Question extends SL_Model {
	protected $table = 'questions';
	protected $table_content ='question_contents';	
}
