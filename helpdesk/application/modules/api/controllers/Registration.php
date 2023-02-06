<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : SANTOSH SHRIKHANDE
 *  CREATED AT: 23-03-2022
 * 
*/

class Registration extends Generic{
	
	function __construct() {
		parent::__construct();
    $this->load->model('Mdl_api');
	}



   /**
   *  Callback : Contact Number Check
   */
  public function contact_check($contact){
		if($contact !== ""){
			if(! preg_match("/^[0-9]{7,10}$/", $contact)){
			  $this->form_validation->set_message('contact_check','Contact Number is incorrect');
			  return false;
		  }else{
        return true;
      }
		}else{
      $this->form_validation->set_message('contact_check','Contact Number is required');
      return false;
    }
  }

  function newUserRegistration(){
    $method = $this->input->method(TRUE);  
    if($method !== 'POST'){
        json_output(400,array('status' => 400,'message' => 'Bad request.'));
    } else {  

      $content = json_decode(file_get_contents('php://input'), TRUE);
      // print_r($content);exit;
      $this->form_validation->set_data($content);
      $this->form_validation->set_rules('name','Full name','trim|xss_clean|required',
      array(
        "required" => "Organisation Name is required"
      ));

      $this->form_validation->set_rules('email','Email','trim|xss_clean|required|valid_email|is_unique[users.email]',
      array(
        "required" => "Email is required",
        "valid_email" => "Email is incorrect",
        "is_unique" => "This email address is already in use"
      ));

      $this->form_validation->set_rules('mobile','Mobile','trim|xss_clean|required|exact_length[10]|is_unique[users.mobile]',
      array(
        "required" => "Mobile no is required",
        "exact_length" => "Mobile no is incorrect",
        "is_unique" => "This mobile no is already in use"
      ));

      $this->form_validation->set_rules("pword","Password","trim|xss_clean|required|min_length[6]|max_length[25]",
      array(
        'required' => "Password is required"
      ));
      
     

    
      if($this->form_validation->run($this) == FALSE){
        $errors = $this->form_validation->error_array();
        echo json_encode($errors); exit;
      }else{
        $record =  $this->Mdl_login->retrieve("otp_verfication_email",array('email' => $content['r_email']));
        if($record !=="NA"){
          if($record[0]->verified !=="1"){
            echo json_encode(array("email"=>"Email not verified")); exit;
          }
        }else{
          echo json_encode(array("email"=>"Email not verified")); exit;
        }

        $admin_session = $this->session->userdata('admin');
        
        $passwordText = strip_tags($content['pword']);
        $passwordEnc = Modules::run('security/makeHash',$passwordText);

        $registrationData = array(
          "type" => strip_tags($content['user_type']),
          "email" => strip_tags($content['r_email']),
          "password_txt" => $passwordText,
          "password_enc" => $passwordEnc,
          "status" => "1",
          "created_at" => date('Y-m-d H:i:s'),
          "modified_at" => date('Y-m-d H:i:s')
        );
        $registrationId = $this->Mdl_login->insert("registration", $registrationData);

        if( $registrationId ){

          if(!empty($content['refer']) && $content['refer'] !==""){
             $map_institute = $this->Mdl_login->insert("institution_mapping", array("registration_id"=>$registrationId,"institution_id"=>$content['refer'],"status"=>"0"));
          }
          $institutionData = array(
            "registration_id" => $registrationId,
            "institution_id" => strip_tags($content['refer']),
            "name" => strip_tags($content['full_name']),
            "email" => strip_tags($content['r_email']),
            "mobile" => strip_tags($content['mobile']),
            "status" => "pending",
            "created_at" => date('Y-m-d H:i:s'),
            "modified_at" => date('Y-m-d H:i:s')
          );
          if($content['user_type'] =="arbitrator"){
            $profile_id = $this->Mdl_login->insert("profile_arbitrator", $institutionData);
          }else{
            $profile_id = $this->Mdl_login->insert("profile_user", $institutionData);
          }
          
          if($profile_id){
             $mailData = array(
            'view_file' => 'new-registration',
            'to' => $content['r_email'],
            'cc' => 'santosh@kwebmaker.com',
            'bcc' => '',
            'subject' => 'Adraas - Registration Confirmation', 
            "name" =>$content['full_name'],
            "email" =>$content['r_email'],
           
          );
          Modules::run('email/mailer', $mailData);
          }
          echo json_encode(array("status"=>"success","title"=>"Registration","icon"=>"success","redirect"=>"./","message"=>"Registration has been completed successfully. Check your mail for login details")); exit;

        }else{

          echo json_encode(array("status"=>"alert","title"=>"Oops! something went wrong","icon"=>"error","message"=>"Please reload & try again.")); exit;

        } 
      }

    }
  }

  

  
  
}