<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 	Author : Amit Kashte
 */

class Mdl_generic extends CI_Model{
	
	function __construct() {
		parent::__construct();
		$this->load->model('Mdl_generic');
	}

	/** 
	 * Insert records
	*/
	function insert($table, $data){
		$this->db->insert($table, $data);
		$id = $this->db->insert_id();
	//	echo $this->db->last_query(); exit;
		return $id;
	}

  /**
	 * Bulk insert
	 */
  function insert_batch($table, $data){
    $this->db->insert_batch($table, $data);
    return 1;
	}
	
	/**
	 * Update
	 */
	function update($table, $param, $data){
		foreach($param as $key => $value){
      $this->db->where($key, $value);
    }
		return $this->db->update($table, $data);
	}
	
	function update2($table, $col, $val, $data){
		$this->db->where($col, $val);
		return $this->db->update($table, $data);
	}

	/**
	 * Delete
	 */
	function delete($table, $param){
		foreach($param as $key => $value){
			$this->db->where($key, $value);
		}
		return $this->db->delete($table);
	}

	/**
	 * Retrieve records
	 */
	function retrieve($table, $param){
		//echo $table;
		foreach($param as $key => $value){
			$this->db->where($key, $value);
		}
		//	echo $this->db->last_query(); exit;
		$query=$this->db->get($table);

		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return "NA";
		} 
	}

	function retrieveByCol($column, $table, $param){
		$this->db->select($column);
		
		foreach($param as $key => $value){
			$this->db->where($key, $value);
		}

		$query=$this->db->get($table);

		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return "NA";
		} 
	}

	
	function retrieveByorder($table, $param,$column,$order){
		
		foreach($param as $key => $value){
			$this->db->where($key, $value);
		}
		$this->db->order_by($column,$order);
		$query=$this->db->get($table);

		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return "NA";
		} 
	}

	function retrieveByGroup($table, $param,$column){
		foreach($param as $key => $value){
			$this->db->where($key, $value);
		}
		$this->db->group_by($column);
		$query=$this->db->get($table);

		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return "NA";
		} 
	}

	/**
	 * Retrieve records
	 */
	function countRecords($table, $param){
		//$this->db->select("id");
		foreach($param as $key => $value){
			$this->db->where($key, $value);
		}
		$query=$this->db->get($table);

		if($query->num_rows() > 0){
			return $query->num_rows(); 
		}else{
			return 0;
		} 
	}

	/** 
	 * Find record 
	 * return TRUE / FALSE
	*/
	function isExist($table, $param){
		foreach($param as $key => $value){
			$this->db->where($key, $value);
		}
		$query=$this->db->get($table);
		if($query->num_rows() > 0){
			return TRUE; 
		}else{
			return FALSE;
		} 
	}

	/**
	 * Custom query
	 */
	function customQuery($query_str){
		$result = $this->db->query($query_str);
		// echo $this->db->last_query();

		if($result->num_rows() > 0){
			return $result->result(); 
		}else{
			return "NA";
		} 
	}

	function getByFilter($table, $param, $start, $limit,$column,$order){
		foreach($param as $key => $value){
			$this->db->where($key, $value);
        }
    
		$this->db->limit($limit,$start);
		$this->db->order_by($column,$order);
		$query=$this->db->get($table);
		
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return "NA";
		} 
	}




	/**
	 * Datatable queries
	 */
	public function get_datatables($table){
		$funcation_name = "_get_datatables_query_$table";
		$this->{$funcation_name}();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		// echo $this->db->last_query(); exit;
    	return $query->result();
	}
	
  public function count_filtered($table){
		$funcation_name = "_get_datatables_query_$table";
    $this->{$funcation_name}();
    $this->db->select("id");
    $query = $this->db->get();
    return $query->num_rows();
	}

	public function count_filtered_role($table){
		$funcation_name = "_get_datatables_query_$table";
    $this->{$funcation_name}();
    $this->db->select("role_id");
    $query = $this->db->get();
    return $query->num_rows();
	}
	
	public function count_all($table){
		$table_name = "table_$table";
		$this->db->from($this->{$table_name});
		$this->db->select("id");
		return $this->db->count_all_results();
	}

	public function count_all_roll($table){
		$table_name = "table_$table";
		$this->db->from($this->{$table_name});
		$this->db->select("role_id");
		return $this->db->count_all_results();
	}


	/**
	 * 	Stored Procedures
	 */
	public function callFetch($procedure){
		$query = $this->db->query($procedure);
		mysqli_next_result( $this->db->conn_id );

		if($query->num_rows() > 0){
			$result = $query->result();
			return $result; 
		}else{
			return "NA";
		} 
	}

	public function callInsert($procedure, $param){
		$result = $this->db->query($procedure, $param);
		return $result;
	}
	
	function getByValue($table, $col, $val){
		$this->db->where($col, $val);
		$query=$this->db->get($table);
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return "No Data";
		} 
	}
}