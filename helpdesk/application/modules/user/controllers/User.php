<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : SANTOSH SHRIKHANDE
 */

class User extends Generic{
	
	function __construct() {
		parent::__construct();
    $this->load->model('Mdl_user');
	}

  /**
   *  INDEX page
   */
  function dashboard(){
     
    $this->userSession();
    
    $user = $this->session->userdata("user");
    $uid = $user['uid'];
    $userDetails = $this->Mdl_user->retrieve("authentication",array("uid"=>$uid));
    $zones = $this->Mdl_user->retrieve("zones",array("status"=>"1"));
    // print_r($zones_resp['result']);
    
    $data['zones'] = $zones;
    $data['userDetails'] = $userDetails;
   
    $data['viewFile'] = "dashboard";
    $data['scriptFile'] = "dashboard";
    $data['module'] = "user";
    $template = 'user';
    echo Modules::run('template/'.$template, $data);

  }
   function dashboard_v2(){
     
    $this->userSession();
    
    $user = $this->session->userdata("user");
    $uid = $user['uid'];
    $userDetails = $this->Mdl_user->retrieve("authentication",array("uid"=>$uid));
    $zones = $this->Mdl_user->retrieve("zones",array("status"=>"1"));
    // print_r($zones_resp['result']);
    
    $data['zones'] = $zones;
    $data['userDetails'] = $userDetails;
   
    $data['viewFile'] = "dashboard_v2";
    $data['scriptFile'] = "dashboard_v2";
    $data['module'] = "user";
    $template = 'user';
    echo Modules::run('template/'.$template, $data);

  }
  
  // function scanVisitor(){

  //   if(! Modules::run('security/isUser')){
  //    echo json_encode(array("status"=>"error","message"=>"Session Expired."));exit;
  //   }
  //   $user = $this->session->userdata("user");
  //   $token = $user['token'];
  //   $content = $this->input->post();
    
  //   $data  = $content['data'];
  //   $data_array = explode("|",$content['data']);
  //   $unique_code = $data_array[0];

  //   $payload = array("unique_code"=>$unique_code,"device_type"=>"check_in","zone"=>"hall_1");
  //   $request_url = base_url()."api/scanapi/visitorScan";
  //   $response = $this->fetchAuthCurlApi($payload,$request_url,$token); 
  //   echo $response; exit;
  // }

  function scanVisitor(){

    if(! Modules::run('security/isUser')){
     echo json_encode(array("status"=>"error","message"=>"Session Expired."));exit;
    }
    $user = $this->session->userdata("user");
    $token = $user['token'];
    $uid = $user['uid'];
    $content = $this->input->post();
    // print_r($content);exit;
    $qr_content = $content['qr_content'];
    $qr_content_arr = explode("|",$qr_content);
     $unique_code =  $qr_content_arr[0];
    if($unique_code =="" || empty($unique_code)){
      echo json_encode(array("status"=>"error","message"=>"Wrong badge qr code."));exit;
    }
    $device_type =$content['device_type'];
    $current_zone = $content['zone'];


    //  GET SCANNER PERSON INFO
    $scanner_info = $this->Mdl_user->retrieve("authentication",array("uid"=> $uid));
    $user_id = $scanner_info[0]->id;
    
    //GET VISITOR INFO
      
    $visitor = $this->Mdl_user->retrieve("visitors",array("unique_code"=> $unique_code));

      
   if($visitor !=="NA"){
       $registration_id = trim($visitor[0]->registration_id);  
       $visitor_id = trim($visitor[0]->id);   
       $company = trim($visitor[0]->company);
       $name = trim($visitor[0]->name);
       $mobile = trim($visitor[0]->mobile);
       $email = trim($visitor[0]->email);
       $designation = trim($visitor[0]->designation);
       $photo_url = base_url("images/".$visitor[0]->photo_name);
       $category = trim($visitor[0]->category);
       $description = "";
       $getCategoryName = $this->Mdl_user->retrieve("category_master",array("short_name"=>$category));
       if($getCategoryName !=="NA"){
         $description = $getCategoryName[0]->cat_name;
       }
       $status = $visitor[0]->status;

       // Get Zone wise allow for machinery visitor       
       $remark_message = "";
       if($category =="MV"){
         $zone_master = $this->Mdl_user->retrieve("zones",array("name"=> $current_zone));
          if($zone_master !=="NA"){
            $allow_machinery = $zone_master[0]->allow_machinery;
            if($allow_machinery == "0"){    
               $remark_message = "blocked_check_in";
            }
          }
       }
       if($category =="SV"){
         $zone_master = $this->Mdl_user->retrieve("zones",array("name"=> $current_zone));
         if($zone_master !=="NA"){
           $allow_service = $zone_master[0]->allow_service;

           if($allow_service == "0"){
               $remark_message = "blocked_check_in";
           }
         }
       }
       if($status =="D"){
         $remark_message = "blocked_check_in";
       }
   
       $insert_data = array(
         "user_id"=>$user_id,
         "unique_code"=>$unique_code,
         "visitor_id"=>$visitor_id,
         "category"=>$category,
         "current_zone"=>$current_zone,
         "device_type"=>$device_type,
         "latitude"=>"",
         "longitude"=>"",
         "status"=>"1",
         "message"=>$remark_message,
         "type"=> $device_type,
         "role"=>"admin",
         "day"=>date("Y-m-d"),
         "created_at"=>date("Y-m-d H:i:s"),
         "updated_at"=>date("Y-m-d H:i:s"),
       );

     $insert =  $this->Mdl_user->insert("scan_logs",$insert_data);
     /*
     ** START UNIQUE LOG
     */
     if($insert){
      $checkUnique = $this->Mdl_user->isExist("unique_scan_logs",array("unique_code"=>$unique_code));
      if($checkUnique == FALSE){
         $insert_unique_data = array(
         "user_id"=>$user_id,
         "unique_code"=>$unique_code,
         "visitor_id"=>$visitor_id,
         "mobile"=>$mobile,
         "category"=>$category,
         "current_zone"=>$current_zone,
         "device_type"=>$device_type,
         "status"=>"1",
         "message"=>$remark_message,
         "type"=> $device_type,
         "day"=>date("Y-m-d"),
         "created_at"=>date("Y-m-d H:i:s"),

       );

        $insert =  $this->Mdl_user->insert("unique_scan_logs",$insert_unique_data);
      }
     }
     /*
     ** END UNIQUE LOG
     */
    //  echo $this->db->last_query();exit;
     $status = "";
     if($visitor[0]->status =="P"){
     $status = "PENDING";
     $message = "Visitor approval is pending";

     }else if($visitor[0]->status =="Y"){
     $status = "APPROVED";
     $message = "Approved Visitor";
     if($category =="MV"){

         $zone_master = $this->Mdl_user->retrieve("zones",array("name"=> $current_zone));
          if($zone_master !=="NA"){
            $allow_machinery = $zone_master[0]->allow_machinery;

            if($allow_machinery == "0"){
               
               $status = "BLOCKED";
               $message = "Machinery visitor is not allowed this zone";
            }
          }
       }
       if($category =="SV"){
         $zone_master = $this->Mdl_user->retrieve("zones",array("name"=> $current_zone));
         if($zone_master !=="NA"){
           $allow_service = $zone_master[0]->allow_service;

           if($allow_service == "0"){
               $status = "BLOCKED";
               $message = "ACCESS DENIED. ENTRY FROM GATE 2 & 4 ONLY.";
           }
         }
       }
     }else if($visitor[0]->status=="D"){
       $status = "BLOCKED";
       $message = "Visitor is blocked";
     }else if($visitor[0]->status =="DA"){
       $status = "BLOCKED";
       $message = "Visitor is blocked";
     }else if($visitor[0]->status =="R"){
       $status = "REPLACED";
       $message = "Visitor is replaced";
     }

     $response = array("status"=>"success","message"=>"visitor has been scanned successfully.","result"=>array("name"=>$name,"company"=>$company,"category"=>$category,"description"=>$description,"photo_url"=>$photo_url,"isReplaced"=>$visitor[0]->isReplaced,"status"=>$status,"message"=>$message));
     
   }else{
     $response = array("status"=>"error","message"=>"Visitor Record not found in scan system","result"=>array());
   }

   echo json_encode($response);exit;

   
  }

