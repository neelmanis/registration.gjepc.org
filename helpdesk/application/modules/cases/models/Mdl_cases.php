<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/models/Mdl_generic.php';

/**
 * 	Author : Amit Kashte
 */

class Mdl_cases extends Mdl_generic {

	function __construct(){
		parent::__construct();
	}
  
  /** 
   *  Cases List
   */
  var $table_cases = "case_registration c";
  var $column_order_cases = array(null,"c.status","c.serial_no","d.offline_id","c.created_at"); 
  var $column_search_cases = array("c.status","c.serial_no","d.offline_id","c.created_at"); 
  var $order_cases = array("c.created_at"=>"desc"); 

  /**
   *  User List
   */
  public function _get_datatables_query_cases(){
    $this->db->select("c.id, c.serial_no, c.status, c.created_at, d.offline_id");

    $this->db->from($this->table_cases);
    $this->db->join('case_details d', 'c.id = d.case_id');
    $i = 0;

    // $this->db->where('r.type', 'user');
  
    foreach ($this->column_search_cases as $item){
      if($_POST['search']['value']){
        
        if($i===0){
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }else{
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search_cases) - 1 == $i) 
          $this->db->group_end(); 
      }
      $i++;
    }
    
    if(isset($_POST['order'])){
      $this->db->order_by($this->column_order_cases[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }else if(isset($this->order_cases)){
      $order = $this->order_cases;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
}