<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : Amit Kashte
 */

class Template extends Generic{
	function __construct() {
    	parent::__construct();  
	}

	/**
	 * 	Scanning User Template.
	*/
	function user($data){	
		$data['global'] = $this->global_variables;
		$this->load->view('user',$data);
	}

	function exhibitor($data){	
		$data['global'] = $this->global_variables;
		$this->load->view('exhibitor',$data);
	}
	/**
	 * 	Admin Template.
	*/
	function admin($data){	
		$data['global'] = $this->global_variables;
		$this->load->view('admin', $data);
	}

	
	/**
	 * 	Error Template.
	*/
	function errors($data){
		$data['global'] = $this->global_variables;
    	$this->load->view('errors',$data);
	}

}