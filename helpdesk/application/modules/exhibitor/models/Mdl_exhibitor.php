<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/models/Mdl_generic.php';


class Mdl_exhibitor extends Mdl_generic {

	function __construct(){
		parent::__construct();
	}
  
  /** 
   *  space exhibitor List
   */
  var $tickets = "tickets";
  var $column_order_tickets = array(null,"unique_code","exhibitor_name","hall_no","subject","created_date"); 
  var $column_search_tickets = array("unique_code","exhibitor_name","subject"); 
  var $order_tickets = array("created_at"=>"desc"); 

  public function _get_datatables_query_tickets(){
    $this->db->from($this->tickets);
    $i = 0;
    $exhibitor_session = $this->session->userdata('exhibitor');
    $exhibitor_code = $exhibitor_session['Exhibitor_Code'];
    if(isset($exhibitor_code)){
      $this->db->where('exhibitor_code', $exhibitor_code);
    }
    if($this->input->post('unique_code')){
      $this->db->like('unique_code', $this->input->post('unique_code'));
    }
    if($this->input->post('subject')){
      $this->db->like('subject', $this->input->post('subject'));
    }
    foreach ($this->column_search_tickets as $item){
      if($_POST['search']['value']){
        
        if($i===0){
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }else{
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search_tickets) - 1 == $i) 
          $this->db->group_end(); 
      }
      $i++;
    }
    
    if(isset($_POST['order'])){
      $this->db->order_by($this->column_order_tickets[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }else if(isset($this->order_tickets)){
      $order = $this->order_tickets;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
}