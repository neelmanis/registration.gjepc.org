<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : Amit Kashte
 */

class Seo extends Generic{
	
	function __construct() {
		parent::__construct();
		$this->load->model('Mdl_seo');
	}

  /**
   *  Listing Page
   */
  function listPage(){
    $this->adminSession('1');

    $data['scriptFile'] = 'seo';
    $data['viewFile'] = 'list';
    $data['module'] = "seo";
    echo Modules::run('template/admin', $data);
  }

  /**
   *  Get records
   */
  function page(){
    $records = $this->Mdl_seo->get_datatables("seo");

    $data = array();
    $no = $_POST['start']; 
    
    $admin_session = $this->session->userdata('admin');

    foreach ($records as $val){
      $row = array();
      
      $url = base_url().'seo/update/'.$val->seo_id;
      $row[] = '<a class="btn btn-rounded btn-outline-success" href="'.$url.'"><i class="ti-pencil-alt"></i></a>';

      $row[] = $val->page;
      $row[] = $val->meta_title;

      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_seo->count_all("seo"),
      "recordsFiltered" => $this->Mdl_seo->count_filtered("seo"),
      "data" => $data,
    );

    echo json_encode($output);
  }

  public function url_check($link){
    // $pattern = "/^((ht|f)tp(s?)\:\/\/|~/|/)?([w]{2}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?/";
    $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";

    if( $link == "" ){
      return true;
    }else if(!preg_match($pattern, $link)){
      $this->form_validation->set_message('url_check', 'Invalid link');
      return false;
    }else{
      return true;
    }
  }

  /**
   *  Update
   */
  function update($id){
    $this->adminSession('1');
    $seo = $this->Mdl_seo->retrieve("seo",array("seo_id"=>$id));

    if($seo == "NA"){
      redirect("page-not-found","refresh");
    }else{
      $data['seo'] = $seo;
      $data['viewFile'] = "update";
      $data['scriptFile'] = "seo";
      $data['module'] = "seo";
      echo Modules::run('template/admin', $data);
    }
  }

  /**
   *  Update Action
   */
  function updateAction(){
    $content = $this->input->post();

    $token= $this->session->userdata("token");
    if($content["csrfToken"] == $token){

      $this->form_validation->set_rules('meta_title','Meta Title','trim|xss_clean');
      $this->form_validation->set_rules('meta_description','Meta Description','trim|xss_clean');
      $this->form_validation->set_rules('meta_keywords','Meta Keywords','trim|xss_clean');
      $this->form_validation->set_rules('canonical', 'Canonical url', 'trim|xss_clean|callback_url_check');

      if($this->form_validation->run($this) == FALSE){
        $errors = $this->form_validation->error_array();
        echo json_encode($errors); exit;
      }else{
        
        $admin_session = $this->session->userdata('admin');
  
        $seoData = array(
          'meta_title' => strip_tags($content['meta_title']),
          'meta_description' => strip_tags($content['meta_description']),
          'meta_keywords' => strip_tags($content['meta_keywords']),
          'canonical' => strip_tags($content['canonical']),
          'admin_id' => $admin_session['admin_id'],
          'modified_at' => date('Y-m-d H:i:s')
        );
        $update = $this->Mdl_seo->update("seo", array("seo_id"=>$content['seoId']), $seoData);

        echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'SEO updated Successfully.',"redirect"=>'seo/list')); exit;
      }
    }else{
      echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    }
  }
}