<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/models/Mdl_generic.php';

/**
 * 	Author : Amit Kashte
 */

class Mdl_master extends Mdl_generic {

	function __construct(){
		parent::__construct();
	}

  

  /** 
   *  Zone List
   */
  
  var $table_zone_master = "zones";
  var $column_order_zone_master = array(null,"name","description","created_at"); 
  var $column_search_zone_master = array("name","description"); 
  var $order_zone_master = array("id"=>"asc"); 

  public function _get_datatables_query_zone_master(){
    $this->db->from($this->table_zone_master);
    $i = 0;
  
    foreach ($this->column_search_zone_master as $item){
      if($_POST['search']['value']){
        
        if($i===0){
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }else{
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search_zone_master) - 1 == $i) 
          $this->db->group_end(); 
      }
      $i++;
    }
    
    if(isset($_POST['order'])){
      $this->db->order_by($this->column_order_zone_master[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }else if(isset($this->order_zone_master)){
      $order = $this->order_zone_master;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
}