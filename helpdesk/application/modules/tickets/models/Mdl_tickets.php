<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/models/Mdl_generic.php';

/**
 * 	Author : NEELMANI
 */

class Mdl_tickets extends Mdl_generic {
  function __construct() {
    parent::__construct();
  }

   /** 
   *  Ticket List
   */
  var $table_tickets = "tickets";
  var $column_order_tickets = array("unique_code","exhibitor_code","exhibitor_name","hall_no","status_id"); 
  var $column_search_tickets = array("exhibitor_code","exhibitor_name"); 
  var $order_tickets = array("created_at"=>"desc"); 

  public function _get_datatables_query_tickets(){
    $admin = $this->session->userdata('admin');
	$role = $admin['role'];
    $admin_id = $admin['admin_id'];
    $division_no = $admin['division_name'];
	
    if($this->input->post('unique_code')){
      $this->db->like('unique_code', $this->input->post('unique_code'));
    }
    if($this->input->post('exhibitor_name')){
      $this->db->like('exhibitor_name', $this->input->post('exhibitor_name'));
    }
    if($this->input->post('statuses')){
      $this->db->where('status_id', $this->input->post('statuses'));
    }
	
    $this->db->from($this->table_tickets);
    $i = 0;

	if($role == 'Super Admin'){		
	  //$this->db->where(array());
	} else if($role == 'Admin'){
	 $this->db->where('division_no',$division_no);
	} else { 
    if(isset($admin_id)){
      $this->db->where("FIND_IN_SET($admin_id,vendor_id) >",'0');
    }
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
  
	function tree_all($ticket_id) {
        $query = $this->db->query("SELECT * FROM ticket_replies where ticket_id = $ticket_id");
		if($query->num_rows() > 0){
			$result = $query->result_array();
			foreach ($result as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return "no";
		}
    }
	
	function tree_by_parent($ticket_id,$in_parent){
        $query = $this->db->query("SELECT * FROM ticket_replies where ticket_id = $ticket_id AND parentId = $in_parent order by id DESC");
		if($query->num_rows() > 0){
			$result = $query->result_array();
			foreach ($result as $row) {
				$data[] = $row;
			}
			return $data;
		} else {
			return "no";
		}
    }
}