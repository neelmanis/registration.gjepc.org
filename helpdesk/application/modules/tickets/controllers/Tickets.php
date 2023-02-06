<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : NEEL
 */

class Tickets extends Generic{
	
	function __construct() {
	parent::__construct();
    $this->load->model('Mdl_tickets');
	}
  
  /**
   *  All Visitors listing page
  */
  
  function all_tickets(){
    $data["categories"] = $this->Mdl_tickets->retrieveByorder("ticket_statuses",array("status"=>"1"),"","");
    $template = 'admin';
    $data['scriptFile'] = 'all-visitors';
    $data['viewFile'] = 'all-tickets';
    $data['module'] = "tickets";
    echo Modules::run('template/'.$template, $data);
  }
  
  
  /**
   *  Get All Tickets
  */
  public function getAllVisitorsRecords(){ 
    $records = $this->Mdl_tickets->get_datatables("tickets"); 
	  //echo '<pre>'; print_r($records); exit;
    $data = array();
    $no = $_POST['start']; 
    $admin_session = $this->session->userdata('admin');

    $admin_id = $admin_session['admin_id'];
    $admin_access = $admin_session['admin_access'];

    foreach($records as $val){
		
		$row = array();
		$getDept = $this->Mdl_tickets->retrieve("ticket_departments", array("id"=>$val->department_id));
		$dept = $getDept[0]->name;

		$visitor = '<div class="d-flex">
		<div class="text-left">
          <p class="mb-0">'.$val->exhibitor_name.'</p>
          <p class="">
              '.$val->exhibitor_code.'
          </p>
		</div>
		</div>';
	  
	  $url = base_url().'tickets/view/'.$val->id;	  
      $row[] = $val->unique_code;
      $row[] = $visitor;
      $row[] = $val->subject; 
      $row[] = $dept;
      $row[] = $val->hall_no;
      $row[] = $val->division_no;
      if($val->status_id == '1'){
        $row[] = '<span class="badge badge-success">Open</span>';
      }elseif($val->status_id == '2'){
        $row[] = '<span class="badge badge-warning">Pending</span>';
      }elseif($val->status_id == '3'){
        $row[] = '<span class="badge badge-info">Resolved</span>';
      } else {
        $row[] = '<span class="badge badge-danger">Closed</span>';
      }

	  if($val->priority_id == '1'){
        $row[] = '<span class="badge badge-success">Low</span>';
      }elseif($val->priority_id == '2'){
        $row[] = '<span class="badge badge-warning">Medium</span>';
      }elseif($val->priority_id == '3'){
        $row[] = '<span class="badge badge-danger">High</span>';
      }elseif($val->priority_id == '4'){
        $row[] = '<span class="badge badge-danger">Urgent</span>';
	  } else {
        $row[] = '<span class="badge badge-info">Unassigned</span>';
      }	  
	  
	  $row[] = date("d-m-Y",strtotime($val->created_at));
      $row[] = '<a class="btn btn-circle btn-info action_edit" href="'.$url.'" title="view Ticket"><i class="fa fa-eye"></i></a>';             
      
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_tickets->count_all("tickets"),
      "recordsFiltered" => $this->Mdl_tickets->count_filtered("tickets"),
      "data" => $data,
    );
    //echo $this->db->last_query(); exit;
    
    echo json_encode($output);
  }
 

  /*
  ** View
  */
  function view($id){
    $result = $this->Mdl_tickets->getByValue("tickets","id",$id);
	
    if($result == "No Data"){
      redirect('errors','refresh');
    } else {
	    $admin_session = $this->session->userdata('admin');
		$comment = $this->show_tree($id); 
		
		if($comment == 'no'){
			$data['comments'] = '';
		}else{
			$data['comments'] = $comment;
		}
	  $data['dept'] = $this->Mdl_tickets->getByValue("ticket_departments", "status", 'Y');
	  $data['statuses'] = $this->Mdl_tickets->getByValue("ticket_statuses", "status", '1');
	  $data['adminUser'] = $this->Mdl_tickets->getByValue("admin_master", "role", 'Admin');
	  $data['vendorUser'] = $this->Mdl_tickets->getByValue("admin_master", "role", 'Vendor');
	  $data['priorities'] = $this->Mdl_tickets->getByValue("priorities", "status", '1');
	  $data['onlineStatus'] = $this->Mdl_tickets->retrieve("admin_master",array("id" => $admin_session['admin_id']));
	//  echo $this->db->last_query(); exit;
	//  print_r($data['statuses']); exit;
      $data['onspot_visitor'] = $result;
      $data['breadcrumb'] = "View Ticket";
      $data['viewFile'] = "view";
      $data['scriptFile'] = "all-visitors";
      $data['module'] = "tickets";
      $template = 'admin';	  
      echo Modules::run('template/'.$template, $data);
    }
  }
	
