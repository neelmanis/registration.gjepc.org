<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : NEELMANI GUPTA
 */

class Onspot extends Generic{
	
	function __construct() {
		parent::__construct();
    $this->load->model('Mdl_onspot');
	}
  
	function add(){
		$data['designation'] = $this->Mdl_onspot->getByValue("category_master", "status", 1);
		$data['viewFile'] = 'add';
		$data['page'] = 'professional';
		$data['scriptFile'] = 'onspot';
		$data['module'] = "onspot";
		$data['breadcrumb'] = "Add Onspot Visitor";
		$template = 'admin';		
		echo Modules::run('template/'.$template, $data); 
	}
  
	/*
  ** ADD ONSPOT ACTION
  */
  function addOnspotAction(){
    $content = $this->input->post();
    // print_r($content); exit;

    $this->form_validation->set_rules("category","category","trim|required|xss_clean",
    array(
      'required' => 'Please select category.'
    ));

    $this->form_validation->set_rules("fname","Name","trim|required|xss_clean",
    array(
      'required' => 'Name is required.'
    ));
    
	$this->form_validation->set_rules("mobile","Mobile","trim|required|xss_clean");
	
	$this->form_validation->set_rules("email","Email","trim|required|xss_clean|valid_email",
    array(
      'required' => 'Email is required.',
      'valid_email' => 'Email is invalid.'
    ));
	
    $this->form_validation->set_rules("pan_no","PAN No","trim|required|xss_clean",
    array(
      'required' => 'PAN is required.'
    ));

    $this->form_validation->set_rules("designation","Designation","trim|required|xss_clean",
    array(
      'required' => 'Designation is required.'
    ));

    $this->form_validation->set_rules("company","Company Name","trim|required|xss_clean",
    array(
      'required' => 'Company Name is required.'
    ));
    

    if($this->form_validation->run() == FALSE){
      $errors = $this->form_validation->error_array();
      echo json_encode($errors); exit;
    } else {
		
		/*$digits = 9;	
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		$checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
		$countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
			$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} */
		
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier =$this->Mdl_onspot->isExist("visitors", array("unique_code"=>$uniqueIdentifier));
	  
		while($checkUniqueIdentifier){
        $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
			  
	  if(!empty($_FILES['visitor_photo']['name'])){
        $filename = $_FILES['visitor_photo']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
		$imagename_photo =  $uniqueIdentifier;
        $img = $this-> uploadFile($imagename_photo,"images","jpg|png|jpeg",'3000','','',"visitor_photo");
        $imgName = $imagename_photo.'.'.$ext;
        if($img !== 1){
          echo json_encode(array("image"=>$img)); exit;
        }
      } else {
        echo json_encode(array("image"=>"Please select file to upload")); exit;
      }

		if($this->session->userdata('admin')){
			$admin = $this->session->userdata('admin');
			$adminId = $admin['admin_id'];
		}
		
		$mobile = $content['mobile'];
		$registration_id = substr($mobile,0,4);
		$visitor_id = substr($mobile,0,4);
		$photo_url = base_url().'images/'.$imgName;
		$category = $content['category'];
		
		switch ($category) {
					 
					 case 'VIS':
							$category = "V";
					  break;
					  case 'IGJME':
							$category = "MV";
					  break;
					  case 'INTL':
						   $category = "OV";
					  break;
					  case 'EXH':
						   $category = "E";
					  break;
					  case 'EXHM':
						   $category = "ME";
					  break;
					  case 'CONTR':
							$agency_category = $result['agency_category'];
							$committee = $result['committee'];

							if($agency_category =="CM"){
							  $category = $committee;
							}else{
							   $category = $agency_category;
							}
					  break;
					  default:
						   $category="";
					  break;
					}

      $data = array(
        'unique_code' => strip_tags($uniqueIdentifier),
        'registration_id' => strip_tags($registration_id),
        'category' => strip_tags($category),
        'visitor_id' => strip_tags($visitor_id),
        'name' => strip_tags($content['fname']),
		'mobile' => strip_tags($content['mobile']),
		'email' => strip_tags($content['email']),
		'pan_no' => strip_tags($content['pan_no']),		
        'designation' => strip_tags($content['designation']),		
        'company' => strip_tags($content['company']),
        'photo_url' => $photo_url,
        'source' => 'onspot',
        'photo_name'=> strip_tags($imgName),
        'created_at' => date('Y-m-d H:i:s'),
        'status' => $content['status'],
        'created_by'=> $adminId
      );
	
      $insert = $this->Mdl_onspot->insert("visitors", $data);
      echo json_encode(array("status"=>"success")); exit;
    }
  }
  
  
}