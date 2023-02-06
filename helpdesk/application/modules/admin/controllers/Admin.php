<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : NEEL
 */

class Admin extends Generic{
	
	function __construct() {
		parent::__construct();
    $this->load->model('Mdl_admin');
    $this->load->helper('captcha');
	}

  /**
   * Admin Login Form
   */
	function index(){
    if(!Modules::run('security/isAdmin')){

      $captcha_array = array(
        'img_path'      => './assets/captcha/images/',
        'img_url'       => base_url('assets').'/captcha/images/',
        'font_path'     => base_url('assets').'/captcha/fonts/Roboto-Regular.ttf',
        'img_width'	    => '150',
        'img_height'	  => '30',
        'word_length'   => 5,
        'font_size'     => 30,
        'colors'        => array(
          'background'     => array(255, 200, 255),
          'border'         => array(255, 255, 255),
          'text'           => array(0, 0, 0),
          'grid'           => array(255, 75, 100)
        )
      );

      $captcha = create_captcha($captcha_array);
      $this->session->set_userdata('captcha_code',$captcha['word']);

      $data['captcha'] = $captcha;
      $data['global'] = $this->global_variables;
      $this->load->view('login',$data);
    }else{
      redirect('admin/dashboard','refresh');
    }
	}
  
  /**
   *  Validate captcha
   */
  function captcha_check($captcha){
    if($captcha == ""){
			$this->form_validation->set_message('captcha_check','Captcha is required');
			return false;
		}else{
      $code = $this->session->userdata('captcha_code');
      if($captcha !== $code){
        $this->form_validation->set_message('captcha_check','Invalid Captcha');
			  return false;
      }else{
        return true;
      }
    }
  }

  /**
   *  Admin Login Action
   */
	function loginAction(){
	$content = $this->input->post();
      
    $token = $this->session->userdata("token");
	if($content["csrfToken"] == $token){
      $this->form_validation->set_rules("email_id","email_id","trim|xss_clean|required",
      array(
        'required' => "email_id is required"
      ));
      
      $this->form_validation->set_rules("password","Password","trim|xss_clean|required",
      array(
        'required' => "Password is required."
      ));
			if($this->form_validation->run($this) == FALSE){
				$errors = $this->form_validation->error_array();
				echo json_encode($errors); exit;
			} else {

        $email_id = strip_tags($content['email_id']);
        $password = strip_tags($content['password']);
        $admin = $this->Mdl_admin->retrieve("admin_master",array('email_id' => $email_id));

        if($admin !== "NA"){
			if($admin[0]->status == '1'){
  
            //$check = Modules::run('security/verifyPassoword', $password, $admin[0]->password);
  
           // if($check){
              $admin_session_data = array(
                'admin_id'=>$admin[0]->id,
                'contact_name'=>$admin[0]->contact_name,
                'role'=>$admin[0]->role,
                'admin_access'=>$admin[0]->admin_access,
                'vendor_access'=>$admin[0]->vendor_access,
                'division_name'=>$admin[0]->division_name,
                'hall'=>$admin[0]->hall,
                'image'=>$admin[0]->image,
                'online'=>$admin[0]->online
              );
                
              $this->session->set_userdata('admin', $admin_session_data);
			  
			  $updateData = array(
                'online'=>'1'
              );			  
			  $update = $this->Mdl_admin->update("admin_master",array("id"=>$admin[0]->id),$updateData);
              $redirect = 'admin/dashboard';
              echo json_encode(array("status"=>"redirect","redirect"=>$redirect)); exit;
            /*}else{
              echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>'email_id and password does not match.')); exit;
            }*/
          }else{
            echo json_encode(array("status"=>"alert","title"=>"Access Denied!","icon"=>"error","message"=>'Your account is Inactive. Contact your administrator for more information.')); exit;
          }
        }else{
          echo json_encode(array("status"=>"alert","title"=>"No such Account","icon"=>"error","message"=> "Admin with email_id '$email_id' does not exist.")); exit;
        }
      }
    }else{
      echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    }
	}
  
