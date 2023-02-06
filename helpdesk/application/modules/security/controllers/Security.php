<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : Amit Kashte
 */

class Security extends Generic{

	function __construct() {
		parent::__construct();
		$this->load->model('Mdl_security');
		$this->load->helper('jwt_helper');  
		// $this->load->library('encryption');

		// $this->encryption->initialize(
		// 	array(
		// 		'cipher' => 'aes-256',
		// 		'mode' => 'ctr'
		// 	)
		// );
	}
	
	/**
	 * 	Generate encryption key
	 */
	function generateKey(){
		echo $key = bin2hex($this->encryption->create_key(32));
	}

	/**
	 * 	Generate HASH value
	 */
	function generateHash(){
		$password = 'capital@superuser';
		
		$options = array(
			'cost' => 12
		);
		
		$hash = password_hash($password, PASSWORD_BCRYPT, $options);
		echo $hash;
	}

	/**
	 * 	Create HASH
	 */
	function makeHash($password){
		$options = array(
			'cost' => 12
		);
		
		$hash = password_hash($password, PASSWORD_BCRYPT, $options);
		return $hash;
	}

	/**
	 * 	Verify password with hashed value
	 */
	function verifyPassoword($password, $hash){
		if(password_verify($password, $hash)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	/**
	 * 	Verify Admin session
	 */
	function isAdmin(){
		// print_r($this->session->userdata('admin'));exit;
		if($this->session->userdata('admin')){


			$admin_session = $this->session->userdata('admin');
			if(is_numeric($admin_session['admin_id'])){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	/**
	 * 	Verify User session
	 */
	function isUser(){
		if($this->session->userdata('user')){

			$user = $this->session->userdata('user');
			if( $user['type'] == "user"){
				$auth_details = $this->Mdl_security->retrieve('authentication',array('uid'=>$user['uid']));
				if($auth_details !=="NA"){
					if($auth_details[0]->status=="allow"){
						return TRUE;
					}else{
						return FALSE;
					}
					return TRUE;
				}else{
					return FALSE;
				}
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	/**
	 * Generate JWT Auth Token
	*/
	function generateAuthToken($uid){
		$token['uid'] = $uid;
		$key = $this->global_variables['jwt_key'];
		$token =  JWT::encode($token, $key);
		return $token;
	}

	/**
	 * Validate JWT Auth Token
	 */

	function validateAuthToken($token){
      // echo $token;exit;
		$auth_details = $this->Mdl_security->retrieve('authentication',array('token'=>$token));
		// print_r($auth_details);exit;
		// print_r($auth_details);
		if($auth_details == "NA"){
			return array("status"=>"invalid");
		} else {
			if(strtotime($auth_details[0]->expiry_time) < strtotime("now")){
				return array("status"=>"expired");
			} else {
				$key = $this->global_variables['jwt_key'];
				$token_value = JWT::decode($token, $key);
                // echo $token_value->uid ."__".$auth_details[0]->uid;exit;
				if($token_value->uid === $auth_details[0]->uid){
					return array("status"=>"valid","registration_id"=>$auth_details[0]->id,"access"=>$auth_details[0]->access,"uid"=>$auth_details[0]->uid);
				}else{
					return array("status"=>"invalid");
				}
			}
		}
	}

	/* Check Exhibitor Login*/
	function isExibitor(){
		if($this->session->userdata('exhibitor')){

			$user = $this->session->userdata('exhibitor');
			if( $user['type'] == "exhibitor"){
				$auth_details = $this->Mdl_security->retrieve('iijs_exhibitor',array('Exhibitor_Registration_ID'=>$user['uid']));
				if($auth_details !== "NA"){
					return TRUE;
				}else{
					return FALSE;
				}
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}


}