	/***************************************** Add Comments ***************************************/
	function addComment(){
		$content = $this->input->post();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules("comment","Comment","required|xss_clean",array(
					'required' => 'Comment field should not be empty' ));

		if($this->form_validation->run() == FALSE){
			echo validation_errors();
		}else{
			$data = array(
				'ticket_id' => $content['ticket_id'],
				'comments' => $content['comment'],
				'role' => $content['utype'],
				'user_id'=> $content['user_id'],
				'parentId'=> $content['pid'],
				'created_at' =>date('Y-m-d H:i:s')
			);
			$insert = $this->Mdl_tickets->insert("ticket_replies", $data);			
			//echo json_encode(array("status"=>"success")); exit;
		}
	}
	
	/***************************************** Get Comment Id ***************************************/
	function show_tree($bid){
        // create array to store all comments ids
        $store_all_id = array();
        // get all parent comments ids by using news id
        $id_result = $this->Mdl_tickets->tree_all($bid);
        // loop through all comments to save parent ids $store_all_id array
		
		if($id_result !== 'no'){
			foreach ($id_result as $comment_id) {
				//echo '<pre>'; print_r($comment_id); exit;
				//array_push($store_all_id, $comment_id['parentId']);
				array_push($store_all_id, $comment_id['parentId']);
			}
			// return all hierarchical tree data from in_parent by sending
			//  initiate parameters 0 is the main parent,news id, all parent ids
			return  $this->in_parent(0,$bid, $store_all_id);
		} else {
			return "no";
		}
    }

    /***************************************** Get Comment Hierarchy ***************************************/
    function in_parent($in_parent,$bid,$store_all_id) {
        $html = "";
        if (in_array($in_parent,$store_all_id)) {
            $result = $this->Mdl_tickets->tree_by_parent($bid,$in_parent);
			
            foreach ($result as $re){ //echo '<pre>'; print_r($re); exit;
				$type = $re['role'];
				$uid = $re['user_id'];
				$commentId = $re['id'];
				$comment = $re['comments'];
				$date = $re['created_at'];
				$url = '';
				$getAdminName = $this->Mdl_tickets->retrieve("admin_master", array("id"=>$re['user_id']));
				$contact_name = $getAdminName[0]->contact_name;
				$onlineStatus = $getAdminName[0]->online;						
				if($onlineStatus == '1') {
					$activeUser = 'ppWrp'; //online
				} else { 
					$activeUser = ''; //offline
				}
				$name = strtoupper($contact_name);
								
				if($type == 'Super Admin'){
					$url = 'https://gjepc.org/assets/images/logo.png';
				}else if($type == 'Admin'){
					$url = base_url().'/assets/admin/images/users/hall-manager.png'; 
				}else if($type == 'Vendor'){
					$url = base_url().'/assets/admin/images/users/vendor.png';
				}
				
				if($type == 'Super Admin'){
					$html .= '<div class="comment_box">
					<div class="author_dp"><div><span class="'.$activeUser.'"></span><img src="'.$url.'"></div></div>
					<div class="comment">
					<div class="comment_container">
					<div class="comment_holder doc_comment">
					<strong class="txtblue">'.$name.' -</strong> '.$comment.'
					</div>
					<div class="comment_detail"><span style="margin-right:15px;">'.date("d-M, Y ",strtotime($date)).'</span> <a href="javascript:;" class="reply" id="'.$commentId.'" >Reply</a>
					<a href="javascript:;" class="report" id="'.$commentId.'"></a>
					</div></div>';
					$html .= $this->in_parent($commentId, $bid, $store_all_id);
					$html .= '</div></div>';
				}else if($type == 'Admin' || $type == 'Vendor'){
					
					$html .= '<div class="comment_box">
					<div class="author_dp"><div><span class="'.$activeUser.'"></span><img src="'.$url.'"></div></div>
					<div class="comment">
					<div class="comment_container">
					<div class="comment_holder doc_comment">
					<strong class="txtblue">'.$name.' -</strong> '.$comment.'
					</div>
					<div class="comment_detail"><span style="margin-right:15px;">'.date("d-M, Y ",strtotime($date)).'</span> <a href="javascript:;" class="reply" id="'.$commentId.'" >Reply</a>
					<a href="javascript:;" class="report" id="'.$commentId.'"></a>
					</div></div>';
					$html .= $this->in_parent($commentId, $bid, $store_all_id);
					$html .= '</div></div>';
				}
			}
        }
        return $html;
    }
	
