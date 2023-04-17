<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Department_model extends MY_Generic_Model
{
	
	public function __construct()
		{
			parent::__construct();	  	
		}
 
/*department Datatable*/
	public function get_all_department()
	{
		if ($this->data['order_by']=='') 
			{
				$query="SELECT c.d_id,c.d_name,c.shortname
					FROM department as c  
					WHERE c.is_delete = 0 
					AND 1=1".$this->data['search_text']." 
					ORDER BY c.d_name  ASC 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']."";

					$query_count="SELECT COUNT(c.d_id) as total 
					FROM department  as c 
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text'];
			}
			else
			{
				$query="SELECT c.d_id,c.d_name,c.shortname
				    FROM department as c  
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text']."  
					ORDER BY ".$this->data['order_by']." 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']." ";

				$query_count 	= "SELECT COUNT(c.d_id) as total 
					FROM department  as c  
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text'];
			}

		
			$result = $this->query_result($query);
			$total  = $this->query_result($query_count);			
			if ($result>0 && $total>0) 
				{ 
					return array('total'=>$total[0]->total,"result"=>$result) ;	
				}
			return false;
	}

	public function get_all_department_list()
		{
			$result  = $this->query("SELECT *
				FROM department  as c
				WHERE c.is_delete=0  
				ORDER BY c.d_name ASC ") ;
				
			if ($result->result_id->num_rows > 0)
			{
				return $result->result();		
			}
	    	else
		   	{
	   	 	return false;
	   		}
		}


	/*department details*/
	public function get_department_detail()
		{ 
			$result  = $this->query("SELECT c.*,c.d_id as id
				FROM ".$this->tables["department"]."  as c
				WHERE c.d_id='".$this->data['id']."'  ") ;

			if ( $result->result_id->num_rows > 0 )
			{
				return $result->row_array();		
			}
	    	else
		   	{
	   	 	return false;
	   		}
		}
}