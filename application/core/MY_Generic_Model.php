<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
	
	Class	purpose	: This class contain most usefull function 
						  This class will helps achieve reuse concept,
	How to use		:
			--For Beginner
						: step 1: Create new Model_name.php on application/model
						  step 2: class Model_name extends Generic_Modal
						  step 3: //Use insert,update,delete query like this
						  			 $this->insert($table_name,$data);
						  			 $this->update($table_name,$data,$where_arr);
						  			 $this->delete($table_name,$where_arr);
									 $this->query($full_query);			--> will return $query only
									 $this->query_result($full_query);	--> willl return results
			--Upload Image
						: Just call upload_file()
*/
/********Base class..********/
class MY_Generic_Model extends CI_Model
{
	
	protected 	$tables	;
	protected 	$data  ;	
	
	//Initialize
	public function __construct()
	{
        	parent::__construct();
			
			//initialize 
			$this->data		= array();
			$this->tables	= array( 
									"blog"		   				=>	"blog",
									"department"		   		=>	"department",
									"pricelist"		    		=>	"pricelist",
									"galleries"		   			=>	"galleries",
									"appusers"		    		=>	"appusers",
									"galleries_a"		    	=>	"galleries_a",
									"galleries_b"		    	=>	"galleries_b",
									"galleries_c"		    	=>	"galleries_c",
									"galleries_d"		    	=>	"galleries_d",
									"users"		    			=>	"users",
			);
	}
	
	/*Fields setter*/
	public function set_fields($data)
	{
		$this->data = $data;
	} 
	 
	
	public function set_field($key,$value)
	{
		$this->data [$key] = $value ; 
	}
	
	public function update_fields($data)
	{
		foreach( $data as $key=>$value )
		{
			$this->data [$key] = $value ;
		}	
	}
	
	/*Field getter*/
	public function get_field( $field_name )
	{
		if ( array_key_exists( $field_name, $this->data ) )
			return $this->data [ $field_name  ];
		return false;	
	}

	
	//insert query
	public function insert($table_name,$data)
	{
		$this->db->insert($table_name,$data);
		return $this->db->insert_id();
	}
	
	//update query
	public function update($table_name,$data,$where_arr)
	{
		$this->db->where($where_arr);
		//print_r($data);exit();
		$this->db->update($table_name,$data);
	}
	
	//Delete query
	public function delete ($table_name,$where_arr)
	{
		$this->db->where($where_arr);
		$this->db->delete($table_name);
	}
	
	//Select query
	public function query($query)
	{
		return $this->db->query($query);	
	}
	
	public function select_query( $fields,$table_name,$where = array() )
	{
		
		$this->db->select($fields);		
		$this->db->from($table_name);
		
		if ( !empty($where) )
		{
				$this->db->where($where);
		}
		
		return $this->db->get();
	}
	
	//Select query and return result
	public function query_result($query)
	{ 
		$query =  $this->db->query($query);
		if ( $query->result_id->num_rows > 0 )
			return $query->result();
		
		return array();	
	}
	public function query_array($query)
	{ 
		$query =  $this->db->query($query);
		if ( $query->result_id->num_rows > 0 )
			return $query->result_array();
		
		return array();	
	}

	public function string_result($query)
	{ 
		$query =  $this->db->query($query);
		if ( $query->result_id->num_rows > 0 )
			return $query->row();	
	}

	public function array_result($query)
	{ 
		$query =  $this->db->query($query);
		if ( $query->result_id->num_rows > 0 )
			return $query->row_array();	
	}
	
	//public function 	
	
	//Insert batch records
	public function insert_batch($table_name,$data)
	{
		$this->db->insert_batch($table_name, $data);		 	
		return $this->db->insert_id();		 	
	}
	
	//Generate an array for drop down
	public function get_drop_down( $query, $key, $value, $name )
	{
		$query 		= $this->db->query($query);
		$records = $query->result_array(); //array of arrays
		
		$data=array(""=>"Select ".$name." ");
		
		
		foreach ($records as $row)
    	{
      	$data[ $row[$key] ] = $row[ $value ];
    	}
    	
		return $data;
	}
	
	/* generate random password*/
	public function createRandomPassword() {
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		
		srand((double)microtime()*1000000);
		
		$i = 0;
		
		$pass = '' ;
		
		while ($i <= 7) {
		
			$num = rand() % 33;
		
			$tmp = substr($chars, $num, 1);
		
			$pass = $pass . $tmp;
		
			$i++;
		
		}
		return $pass;
	}
	
	/* send mail*/
	public function sendmail($to,$subject,$emailBody) {
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "From: Emall <noreply@emall.com> \r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $emailBody, $headers);
	}
	
	
	
}
?>
