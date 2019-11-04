<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_super extends MY_Model {
	public $table;

    function __construct() {
        parent::__construct();
    }

    public function setTabla($table = '') {
    	$this->table = $table;
    }
}
?>