<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'modules/generic/controllers/Generic.php';

date_default_timezone_set('Asia/Kolkata');

class Reports extends Generic{

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


  public function getTotalCheckInCategory(){

    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }
    $data = json_decode(file_get_contents('php://input'), true);
    $gate_d = $_GET['gate'];
    if(isset($_GET['created_at'])){
        $created_at = $_GET['created_at'];
    } else {
        $created_at = '';
    }
    
    //$zones = $this->Mdl_api->retrieve("zones",array("gate_name"=>$gate_d));
    $zones = $this->Mdl_api->customQuery("SELECT * FROM zones WHERE gate_name='$gate_d' limit 0");
    if($zones[0]->name == null || $zones[0]->name == ""){
        $response = array("status"=>"error","message"=>"Zones not added",array("result"=>array()));
        echo json_encode($response); exit;
    }
    $gate_name = $zones[0]->name;
    $gate = $zones[0]->description;

    // if($gate_d == "Gate1"){
    //     $gate = $gate_name;
    // }if($gate_d == "Gate2"){
    //      $gate = $gate_name;
    // }if($gate_d == "Gate3"){
    //      $gate = $gate_name;
    // }if($gate_d == "Gate4"){
    //      $gate = $gate_name;
    // }if($gate_d == "Gate5"){
    //      $gate = $gate_name;
    // }if($gate_d == "Gate6"){
    //      $gate = $gate_name;
    // }if($gate_d == "Gate7"){
    //      $gate = $gate_name;
    // }if($gate_d == "Gate8"){
    //      $gate = $gate_name;
    // }if($gate_d == "Gate9"){
    //      $gate = $gate_name;
    // }

    if(empty($gate) && empty($created_at)){
        $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_in'   group by category order by totalCategory DESC");
    } elseif(!empty($gate) && isset($created_at)){
        $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_in'  and current_zone = '$gate'   group by category order by totalCategory DESC");
    }elseif(!empty($created_at) && isset($gate)){
        $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_in'  and created_at like '%".$created_at."%'   group by category order by totalCategory DESC");
    }else {
         $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_in'  and current_zone = '$gate'  and created_at like '%".$created_at."%' group by category order by totalCategory DESC");
    }
 
