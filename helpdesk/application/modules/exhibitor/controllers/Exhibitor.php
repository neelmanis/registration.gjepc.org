<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

class Exhibitor extends Generic{
  
    function __construct() {
        parent::__construct();
        //$this->userSession();
        //$user = $this->session->userdata('user');
        $this->load->model('Mdl_exhibitor');
    }

    function index(){
      if(!Modules::run('security/isExibitor')){
        $data['title'] = "Exhibitor Login Page";
        $data['global'] = $this->global_variables;
        $this->load->view( 'web/login', $data );
      }else{
        redirect('exhibitor/dashboard','refresh');
      }
    }

    function loginAction()
    {
      $content = $this->input->post();
      $token = $this->session->userdata("token");
      //print_r($content);
      if(isset($content) && !empty($content)){
        $this->form_validation->set_rules('username','User name','trim|xss_clean|required');
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
          $registration = $this->Mdl_exhibitor->retrieve("iijs_exhibitor", array("Exhibitor_Code" => $username,"Exhibitor_Password"=>$password));

          if($registration == "NA"){
            echo json_encode(array("status"=>"fail","title"=>"Login Failed","icon"=>"error","message"=>'Username And Password Does Not Exit'));exit;
          } else {
          
            //$is_valid_password = Modules::run('security/verifyPassoword',$password,$registration[0]->password);
            if($password != $registration[0]->Exhibitor_Password){
              $is_valid_password = false;
            } else {
              $is_valid_password = true;
            }
            if($is_valid_password){
              $exhibitor_session_data = array(
                'uid'=>$registration[0]->Exhibitor_Registration_ID,
                'Exhibitor_Name'=>$registration[0]->Exhibitor_Name,
                'Exhibitor_Code'=>$registration[0]->Exhibitor_Code,
                'Exhibitor_Email'=>$registration[0]->Exhibitor_Email,
                'Exhibitor_Registration_ID'=>$registration[0]->Exhibitor_Registration_ID,
                'is_superadmin'=>"no",
                'type'=>'exhibitor',
                'rights'=> "",
                "token"=>$token,
              );
                
              $this->session->set_userdata('exhibitor', $exhibitor_session_data);
              $redirect = 'exhibitor/dashboard';
              
              echo json_encode(array("status"=>"redirect","redirect"=>$redirect)); exit;
            } else {
              echo json_encode(array("status"=>"alert","title"=>"Access Denied!","icon"=>"error","message"=>'Incorrect Password.'));exit;
            }
          }
        }
            
      }else{
        redirect('/exhibitor-login','refresh');
        //echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
      }
    }

    function logout(){
      $this->session->unset_userdata('exhibitor');
      redirect('/exhibitor-login','refresh');
    }

    function dashboard(){
      
      $this->exhibitorSession();
      
      $exhibitor = $this->session->userdata("exhibitor");
      $uid = $exhibitor['uid'];
      $userDetails = $this->Mdl_exhibitor->retrieve("iijs_exhibitor",array("Exhibitor_Registration_ID"=>$uid));
    
      $data['userDetails'] = $userDetails;
    
      $data['viewFile'] = "web/dashboard";
      $data['scriptFile'] = "exhibitor";
      $data['module'] = "exhibitor";
      $template = 'exhibitor';
      //print_r($data);
      echo Modules::run('template/'.$template, $data);

    }

    function getAllTicketRecords()
    {
      $records = $this->Mdl_exhibitor->get_datatables("tickets");
      $data = array();
      $no = $_POST['start']; 
      $exhibitor_session = $this->session->userdata('exhibitor');
      // echo $this->db->last_query();
      // exit;
      //echo '<pre>'; print_r($exhibitor_session); exit;
      foreach ($records as $val){
        $row = array();
        // $visitor = '<div class="d-flex">
        // <div class="mr-3">
        //     <img width="40" height="40" class="img-circle" src="'.base_url('images/'.$val->photo_name).'" alt="" >
        // </div>
        // <div class="text-left">
        //     <p class="mb-0">'.$val->name.'</p>
        //     <p class="">
        //         '.$val->designation.'
        //     </p>
        // </div>
        // </div>';
      
        $url = base_url().'exhibitor/update/'.$val->id;	
        $row[] = $val->unique_code;  
        $row[] = $val->exhibitor_name;
        $row[] = $val->hall_no;
        $row[] = $val->subject;
        $row[] = $val->status_id;;
        $row[] = date("d-m-Y",strtotime($val->created_at));
        // if($val->status_id == 'Y'){
        //   $row[] = '<span class="badge badge-success">Active</span>';
        // }elseif($val->status == 'D'){
        //   $row[] = '<span class="badge badge-danger">Disapproved</span>';
        // }elseif($val->status == 'N'){
        //   $row[] = '<span class="badge badge-danger">Disapproved</span>';
        // }else{
        //   $row[] = '<span class="badge badge-warning">Pending</span>';
        // }

        $data[] = $row;
      }
     
      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->Mdl_exhibitor->count_all("tickets"),
        "recordsFiltered" => $this->Mdl_exhibitor->count_filtered("tickets"),
        "data" => $data,
      );
      //echo $this->db->last_query(); exit;
      
      echo json_encode($output);
    }

    function add()
    {
      if(Modules::run('security/isExibitor')){
        $exhibitor = $this->session->userdata('exhibitor');
        $uid = $exhibitor['uid'];
        $registration = $this->Mdl_exhibitor->retrieve("iijs_exhibitor",array("Exhibitor_Registration_ID"=>$uid));
        if($registration == "NA"){
          redirect('/exhibitor-login','refresh');
        }
        $ticket_departments = $this->Mdl_exhibitor->retrieve("ticket_departments",array("status"=>'Y'));
        $data['departments'] = $ticket_departments;
        $data['scriptFile'] = 'exhibitor';
        $data['viewFile'] = 'web/add';
        $data['module'] = "exhibitor";
        $data['breadcrumb'] = "Add Ticket";
        $template = 'exhibitor';		
        echo Modules::run('template/'.$template, $data);
      }else{
        redirect('/exhibitor-login','refresh');
      } 
    }

    function addTicketction()
    {
      $content = $this->input->post();    
      $this->form_validation->set_rules("subject","subject","trim|required|xss_clean",
      array(
        'required' => 'Subject is required.'
      ));

      $this->form_validation->set_rules("department","department","trim|required|xss_clean",
      array(
        'required' => 'Please select Department.'
      ));

      $this->form_validation->set_rules("description","description","trim|xss_clean",
      array(
        'required' => 'Description is required.'
      ));

      if ($this->form_validation->run($this) == FALSE) {
        $errors = $this->form_validation->error_array();
        echo json_encode($errors);
        exit;
      } else {
      
        $digits = 9;	
        $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $checkUniqueIdentifier =$this->Mdl_exhibitor->isExist("tickets", array("unique_code"=>$uniqueIdentifier));
      
        while($checkUniqueIdentifier){
            $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
        } 
        if($this->session->userdata('exhibitor')){
          $exhibitor = $this->session->userdata('exhibitor');
          $registration_id = $exhibitor['uid'];
          $exhibitor_code = $exhibitor['Exhibitor_Code'];
          $exhibitor_data = $this->Mdl_exhibitor->retrieve("iijs_exhibitor", array("Exhibitor_Code" => $exhibitor_code));
          if($exhibitor_data == "NA"){
            redirect('/exhibitor-login','refresh');
          }
          $exhibitor_name = $exhibitor_data[0]->Exhibitor_Name;
          $exhibitor_hall_no = $exhibitor_data[0]->Exhibitor_HallNo;
        } else {
          redirect('/exhibitor-login','refresh');
        } 
        $base_path = "web_uploads/tickets/";
        if(!empty($_FILES['exh_photo']['name'])){
            $filename = $_FILES['exh_photo']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $imagename_photo =  $uniqueIdentifier;
            $img = $this->uploadFile($imagename_photo,$base_path,"pdf|png|jpg|jpeg|doc|docx|xls|zip|ods|xlsm|xlsx|ppt|pptxs",'3000','','',"exh_photo");
            $imgName = $imagename_photo.'.'.$ext;
            if($img !== 1){
              echo json_encode(array("image"=>$img)); exit;
            }
        } else {
          echo json_encode(array("image"=>"Please select Photo file to upload")); exit;
        }

        $photo_url = base_url().'web_uploads/tickets/'.$imgName;
        $department = $content['department'];
        $data = array(
          'unique_code' => strip_tags($uniqueIdentifier),
          'registration_id' => strip_tags($registration_id),
          'exhibitor_code' => strip_tags($registration_id),
          'exhibitor_name' => $exhibitor_name,
          'hall_no' => strip_tags($exhibitor_hall_no),
          'photo_url' => $photo_url,
          'subject' => strip_tags($content['subject']),
          'description' => strip_tags($content['description']),
          'department_id' => strip_tags($department),
          'created_at' => date('Y-m-d H:i:s'),
        );
    
        $insert = $this->Mdl_exhibitor->insert("tickets", $data);
        if($insert > 0){
          echo json_encode(array("status"=>"success","message"=>"Ticket Succefully Created","redirect"=>'exhibitor/dashboard')); exit;
        } else {
          echo json_encode(array("status"=>"error")); exit;
        }
        
      }
    }


}