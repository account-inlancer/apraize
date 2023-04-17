<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_model extends MY_Generic_Model
{
	public function __construct()
		{
			parent::__construct();	  	
		}
	public function get_gallery_data($department)
	{
		$result  = $this->query("SELECT c.*,c.id as id,d.d_id as department
				FROM ".$this->tables["galleries_".$department]."  as c
				LEFT JOIN department as d ON d.shortname = c.department
				") ;

			if ( $result->result_id->num_rows > 0 )
			{
				return $result->result();
			}
	    	else
		   	{
	   	 	return false;
	   		}
	}

	public function get_pricelist_data($department)
	{
		$result  = $this->query("SELECT c.*,c.id as id
					FROM pricelist_".$department." as c ");

			if ( $result->result_id->num_rows > 0 )
			{
				 return $result->result();
			}
	    	else
		   	{
	   	 	return false;
	   		}
	}
	public function get_blog_data($department)
	{
		$result  = $this->query("SELECT * FROM blog_".$department."");

			if ( $result->result_id->num_rows > 0 )
			{
				 return $result->result();
			}
	    	else
		   	{
	   	 	return false;
	   		}
	}
	public function get_all_gallery_data($limit,$offset)
	{
		$result  = $this->query("SELECT c.*,c.id as id
				FROM ".$this->tables["galleries"]."  as c
				LIMIT ".$limit."
				OFFSET ".$offset."
				") ;

			if ( $result->result_id->num_rows > 0 ){
				return $result->result();
			}else{
	   	 		return false;
	   		}
	}

 }