  /**
   *  Forgot Password Form
   */
  function forgotPassword(){
    if(!Modules::run('security/isAdmin')){
      $captcha_array = array(
        'img_path'      => './assets/captcha/images/',
        'img_url'       => base_url('assets').'/captcha/images/',
        'font_path'     => base_url('assets').'/captcha/fonts/Roboto-Regular.ttf',
        'img_width'	    => '150',
        'img_height'	  => '30',
        'word_length'   => 5,
        'font_size'     => 30,
        'colors'        => array(
          'background'     => array(255, 200, 255),
          'border'         => array(255, 255, 255),
          'text'           => array(0, 0, 0),
          'grid'           => array(255, 75, 100)
        )
      );

      $captcha = create_captcha($captcha_array);
      $this->session->set_userdata('captcha_code',$captcha['word']);

      $data['captcha'] = $captcha;
      $data['global'] = $this->global_variables;
      $this->load->view('forgot-password',$data);
    }else{
      redirect('admin/dashboard','refresh');
    }
	}

  /**
   *  Admin Recover Password Action
   */
	function recoverPasswordAction(){
		$content = $this->input->post();
      
    $token = $this->session->userdata("token");
	if($content["csrfToken"] == $token){
      $this->form_validation->set_rules("email_id","email_id","trim|xss_clean|required",
      array(
        'required' => "email_id is required"
      ));
      
        $this->form_validation->set_rules("captcha","Captcha","trim|xss_clean|callback_captcha_check");

			if($this->form_validation->run($this) == FALSE){
				$errors = $this->form_validation->error_array();
				echo json_encode($errors); exit;
			} else {

        $email_id = strip_tags($content['email_id']);
        $admin = $this->Mdl_admin->retrieve("admin_master",array('email_id' => $email_id));
		
        if($admin !== "NA"){
          if($admin[0]->status == 'active'){

            if( $admin[0]->email !== "" ){
              $mailData = array(
                'view_file' => 'password-recovery',
                'to' => $admin[0]->email,
                'cc' => '',
                'bcc' => '',
                'subject' => 'Password Recovery',
                "name" => $admin[0]->name,
                "password_text" => $admin[0]->password_text
              );
              Modules::run('email/mailer', $mailData);

              $this->session->unset_userdata('captcha_code');
              $redirect = "admin";
              echo json_encode(array("status"=>"success","title"=>"Mail Sent","icon"=>"success","message"=> "Password has been sent on your registered email id.","redirect"=>$redirect)); exit;
            }else{
              echo json_encode(array("status"=>"alert","title"=>"Failed","icon"=>"error","message"=>'Your email id is not updated. Contact administrator for more information.')); exit;
            }
          }else{
            echo json_encode(array("status"=>"alert","title"=>"Access Denied!","icon"=>"error","message"=>'Your account is Inactive. Contact your administrator for more information.')); exit;
          }
        }else{
          echo json_encode(array("status"=>"alert","title"=>"No such Account","icon"=>"error","message"=> "Admin with email_id '$email_id' does not exist.")); exit;
        }
      }
    }else{
      echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    }
	}

  /**
   *  Admin Logout Action
   */
	function logout(){
		$admin_session = $this->session->userdata("admin");
		$updateData = array(
            'online'=>'0'
        );			  
		$update = $this->Mdl_admin->update("admin_master",array("id"=>$admin_session['admin_id']),$updateData);
		$this->session->unset_userdata('admin');
		redirect('admin','refresh');
    }
  
  /**
   *  Dashboard page
   */
  function dashboard(){
    if(! Modules::run('security/isAdmin')){
      redirect('admin','refresh');
    }
	$admin_session = $this->session->userdata("admin");
    $data['onlineStatus'] = $this->Mdl_admin->retrieve("admin_master",array("id" => $admin_session['admin_id']));
    $template = 'admin';
    $data['viewFile'] = "account/dashboard";
    $data['module'] = "admin";
    echo Modules::run('template/'.$template, $data);
  }

