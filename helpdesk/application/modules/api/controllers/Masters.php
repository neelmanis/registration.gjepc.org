<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'modules/generic/controllers/Generic.php';

date_default_timezone_set('Asia/Kolkata');

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authtoken');
// header("Access-Control-Max-Age: 86000");

class Masters extends Generic{

  function __construct() {
    parent::__construct();
    $this->load->model('Mdl_api');	
  }

  public function getZoneList(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }
    $data = $this->Mdl_api->retrieve("zones",array("status"=>"1"));
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
        
    }else{
        $response = array("status"=>"error","message"=>"Zones not added",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }
  public function getVisitorCategoryList(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }
    $data = $this->Mdl_api->retrieve("category_master",array("status"=>"1","onspot_status"=>"1"));
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
        
    }else{
        $response = array("status"=>"error","message"=>"categories not added",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }
  public function getAppName(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }
    $data = $this->Mdl_api->retrieve("app_title_master",array("status"=>"1"));
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"app name not added",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }
  public function getDesignationList(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }
    $data = $this->Mdl_api->retrieve("designation_master",array("status"=>"1"));
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"designation not added",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }
  public function getIdProofDocumentList(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }
    $data = $this->Mdl_api->retrieve("id_proof_documents_master",array("status"=>"1"));
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"documents not added",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }
  
  

}

