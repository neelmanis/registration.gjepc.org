<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 *  Author : Amit Kashte
 */

class Cases extends Generic{
  
  function __construct() {
    parent::__construct();
    $this->load->model('Mdl_cases');  
  }

  /**
   *  Listing Page
   */
  function listPage(){
    $this->adminSession('7');

    $data['scriptFile'] = 'cases';
    $data['viewFile'] = 'admin/list';
    $data['module'] = "cases";
    echo Modules::run('template/admin', $data);
  }

  /**
   *  Get records
   */
  function page(){
    $records = $this->Mdl_cases->get_datatables("cases");

    $data = array();
    $no = $_POST['start']; 
    
    $admin_session = $this->session->userdata('admin');

    foreach ($records as $val){
      $row = array();
      $isStatus = Modules::run("institution/getColumn", "isStatus", "case_details",  array("case_id" => $val->id));
      $url = base_url().'cases/details/'.$val->id;
      $id = $this->encryptParam($val->id);
      $editUrl = base_url().'cases/caseStepOne/'.$id;
      if($isStatus != "1"){
        $row[] = '<a class="btn btn-circle btn-info" href="'.$url.'"><i class="ti-eye"></i></a> <a class="btn btn-circle btn-info" href="'.$editUrl.'"><i class="ti-pencil-alt"></i></a>';
      } else {
        $url = base_url().'cases/details/'.$val->id;
        $row[] = '<a class="btn btn-circle btn-info" href="'.$url.'"><i class="ti-eye"></i></a>';
      }
        
      if($isStatus != "1") {
        if($val->status == 'active'){
          $row[] = '<span class="badge badge-success">ACTIVE</span>';
        } else if($val->status == 'closed'){
          $row[] = '<span class="badge badge-info">CLOSED</span>';
        }else{
          $row[] = '<span class="badge badge-danger">INACTIVE</span>';
        }
      } else {
        $row[] = '<span class="badge btn-dark"">CLOSED</span>';
      }

      $row[] = $val->serial_no;
      $row[] = $val->offline_id;
      $row[] = date("d-m-Y",strtotime($val->created_at));

      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_cases->count_all("cases"),
      "recordsFiltered" => $this->Mdl_cases->count_filtered("cases"),
      "data" => $data,
    );

    echo json_encode($output);
  }

  /**
   *  Profile Page
   */
  function details($id){
    $this->adminSession('7');
    $cases = $this->Mdl_cases->retrieve("case_registration",array("id"=>$id));
    $institution = "NA";

    if($cases == "NA"){
      redirect("cases/list","refresh");
    }else{
      $details = $this->Mdl_cases->retrieve("case_details",array("case_id"=>$cases[0]->id));
      $modify_by = $this->Mdl_cases->retrieve("profile_user",array("registration_id"=>$cases[0]->modified_by));
      
      $case_user = $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='".$id."' and type = 'institution' ");
      ///claimant Profile
      $user =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='".$id."' AND party='claimant' and type ='user'");
      $claimant_profiles = "NA";
      if( $user !== "NA" && !empty($user) ){
        $registrationId = $user[0]->registration_id;
        $claimant_profiles = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => $registrationId));
      }
      /////// claimnat authorized person
      $persons =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='".$id."' AND party='claimant' and type != 'user' ");

      $representative = "NA";

      if( $persons !== "NA" ){
        $representative = array();
        foreach( $persons as $p ){
          $registration = $this->Mdl_cases->retrieve("registration", array('registration_id' => "$p->registration_id"));
          $claimantAuthorisedPersons = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => "$p->registration_id"));

