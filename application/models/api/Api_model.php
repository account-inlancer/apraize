<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends MY_Generic_Model
{
	public function __construct()
		{
			parent::__construct();	  	
		}
 		/*appusers*/
		public function get_all_appusers_list()
		{
			$result  = $this->query("SELECT *
				FROM appusers  as c
				WHERE c.is_delete=0 ") ;
				
			if ($result->result_id->num_rows > 0)
			{
				return $result->result();		
			}
	    	else
		   	{
	   	 	return false;
	   		}
		}

		/*pricelist */
		public function get_all_pricelist_list()
		{
			$result  = $this->query("SELECT *
				FROM pricelist  as c
				WHERE c.is_delete=0 ") ;
				
			if ($result->result_id->num_rows > 0)
			{
				return $result->result();		
			}
	    	else
		   	{
	   	 	return false;
	   		}
		}

		/*Blog*/
		public function get_all_blog_list()
		{
			$result  = $this->query("SELECT *
				FROM blog  as c
				WHERE c.is_delete=0 ") ;
				
			if ($result->result_id->num_rows > 0)
			{
				return $result->result();		
			}
	    	else
		   	{
	   	 	return false;
	   		}
		}
		/*galleries*/
		public function get_all_galleries_list()
		{
			$result  = $this->query("SELECT *
				FROM galleries  as c
				WHERE c.is_delete=0 ") ;
				
			if ($result->result_id->num_rows > 0)
			{
				return $result->result();		
			}
	    	else
		   	{
	   	 	return false;
	   		}
		}
		/*dept*/
		public function get_all_dept_list()
		{
			$result  = $this->query("SELECT d_id as id, d_name as name, shortname 
				FROM department
				WHERE is_delete=0 ") ;
				
			if ($result->result_id->num_rows > 0)
			{
				return $result->result();		
			}
	    	else
		   	{
	   	 	return false;
	   		}
		}
}