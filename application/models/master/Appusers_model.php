<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Appusers_model extends MY_Generic_Model
{
	public function __construct()
		{
			parent::__construct();	  	
		}
 
/*pricelist Datatable*/
	public function get_all_appusers()
	{
		if ($this->data['order_by']=='') 
			{
				$query="SELECT c.id,c.name,c.a_status,c.email,c.a,c.b,c.c,c.d,c.password,c.username,c.contact,c.address,c.gender,c.dob
					FROM appusers as c  
					WHERE c.is_delete = 0 
					AND 1=1".$this->data['search_text']." 
					ORDER BY c.name  ASC 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']."";

					$query_count="SELECT COUNT(c.id) as total 
					FROM appusers  as c 
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text'];
			}
			else
			{
				$query="SELECT c.id,c.name,c.a_status,c.email,c.a,c.b,c.c,c.d,c.password,c.username,c.contact,c.address,c.gender,c.dob
				    FROM appusers as c  
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text']."  
					ORDER BY ".$this->data['order_by']." 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']." ";

				$query_count 	= "SELECT COUNT(c.id) as total 
					FROM appusers  as c  
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

	public function get_all_appusers_list()
		{
			$result  = $this->query("SELECT *
				FROM appusers  as c
				WHERE c.is_delete=0  
				ORDER BY c.name ASC ") ;
				
			if ($result->result_id->num_rows > 0)
			{
				return $result->result();		
			}
	    	else
		   	{
	   	 	return false;
	   		}
		}


	/*pricelist details*/
	public function get_appusers_detail()
		{ 
			$result  = $this->query("SELECT c.*,c.id as id
				FROM appusers as c
				WHERE c.id='".$this->data['id']."'  ") ;

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