  public function changeZoneAction(){
    if(! Modules::run('security/isUser')){
     echo json_encode(array("status"=>"error","message"=>"Session Expired."));exit;
    }

    $user = $this->session->userdata("user");
    $token = $user['token'];
    $uid = $user['uid'];

    $content = $this->input->post();
    $zone = $content['zone'];
    if($zone !==""){
      $update_zone = $this->Mdl_user->update("authentication", array("uid"=>$uid), array("current_zone"=>$zone));
      if($update_zone){
        echo json_encode(array("status"=>"success","message"=>"Zone has been updated successfully"));exit;
      }
    }

  }

    public function changeDeviceTypeAction(){
    if(! Modules::run('security/isUser')){
     echo json_encode(array("status"=>"error","message"=>"Session Expired."));exit;
    }
    $user = $this->session->userdata("user");
    $token = $user['token'];
    $uid = $user['uid'];

    $content = $this->input->post();
    $device_type = $content['device_type'];
    if($device_type !==""){
      $update_device_type = $this->Mdl_user->update("authentication", array("uid"=>$uid), array("device_type"=>$device_type));
      // echo $this->db->last_query();exit;
      if($update_device_type){
        echo json_encode(array("status"=>"success","message"=>"Device has been set for {$device_type}  successfully"));exit;
      }
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
    $records = $this->Mdl_user->get_datatables("admin");

    $data = array();
    $no = $_POST['start']; 

    $max_limit = sizeof($records);
    $counter = 1;

    foreach ($records as $val){
      $row = array();
      
      $row[] = '<input type="checkbox" name="selectedRows[]" id="'.$val->id.'" value="'.$val->id.'">';

      $url = base_url().'admin/update/'.$val->id;
      $row[] = '<a class="btn btn-rounded btn-outline-success" href="'.$url.'">Update</a>';

      if($val->status == 'active'){
        $row[] = '<span class="badge badge-success">ACTIVE</span>';
      }else{
        $row[] = '<span class="badge badge-danger">INACTIVE</span>';
      }

      $row[] = $val->name;
      $row[] = $val->username;
      $row[] = $val->password_text;

      $role = $this->Mdl_user->retrieve("admin_roles_master",array("role_id"=>$val->role));
      $row[] = $role !== "NA" ? $role[0]->name : "NA";
      $row[] = date("d-m-Y",strtotime($val->created_at));

      $data[] = $row;
      $counter++;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_user->count_all("admin"),
      "recordsFiltered" => $this->Mdl_user->count_filtered("admin"),
      "data" => $data,
    );

    echo json_encode($output);
  }

}