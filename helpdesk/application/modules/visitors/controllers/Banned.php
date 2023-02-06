<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : NEEL
 */

class Banned extends Generic{
	
	function __construct() {
		parent::__construct();
    $this->load->model('Mdl_visitors');
	}
  
  /**
   *  listing page
   */
  function lists(){
    $this->adminSession('super');
    $template = 'admin';
    $data['scriptFile'] = 'banned';
    $data['viewFile'] = 'banned-list';
	$data['breadcrumb'] = "Manage Banned Visitor";
    $data['module'] = "visitors";
    echo Modules::run('template/'.$template, $data);
  }

  /**
   *  Get records
   */
  public function getBannedRecords(){
    $records = $this->Mdl_visitors->get_datatables("pending_images");
	//echo '<pre>'; print_r($records); exit;
    $data = array();
    $no = $_POST['start']; 
    $admin_session = $this->session->userdata('admin');
    $status_counter = $this->Mdl_visitors->countRecords('visitors',array('1'=>'1'));

    foreach ($records as $val){
    $row = array();
     
	$visitors = '<div class="d-flex">
      <div class="mr-3">
          <img width="40" height="40" class="img-circle" src="'.base_url('images/'.$val->photo_name).'" alt="" >
       
      </div>
      <div class="text-left">
          <p class="mb-0">'.$val->name.'</p>
          <p class="">
              '.$val->designation.'
          </p>
      </div>
  </div>';
  
      $row[] = $visitors;
      $row[] = $val->company;
      $row[] = $val->category;
      $row[] = $val->handover;
      if($val->status == 'Y'){
        $row[] = '<span class="badge badge-success">ACTIVE</span>';
      }else{
        $row[] = '<span class="badge badge-danger">Pending</span>';
      }
      $row[] = '<a class="btn btn-circle btn-success mr-1" href="javascript:void(0);"><i class="ti-pencil-alt"></i></a><a class="btn btn-circle btn-info" href="javascript:void(0);"><i class="ti-eye"></i></a>';
     
      $row[] = date("d-m-Y",strtotime($val->post_date));
      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_visitors->count_all("pending_images"),
      "recordsFiltered" => $this->Mdl_visitors->count_filtered("pending_images"),
      "data" => $data,
    );
    echo json_encode($output);
  }
  
  
  
}