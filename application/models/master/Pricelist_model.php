<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pricelist_model extends MY_Generic_Model
{
	
	public function __construct()
		{
			parent::__construct();	  	
		}
 
/*pricelist Datatable*/
	public function get_all_pricelist()
	{
		if ($this->data['order_by']=='') 
			{
				$query="SELECT c.id,c.name,c.unit,c.mrp,c.ptr,c.pts,c.netrate,c.tax,c.hsn,c.notes,c.department,d.d_name,d.shortname
					FROM pricelist as c  
					LEFT JOIN department as d
					ON c.department = d.d_id
					WHERE c.is_delete = 0 
					AND 1=1".$this->data['search_text']." 
					ORDER BY c.name  ASC 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']."";

					$query_count="SELECT COUNT(c.id) as total 
					FROM pricelist  as c 
					LEFT JOIN department as d
					ON c.department = d.d_id
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text'];
			}
			else
			{
				$query="SELECT c.id,c.name,c.unit,c.mrp,c.ptr,c.pts,c.netrate,c.tax,c.hsn,c.notes,c.department,d.d_name,d.shortname
				    FROM pricelist as c  
				    LEFT JOIN department as d
					ON c.department = d.d_id
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text']."  
					ORDER BY ".$this->data['order_by']." 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']." ";

				$query_count 	= "SELECT COUNT(c.id) as total 
					FROM pricelist  as c 
					LEFT JOIN department as d
					ON c.department = d.d_id 
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

	public function get_all_pricelist_list()
		{
			$result  = $this->query("SELECT *
				FROM pricelist  as c
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
	public function get_pricelist_detail()
		{ 
			$result  = $this->query("SELECT c.*,c.id as id
				FROM ".$this->tables["pricelist"]."  as c
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