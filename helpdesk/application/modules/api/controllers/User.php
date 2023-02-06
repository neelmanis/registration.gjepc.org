<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'modules/generic/controllers/Generic.php';

date_default_timezone_set('Asia/Kolkata');

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authtoken');
// header("Access-Control-Max-Age: 86000");

class User extends Generic{

  function __construct() {
    parent::__construct();
    $this->load->model('Mdl_api');	
  }

  public function appUserCurrentInfo(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }



    $data = $this->Mdl_api->retrieve("authentication",array());
    if($data !=="NA"){
        $data = array("name"=>$data[0]->name,"access"=>$data[0]->access,"mobile"=>$data[0]->mobile,"email"=>$data[0]->email,"current_zone"=>$data[0]->current_zone,"device_type"=>$data[0]->device_type);
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
        
    }else{
        $response = array("status"=>"error","message"=>"User not found",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }
  public function deleteUserApi(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }
    $data = $this->Mdl_api->retrieve("authentication",array());
    if($data !=="NA"){
      $uid = $data[0]->uid;
        $delete = $this->Mdl_api->delete("authentication",array("uid"=>$uid));
        if( $delete ){
          $response = array("status"=>"success","message"=>"User Deleted successfully",array("result"=>""));
        }else{
          $response = array("status"=>"error","message"=>"server error",array("result"=>array()));
        }
       
        
    }else{
        $response = array("status"=>"error","message"=>"User not found",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }


  
  

}

