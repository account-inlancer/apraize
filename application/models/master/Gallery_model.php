<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_model extends MY_Generic_Model
{
	
	public function __construct()
		{
			parent::__construct();	  	
		}

	/*department Datatable*/
	public function get_all_gallery()
	{
		if ($this->data['order_by']=='') 
			{
				$query="SELECT c.id,c.name,c.file_name,c.department,department.d_name,department.d_id,department.shortname
					FROM galleries as c
					LEFT JOIN department ON d_id=c.department  
					WHERE c.is_delete = 0 
					AND 1=1".$this->data['search_text']." 
					ORDER BY c.name  ASC 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']."";

					$query_count="SELECT COUNT(c.id) as total 
					FROM galleries  as c 
					LEFT JOIN department ON 
					d_id=c.department  
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text'];
			}
			else
			{
				$query="SELECT c.id,c.name,c.file_name,c.department,department.d_name,department.d_id,department.shortname
					FROM galleries as c
					LEFT JOIN department ON d_id=c.department  
					WHERE c.is_delete = 0 
					AND 1=1".$this->data['search_text']." 
					ORDER BY c.name  ASC 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']."";

					$query_count="SELECT COUNT(c.id) as total 
					FROM galleries  as c 
					LEFT JOIN department 
					ON d_id=c.department  
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text'];
			}

			/*echo $query;
			header("HTTP/1.0 500 Internal Server Error"); die;*/	
		
			$result = $this->query_result($query);
			$total  = $this->query_result($query_count);			
			if ($result>0 && $total>0) 
				{ 
					return array('total'=>$total[0]->total,"result"=>$result) ;	
				}
			return false;
	}
	/*Products details*/
	public function get_gallery_detail()
		{
			$result  = $this->query("SELECT c.*,c.id as id,department.d_name,department.d_id 
				FROM ".$this->tables["galleries"]."  as c
				LEFT JOIN department ON d_id = c.department
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
	
	public function get_all_gallery_list()
		{
			$result  = $this->query("SELECT c.id,c.name,c.file_name,c.department,department.d_name,department.d_id,department.shortname
					FROM galleries as c
					LEFT JOIN department ON d_id=c.department  
					WHERE c.is_delete = 0 
					ORDER BY c.name ASC 
					");

			if ( $result->result_id->num_rows > 0 )
			{
				return  $result->result();
			}
	    	else
		   	{
	   	 	return false;
	   		}
	   		 
		}
	
	public function get_home_gallery_list()
	    {
	        $result  = $this->query("
		        	SELECT setting_value
		        	FROM settings
		        	WHERE setting_name = 'home_page_products'
	        	");
	        $home_page_product_list = $result->row()->setting_value;

	        $result  = $this->query("SELECT c.product_id,c.product_title,c.product_priority,c.product_main_image,c.product_other_image,c.product_details,c.product_category,c.product_slug,department.category_name,department.category_slug 
					FROM products as c
					LEFT JOIN department ON category_id=c.product_category  
					WHERE product_id IN (".$home_page_product_list.")
					AND c.is_delete = 0 
					ORDER BY FIELD(product_id, ".$home_page_product_list.")
				");

			if ( $result->result_id->num_rows > 0 )
			{
				return  $result->result();
			}
	    	else
		   	{
	   	 		return false;
	   		}
	    }
	public function get_department_gallery_list()
		{
			$result  = $this->query("SELECT c.*,department.d_name,department.d_name,department.shortname
					FROM galleries as c
					LEFT JOIN department ON d_id=c.department  
					WHERE c.is_delete = 0 
					AND c.department='".$this->data['department']."'
					ORDER BY c.name ASC 
					");

			if ( $result->result_id->num_rows > 0 )
			{
				return  $result->result();
			}
	    	else
		   	{
	   	 	return false;
	   		}
	   		 
		}		
	// public function get_all_category_list()
	// 	{
	// 		$result  = $this->query("SELECT c.category_name,c.category_id,product_title
	// 				FROM department as c
	// 				LEFT JOIN products ON product_category=c.category_id
	// 				WHERE c.is_delete = 0 
	// 				ORDER BY c.category_id ASC 
	// 				");

	// 		if ( $result->result_id->num_rows > 0 )
	// 		{
	// 			return  $result->result();
	// 		}
	//     	else
	// 	   	{
	//    	 	return false;
	//    		}
	   		 
	// 	}		
}