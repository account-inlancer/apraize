<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends MY_Generic_Model
{
	
	public function __construct()
		{
			parent::__construct();	  	
		}

	/*Categories Datatable*/
	public function get_all_blog()
	{
		if ($this->data['order_by']=='') 
			{
				$query="SELECT c.blog_id,c.title,c.post_image,c.body,c.slug,c.department,d.d_name
					FROM blog as c
					LEFT JOIN department as d
					ON c.department = d.d_id
					WHERE c.is_delete = 0 
					AND 1=1".$this->data['search_text']." 
					ORDER BY c.title  ASC 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']."";

					$query_count="SELECT COUNT(c.blog_id) as total 
					FROM blog  as c 
					LEFT JOIN department as d
					ON c.department = d.d_id
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text'];
			}
			else
			{
				$query="SELECT c.blog_id,c.title,c.post_image,c.body,c.slug,c.department,d.d_name
				    FROM blog as c 
				    LEFT JOIN department as d
					ON c.department = d.d_id
					WHERE c.is_delete=0 
					AND 1=1 ".$this->data['search_text']."  
					ORDER BY ".$this->data['order_by']." 
					LIMIT ".$this->data['limit_start'].",".$this->data['limit_length']." ";

				$query_count 	= "SELECT COUNT(c.blog_id) as total 
					FROM blog  as c  
					LEFT JOIN department as d
					ON c.department = d.d_id
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
	public function get_blog_detail()
		{
			$result  = $this->query("SELECT c.*,c.blog_id
				FROM ".$this->tables["blog"]."  as c
				WHERE c.blog_id='".$this->data['id']."'  ") ;

			if ( $result->result_id->num_rows > 0 )
			{
				return $result->row_array();
			}
	    	else
		   	{
	   	 	return false;
	   		}
		}
	
	public function get_all_blog_list()
		{
			$result  = $this->query("SELECT c.title,c.body,c.post_image,c.slug,c.department
					FROM blog as c
					WHERE c.is_delete = 0 
					ORDER BY c.blog_id ASC 
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
	
	
	// public function get_category_product_list()
	// 	{
	// 		$result  = $this->query("SELECT c.*,categories.category_name,categories.category_slug 
	// 				FROM products as c
	// 				LEFT JOIN categories ON category_id=c.product_category  
	// 				WHERE c.is_delete = 0 
	// 				AND c.product_category='".$this->data['product_category']."'
	// 				ORDER BY c.product_priority ASC 
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
	// public function get_all_category_list()
	// 	{
	// 		$result  = $this->query("SELECT c.category_name,c.category_id,product_title
	// 				FROM categories as c
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