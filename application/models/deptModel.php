<?php
class deptModel extends CI_Model{
    
	var $table = 'department';

	var $column_order = array('id','dept'); //set column field database for datatable orderable
	var $column_search = array('id', 'name'); //set column field database for datatable searchable.
	var $order = array('id' => 'desc'); // default order 
	
    function __construct() {
        parent::__construct();
        
	$this->load->helper('common_functions_helper'); // for password encription/ verification
	$this->load->helper('send_email_helper');
	$this->load->helper('dbclass');
        
        ini_set('max_execution_time',300);
        ini_set('memory_limit', '64M'); //Raise to 512 MB
        ini_set('post_max_size', '64M');
        ini_set('upload_max_filesize', '64M');
        ini_set("date.timezone", "Asia/Kolkata");
	
        //session_start();
    }
	
	function getDataTables()
	{
	   $this->getDataTableQuery();
		
		if($_POST['length'] != -1)  // commented for working
			$this->db->limit($_POST['length'], $_POST['start']); // commented for working
		
		$query = $this->db->get();
		return $query->result();
	}
 
 private function getDataTableQuery()
	{
		
		$this->db->from($this->table);
	    
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
		 if(isset($_POST['search']) && $_POST['search']['value']!="" )
		 {
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					//$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. this is not working
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					{
						//$this->db->group_end(); //close bracket. this is not working
					}
			}
		 } // isset ending	
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
 
 
 function countFiltered()
	{
		
		$this->getDataTableQuery();
		
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function countAll()
	{
		
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function getById($id)
	{
		$this->db->from($this->table);
		$this->db->where('Id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	
	public function saveData($data, $id)
	{
               
		if($id==0)
		{
			$this->db->insert($this->table, $data);
			$insertId =  $this->db->insert_id();
            return $insertId;
						
		}
		else
			{
				$this->db->update($this->table, $data, array('Id' =>$id)); // 3rd argument is where
			    return $this->db->affected_rows();
                                
				
			
			}	
	}
	public function deleteData($id)
	{
                $db  = new Database();
                // checking if detail exits
                /*res = $db->getFieldValueById("candidate_list", "DepartmentId", "Id='{$id}'");
                if($res)
                    return "Error! Can't delete, details exists.";
				*/
				$this->db->where('Id', $id);
				$this->db->delete($this->table);
                return TRUE;
	}
	
	

} // CLASS ENDING	
?>