	/*
	** VIEW Update Ticket ACTION
	*/
	function updateTicketAction(){
    $content = $this->input->post();
	$admin_session = $this->session->userdata('admin');
    $name = $admin_session['contact_name'];
	//print_r($content); exit;
	
	$this->form_validation->set_rules("statuses","Status","trim|xss_clean|required",
      array(
        'required' => "Status is required"
      ));
	  
	if($this->form_validation->run() == FALSE){
      $errors = $this->form_validation->error_array();
      echo json_encode($errors); exit;
    } else {

		$data = array(
          'priority_id' => strip_tags($content['priority_id']),    
          'status_id' => strip_tags($content['statuses']),    
          'vendor_id' => strip_tags(implode(",", $content['rights'])),
          'closed_at' => date('Y-m-d H:i:s'),
          'closed_by'=> $name
        );
		//echo $this->db->last_query(); exit;
      $update = $this->Mdl_tickets->update2("tickets","id",$content['id'],$data);
      echo json_encode(array("status"=>"success")); exit;
	}
	}
	
	
	
	/*
  ** Add ACTION
  */
	function add(){
		$admin = $this->session->userdata('admin');
		$role = $admin['role'];
		if($role == "Super Admin" || $role == "Admin"){
		$data['dept'] = $this->Mdl_tickets->getByValue("ticket_departments", "status", 'Y');
		$data['statuses'] = $this->Mdl_tickets->getByValue("ticket_statuses", "status", '1');
		$data['adminUser'] = $this->Mdl_tickets->getByValue("admin_master", "role", 'Admin');
		$data['vendorUser'] = $this->Mdl_tickets->getByValue("admin_master", "role", 'Vendor');
		$data['priorities'] = $this->Mdl_tickets->getByValue("priorities", "status", '1');
		$data['scriptFile'] = 'all-visitors';
		$data['viewFile'] = 'add';
		$data['module'] = "tickets";
		$data['breadcrumb'] = "Create Ticket";
		$template = 'admin';		
		echo Modules::run('template/'.$template, $data);
		} else { 
		redirect('/tickets/all_tickets');
		}
	}
	
	/*
  ** ADD ONSPOT ACTION
  */
  function addOnspotAction(){
	//  echo '<pre>'; print_r($_POST);
    $content = $this->input->post();
    $vendor_id = $content['vendor_id'];
    $department_id = $content['department_id'];
    $priority_id = $content['priority_id'];
    $status_id = $content['statuses'];
    $subject = $content['subject'];
    $description = $content['description'];
	
    $this->form_validation->set_rules("vendor_id","vendor_id","trim|required|xss_clean",
    array(
      'required' => 'Please select Vendor'
    ));

    $this->form_validation->set_rules("department_id","department_id","trim|required|xss_clean",
    array(
      'required' => 'Please select Department'
    ));
    
    $this->form_validation->set_rules("priority_id","Priority","trim|required|xss_clean",
    array(
      'required' => 'Please select Priority'
    ));

    $this->form_validation->set_rules("statuses","Status","trim|required|xss_clean",
    array(
      'required' => 'Please select Status'
    ));
	
	$this->form_validation->set_rules("subject","Subject","trim|required|xss_clean",
    array(
      'required' => 'Please select Subject'
    ));
	
	$this->form_validation->set_rules("description","Description","trim|required|xss_clean",
    array(
      'required' => 'Please select Description'
    ));

    if ($this->form_validation->run($this) == FALSE) {
      $errors = $this->form_validation->error_array();
      echo json_encode($errors);
      exit;
    } else {
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier =$this->Mdl_tickets->isExist("tickets", array("unique_code"=>$uniqueIdentifier));
		while($checkUniqueIdentifier){
        $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		}

		if($this->session->userdata('admin')){
			$admin = $this->session->userdata('admin');
			$adminId = $admin['admin_id'];
			$name = $admin['contact_name'];
		}
    }

      $data = array(
        'unique_code' => strip_tags($uniqueIdentifier),
        'admin_id' => strip_tags($adminId),
		'user_id' => $adminId,
        'subject'=> strip_tags($subject),
        'description'=> strip_tags($description),
        'status_id'=> strip_tags($status_id),
        'priority_id'=> strip_tags($priority_id),
        'department_id'=> strip_tags($department_id),
        'vendor_id'=> strip_tags($vendor_id),
        'created_at' => date('Y-m-d H:i:s')
      );
      
      $insert = $this->Mdl_tickets->insert("tickets", $data);
      echo json_encode(array("status"=>"success")); exit;
    }
   
	
  
}