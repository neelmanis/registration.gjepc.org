<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : SANTOSH SHRIKHANDE
 */

class Login extends Generic{
	
	function __construct() {
		parent::__construct();
    $this->load->model('Mdl_login');
	}


	function index(){
    if(!Modules::run('security/isUser')){
      $data['title'] = "Exhibitor Login Page";
      $data['global'] = $this->global_variables;
      $this->load->view( 'login', $data );
    }else{
      redirect('user/dashboard','refresh');
    }
	}
  /**
   *  Callback : Username Check
  */
  public function username_check($username){
    if($username !== ""){
      $isExist = $this->Mdl_login->retrieve("users",array("username"=>$username));

      if($isExist =="NA"){
        $this->form_validation->set_message('username_check','Username is incorrect');
        return false;
      }else{
        return true;
      }
    }else{
      $this->form_validation->set_message('username_check','Username  is required');
      return false;
    }
  }

  /**
   *   Login Action
   */
	function loginAction(){
		$content = $this->input->post();
    $token = $this->session->userdata("token");
		// if($content["csrfToken"] == $token){

      
      $this->form_validation->set_rules('name','Full name','trim|xss_clean|required',
      array(
        "required" => "Name  is required"
      ));

      // $this->form_validation->set_rules('email','Email','trim|xss_clean|required|valid_email',
      // array(
      //   "required" => "Email is required",
      //   "valid_email" => "Email is incorrect"
      // ));

      $this->form_validation->set_rules('mobile','Mobile','trim|xss_clean|required|exact_length[10]',
      array(
        "required" => "Mobile no is required",
        "exact_length" => "Mobile no is incorrect"
      ));

      $this->form_validation->set_rules('username','User name','trim|xss_clean|callback_username_check');
      $this->form_validation->set_rules("password","Password","trim|xss_clean|required|min_length[6]|max_length[25]",
      array(
        'required' => "Password is required"
      ));

      if($this->form_validation->run($this) == FALSE){

        $errors = $this->form_validation->error_array();
        $errors = $this->form_validation->error_array();
				echo json_encode($errors); exit;

      } else {        

        $password = $content['password'];
        $username = $content['username'];
        $registration = $this->Mdl_login->retrieve("users", array("username" => $username));

        if($registration == "NA"){
           echo json_encode(array('status'=>'fail','message'=>'user-not-exist'));exit;
        } else if($registration[0]->status == "deactive"){
           echo json_encode(array('status'=>'fail','message'=>'account-deactivate'));exit;
        } else if($registration[0]->status == "pending"){
           echo json_encode(array('status'=>'fail','message'=>'account-pending'));exit;
        } else {
        
	  	  $is_valid_password = Modules::run('security/verifyPassoword',$password,$registration[0]->password);
		      if($is_valid_password){
            
            $name = $content['name'];
            $mobile = $content['mobile'];
            // $email = $content['email'];

            $access = $registration[0]->access;
            $admin_id = $registration[0]->id;
            $category = $registration[0]->category;

            $role = $registration[0]->role;
            $rights_master = $this->Mdl_login->retrieve("admin_roles_master",array("role_id"=>$role));
            if($rights_master !=="NA"){
              $rights = explode(",",$rights_master[0]->rights);
            }else{
              $rights = "";
            }


            $search_user_params = array(
              "parent_id"=>$registration[0]->id,
            //  "name"=>$name,
              "mobile" =>  $mobile
            );
            if($this->Mdl_login->isExist("authentication",$search_user_params)){
              $userInfo = $this->Mdl_login->retrieve("authentication",$search_user_params);
              $user_id = $userInfo[0]->id;
              $uid = $userInfo[0]->uid;
              $token = Modules::run('security/generateAuthToken', $userInfo[0]->uid);
              $token_data =  array(
                "token" => $token,
                "access" => $registration[0]->access,
                "expiry_time" => date("Y-m-d H:i:s",strtotime("+5 day")),
                "modified_date" => date("Y-m-d H:i:s")
              );
              $update_user_token = $this->Mdl_login->update("authentication",array("id"=> $user_id),$token_data);
            }else{
              if($this->Mdl_login->isExist("authentication",array("mobile"=>$mobile))){
                $mobileInfo = $this->Mdl_login->retrieve("authentication",array("mobile"=>$mobile));
                $parent_id = $mobileInfo[0]->parent_id;
                $parent_info = $this->Mdl_login->retrieve("users",array("id"=>$parent_id));
                $parent_name = $parent_info[0]->name;
                echo  json_encode(array("status"=>"alert","message"=>"Mobile Number is already used with ".$parent_name));exit;
              }else{
                $insert_data = array("name"=>$name,"mobile"=>$mobile,"parent_id"=>$registration[0]->id,"access"=> $access,"created_date"=>date("Y-m-d H:i:s"));
                $user_id = $this->Mdl_login->insert("authentication",$insert_data);
                $uid = $this->encryptParam($user_id);
                $token = Modules::run('security/generateAuthToken',$uid);
                $token_data =  array(
                  "uid"=>$uid,
                  "token" => $token,
                  "expiry_time" => date("Y-m-d H:i:s",strtotime("+5 day")),
                  "created_date" => date("Y-m-d H:i:s"),
                  "modified_date" => date("Y-m-d H:i:s")
                );
                $update_user_token = $this->Mdl_login->update("authentication",array("id"=> $user_id),$token_data);
              }
            }
             $response =  array(
                "token" => $token,
                "uid"=> $uid,
                "access" => $registration[0]->access,
                "name" => $name,
                "organization" => $registration[0]->name,
                "expiry_time" => date("Y-m-d H:i:s",strtotime("+5 day")),
              );
            // echo json_encode(array('status'=>'success','result'=>$response));exit;
            $user_session_data = array(
              'admin_id'=>$admin_id,
              'uid'=>$uid,
			        'id'=>$user_id,
              'name'=>$name,
              'is_superadmin'=>"no",
              'type'=>'user',
              'rights'=> $rights,
              'category'=> $category,
              "token"=>$token,
            );
              
            $this->session->set_userdata('user', $user_session_data);
            $redirect = 'user/dashboard';
            
            echo json_encode(array("status"=>"redirect","redirect"=>$redirect)); exit;
          } else {
            echo json_encode(array('status'=>'alert','message'=>"sorry wrong password"));exit;
          }
        }
      }
          
    // }else{
    //   echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    // }
	}

  function logout(){
		$this->session->unset_userdata('user');
		redirect('/login','refresh');
  }

   

  

  
  
}