          array_push($representative, $claimantAuthorisedPersons);
        }
      }

      ////respondant 
      $resUser =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='".$id."' AND party='respondant' and type ='user'");

      $resProfile = "NA";
      if( $resUser !== "NA" && !empty($resUser) ){
        $resRegistrationId = $resUser[0]->registration_id;
        $resProfile = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => $resRegistrationId));
      }
      ////

      ///respondant authorised person 
      $resPersons =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='".$id."' AND party='respondant' and type != 'user' ");

      $resRepresentative = "NA";

      if( $resPersons !== "NA" ){
        $resRepresentative = array();
        foreach( $resPersons as $p ){
          $respRegistration = $this->Mdl_cases->retrieve("registration", array('registration_id' => "$p->registration_id"));
          $resDetails = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => "$p->registration_id"));

          array_push($resRepresentative, $resDetails);
        }
      }

      if($case_user != "NA") {
        $institution = $this->Mdl_cases->retrieve("profile_institution",array("registration_id"=>$case_user[0]->registration_id));
      }
      ///claimant & respondant
      $claimantArbitrator =  $this->Mdl_cases->customQuery("SELECT DISTINCT  registration_id FROM case_arbitrator_selection WHERE case_id='".$id."' and party='claimant' ");
      $claimantArbdetails =  array();
      if($claimantArbitrator != null && $claimantArbitrator != null && $claimantArbitrator != "NA"){
        foreach( $claimantArbitrator as $p ){
          //$cldetails = $this->Mdl_cases->retrieve("profile_user", array('registration_id' => "$p->registration_id"));
          $cldetails = $this->Mdl_cases->customQuery("select pu.registration_id, pu.`name`, pu.mobile, pu.email  
                                                      from profile_arbitrator as pu where pu.registration_id = $p->registration_id ");
          $claimantArbdetails[] = $cldetails;
        }
        // print_r($claimantArbdetails);exit;
        //$arbitrators['claimantArbdetail'] = $claimantArbdetails;
      }
      $respondantArbitrator =  $this->Mdl_cases->customQuery("SELECT DISTINCT  registration_id FROM case_arbitrator_selection WHERE case_id='".$id."' and party='respondant' ");
      $respondantArbitrators = array();
      
      if($respondantArbitrator != null && $respondantArbitrator != null && $respondantArbitrator != "NA"){
        foreach( $respondantArbitrator as $p ){
          //$bdetails = $this->Mdl_cases->retrieve("profile_user", array('registration_id' => "$p->registration_id"));
          $bdetails = $this->Mdl_cases->customQuery("select pu.registration_id, `pu`.`name`, `pu`.`mobile`, `pu`.`email`  from profile_arbitrator as pu    where pu.registration_id = $p->registration_id ");
          $respondantArbitrators[] = $bdetails;
        }

        //$arbitrators['respondantArbitrators'] = $respondantArbitrators;
      }

      $limit_per_page = 3;
      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
      $start_index = ($page - 1) * $limit_per_page;
      $allArbitrators = $this->Mdl_cases->retrieve("profile_arbitrator", array());
      //$allArbitrators= $this->Mdl_cases->customQuery("SELECT profile_arbitrator.registration_id, profile_arbitrator.photo,    profile_arbitrator.email,profile_arbitrator.name,
                                                      // profile_arbitrator.mobile,institution_mapping.institution_id,pi.organisation_name,pi.contact_number
                                                      // FROM `profile_arbitrator` 
                                                      // JOIN institution_mapping on profile_arbitrator.registration_id = institution_mapping.registration_id
                                                      // left join profile_institution as pi on pi.institution_id = institution_mapping.institution_id
                                                      // order by profile_arbitrator.id DESC
                                                      // limit $limit_per_page offset $start_index  "); 
      $total_records =  $allArbitrators == "NA" ? 0 : sizeof($allArbitrators);
      $arbitrators =$this->Mdl_cases->getByFilter("profile_arbitrator",array(),$start_index,$limit_per_page,"created_at","DESC");
     // $count =  $this->Mdl_cases->customQuery("SELECT COUNT(*) as records FROM `profile_arbitrator` ");
      if($allArbitrators != "NA"){
        $base_url = base_url().'cases/details/'.$id.'/'.$page;
        $links = $this->create_pagination($limit_per_page,$total_records,$base_url);
      }else{
        $links = "NA";
      }
      $isStatus = Modules::run("institution/getColumn", "isStatus", "case_details",  array("case_id" =>$id));
      
      $data['claimant_profile'] = $claimant_profiles;
      $data['claimantAuthorisedPersons'] = $representative;
      $data['respondentDetails'] = $resProfile;
      $data['respondentAuthorisedPersons'] = $resRepresentative;
      $data['claimantArbdetail'] = $claimantArbdetails;
      $data['respondantArbitrators'] = $respondantArbitrators;
      $data['claimant_arbitrators'] = "NA";
      $data['respondent_arbitrators'] = "NA";
      $data['allArbitrators'] = $allArbitrators;
      //$data['allArbitrators_data'] = $allArbitrators_data;
      //$data['arbitrators'] = $arbitrators;
      $data['arbitrator_pagination'] = $links;

      $data['isStatus'] = $isStatus;
      $data['cases'] = $cases;
      $data['details'] = $details;
      $data['modify_by'] = $modify_by;
      $data['institution'] = $institution;
      $data['scriptFile'] = "cases";
      $data['viewFile'] = "admin/details";
      $data['module'] = "cases";
      echo Modules::run('template/admin', $data);
    }
  }

  function getClaimant( $caseId ){
    $user =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='".$caseId."' AND party='claimant' and type ='user'");

    $profile = "NA";
    if( $user !== "NA" && !empty($user) ){
      $registrationId = $user[0]->registration_id;
      $profile = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => $registrationId));
    }

    return $profile;
  }

  function getAuthorisedClaimants( $caseId ){
    $persons =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='".$caseId."' AND party='claimant' and type != 'user' ");

    $representative = "NA";

    if( $persons !== "NA" ){
      $representative = array();
      foreach( $persons as $p ){
        $registration = $this->Mdl_cases->retrieve("registration", array('registration_id' => "$p->registration_id"));
        $details = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => "$p->registration_id"));

        array_push($representative, $details);
      }
    }

    return $representative;
  }

  function getRespondent( $caseId ){
    $user =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='".$caseId."' AND party='respondant' and type ='user'");

    $profile = "NA";
    if( $user !== "NA" && !empty($user) ){
      $registrationId = $user[0]->registration_id;
      $profile = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => $registrationId));
    }

    return $profile;
  }
  function getAuthorisedRespondent( $caseId ) {
    $persons =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='".$caseId."' AND party='respondant' and type != 'user' ");

    $representative = "NA";

    if( $persons !== "NA" ){
      $representative = array();
      foreach( $persons as $p ){
        $registration = $this->Mdl_cases->retrieve("registration", array('registration_id' => "$p->registration_id"));
        $details = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => "$p->registration_id"));

        array_push($representative, $details);
      }
    }

    return $representative;
  }
  function getArbitrator($caseId) {
    $case_details =  $this->Mdl_cases->customQuery("SELECT * FROM case_details WHERE case_id='".$caseId."' ");
    $arbitrator = "NA";
    if( $case_details !== "NA" && !empty($case_details) ){
      
      $arbitration_selection_type = $case_details[0]->c_arbitration_selection_type;
      $r_arbitration_selection_type = $case_details[0]->r_arbitration_selection_type;
      $arbitrators = array(
        "arbitration_selection_type" => $arbitration_selection_type,
         "r_arbitration_selection_type" => $r_arbitration_selection_type
      );
      ///array_push($arbitrators, );
      // if($arbitration_selection_type == "all" || $arbitration_selection_type == "institution"){
      //   $arbitrator =  $this->Mdl_cases->customQuery("SELECT * FROM case_arbitrator_selection WHERE case_id='".$caseId."' ");
      //   foreach( $arbitrator as $p ){
      //     $details = $this->Mdl_cases->retrieve("profile_arbitrator", array('registration_id' => "$p->registration_id"));
      //     //$details = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => "$p->registration_id"));
      //     array_push($arbitrators, $details);
      //   }
      // }
      //  if($arbitration_selection_type == "institution" || $arbitration_selection_type == "request_institution") {
      //   $arbitrator =  $this->Mdl_cases->customQuery("SELECT * FROM case_arbitrator_selection WHERE case_id='".$caseId."' ");
      //   foreach( $arbitrator as $p ){
      //     $details = $this->Mdl_cases->retrieve("profile_institution", array('registration_id' => "$p->registration_id"));
      //     //$details = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => "$p->registration_id"));
      //     array_push($arbitrators, $details);
      //   }
      // }
      $claimantArbitrator =  $this->Mdl_cases->customQuery("SELECT DISTINCT  registration_id FROM case_arbitrator_selection WHERE case_id='".$caseId."' and party='claimant' ");
      $claimantArbdetails =  array();
      if($claimantArbitrator != null && $claimantArbitrator != null && $claimantArbitrator != "NA"){
        foreach( $claimantArbitrator as $p ){
          $details = $this->Mdl_cases->retrieve("profile_user", array('registration_id' => "$p->registration_id"));
          $claimantArbdetails[] = $details;
        }
        $arbitrators['claimantArbdetail'] = $claimantArbdetails;
      }
      $respondantArbitrator =  $this->Mdl_cases->customQuery("SELECT DISTINCT  registration_id FROM case_arbitrator_selection WHERE case_id='".$caseId."' and party='respondant' ");
      $respondantArbitrators = array();
      $respondantArbitrators = "NA";
      if($respondantArbitrator != null && $respondantArbitrator != null && $respondantArbitrator != "NA"){
        foreach( $respondantArbitrator as $p ){
          $bdetails = $this->Mdl_cases->retrieve("profile_user", array('registration_id' => "$p->registration_id"));
          //$details = $this->Mdl_cases->retrieveByCol("name, mobile, email, address", "profile_user", array('registration_id' => "$p->registration_id"));
          $respondantArbitrators[] = $bdetails;
        }
        $arbitrators['respondantArbitrators'] = $respondantArbitrators;
      }
  
    }
    return $arbitrators;
  }

 public function showArbitratorRequestAction(){
    $content = $this->input->post();
    $status = $content['status'];
    $case_id = $content['case_id'];
    $data = array("arbitrator_show_request"=>$status);
     
    $update = $this->Mdl_cases->update("case_details",array("case_id"=>$case_id),$data);
    echo json_encode(array("status" => "success", "title" => "Success", "icon" => "success", "message" => "Response has been successfully updated for case"));
  }

  function checkArbitraor() {
    $claimant_id = $_POST['claimant'];
    $caseId = $_POST['case_id'];

    $claimantArbitrator =  $this->Mdl_cases->customQuery("SELECT DISTINCT  registration_id FROM case_arbitrator_selection WHERE case_id='".$caseId."' and party='claimant' ");
    $respondantArbitrator =  $this->Mdl_cases->customQuery("SELECT DISTINCT  registration_id FROM case_arbitrator_selection WHERE case_id='".$caseId."' and party='respondant' ");
    $data = array(
      "type" => strip_tags('arbitrator'),
      'modified_at' => date("Y-m-d H:i:s")
    );
    $arbitrators = false;
    $case_id ="";
    if($claimantArbitrator == "NA") {
      $instituteArbitrator = $this->Mdl_cases->retrieve("case_users",array("case_id"=>$caseId, "registration_id"=>$claimant_id, "type"=>"arbitrator", "status"=> "1"));
        if($instituteArbitrator == "NA") {
          $caseRegistrationData = array(
            "case_id" => $caseId,
            "registration_id" => $claimant_id,
            "type" => "arbitrator",
            "party" => "",
            "remark" => "",
            "status" => "1",
            "created_at" => date('Y-m-d H:i:s'),
            "modified_at" => date('Y-m-d H:i:s'),
            
          );
          $case_id = $this->Mdl_cases->insert("case_users", $caseRegistrationData);
        }
      } elseif($respondantArbitrator == "NA") {
          $instituteArbitrator = $this->Mdl_cases->retrieve("case_users",array("case_id"=>$caseId, "registration_id"=>$claimant_id, "type"=>"arbitrator", "status"=> "1"));
        if($instituteArbitrator == "NA") {
          $caseRegistrationData = array(
            "case_id" => $caseId,
            "registration_id" => $claimant_id,
            "type" => "arbitrator",
            "party" => "",
            "remark" => "",
            "status" => "1",
            "created_at" => date('Y-m-d H:i:s'),
            "modified_at" => date('Y-m-d H:i:s'),
            
          );
          $case_id = $this->Mdl_cases->insert("case_users", $caseRegistrationData);
        }
      } else {
        //check 
        $instituteArbitrator = $this->Mdl_cases->retrieve("case_users",array("case_id"=>$caseId, "registration_id"=>$claimant_id, "type"=>"arbitrator", "status"=> "1"));
        if($instituteArbitrator == "NA") {
        $caseRegistrationData = array(
          "case_id" => $caseId,
          "registration_id" => $claimant_id,
          "type" => "arbitrator",
          "party" => "",
          "remark" => "",
          "status" => "1",
          "created_at" => date('Y-m-d H:i:s'),
          "modified_at" => date('Y-m-d H:i:s'),
          
        );
        $case_id = $this->Mdl_cases->insert("case_users", $caseRegistrationData);
      }

    }
    
    if($case_id) {
      $status = "update";
    } else {
      $status = "notUpdate";
    }
    echo json_encode(array("arbitrators"=>$arbitrators,"status"=>$status)); exit; 
  }

  function adminSelectedArb() {
    $claimant_id = $_POST['claimant'];
    $caseId = $_POST['case_id'];
    if(!isset($claimant_id)){
      $status = "fail";
      echo json_encode(array("status"=>$status)); exit; 
    }
    $data = array(
      "type" => strip_tags('arbitrator'),
      'modified_at' => date("Y-m-d H:i:s")
    );
    $arbitrators = false;
    $case_id = "";
    $instituteArbitrator = $this->Mdl_cases->retrieve("case_users",array("case_id"=>$caseId, "registration_id"=>$claimant_id, "type"=>"arbitrator", "status"=> "1"));
      if($instituteArbitrator == "NA") {
        $caseRegistrationData = array(
          "case_id" => $caseId,
          "registration_id" => $claimant_id,
          "type" => "arbitrator",
          "party" => "",
          "remark" => "",
          "status" => "1",
          "created_at" => date('Y-m-d H:i:s'),
          "modified_at" => date('Y-m-d H:i:s'),
          
        );
        $insert_arbitrator = $this->Mdl_cases->insert("case_users", $caseRegistrationData);
        $arbitrator = $this->Mdl_cases->retrieve("profile_arbitrator",array("registration_id"=>$claimant_id));
        $registration_data = $this->Mdl_cases->retrieve("registration", array('registration_id' => $arbitrator[0]->registration_id));
        $info_link = "https://adraas.com/";

        if( $arbitrator !== "NA"){
          if($registration_data[0]->status == "1") {
            $case_id = Modules::run("common/getCaseId",$caseId);
            $mailData = array(
              'view_file' => 'admin_selection_arbitrator',
              'to' => $arbitrator[0]->email,
              'cc' => '',
              'bcc' => '',
              'subject' => 'ADRAAS Arbitrator Selection',
              "caseId" => $case_id,
              "info_link" => $info_link,
              "name" => $arbitrator[0]->name,
            
            );
            Modules::run('email/mailer', $mailData);
          }
          Modules::run("common/insertNotification",$caseId,$claimant_id,0, "You have been successfully appointed as arbitrator","caseDetails");
    
        }
      }
    
    if($case_id ){
      

      $status = "success";
    } else {
      $status = "fail";
    }
    echo json_encode(array("arbitrators"=>$arbitrators,"status"=>$status)); exit; 
  }

  function getInstitutionArbitrator($caseId){
    $limit_per_page = 3;
    $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
    $start_index = ($page - 1) * $limit_per_page;
    $allArbitrators= $this->Mdl_cases->customQuery("SELECT profile_arbitrator.registration_id, profile_arbitrator.photo,profile_arbitrator.email,profile_arbitrator.name,
                                                      profile_arbitrator.mobile,institution_mapping.institution_id,pi.organisation_name,pi.contact_number
                                                      FROM `profile_arbitrator` 
                                                      JOIN institution_mapping on profile_arbitrator.registration_id = institution_mapping.registration_id
                                                      left join profile_institution as pi on pi.institution_id = institution_mapping.institution_id
                                                      order by profile_arbitrator.id DESC
                                                        "); 
      $total_records =  $allArbitrators == "NA" ? 0 : sizeof($allArbitrators);
      
      if($allArbitrators != "NA"){
        $base_url = base_url().'cases/details/'.$id.'/'.$page;
        $links = $this->create_pagination($limit_per_page,$total_records,$base_url);
      }else{
        $links = "NA";
      }

      $instituteArbitratorData['pagination_arbitrator'] = $links;
      $instituteArbitratorData['instituteArbitrator'] = $allArbitrators;
      
      return $instituteArbitratorData;
     
   
  }

  function arbitratorOrg($registration_id) {
    $allArbitratorsOrg= $this->Mdl_cases->customQuery("select `im`.registration_id, pi.organisation_name from institution_mapping as im
                                                    left join profile_institution as pi on `im`.institution_id = `pi`.institution_id
                                                    where `im`.registration_id = '".$registration_id."' and `im`.`status` = '1' "); 
    
    return  $allArbitratorsOrg;                                      
  }

  function create(){
    $this->adminSession('2');

    $data['scriptFile'] = "create-case";
    $data['viewFile'] = "admin/create";
    $data['module'] = "cases";
    $data['institution'] = $this->Mdl_cases->customQuery("SELECT `p`.`registration_id`,`p`.`organisation_name` FROM profile_institution p join registration r on p.registration_id=r.registration_id where r.status='1' and r.parent='0'");
    $data['currency'] = $this->Mdl_cases->retrieve("currency_master", array('status' => "1"));
    
    echo Modules::run('template/admin', $data);
  }

  function caseStepOne()
  {
    $content = $this->input->post();
    //$data['menu'] = $this->uri->segment(2);
    //$data['submenu'] = $this->uri->segment(3);
    //$user = $this->session->userdata('user');
    $registration_id =  0;
    $user['registration_id'] = 0;
    $docs_data = $this->Mdl_cases->retrieve("profile_institution", array('registration_id' => $registration_id));
    // $data['registration_id'] = $registration_id;

    // $documents =  unserialize($docs_data[0]->documents);
    // if ($documents !== "" && !empty($documents)) {

    //   $data['schedule'] = $documents['schedule'];
    //   $data['schedule_link'] = $documents['schedule_link'];
    // } else {

    //   $data['schedule'] = "";
    //   $data['schedule_link'] = "";
    // }
    if ($this->uri->segment(3)) {

      $uri_segment =  $this->uri->segment(3);
      $case_id = $this->decryptParam($uri_segment);

      

      $data['enc_data'] = $uri_segment;
      $check_case_id = $this->Mdl_cases->isExist("case_registration", array('id' => $case_id ));
      if (!$check_case_id) {
        redirect('cases/list', 'refresh');
      }
      $visits = $this->Mdl_cases->retrieve("case_visits", array("case_id" => $case_id, "registration_id" => $user['registration_id']));
      if ($visits == "NA") {
        $insert_visit = $this->Mdl_cases->insert("case_visits", array("case_id" => $case_id, "registration_id" => $user['registration_id']));
      }
      $data['case_status_tracker'] = $this->Mdl_cases->retrieve("case_status_tracker", array('case_id' => $case_id));
      $data['case_registration'] = $this->Mdl_cases->retrieve("case_registration", array('id' => $case_id));
      $case_details = $this->Mdl_cases->retrieve("case_details", array('case_id' => $case_id));

      $data['institution'] =  $this->Mdl_cases->customQuery("SELECT * FROM case_users left join profile_institution on case_users.registration_id = profile_institution.registration_id WHERE case_id='" . $case_id . "' AND type ='institution' ");
      $data['institutions'] = $this->Mdl_cases->customQuery("SELECT `p`.`registration_id`,`p`.`organisation_name` FROM profile_institution p join registration r on p.registration_id=r.registration_id where r.status='1' and r.parent='0'");


      $data['documents'] = unserialize($case_details[0]->documents);
      // echo "<pre>";print_r($documents); 
      $data['case_details'] = $case_details;
      $data['arbitrator_count'] = $this->Mdl_cases->countRecords("case_users",array("case_id"=>$case_id,"type"=>"arbitrator"));
      // $data['case_documents'] = $this->Mdl_cases->retrieve("case_documents",array('case_id' => $case_id,"name"=>"contract",'status'=>'1'));
      $data['institution_case_status'] = Modules::run("common/getColumn","status","case_users",array("case_id"=>$case_id,"registration_id"=>$registration_id));
      $data['case_status_tracker'] = $this->Mdl_cases->retrieve("case_status_tracker", array('case_id' => $case_id));
      $data['viewFile'] = 'admin/create-case-update';
      $data['scriptFile'] = 'create-case-update';
    } else {
      $data['enc_data'] = "NA";
      $data['case_status_tracker'] = "NA";
      $data['viewFile'] = 'admin/create-case';
      $data['scriptFile'] = 'create-case-update';
    }

    $data['currency'] = $this->Mdl_cases->retrieve("currency_master", array('status' => "1"));
    $data['module'] = "cases";
    echo Modules::run('template/admin', $data);
  }

  public function createCaseAction()
  {
    //echo "<pre>";print_r($_POST);exit;
    //$this->userSession();
    //$user = $this->session->userdata('user');
    $user['registration_id'] = 0;
    $registration_id =  0;//$user['registration_id'];
    $content = $this->input->post();
    $token = $this->session->userdata("token");
    if ($content["csrfToken"] == $token) {

      // Case Details
    
      $this->form_validation->set_rules(
        'case_offline_id',
        'Case Id',
        'trim|xss_clean',
        array(
          "required" => "%s is required"
        )
      );
      $this->form_validation->set_rules(
        'date_of_commencement',
        'date of commencement',
        'trim|xss_clean|required',
        array(
          "required" => "Select Date"
        )
      );
      $this->form_validation->set_rules(
        'isPaid',
        'isPaid',
        'trim|xss_clean|required|in_list[yes,no]',
        array(
          "required" =>  "Choose any one "
        )
      );
  
      if($content['isPaid'] =="yes"){
        $this->form_validation->set_rules(
          'amount_paid',
          'Amount Paid',
          'trim|xss_clean|required',
          array(
            "required" => "%s is required"
          )
        );
      }else{
        $this->form_validation->set_rules(
          'amount_paid',
          'Amount Paid',
          'trim|xss_clean',
          array(
            "required" => "%s is required"
          )
        );
      }
      // $this->form_validation->set_rules(
      //   'case_description',
      //   'Case Description',
      //   'trim|xss_clean|required',
      //   array(
      //     "required" => "%s is required"
      //   )
      // );
      // Arbitration Details
      $this->form_validation->set_rules(
        'arbitration_type',
        'Type of arbitration',
        'trim|xss_clean|required',
        array(
          "required" => "Please select %s"
        )
      );
      $this->form_validation->set_rules(
        'arbitration_number',
        'Number of Arbitration',
        'trim|xss_clean|required',
        array(
          "required" => "Please select %s"
        )
      );
      $this->form_validation->set_rules(
        'seat',
        'Seat',
        'trim|xss_clean',
        array(
          "required" =>  "%s is required"
        )
      );
      $this->form_validation->set_rules('venue','Venue','trim|xss_clean');


      $this->form_validation->set_rules('arbitrator_agreement', 'Arbitrator Agreement', 'callback_validate_file[arbitrator_agreement,notRequired,all]');


      // VALIDATE MULTIPLE IMAGE UPLOAD
      
      foreach ($content['countcheck'] as $i =>$val1) {
        $this->form_validation->set_rules('document' . $i, 'Document', 'callback_validate_file[document' . $i . ',notRequired,all]');
      }

      
      foreach ($content['countcheck_agreement'] as $x =>$val2) {
        $this->form_validation->set_rules('arbitrator_agreement' .$x, 'Document', 'callback_validate_file[arbitrator_agreement' .$x. ',notRequired,all]');
      }


      $this->form_validation->set_rules('currency', 'currency', 'trim|xss_clean');
      $this->form_validation->set_rules('claim_value', 'Claim value', 'trim|xss_clean');
      $this->form_validation->set_rules('counter_claim_value', 'Counter claim value', 'trim|xss_clean');
      $this->form_validation->set_rules('total_claim_value', 'Total claim value', 'trim|xss_clean');
      $this->form_validation->set_rules('administration_fees', 'administration_fees', 'trim|xss_clean');
      $this->form_validation->set_rules('arbitration_fees', 'arbitration_fees', 'trim|xss_clean');
      $this->form_validation->set_rules('miscellaneous_fees', 'miscellaneous_fees', 'trim|xss_clean');
      $this->form_validation->set_rules('out_of_pocket_expences', 'out_of_pocket_expences', 'trim|xss_clean');

      

      $this->form_validation->set_rules(
        'readTerms',
        'Terms of Service',
        'trim|xss_clean|required|in_list[Y,N]',
        array(
          "required" =>  "Agree %s "
        )
      );

      $this->form_validation->set_rules(
        'readPrivacy',
        'Privacy Policies',
        'trim|xss_clean|required|in_list[Y,N]',
        array(
          "required" =>  "Agree %s "
        )
      );
      if ($content['arbitration_number'] > 3) {
        echo json_encode(array("arbitration_number" => "Something went wrong "));
        exit;
      }

      if ($this->form_validation->run($this) == FALSE) {
        $errors = $this->form_validation->error_array();
        echo json_encode($errors);
        exit;
      } else {
        // CREATE UNIQUE SERIAL NO FOR CASE
        $serial = $this->GenerateSerial();
        while ($this->checkifSerialexist($serial)) {
          $serial = $this->GenerateSerial();
        }


        $caseRegistrationData = array(
          "serial_no" => $serial,
          "created_by" => $registration_id,
          "status" => "active",
          "created_at" => date('Y-m-d H:i:s'),
          "modified_at" => date('Y-m-d H:i:s'),
          "modified_by" => $registration_id
        );
        $case_id = $this->Mdl_cases->insert("case_registration", $caseRegistrationData);
        $institution_id = $content["institution"];
        if(!empty($institution_id) &&  $institution_id !=="0"){
          Modules::run("common/insertUserInCase", $case_id, $institution_id, "institution", "");
        }

        //Modules::run("common/insertUserInCase", $case_id, $registration_id, "institution", "");
        // UPLOAD DOCUMENTS


        $base_path = "web_uploads/case_uploads/" . $serial;
        if (!file_exists($base_path)) {
          mkdir($base_path, 0777);
        }
        if ($case_id) {
          $contractDocsArr = [];
         
          foreach ($content['countcheck'] as $j =>$val3) {
            $imgpath_document = "";
            if (isset($_FILES["document" . $j]['name']) && $_FILES["document" . $j]['name'] !== "") {
              $filename_document = $_FILES["document" . $j]['name'];
              $ext_document = pathinfo($filename_document, PATHINFO_EXTENSION);
              $imagename_document = $registration_id . rand() . '-' . 'document' . '-' . strtotime('now');
              $img_document = $this->uploadFile($imagename_document, $base_path, "pdf|png|jpg|jpeg|doc|docx|xls|zip|ods|xlsm|xlsx|ppt|pptx", '5120', '3000', '3000', "document" . $j);
              $imgpath_document = $imagename_document . '.' . $ext_document;
              if ($img_document !== 1) {
                echo json_encode(array("document" . $j => $img_document));
                exit;
              }
            }
            $contractDocsArr[] = $imgpath_document;
          }

          $agreementDocsArr = [];
          foreach ($content['countcheck_agreement'] as $y =>$val3) {
            $imgpath_arbitrator_agreement = "";
            if (isset($_FILES["arbitrator_agreement" . $y]['name']) && $_FILES["arbitrator_agreement" . $y]['name'] !== "") {
              $filename_arbitrator_agreement = $_FILES["arbitrator_agreement" . $y]['name'];
              $ext_arbitrator_agreement = pathinfo($filename_arbitrator_agreement, PATHINFO_EXTENSION);
              $imagename_arbitrator_agreement = $registration_id . rand() . '-' . 'arbitrator_agreement' . '-' . strtotime('now');
              $img_arbitrator_agreement = $this->uploadFile($imagename_arbitrator_agreement, $base_path, "pdf|png|jpg|jpeg|doc|docx|xls|zip|ods|xlsm|xlsx|ppt|pptx", '5120', '3000', '3000', "arbitrator_agreement" . $y);
              $imgpath_arbitrator_agreement = $imagename_arbitrator_agreement . '.' . $ext_arbitrator_agreement;
              if ($img_arbitrator_agreement !== 1) {
                echo json_encode(array("arbitrator_agreement" . $y => $img_arbitrator_agreement));
                exit;
              }
            }
            $agreementDocsArr[] = $imgpath_arbitrator_agreement;
          }

          
          $caseDocsArr = serialize(array(
            "contract" => $contractDocsArr,
            "agreement" => $agreementDocsArr,
            "claimant" => array(),
            "respondant" => array(),
            "arbitrator" => array(),
          ));


          // $case_documents_insert = $this->Mdl_cases->insert("case_documents", $caseDocsArr);
          $caseDetailsData = array(
            "case_id" => $case_id,
            "date_of_commencement" => $content['date_of_commencement'],
            "offline_id" => strip_tags($content['case_offline_id']),
            "isPaid" => strip_tags($content['isPaid']),
            "amount_paid" => strip_tags($content['amount_paid']),
            "claimant_representative" => "institute",
            "respondant_representative" => "institute",
            "description" => strip_tags($content['case_description']),
            "fromInstitute" => "Y",
            "arbitration_type" => strip_tags($content['arbitration_type']),
            "arbitration_number" => strip_tags($content['arbitration_number']),
            "seat" => strip_tags($content['seat']),
            "venue" => strip_tags($content['venue']),
            "currency" => strip_tags($content['currency']),
            "claim_value" => strip_tags($content['claim_value']),
            "counter_claim_value" => strip_tags($content['counter_claim_value']),
            "total_claim_value" => strip_tags($content['total_claim_value']),
            "miscellaneous_fees" => strip_tags($content['miscellaneous_fees']),
            "out_of_pocket_expences" => strip_tags($content['out_of_pocket_expences']),
            
            "arbitration_fees" => strip_tags($content['arbitration_fees']),
            "administration_fees" => strip_tags($content['administration_fees']),
            "documents" => $caseDocsArr,
            "readTerms" => strip_tags($content['readTerms']),
            // "readArbitrator" => strip_tags($content['readArbitrator']),
            // "readCode" => strip_tags($content['readCode']),
            "readPrivacy" => strip_tags($content['readPrivacy']),
            "created_at" => date('Y-m-d H:i:s'),
            "modified_at" => date('Y-m-d H:i:s'),
            "status" => "1",
          );


          $case_details_insert = $this->Mdl_cases->insert("case_details", $caseDetailsData);

          

          // CASE TRACKER INSERT
          $tracker_data = array(
            "case_id" => $case_id,
            "step1" => "Y",
            "step" => "step1",
            "created_at" => date('Y-m-d H:i:s'),
            "modified_at" => date('Y-m-d H:i:s'),
          );
          // STATUS MANAGE
          $case_tracker_insert = $this->Mdl_cases->insert("case_status_tracker", $tracker_data);
         
     
          $payload = $this->encryptParam($case_id);
          echo json_encode(array("status" => "success", "title" => "Success", "icon" => "success", "message" => "Case has been created Successfully.", "redirect" => "cases/caseStepTwo/" . $payload));
          exit;
        } else {
          echo json_encode(array("status" => "alert", "title" => "Oops! something went wrong", "icon" => "error", "message" => "Please reload & try again."));
          exit;
        }
      }
    } else {
      echo json_encode(array("status" => "alert", "title" => "Oops! an Error occured", "icon" => "error", "message" => "Your session has expired. Please reload & try again."));
      exit;
    }
  }
  
  function GenerateSerial()
  {
    $result =  $this->Mdl_cases->customQuery("SELECT serial_no   FROM case_registration order by id desc");
    if ($result == "NA") {
      $series_no = "ADRAAS0001";
    } else {
      $last_case_no = $result[0]->serial_no;
      $number_string = ltrim($last_case_no, "ADRAAS");
      $next_number_string = $number_string + 1;
      $invID = str_pad($next_number_string, strlen($number_string), '0', STR_PAD_LEFT);
      $series_no = "ADRAAS" . $invID;
    }
    return $series_no;
  }
  function checkifSerialexist($serial)
  {
    $result =  $this->Mdl_cases->retrieveByCol("serial_no", "case_registration", array('serial_no' => $serial));
    if ($result !== "NA") {
      return true;
    } else {
      return false;
    }
  }
  
  function caseStepTwo()
  {
    //$this->userSession();
    //$data['menu'] = $this->uri->segment(2);
    //$data['submenu'] = $this->uri->segment(3);
    $uri_segment =  $this->uri->segment(3);
    //$user = $this->session->userdata('user');
    $registration_id =  0;

    $case_id = $this->decryptParam($uri_segment);
    $check_case_id = $this->Mdl_cases->isExist("case_registration", array('id' => $case_id));
    if (!$check_case_id) {
      redirect('cases/list', 'refresh');
    }

    

    $data['case_status_tracker'] = $this->Mdl_cases->retrieve("case_status_tracker", array('case_id' => $case_id));
    $data['enc_data'] = $uri_segment;
    //  Case Info
    $case_registration =  $this->Mdl_cases->retrieve("case_registration", array('id' => $case_id));

    $claimant =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='" . $case_id . "' AND party='claimant' and type ='user' ");


    $data['c_additional_info'] = Modules::run("common/getColumn","c_additional_info","case_details",array("case_id"=>$case_id));
    // Get Claimant Data
    if ($claimant !== "NA" && !empty($claimant)) {
      $claimant_id = $claimant[0]->registration_id;
      $claimant_profile =  $this->Mdl_cases->retrieve("profile_user", array('registration_id' => $claimant_id));
      $data["claimant_name"] = $claimant_profile[0]->name;
      $data['claimant_phone'] =  $claimant_profile[0]->mobile;
      $data['claimant_email'] =  $claimant_profile[0]->email;
      $data['claimant_address'] =  $claimant_profile[0]->address;
    } else {
      $data["claimant_name"] = "";
      $data['claimant_phone'] =  "";
      $data['claimant_email'] =  "";
      $data['claimant_address'] =  "";
    }

    $persons =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='" . $case_id . "' AND party='claimant' and type !='user' ");
    $data['authorized_persons'] = $this->getAuthorizedPersons($persons);
    $data['institution_case_status'] = Modules::run("common/getColumn","status","case_users",array("case_id"=>$case_id,"registration_id"=>$registration_id));
    $data['viewFile'] = 'admin/create-claimant';
    $data['scriptFile'] = 'create-claimant';
    $data['module'] = "cases";
    $data['person'] = $persons;
    echo Modules::run('template/admin', $data);
  }

  public function createCaseStepTwoAction()
  {

    //$this->userSession();
    //$user = $this->session->userdata('user');
    $user['registration_id'] = 0;
    $registration_id =  0;//$user['registration_id'];
    $content = $this->input->post();
    $case_id = $this->decryptParam($content['enc_data']);
    $token = $this->session->userdata("token");
    
    if ($content["csrfToken"] == $token) {

      // Claimant Details Validation
      $this->form_validation->set_rules(
        'claimant_email',
        'Claimant E-mail Id',
        'trim|xss_clean|valid_email|required',
        array(
          "required" => "%s is required",
          "valid_email" => "Please enter valid email address",
        )
      );
      $this->form_validation->set_rules(
        'claimant_name',
        'Claimant Name',
        'trim|xss_clean|required',
        array(
          "required" => "%s is required"
        )
      );
      $this->form_validation->set_rules(
        'claimant_phone',
        'Claimant Mobile',
        'trim|xss_clean|exact_length[10]|numeric',
        array(
          "required" => "%s is required",
          "numeric" => "Please enter valid mobile number",
          "exact_length" => "Please enter valid mobile number",
        )
      );
      $this->form_validation->set_rules(
        'claimant_address',
        'Claimant Address',
        'trim|xss_clean',
        array(
          "required" => "%s is required"
        )
      );

      // Authorized Person Details Validation
      $countPersonEmail = count($content['person_email']);
      for ($i = 0; $i < $countPersonEmail; $i++) {
        $this->form_validation->set_rules(
          'person_email[' . $i . ']',
          'person E-mail Id',
          'trim|xss_clean|valid_email',
          array(
            "required" => "%s is required",
            "valid_email" => "Please enter valid email address",
          )
        );
        if ($content['person_email'][$i] !== "" && !empty($content['person_email'][$i])) {
          $this->form_validation->set_rules(
            'type[' . $i . ']',
            'Type',
            'trim|xss_clean|required',
            array(
              "required" => "Select authorized person type"
            )
          );
          $this->form_validation->set_rules(
            'person_name[' . $i . ']',
            'Full name',
            'trim|xss_clean|required',
            array(
              "required" => "%s is required"
            )
          );
          $this->form_validation->set_rules(
            'person_phone[' . $i . ']',
            ' Mobile number',
            'trim|xss_clean|exact_length[10]|numeric',
            array(
              "required" => "%s is required",
              "numeric" => "Please enter valid mobile number",
              "exact_length" => "Please enter valid mobile number",
            )
          );
          $this->form_validation->set_rules(
            'person_address[' . $i . ']',
            'Address',
            'trim|xss_clean',
            array(
              "required" => "%s is required"
            )
          );
        }
      }
      $this->form_validation->set_rules(
        'c_additional_info',
        'Additional Info',
        'trim|xss_clean',
        array(
          "required" => "%s is required"
        )
      );
      if ($this->form_validation->run($this) == FALSE) {
        $errors = $this->form_validation->error_array();
        echo json_encode($errors);
        exit;
      } else {
        // Claimant details check and  insert as new user
        $claimantExist =  $this->Mdl_cases->isExist("registration", array("email" => trim($content['claimant_email'])));
        if ($claimantExist) {
          $claimant = $this->Mdl_cases->retrieve("registration", array("email" => trim($content['claimant_email'])));
          if ($claimant[0]->type == "user") {
            $claimant_id = $claimant[0]->registration_id;
          } else {
            echo json_encode(array("status" => "error", "title" => "wrong e-mail id", "icon" => "warning", "message" => "Entered Email id is registered as {$claimant[0]->type}. Please enter another one"));
            exit;
          }
        } else {
          $claimant_account_data =  array(
            "type" => "user",
            "email" => strip_tags($content['claimant_email']),
            "name" => strip_tags($content['claimant_name']),
            "mobile" => strip_tags($content['claimant_phone']),
            "address" => strip_tags($content['claimant_address']),
          );
          // CREATE CLAIMANT ACCOUNT                              
          $claimant_id = Modules::run("common/createNewAccount", $claimant_account_data);
        }
            
          
        for ($j = 0; $j < $countPersonEmail; $j++) {

          if ($content['person_email'][$j] !== "" && !empty($content['person_email'][$j])) {

            // person details check and  insert as new person
            $personExist =  $this->Mdl_cases->isExist("registration", array("email" => trim($content['person_email'][$j])));
            if ($personExist) {
              $person = $this->Mdl_cases->retrieve("registration", array("email" => trim($content['person_email'][$j])));
             
              if ($person[0]->type == "user") {
                $person_id = $person[0]->registration_id;
              } else {
                echo json_encode(array("status" => "error", "title" => "wrong e-mail id", "icon" => "warning", "message" => "Given Email id is registered as {$person[0]->type}. Please Select correct authorized person type"));
                exit;
              }
            } else {

              $person_account_data =  array(
                "type" => $content['type'][$j],
                "email" => strip_tags($content['person_email'][$j]),
                "name" => strip_tags($content['person_name'][$j]),
                "mobile" => strip_tags($content['person_phone'][$j]),
                "address" => strip_tags($content['person_address'][$j]),
              );
              // CREATE AUTHORIZED PERSONS ACCOUNT                              
              $person_id =   Modules::run("common/createNewAccount", $person_account_data);
            }

           
            $isPersonExistInCase = $this->Mdl_cases->isExist("case_users",array("registration_id"=>$person_id,"case_id"=>$case_id));
            if($isPersonExistInCase !==TRUE){
              Modules::run("common/insertNotification",$case_id,$person_id,$registration_id, "Institution has assigned you as claimant ".$content['type'][$j],"caseStepOne");
            }
            Modules::run("common/insertUserInCase", $case_id, $person_id, $content['type'][$j], "claimant");
            
          }
        }

        $isClaimantExistInCase = $this->Mdl_cases->isExist("case_users",array("registration_id"=>$claimant_id,"case_id"=>$case_id));
        if($isClaimantExistInCase !==TRUE){
          Modules::run("common/insertNotification",$case_id,$claimant_id,$registration_id, "Your are assigned as claimant. ","caseStepOne");
        }
        Modules::run("common/insertUserInCase", $case_id, $claimant_id, "user", "claimant");

        // Update Case status Tracker
        $this->Mdl_cases->update("case_status_tracker", array("case_id" => $case_id), array("step2" => "Y", "step" => "step2", "modified_at" => date('Y-m-d H:i:s')));
        // UPDATE ADDITIONAL INFO CLAIMANT
        $this->Mdl_cases->update("case_details", array("case_id" => $case_id), array("c_additional_info" => strip_tags($content['c_additional_info']), "modified_at" => date('Y-m-d H:i:s')));


        echo json_encode(array("status" => "success", "title" => "Success", "icon" => "success", "message" => "Claimants details has been Successfully updated.", "redirect" => "cases/caseStepThree/" . $content['enc_data']));
        exit;
      }
    } else {
      echo json_encode(array("status" => "alert", "title" => "Oops! an Error occured", "icon" => "error", "message" => "Your session has expired. Please reload & try again."));
      exit;
    }
  }

  /**
   *  Dashboard Page - Create Cases step 3 Tab
   */
  function caseStepThree()
  {
    //$this->userSession();
    
    //$data['menu'] = $this->uri->segment(2);
    //$data['submenu'] = $this->uri->segment(3);
    $uri_segment =  $this->uri->segment(3);
    
    //$user = $this->session->userdata('user');
    $user['registration_id'] = 0;
    $registration_id =  0;//$user['registration_id'];

    $case_id = $this->decryptParam($uri_segment);
    $check_case_id = $this->Mdl_cases->isExist("case_registration", array('id' =>  $case_id));
    if (!$check_case_id) {
      redirect('cases/list', 'refresh');
    }

    // if($user['isAccess']){
    //     $access_details =  $this->Mdl_cases->retrieve("account_access", array('case_id' => $case_id,"access_id"=>$user['registration_id']));
    //     if($access_details !=="NA"){
    //       $registration_id =  $access_details[0]->registration_id;
    //     }else{
    //        redirect('cases/list', 'refresh');
    //     }
    //   }
    $data['case_status_tracker'] = $this->Mdl_cases->retrieve("case_status_tracker", array('case_id' =>  $case_id));
    $data['enc_data'] = $uri_segment;
    //  Case Info
    $case_registration =  $this->Mdl_cases->retrieve("case_registration", array('id' =>  $case_id));
    $respondant =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='" .  $case_id . "' AND party='respondant' and type ='user' ");


    $data['r_additional_info'] = Modules::run("common/getColumn","r_additional_info","case_details",array("case_id"=>$case_id));
    // Get Respondant Data
    if ($respondant !== "NA" && !empty($respondant)) {
      $respondant_id = $respondant[0]->registration_id;
      $respondant_profile =  $this->Mdl_cases->retrieve("profile_user", array('registration_id' => $respondant_id));
      $data["respondant_name"] = $respondant_profile[0]->name;
      $data['respondant_phone'] =  $respondant_profile[0]->mobile;
      $data['respondant_email'] =  $respondant_profile[0]->email;
      $data['respondant_address'] =  $respondant_profile[0]->address;
    } else {
      $data["respondant_name"] = "";
      $data['respondant_phone'] =  "";
      $data['respondant_email'] =  "";
      $data['respondant_address'] =  "";
    }
    $persons =  $this->Mdl_cases->customQuery("SELECT * FROM case_users WHERE case_id='" .  $case_id . "' AND party='respondant' and type !='user' ");
    $data['authorized_persons'] = $this->getAuthorizedPersons($persons);
    $data['institution_case_status'] = Modules::run("common/getColumn","status","case_users",array("case_id"=>$case_id,"registration_id"=>$registration_id));
   
    $data['viewFile'] = 'admin/create-respondant';
    $data['scriptFile'] = 'create-respondant';
    $data['module'] = "cases";
    echo Modules::run('template/admin', $data);
  }

   function caseStepFour()
  {
    //$this->userSession();
    //$data['menu'] = $this->uri->segment(2);
    //$data['submenu'] = $this->uri->segment(3);
    $uri_segment =  $this->uri->segment(3);

   // $user = $this->session->userdata('user');
   $user['registration_id'] = 0;
    $registration_id =  0;//$user['registration_id'];

    $case_id = $this->decryptParam($uri_segment);
    $check_case_id = $this->Mdl_cases->isExist("case_registration", array('id' => $case_id));
    if (!$check_case_id) {
      redirect('cases/list', 'refresh');
    }
    // if($user['isAccess']){
    //   $access_details =  $this->Mdl_cases->retrieve("account_access", array('case_id' => $case_id,"access_id"=>$user['registration_id']));
    //   if($access_details !=="NA"){
    //     $registration_id =  $access_details[0]->registration_id;
    //   }else{
    //      redirect('cases/list', 'refresh');
    //   }
    // }
    $data['enc_data'] = $uri_segment;
   
    //$data['arbitrators'] = $this->Mdl_cases->customQuery("SELECT p.* from profile_arbitrator p JOIN institution_mapping m on p.registration_id  = m.registration_id where m.institution_id = '$registration_id' and m.status ='1'");
    $data['arbitrators'] = $this->Mdl_cases->customQuery("SELECT * from profile_arbitrator ");
    $data['case_status_tracker'] = $this->Mdl_cases->retrieve("case_status_tracker", array('case_id' => $case_id));
    $data['enc_data'] = $uri_segment;
    // SELECTED ARBITRATORS
    $case_arbitrators =  $this->Mdl_cases->retrieve("case_users", array('case_id' => $case_id,"type"=>"arbitrator","status"=>"1"));
    //print_r($case_arbitrators);exit;
    $data['case_arbitrators'] = $case_arbitrators;
    $selected_arbitrators = array();
    if($case_arbitrators !=="NA"){
      foreach($case_arbitrators as $arbitrator){
        $selected_arbitrators[] = $arbitrator->registration_id; 
      }
    }
    $data['institution_case_status'] = Modules::run("common/getColumn","status","case_users",array("case_id"=>$case_id,"registration_id"=>$registration_id));
    $data['selected_arbitrators'] =  $selected_arbitrators;
    $data['viewFile'] = 'admin/select-arbitrator';
    $data['scriptFile'] = 'select-arbitrator';
    $data['module'] = "cases";
    echo Modules::run('template/admin', $data);
  }

  public function createCaseStepThreeAction()
  {

    //$this->userSession();
    //$user = $this->session->userdata('user');
    $registration_id =  0;//$user['registration_id'];
    $content = $this->input->post();
    $case_id = $this->decryptParam($content['enc_data']);
    $token = $this->session->userdata("token");
   
    if ($content["csrfToken"] == $token) {

     
      // Claimant Details Validation
      $this->form_validation->set_rules(
        'respondant_email',
        'Respondant E-mail Id',
        'trim|xss_clean|valid_email|required',
        array(
          "required" => "%s is required",
          "valid_email" => "Please enter valid email address",
        )
      );
      $this->form_validation->set_rules(
        'respondant_name',
        'Respondant Name',
        'trim|xss_clean|required',
        array(
          "required" => "%s is required"
        )
      );
      $this->form_validation->set_rules(
        'respondant_phone',
        'Respondant Mobile',
        'trim|xss_clean|exact_length[10]|numeric',
        array(
          "required" => "%s is required",
          "numeric" => "Please enter valid mobile number",
          "exact_length" => "Please enter valid mobile number",
        )
      );
      $this->form_validation->set_rules(
        'respondant_address',
        'Respondant Address',
        'trim|xss_clean',
        array(
          "required" => "%s is required"
        )
      );

      // Authorized Person Details Validation
      $countPersonEmail = count($content['person_email']);
      for ($i = 0; $i < $countPersonEmail; $i++) {
        $this->form_validation->set_rules(
          'person_email[' . $i . ']',
          'person E-mail Id',
          'trim|xss_clean|valid_email',
          array(
            "required" => "%s is required",
            "valid_email" => "Please enter valid email address",
          )
        );
        if ($content['person_email'][$i] !== "" && !empty($content['person_email'][$i])) {
          $this->form_validation->set_rules(
            'type[' . $i . ']',
            'Type',
            'trim|xss_clean|required',
            array(
              "required" => "Select authorized person type"
            )
          );
          $this->form_validation->set_rules(
            'person_name[' . $i . ']',
            'Full name',
            'trim|xss_clean|required',
            array(
              "required" => "%s is required"
            )
          );
          $this->form_validation->set_rules(
            'person_phone[' . $i . ']',
            ' Mobile number',
            'trim|xss_clean|exact_length[10]|numeric',
            array(
              "required" => "%s is required",
              "numeric" => "Please enter valid mobile number",
              "exact_length" => "Please enter valid mobile number",
            )
          );
          $this->form_validation->set_rules(
            'person_address[' . $i . ']',
            'Address',
            'trim|xss_clean',
            array(
              "required" => "%s is required"
            )
          );
        }
      }

      $this->form_validation->set_rules(
        'r_additional_info',
        'Additional Info',
        'trim|xss_clean',
        array(
          "required" => "%s is required"
        )
      );

      if ($this->form_validation->run($this) == FALSE) {
        $errors = $this->form_validation->error_array();
        echo json_encode($errors);
        exit;
      } else {
        // Claimant details check and  insert as new user
        $respondantExist =  $this->Mdl_cases->isExist("registration", array("email" => trim($content['respondant_email'])));
        if ($respondantExist) {
          $respondant = $this->Mdl_cases->retrieve("registration", array("email" => trim($content['respondant_email'])));
          if ($respondant[0]->type == "user") {
            $respondant_id = $respondant[0]->registration_id;
          } else {
            echo json_encode(array("status" => "error", "title" => "wrong e-mail id", "icon" => "warning", "message" => "Entered Email id is registered as {$respondant[0]->type}. Please enter another one"));
            exit;
          }
        } else {
          $respondant_account_data =  array(
            "type" => "user",
            "email" => strip_tags($content['respondant_email']),
            "name" => strip_tags($content['respondant_name']),
            "mobile" => strip_tags($content['respondant_phone']),
            "address" => strip_tags($content['respondant_address']),
          );
          // CREATE CLAIMANT ACCOUNT                              
          $respondant_id = Modules::run("common/createNewAccount", $respondant_account_data);
        }

        

        for ($j = 0; $j < $countPersonEmail; $j++) {

          if ($content['person_email'][$j] !== "" && !empty($content['person_email'][$j])) {

            // person details check and  insert as new person
            $personExist =  $this->Mdl_cases->isExist("registration", array("email" => trim($content['person_email'][$j])));
            if ($personExist) {
              $person = $this->Mdl_cases->retrieve("registration", array("email" => trim($content['person_email'][$j])));
              if ($person[0]->type == "user") {
                $person_id = $person[0]->registration_id;
              } else {
                echo json_encode(array("status" => "error", "title" => "wrong e-mail id", "icon" => "warning", "message" => "Given Email id is registered as {$person[0]->type}. Please Select correct authorized person type"));
                exit;
              }
            } else {

              $person_account_data =  array(
                "type" => $content['type'][$j],
                "email" => strip_tags($content['person_email'][$j]),
                "name" => strip_tags($content['person_name'][$j]),
                "mobile" => strip_tags($content['person_phone'][$j]),
                "address" => strip_tags($content['person_address'][$j]),
              );
              // CREATE AUTHORIZED PERSONS ACCOUNT                              
              $person_id =   Modules::run("common/createNewAccount", $person_account_data);
            }

            
            $isPersonExistInCase = $this->Mdl_cases->isExist("case_users",array("registration_id"=>$person_id,"case_id"=>$case_id));
            if($isPersonExistInCase !==TRUE){
              Modules::run("common/insertNotification",$case_id,$person_id,$registration_id, "Institution has assigned you as respondent ".$content['type'][$j],"caseStepOne");
            }
            Modules::run("common/insertUserInCase", $case_id, $person_id, $content['type'][$j], "respondant");
          }
        }
       
        $isRespondentExistInCase = $this->Mdl_cases->isExist("case_users",array("registration_id"=>$respondant_id,"case_id"=>$case_id));
        if($isRespondentExistInCase !==TRUE){
          Modules::run("common/insertNotification",$case_id,$respondant_id,$registration_id, "Your are assigned as respondent. ","caseStepOne");
        }
        Modules::run("common/insertUserInCase", $case_id, $respondant_id, "user", "respondant");

        // Update Case status Tracker
        $this->Mdl_cases->update("case_status_tracker", array("case_id" => $case_id), array("step3" => "Y", "step" => "step3", "modified_at" => date('Y-m-d H:i:s')));

        // UPDATE ADDITIONAL INFO RESPONDENT
        $this->Mdl_cases->update("case_details", array("case_id" => $case_id), array("r_additional_info" => strip_tags($content['r_additional_info']), "modified_at" => date('Y-m-d H:i:s')));

        echo json_encode(array("status" => "success", "title" => "Success", "icon" => "success", "message" => "Respondent details has been Successfully updated.", "redirect" => "cases/caseStepFour/" . $content['enc_data']));
        exit;
      }
    } else {
      echo json_encode(array("status" => "alert", "title" => "Oops! an Error occured", "icon" => "error", "message" => "Your session has expired. Please reload & try again."));
      exit;
    }
  }

  public function selectArbitratorAction()
  {
    //$this->userSession();
    //$user = $this->session->userdata('user');
    $user['registration_id'] = 0;
    $registration_id =  0;//$user['registration_id'];
    $content = $this->input->post();
    $token = $this->session->userdata("token");
    $case_id = $this->decryptParam($content['enc_data']);
    
    if ($content["csrfToken"] == $token) {
      
      $this->form_validation->set_rules(
        'arbitrator[]',
        'Arbitrator',
        'trim|xss_clean|required',
        array(
          "required" => "Select Arbitrator",

        )
      );

      if ($this->form_validation->run($this) == FALSE) {
        $errors = $this->form_validation->error_array();
        echo json_encode($errors);
        exit;
      } else {
        //  Delete previous Arbitrators
      
        $this->Mdl_cases->delete("case_arbitrator_selection", array("case_id"=>$case_id ));
        $this->Mdl_cases->delete("case_users", array("case_id" => $case_id, "type" => "arbitrator"));
        $arbitrators = $content['arbitrator'];
        if (count($arbitrators) > 3) {
          echo  json_encode(array("arbitrator[]" => "Select less than three arbitrators"));
          exit;
        }
        $this->Mdl_cases->delete("case_users", array("case_id" => $case_id, "type" => "arbitrator"));
        foreach ($arbitrators as $arbitrator) {
         
          Modules::run("common/insertUserInCase", $case_id, $arbitrator, "arbitrator", "","0");
        //  $this->Mdl_cases->update("case_users",array("case_id"=>$case_id,"registration_id"=>$arbitrator),array("status"=>"0"));
          $profile_arbitrator = $this->Mdl_cases->retrieve("profile_arbitrator", array("registration_id" => $arbitrator));
          $name =  $profile_arbitrator[0]->name;
          $email =  $profile_arbitrator[0]->email;

         // CREATE CASE ACCEPT / DENY LINK
          $accept_param = $this->encryptParam($arbitrator."|".$case_id."|1");
          $deny_param = $this->encryptParam($arbitrator."|".$case_id."|0");
          $assistant_accept_link = base_url() . "arbitrator/acceptOrDenyCase/" . $accept_param;
          $assistant_deny_link = base_url() . "arbitrator/acceptOrDenyCase/" . $deny_param;
         
          $info_link = base_url() . "arbitrator/casedetails/" . $this->encryptParam($case_id);
          // SEND MAIL
          $institution_name  = Modules::run("common/getUserName",$registration_id);
          $case_serial  = Modules::run("common/getCaseId",$case_id);
          $assistantMailData = array(
            'view_file' => 'arbitrator-case=accept-deny',
            'to' => $email,
            'cc' => 'santosh@kwebmaker.com',
            'bcc' => '',
            'subject' => 'Adraas - Case Accept Deny',
            "name" => $name,
            "accept_link" => $assistant_accept_link,
            "deny_link" => $assistant_deny_link,
            "info_link" => $info_link,
            "institution_name" =>$institution_name,
            "case_serial" =>$case_serial,

          );
          Modules::run('email/mailer', $assistantMailData);
          Modules::run("common/insertNotification",$case_id,$arbitrator,$registration_id, "Arbitration request from institution","caseStepFour");
        }
      
        // Update Case status Tracker

        $this->Mdl_cases->update("case_status_tracker", array("case_id" => $case_id), array("step4" => "Y", "step" => "step4", "modified_at" => date('Y-m-d H:i:s')));
       
        echo json_encode(array("status" => "success", "title" => "Success", "icon" => "success", "message" => "Arbitrator has been successfully appointed for case.", "redirect" => "cases/list/"));
        exit;
      }
    } else {
      echo json_encode(array("status" => "alert", "title" => "Oops! an Error occured", "icon" => "error", "message" => "Your session has expired. Please reload & try again."));
      exit;
    }
  }

  public function getAuthorizedPersons($persons)
  {
    $html = "";
 
    if ($persons !== "NA") {
      foreach ($persons as $person) {
        $registration = $this->Mdl_cases->retrieve("registration", array('registration_id' => "$person->registration_id"));
        $details = $this->Mdl_cases->retrieve("profile_user", array('registration_id' => "$person->registration_id"));

        $html .= '<div class="row " id="row'.$person->id.'">
       <div class="col-md-6 form-group">
           <label>Authorized Person</label>
           <input type="text" class="form-control" value="' . ucfirst($person->type) . '" readonly>
       </div>
       <div class="col-md-6 form-group d-flex align-items-center">
           <div class="addButton removePerson">
               <a class="pointer"><img src="' . $this->global_variables['web_assets'] . 'images/icons/minusicon.png" data-id="'.$person->id.'"  alt="icon" class="mr-3 remove-caseuser" />Remove</a>
           </div>
       </div>
       <div class="col-md-6 form-group">
           <label>Email</label>
           <input type="text" class="form-control" value="' . $registration[0]->email . '"  placeholder="Email" readonly>
       </div>
       <div class="col-md-6 form-group">
           <label>Full Name</label>
           <input type="text" class="form-control" value="' . $details[0]->name . '"  placeholder="Full Name" readonly>
       </div>
       <div class="col-md-6 form-group">
           <label>Mobile</label>
           <input type="text" class="form-control numeric"  value="' . $details[0]->mobile . '" placeholder="Mobile Number" readonly>
       </div>
       <div class="col-md-6 form-group">
           <label>Address</label>
           <input type="text" class="form-control" value="' . $details[0]->address . '" placeholder="Address" readonly>
       </div>
       <div class="col-12">
         <div class="border mb-3"></div>
       </div>
     </div>';
      }
    }

    return $html;
  }

  public function updateCaseAction()
  {

    // $this->userSession();
    //$user = $this->session->userdata('user');
    $registration_id =  0;
    $content = $this->input->post();
    $token = $this->session->userdata("token");
    // if($content["csrfToken"] == $token){

    $case_id = $this->decryptParam($content['enc_data']);
    

    $this->form_validation->set_rules(
      'case_offline_id',
      'Case Id',
      'trim|xss_clean',
      array(
        "required" => "%s is required"
      )
    );
    $this->form_validation->set_rules(
        'date_of_commencement',
        'date of commencement',
        'trim|xss_clean|required',
        array(
          "required" => "Select Date"
        )
    );
    $this->form_validation->set_rules(
      'isPaid',
      'isPaid',
      'trim|xss_clean|required|in_list[yes,no]',
      array(
        "required" =>  "Choose any one "
      )
    );

    if($content['isPaid'] =="yes"){
      $this->form_validation->set_rules(
        'amount_paid',
        'Amount Paid',
        'trim|xss_clean|required',
        array(
          "required" => "%s is required"
        )
      );
    }else{
      $this->form_validation->set_rules(
        'amount_paid',
        'Amount Paid',
        'trim|xss_clean',
        array(
          "required" => "%s is required"
        )
      );
    }
    $this->form_validation->set_rules('venue','Venue','trim|xss_clean');

    // Case Description

    // $this->form_validation->set_rules(
    //   'case_description',
    //   'Case Description',
    //   'trim|xss_clean|required',
    //   array(
    //     "required" => "%s is required"
    //   )
    // );
    // Arbitration Details
    $this->form_validation->set_rules(
      'arbitration_type',
      'Type of arbitration',
      'trim|xss_clean|required',
      array(
        "required" => "Please select %s"
      )
    );
    $this->form_validation->set_rules(
      'arbitration_number',
      'Number of Arbitration',
      'trim|xss_clean|required',
      array(
        "required" => "Please select %s"
      )
    );
    $this->form_validation->set_rules(
      'seat',
      'Seat',
      'trim|xss_clean',
      array(
        "required" =>  "%s is required"
      )
    );
    // $this->form_validation->set_rules('expedite_procedure','Expedite Procedure','trim|xss_clean|required',
    // array(
    //   "required" =>  "%s is required"
    // ));


    $this->form_validation->set_rules('arbitrator_agreement', 'Arbitrator Agreement', 'callback_validate_file[arbitrator_agreement,notRequired,all]');
    // VALIDATE MULTIPLE IMAGE UPLOAD
    
    foreach ($content['countcheck'] as $i =>$val1) {
      $this->form_validation->set_rules('document' . $i, 'Document', 'callback_validate_file[document' . $i . ',notRequired,all]');
    }

    
    foreach ($content['countcheck_agreement'] as $x =>$val2) {
      $this->form_validation->set_rules('arbitrator_agreement' .$x, 'Document', 'callback_validate_file[arbitrator_agreement' .$x. ',notRequired,all]');
    }



    $this->form_validation->set_rules('currency', 'currency', 'trim|xss_clean');
    $this->form_validation->set_rules('claim_value', 'Claim value', 'trim|xss_clean');
    $this->form_validation->set_rules('counter_claim_value', 'Counter claim value', 'trim|xss_clean');
    $this->form_validation->set_rules('total_claim_value', 'Total claim value', 'trim|xss_clean');
    $this->form_validation->set_rules('administration_fees', 'administration_fees', 'trim|xss_clean');
    $this->form_validation->set_rules('arbitration_fees', 'arbitration_fees', 'trim|xss_clean');
    $this->form_validation->set_rules('miscellaneous_fees', 'miscellaneous_fees', 'trim|xss_clean');
    $this->form_validation->set_rules('out_of_pocket_expences', 'out_of_pocket_expences', 'trim|xss_clean');
    

    $this->form_validation->set_rules(
      'readTerms',
      'Terms of Service',
      'trim|xss_clean|required|in_list[Y,N]',
      array(
        "required" =>  "Agree %s "
      )
    );
    $this->form_validation->set_rules(
      'readPrivacy',
      'Privacy Policies',
      'trim|xss_clean|required|in_list[Y,N]',
      array(
        "required" =>  "Agree %s "
      )
    );
    if ($content['arbitration_number'] > 3) {
      echo json_encode(array("arbitration_number" => "Something went wrong "));
      exit;
    }
    if ($this->form_validation->run($this) == FALSE) {
      $errors = $this->form_validation->error_array();
      echo json_encode($errors);
      exit;
    } else {

      $serial = $this->Mdl_cases->retrieveByCol("serial_no", "case_registration", array("id" => $case_id));
      // UPLOAD DOCUMENTS
      // print_r($serial);
      $base_path = "web_uploads/case_uploads/" . $serial[0]->serial_no;
      if (!file_exists($base_path)) {
        mkdir($base_path, 0777);
      }
      if ($case_id) {
        
        $case_details = $this->Mdl_cases->retrieve("case_details", array("case_id" => $case_id));
        $documents = unserialize($case_details[0]->documents);
        
        if (isset($documents['contract'])) {
          $contractDocsArr = $documents['contract'];
        } else {
          $contractDocsArr = array();
        }
        if (isset($documents['agreement'])) {
          if($documents['agreement'] ==""){
            $agreementDocsArr = array();
          }else{
            $agreementDocsArr = $documents['agreement'];
          }
         
        } else {
          $agreementDocsArr = array();
        }
  
        foreach ($content['countcheck'] as $j =>$val3) {
          $imgpath_document = "";
          if (isset($_FILES["document" . $j]['name']) && $_FILES["document" . $j]['name'] !== "") {
            $filename_document = $_FILES["document" . $j]['name'];
            $ext_document = pathinfo($filename_document, PATHINFO_EXTENSION);
            $imagename_document = $registration_id . rand() . '-' . 'document' . '-' . strtotime('now');
            $img_document = $this->uploadFile($imagename_document, $base_path, "pdf|png|jpg|jpeg|doc|docx|xls|zip|ods|xlsm|xlsx|ppt|pptx", '5120', '3000', '3000', "document" . $j);
            $imgpath_document = $imagename_document . '.' . $ext_document;
            if ($img_document !== 1) {
              echo json_encode(array("document" . $j => $img_document));
              exit;
            }
          }
          if ($imgpath_document != "" && !empty($imgpath_document)) {
            $contractDocsArr[] = $imgpath_document;
          }
        }

       
          foreach ($content['countcheck_agreement'] as $y =>$val3) {
            $imgpath_arbitrator_agreement = "";
            if (isset($_FILES["arbitrator_agreement" . $y]['name']) && $_FILES["arbitrator_agreement" . $y]['name'] !== "") {
              $filename_arbitrator_agreement = $_FILES["arbitrator_agreement" . $y]['name'];
              $ext_arbitrator_agreement = pathinfo($filename_arbitrator_agreement, PATHINFO_EXTENSION);
              $imagename_arbitrator_agreement = $registration_id . rand() . '-' . 'arbitrator_agreement' . '-' . strtotime('now');
              $img_arbitrator_agreement = $this->uploadFile($imagename_arbitrator_agreement, $base_path, "pdf|png|jpg|jpeg|doc|docx|xls|zip|ods|xlsm|xlsx|ppt|pptx", '5120', '3000', '3000', "arbitrator_agreement" . $y);
              $imgpath_arbitrator_agreement = $imagename_arbitrator_agreement . '.' . $ext_arbitrator_agreement;
              if ($img_arbitrator_agreement !== 1) {
                echo json_encode(array("arbitrator_agreement" . $y => $img_arbitrator_agreement));
                exit;
              }
            }
            if ($imgpath_arbitrator_agreement != "" && !empty($imgpath_arbitrator_agreement)) {
              $agreementDocsArr[] = $imgpath_arbitrator_agreement;
            }
          }

        
        // UPDATE CONTRACT AND AGREEMENT DOCUMENTS IN DOCUMENTS ARRAY
        $documents['contract'] = $contractDocsArr;
        $documents['agreement'] = $agreementDocsArr;

        $caseDetailsData = array(

          "offline_id" => strip_tags($content['case_offline_id']),
          "isPaid" => strip_tags($content['isPaid']),
          "amount_paid" => strip_tags($content['amount_paid']),
          "description" => strip_tags($content['case_description']),
          "fromInstitute" => "Y",
          "arbitration_type" => strip_tags($content['arbitration_type']),
          "arbitration_number" => strip_tags($content['arbitration_number']),
          "seat" => strip_tags($content['seat']),
          "venue" => strip_tags($content['venue']),
          //"expedite_procedure"=>strip_tags($content['expedite_procedure']),
          "arbitrator_agreement" => $imgpath_arbitrator_agreement,
          //"isNoAgreement"=>strip_tags($isNoAgreement),
          "currency" => strip_tags($content['currency']),
          "claim_value" => strip_tags($content['claim_value']),
          "counter_claim_value" => strip_tags($content['counter_claim_value']),
          "total_claim_value" => strip_tags($content['total_claim_value']),
          "miscellaneous_fees" => strip_tags($content['miscellaneous_fees']),
          "out_of_pocket_expences" => strip_tags($content['out_of_pocket_expences']),
          "arbitration_fees" => strip_tags($content['arbitration_fees']),
          "administration_fees" => strip_tags($content['administration_fees']),
          "documents" => serialize($documents),
          "readTerms" => strip_tags($content['readTerms']),
          // "readArbitrator" => strip_tags($content['readArbitrator']),
          // "readCode" => strip_tags($content['readCode']),
          "readPrivacy" => strip_tags($content['readPrivacy']),
          "modified_by" => $registration_id,
          "modified_at" => date('Y-m-d H:i:s'),
        );
 
        $case_details_insert = $this->Mdl_cases->update("case_details", array("case_id" => $case_id), $caseDetailsData);
        $check_Institution = $this->Mdl_cases->isExist("case_users", array("case_id" => $case_id, "type" => 'institution'));
        $institution_id = $content["institution"];
        if($check_Institution && !empty($institution_id)) {
            echo json_encode(array("status"=>"alert","title"=>"Institution Alert","icon"=>"warning","message"=>"Institution is already added. Please do not add new institution")); exit;
        }
        if(!empty($institution_id) && $institution_id !== 0) {
          Modules::run("common/insertUserInCase", $case_id, $institution_id, "institution", "");
        }
        

       
        $payload = $content['enc_data'];

       
        echo json_encode(array("status" => "success", "title" => "Success", "icon" => "success", "message" => "Case Details has been updated Successfully.", "redirect" => "cases/caseStepTwo/" . $payload));
        exit;
      } else {
        echo json_encode(array("status" => "alert", "title" => "Oops! something went wrong", "icon" => "error", "message" => "Please reload & try again."));
        exit;
      }
    }
    // }else{
    //   echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    // }
  }

}