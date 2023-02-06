<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'modules/generic/controllers/Generic.php';

date_default_timezone_set('Asia/Kolkata');

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authtoken');
// header("Access-Control-Max-Age: 86000");

class Auth extends Generic{

  function __construct() {
    parent::__construct();
    $this->load->model('Mdl_api');	
	}

	public function index(){
	//	echo 'AUTH';		
	}
  /**
   *  Callback : Username Check
  */
  public function username_check($username){
    if($username !== ""){
      $isExist = $this->Mdl_api->retrieve("users",array("username"=>$username));

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
   * login api and Generate Token
  */

	public function login(){
 
   $method = $this->input->method(TRUE);  
    if($method !== 'POST'){
        //json_output(400,array('status' => 400,'message' => 'Bad request.'));
       echo json_encode(array('status' => 400,'message' => 'Bad request.'));exit;
    } else {  

      $content = json_decode(file_get_contents('php://input'), TRUE);
      
      
      $this->form_validation->set_data($content);
      $this->form_validation->set_rules('username','User name','trim|xss_clean|callback_username_check');
      $this->form_validation->set_rules('name','Full name','trim|xss_clean|required',
      array(
        "required" => "Name  is required"
      ));

      $this->form_validation->set_rules('email','Email','trim|xss_clean|required|valid_email',
      array(
        "required" => "Email is required",
        "valid_email" => "Email is incorrect"
      ));

      $this->form_validation->set_rules('mobile','Mobile','trim|xss_clean|required|exact_length[10]',
      array(
        "required" => "Mobile no is required",
        "exact_length" => "Mobile no is incorrect"
      ));

      $this->form_validation->set_rules("pword","Password","trim|xss_clean|required|min_length[6]|max_length[25]",
      array(
        'required' => "Password is required"
      ));

      if($this->form_validation->run($this) == FALSE){

        $errors = $this->form_validation->error_array();
        echo json_encode(array('status'=>'error','errorData'=>$errors));exit;

      } else {        

        $password = $content['pword'];
        $username = $content['username'];
        $registration = $this->Mdl_api->retrieve("users", array("username" => $username));

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
            $email = $content['email'];

            $access = $registration[0]->access;
            
            $search_user_params = array(
              "parent_id"=>$registration[0]->id,
              // "name"=>$name,
              "mobile" =>  $mobile
            );

            if($this->Mdl_api->isExist("authentication",$search_user_params)){
              $userInfo = $this->Mdl_api->retrieve("authentication",$search_user_params);
              $user_id = $userInfo[0]->id;
              $uid = $userInfo[0]->uid;
              $token = Modules::run('security/generateAuthToken', $userInfo[0]->uid);
              $token_data =  array(
                "token" => $token,
                "access" => $registration[0]->access,
                "expiry_time" => date("Y-m-d H:i:s",strtotime("+5 day")),
                "modified_date" => date("Y-m-d H:i:s")
              );
              $update_user_token = $this->Mdl_api->update("authentication",array("id"=> $user_id),$token_data);
            }else{
              if($this->Mdl_api->isExist("authentication",array("mobile"=>$mobile))){
                $mobileInfo = $this->Mdl_api->retrieve("authentication",array("mobile"=>$mobile));
                $parent_id = $mobileInfo[0]->parent_id;
                $parent_info = $this->Mdl_api->retrieve("users",array("id"=>$parent_id));
                $parent_name = $parent_info[0]->name;
                echo  json_encode(array("status"=>"error","message"=>"Mobile Number is already used with ".$parent_name));exit;
              }else{
                $insert_data = array("name"=>$name,"mobile"=>$mobile,"email"=>$email,"parent_id"=>$registration[0]->id,"access"=> $access,"created_date"=>date("Y-m-d H:i:s"));
                $user_id = $this->Mdl_api->insert("authentication",$insert_data);
                $uid = $this->encryptParam($user_id);
                $token = Modules::run('security/generateAuthToken',$uid);
                $token_data =  array(
                  "uid"=>$uid,
                  "token" => $token,
                  "expiry_time" => date("Y-m-d H:i:s",strtotime("+5 day")),
                  "created_date" => date("Y-m-d H:i:s"),
                  "modified_date" => date("Y-m-d H:i:s")
                );
                $update_user_token = $this->Mdl_api->update("authentication",array("id"=> $user_id),$token_data);
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
            echo json_encode(array('status'=>'success','result'=>$response));exit;
          } else {
            echo json_encode(array('status'=>'error','errorData'=>array('password'=>'password-wrong')));exit;
          }
        }
      }
		}
  }

  /**
   * Change expiry date of token
   */

  public function logout(){
    $method = $_SERVER['REQUEST_METHOD'];
    $headers = $this->input->request_headers();
    if($method !== 'GET'){
		json_output(400, array('status' => 400,'message' => 'Bad request.'));
		} else {

      if(isset($headers['Authtoken'])){
        $token = $headers['Authtoken'];
      } else {
        $token = $headers['authtoken'];
      }

      $check_token_validity = Modules::run('security/validateAuthToken',$token);
      if($check_token_validity['status'] === "invalid"){
        json_output(200, array('status' => 'invalid token'));
      }else if($check_token_validity['status'] === "expired"){
        json_output(200, array('status' => 'expired'));
      }else if($check_token_validity['status'] === "valid"){
        $registration_id = $check_token_validity['registration_id'];
        $uid = $check_token_validity['uid'];
        $type = $check_token_validity['type'];
        $authentication_details = $this->Mdl_api->retrieve('authentication',array('registration_id'=>$registration_id, 'uid'=>$uid, 'type'=>$type));    

        if($authentication_details !== "NA"){
          $updated_data = array(
            "expiry_time" => date("Y-m-d H:i:s"),
            "modified_date" => date("Y-m-d H:i:s")
          );

          $update = $this->Mdl_api->update2('authentication', array('registration_id'=>$registration_id, 'uid'=>$uid, 'type'=>$type), $updated_data);
          json_output(200, array('status' => 'success','message' => 'User has been log out'));
        } else {
          json_output(200, array('status'=>'no data'));
        }
      }
		}
  }  

 
}

