<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'modules/generic/controllers/Generic.php';

date_default_timezone_set('Asia/Kolkata');

class Charts extends Generic{

  function __construct() {
    parent::__construct();
    $this->load->model('Mdl_api');	
  }

  public function getCategoryWiseCount(){
    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }
    $data = $this->Mdl_api->customQuery("SELECT count(*) as visitor_count ,v.category,m.cat_name from visitors v left join category_master m on v.category= m.short_name  group by v.category order by visitor_count asc limit 0");
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
        
    }else{
        $response = array("status"=>"error","message"=>"Zones not added",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }
  
   public function getTotalVisitorCount(){
    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }
    $data = $this->Mdl_api->customQuery("SELECT count(*) as total_record  from visitors limit 0");
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
        
    }else{
        $response = array("status"=>"error","message"=>"Zones not added",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }
  
  
  

}

