<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'SL.php';

class Program extends SL_Model {
	protected $table = 'notices';
	protected $table_content ='notice_contents';
}
