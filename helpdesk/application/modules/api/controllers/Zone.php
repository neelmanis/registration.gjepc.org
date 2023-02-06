<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'modules/generic/controllers/Generic.php';

date_default_timezone_set('Asia/Kolkata');

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authtoken');
// header("Access-Control-Max-Age: 86000");

class Zone extends Generic{

  function __construct() {
    parent::__construct();
    $this->load->model('Mdl_api');	
  }

  public function switchZone(){
    if(!$this->validateToken()){
        echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }else{
        $uid = $this->validateToken();
    }

    $method = $this->input->method(TRUE);  
    if($method !== 'POST'){
       echo json_encode(array('status' => 400,'message' => 'Bad request.'));exit;
    } else {  

      $content = json_decode(file_get_contents('php://input'), TRUE);
    
      
      $this->form_validation->set_data($content);
      $this->form_validation->set_rules('zone','Zone','trim|xss_clean|required', 
        array("required"=>"Please select zone. "));
      $this->form_validation->set_rules("pin_number","Pin number","trim|xss_clean|required|min_length[6]|max_length[25]",
        array(
          'required' => "Pin number is required"
        ));
      $this->form_validation->set_rules('check_type','check_type','trim|xss_clean|required|in_list[check_in,check_out]',
      array(
        'required' => "Select Check in out",
        'in_list'=>"Select check in or check out"
      ));

      if($this->form_validation->run($this) == FALSE){

        $errors = $this->form_validation->error_array();
        echo json_encode(array('status'=>'error','errorData'=>$errors));exit;

      } else {        
        $password = trim($content['pin_number']);
        $check_type = $content['check_type'];
        
        $updated_at = date("Y-m-d H:i:s");
        $current_zone = $content['zone'];
        $zone = $this->Mdl_api->retrieve("zones",array("id"=>$current_zone));
        $zone_name = $zone[0]->name;

        $getUserData =  $this->Mdl_api->retrieve("authentication", array("uid" => $uid));
        if( $getUserData !=="NA"){
          $parent_id =  $getUserData[0]->parent_id;
          $user_id =  $getUserData[0]->id;
          $name =  $getUserData[0]->name;
          $mobile =  $getUserData[0]->mobile;
        }else{
          echo json_encode(array('status' => "error",'message' => 'App user not found'));exit;
        }

        $registration = $this->Mdl_api->retrieve("users", array("id" => $parent_id));
        if($registration !=="NA"){
          
          $is_valid_password = Modules::run('security/verifyPassoword',$password,$registration[0]->password);
		      if($is_valid_password){
            $update = $this->Mdl_api->update("authentication",array("uid"=>$uid),array("current_zone"=>$zone_name,"device_type"=>$check_type,"modified_date"=>$updated_at));
            // Mentain Log 
            //$update = $this->Mdl_api->insert("login_logs",array("user_id"=>$user_id),array("name"=>$name,"mobile"=>$mobile,"type"=>"zone_update","updated_at"=>$updated_at));
            echo json_encode(array('status'=>'success',"message"=>"Zone has been updated successfully.","result"=>array()));exit;
          }else {
            echo json_encode(array('status'=>'error',"message"=>"Pin not matched"));exit;
          }
        }else{
          echo json_encode(array('status' => "error",'message' => 'App user not found'));exit;
        }

       
      }
		}
  }


  
  

}