    //$data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_in'   group by category order by totalCategory DESC");
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"Zones not added",array("result"=>array()));
    }

    echo json_encode($response); exit;

  }


   public function getTotalCheckOutCategory(){

    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }
    $gate_d = $_GET['gate'];
    if(isset($_GET['created_at'])){
        $created_at = $_GET['created_at'];
    } else {
        $created_at = '';
    }
    $zones = $this->Mdl_api->customQuery("SELECT * FROM zones WHERE gate_name='$gate_d' limit 0");
    //$zones = $this->Mdl_api->retrieve("zones",array("gate_name"=>$gate_d));
    if($zones[0]->name == null || $zones[0]->name == ""){
        $response = array("status"=>"error","message"=>"Zones not added",array("result"=>array()));
        echo json_encode($response); exit;
    }
    $gate_name = $zones[0]->name;
    $gate = $zones[0]->description;
   
    // if($gate_d == "Gate1"){
    //     $gate = "Gate 1";
    // }else if($gate_d == "Gate2"){
    //      $gate = "Gate 2";
    // }else if($gate_d == "Gate3"){
    //      $gate = "Gate 3";
    // } else if($gate_d == "Gate4"){
    //      $gate = "Gate 4";
    // } else if($gate_d == "Gate5"){
    //      $gate = "Gate 5";
    // } else if($gate_d == "Gate6"){
    //      $gate = "Gate 6";
    // } else if($gate_d == "Gate7"){
    //      $gate = "Gate 7";
    // } else if($gate_d == "Gate8"){
    //      $gate = "Gate 8";
    // } else if($gate_d == "Gate9"){
    //      $gate = "Gate 9";
    // }
    
    if(empty($gate) && empty($created_at)){
        $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_out'   group by category order by totalCategory DESC");
    } elseif(!empty($gate) && isset($created_at)){
        $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_out'  and current_zone = '$gate'   group by category order by totalCategory DESC");
    }elseif(!empty($created_at) && isset($gate)){
        $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_out'  and created_at like '%".$created_at."%'   group by category order by totalCategory DESC");
    }else {
         $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_out'  and current_zone = '$gate'  or created_at like '%".$created_at."%' group by category order by totalCategory DESC");
    }
    //echo $this->db->last_query();
    //$data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_out' and current_zone = '$gate' and created_at like '%".$created_at."%' group by category order by totalCategory DESC");
    //$data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_out' group by category order by totalCategory DESC");
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"Zones not added",array("result"=>array()));
    }

    echo json_encode($response); exit;

  }
   public function getCheckInCategoryByDate(){

    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }

    //$json = file_get_contents('php://input');
    //$data = json_decode($json);
    $date = $data->date;

    // $data = $this->Mdl_api->customQuery("SELECT user_id,visitor_id,category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_in' AND DATE(created_at) ='$date' group by category order by totalCategory DESC");
    $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_in' AND DATE(created_at) ='$date' group by category order by totalCategory DESC limit 0");
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"Dates not added",array("result"=>array()));
    }

    echo json_encode($response); exit;

  }
   public function getCheckOutCategoryByDate(){

    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $date = $data->date;

    // $data = $this->Mdl_api->customQuery("SELECT user_id,visitor_id,category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_in' AND DATE(created_at) ='$date' group by category order by totalCategory DESC");
    $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='check_out' AND DATE(created_at) ='$date' group by category order by totalCategory DESC limit 0");
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"Dates not added",array("result"=>array()));
    }

    echo json_encode($response); exit;

  }

  public function getCategoryCountByFilter(){

    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $date = $data->date;
    $current_zone = $data->current_zone;
    $type = $data->type;

    $data = $this->Mdl_api->customQuery("SELECT category,current_zone,type,count(*) as totalCategory FROM scan_logs where type='$type' AND DATE(created_at) ='$date' AND current_zone='$current_zone'  group by category order by totalCategory DESC limit 0");
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"Records not found",array("result"=>array()));
    }

    echo json_encode($response); exit;

  }
  
   public function getEventDates(){

    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }

    $data = $this->Mdl_api->customQuery("SELECT DATE(created_at) as event_date FROM scan_logs  group by DATE(created_at) limit 0");
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"Records not found",array("result"=>array()));
    }

    echo json_encode($response); exit;

  }

  public function getUserWiseScanCount(){

    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $type = $data->type;
    $created_at = $data->created_at;
    $data = $this->Mdl_api->customQuery("SELECT s.user_id,a.name,s.type,count(*) as totalScan FROM scan_logs s JOIN authentication a ON a.id=s.user_id WHERE s.type='$type' and s.created_at like '%".$created_at."%' group by s.user_id  order by totalScan desc limit 0");
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"Records not found",array("result"=>array()));
    }

    echo json_encode($response); exit;

  }

  public function getHallWiseCheckInCount(){
   
    // if(!$this->validateToken()){
    //   echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    // }

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $date = $data->date;
   

    $data = $this->Mdl_api->customQuery("SELECT current_zone,type,count(*) as totalCategory,created_at FROM scan_logs where type='check_in' AND DATE(created_at) ='$date'  group by current_zone limit 0");

    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"Records not found",array("result"=>array()));
    }

    echo json_encode($response); exit;

  }

  public function getEventForDates(){
    $data = $this->Mdl_api->customQuery("SELECT created_at FROM scan_logs group by   CAST(created_at AS DATE) limit 0");

    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
    }else{
        $response = array("status"=>"error","message"=>"Records not found",array("result"=>array()));
    }

    echo json_encode($response); exit;
  }


  
  
  
  

}