  /**
   *  Admin Profile Form
   */
	function myProfile(){
    if(! Modules::run('security/isAdmin')){
      redirect('admin','refresh');
    }

    $admin_session = $this->session->userdata("admin");
    $data['admin_details'] = $this->Mdl_admin->retrieve("admin_master",array("admin_id" => $admin_session['admin_id']));
    
    $template = 'admin';
    $data['scriptFile'] = 'account';
    $data['viewFile'] = 'account/my-profile';
    $data['module'] = "admin";
    echo Modules::run('template/'.$template, $data);
	}

  /**
   *  Update Profile Action
   */
  function updateProfileAction(){
    $content = $this->input->post();

    $token= $this->session->userdata("token");
    if($content["csrfToken"] == $token){

      $this->form_validation->set_rules("name","Name","trim|xss_clean|required",
      array(
        'required' => "Name is required"
      ));

      if($content["adminUsername"] !== $content["email_id"]){
        $this->form_validation->set_rules("email_id","email_id","trim|xss_clean|required|is_unique[admin_master.email_id]",
        array(
          'required' => 'email_id is required',
          'is_unique' => 'email_id already exist'
        ));
      }else{
        $this->form_validation->set_rules("email_id","email_id","trim|xss_clean|required",
        array(
          'required' => "email_id is required"
        ));
      }

      if($content["adminEmail"] !== $content["email"]){
        $this->form_validation->set_rules("email","Email","trim|xss_clean|required|valid_email|is_unique[admin_master.email]",
        array(
          'required' => 'Email is required',
          'valid_email' => 'Email is invalid',
          'is_unique' => 'Email already in use'
        ));
      }else{
        $this->form_validation->set_rules("email","Email","trim|xss_clean|required|valid_email",
        array(
          'required' => "Email is required",
          'valid_email' => 'Email is invalid'
        ));
      }

      $this->form_validation->set_rules("newPassword","New Password","trim|xss_clean");
      
      if( $content['newPassword'] !== "" ){
        $this->form_validation->set_rules("confirmPassword","Confirm Password","trim|xss_clean|required|matches[newPassword]",
        array(
          'required' => "Re-enter password",
          'matches' => "Password do not match. Please re-enter your password"
        ));
      }else{
        $this->form_validation->set_rules("confirmPassword","Confirm Password","trim|xss_clean");
      }

      if($this->form_validation->run() == FALSE){
        $errors = $this->form_validation->error_array();
        echo json_encode($errors); exit;
      }else{

        $admin_session = $this->session->userdata('admin');
        $admin = $this->Mdl_admin->retrieve("admin_master",array("admin_id"=>$admin_session['admin_id']));

        if( $content['newPassword'] !== "" ){
          $password = Modules::run('security/makeHash',strip_tags($content['newPassword']));
          $data = array(
            "name" => strip_tags($content['name']),
            "email" => strip_tags($content['email']),
            "email_id" => strip_tags($content['email_id']),
            'password_enc' => $password,
            'password_text' => strip_tags($content['newPassword']),
            'modified_at' => date("Y-m-d H:i:s")
          );
        }else{
          $data = array(
            "name" => strip_tags($content['name']),
            "email" => strip_tags($content['email']),
            "email_id" => strip_tags($content['email_id']),
            'modified_at' => date("Y-m-d H:i:s")
          );
        }
        
        $update = $this->Mdl_admin->update("admin_master",array("admin_id"=>$admin_session['admin_id']),$data);

        $admin_session['name'] = strip_tags($content['name']);
        $this->session->set_userdata('admin', $admin_session);

        echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'Profile details updated successfully.',"redirect"=>'admin/dashboard')); exit;
      }
    }else{
      echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    }
  }

  /**
   *  listing page
   */
  function listPage(){
    $this->adminSession('super');

    $template = 'admin';
    $data['scriptFile'] = 'admin';
    $data['viewFile'] = 'admin/list';
    $data['module'] = "admin";
    echo Modules::run('template/'.$template, $data);
  }

  /**
   *  Get records
   */
  function getRecords(){
    $records = $this->Mdl_admin->get_datatables("admin_master");
//	echo '<pre>'; print_r($records); exit;
    $data = array();
    $no = $_POST['start']; 

    $max_limit = sizeof($records);
    $counter = 1;

    foreach ($records as $val){
      $row = array();
      
      $row[] = '<input type="checkbox" name="selectedRows[]" id="'.$val->id.'" value="'.$val->id.'">';

      $url = base_url().'admin/update/'.$val->id;
      $row[] = '<a class="btn btn-rounded btn-outline-success" href="'.$url.'">Update</a>';

      if($val->status == '1'){
        $row[] = '<span class="badge badge-success">ACTIVE</span>';
      }else{
        $row[] = '<span class="badge badge-danger">INACTIVE</span>';
      }

      $row[] = $val->contact_name;
      $row[] = $val->email_id;
      $row[] = $val->password;
      $row[] = $val->role;

      /*$role = $this->Mdl_admin->retrieve("admin_master",array("role"=>$val->role));
      $row[] = $role !== "NA" ? $role[0]->contact_name : "NA"; */
      $row[] = date("d-m-Y",strtotime($val->post_date));

      $data[] = $row;
      $counter++;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_admin->count_all("admin_master"),
      "recordsFiltered" => $this->Mdl_admin->count_filtered("admin_master"),
      "data" => $data,
    );

    echo json_encode($output);
  }

  /**
   *  Add
   */
  function add(){
    $this->adminSession('super');

    $roles = $this->Mdl_admin->retrieve("admin_master",array("1"=>"1"));
    $category = $this->Mdl_admin->retrieve("category_master",array("onspot_status"=>"1"));
    $template = 'admin';
    $data['viewFile'] = "admin/add";
    $data['scriptFile'] = "admin";
    $data['roles'] = $roles;
    $data['category'] = $category;
    $data['module'] = "admin";
    
    echo Modules::run('template/'.$template, $data);
  }
	
  /**
   *  Add Action
   */
  function addAction(){
    $content = $this->input->post();
    
    $token= $this->session->userdata("token");
    if($content["csrfToken"] == $token){

      $this->form_validation->set_rules("name","Name","trim|xss_clean|required",
      array(
        'required' => "Name is required"
      ));

      $this->form_validation->set_rules("email","Email","trim|xss_clean|required|valid_email|is_unique[admin_master.email]",
      array(
        'required' => 'Email is required',
        'valid_email' => 'Email is invalid',
        'is_unique' => 'Email already in use'
      ));

      $this->form_validation->set_rules("email_id","email_id","trim|xss_clean|required|is_unique[admin_master.email_id]",
      array(
        'required' => 'email_id is required',
        'is_unique' => 'email_id already taken.'
      ));

      $this->form_validation->set_rules("password_text","Password","trim|xss_clean|required",
      array(  
        'required' => "Password is required"
      ));

      $this->form_validation->set_rules("role","Role","trim|xss_clean|required",
      array(
        'required' => "Select role"
      ));
      $this->form_validation->set_rules("category","category","trim|xss_clean|required",
      array(
        'required' => "Select category"
      ));

      if($this->form_validation->run() == FALSE){
        $errors = $this->form_validation->error_array();
        echo json_encode($errors); exit;
      }else{

        $password_enc = Modules::run('security/makeHash',strip_tags($content['password_text']));

        $data = array(
          
          'name' => strip_tags($content['name']),
          'email' => strip_tags($content['email']),
          'email_id' => strip_tags($content['email_id']),
          'password_text' => strip_tags($content['password_text']),
          'password' => $password_enc,
          'is_admin' => "N",
          'status' => "1",
          "role" => strip_tags($content['role']),
          "category" => strip_tags($content['category']),
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        );

        $insert = $this->Mdl_admin->insert('admin_master',$data); 

        echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'User account created successfully',"redirect"=>'admin/list')); exit;
      }
    }else{
      echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    }
  }

  /**
   *  Update
   */
  function update($id){
    $this->adminSession('super');

    $admin_details = $this->Mdl_admin->retrieve("admin_master",array("admin_id"=>$id));
    $roles = $this->Mdl_admin->retrieve("admin_master",array("1"=>"1"));

    if($admin_details == "NA"){
      redirect('errors','refresh');
    }else{
      $template = 'admin';
      $data['admin'] = $admin_details;
      $data['roles'] = $roles;
      $data['viewFile'] = "admin/update";
      $data['scriptFile'] = "admin";
      $data['module'] = "admin";
      echo Modules::run('template/'.$template, $data);
    }
  }

  /**
   *  Update Action
   */
  function updateAction(){
    $content = $this->input->post();

    $token= $this->session->userdata("token");
    if($content["csrfToken"] == $token){

      $this->form_validation->set_rules("name","Name","trim|xss_clean|required",
      array(
        'required' => "Name is required"
      ));

      if($content["adminEmail"] !== $content["email"]){
        $this->form_validation->set_rules("email","Email","trim|xss_clean|required|valid_email|is_unique[admin_master.email]",
        array(
          'required' => 'Email is required',
          'valid_email' => 'Email is invalid',
          'is_unique' => 'Email already in use'
        ));
      }else{
        $this->form_validation->set_rules("email","Email","trim|xss_clean|required|valid_email",
        array(
          'required' => "Email is required",
          'valid_email' => 'Email is invalid'
        ));
      }

      if($content["adminUsername"] !== $content["email_id"]){
        $this->form_validation->set_rules("email_id","email_id","trim|xss_clean|required|is_unique[admin_master.email_id]",
        array(
          'required' => 'email_id is required',
          'is_unique' => 'email_id already exist'
        ));
      }else{
        $this->form_validation->set_rules("email_id","email_id","trim|xss_clean|required",
        array(
          'required' => "email_id is required"
        ));
      }

      $this->form_validation->set_rules("password_text","Password","trim|xss_clean|required",
      array(
        'required' => "Password is required"
      ));

      $this->form_validation->set_rules("role","Role","trim|xss_clean|required",
      array(
        'required' => "Select role"
      ));

      $this->form_validation->set_rules("status","Status","trim|xss_clean|required",
      array(
        'required' => "Select status"
      ));

      if($this->form_validation->run() == FALSE){
        $errors = $this->form_validation->error_array();
        echo json_encode($errors); exit;
      }else{

        $password_enc = Modules::run('security/makeHash',strip_tags($content['password_text']));

        $data = array(
          'name' => strip_tags($content['name']),
          'email' => strip_tags($content['email']),
          'email_id' => strip_tags($content['email_id']),
          'password_text' => strip_tags($content['password_text']),
          'password_enc' => $password_enc,
          'is_superadmin' => "no",
          'status' => strip_tags($content['status']),
          "role" => strip_tags($content['role']),
          'modified_at' => date('Y-m-d H:i:s')
        );

        $update = $this->Mdl_admin->update("admin_master",array("admin_id"=>$content['admin_id']),$data);

        echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'Admin details updated successfully',"redirect"=>'admin/list')); exit;
      }
    }else{
      echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    }
  }

  function deleteAction(){
    $records = explode(",",$this->input->post('values'));

    foreach($records as $val){
      $admin = $this->Mdl_admin->retrieve("admin_master",array("admin_id "=>$val));
      if($admin !== "NA"){
        $this->Mdl_admin->delete('admin_master',array("admin_id "=>$val));
      }
    }
    
    echo json_encode(array("status"=>"success")); exit;
  }
}