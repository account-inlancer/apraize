<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends MY_Generic_Model
{

	//initialize

   public function __construct()
   {
		  	parent::__construct();
   }	

	public function login()
	{
		
		$query = "SELECT id,name,email,password,username,status
		FROM users 
		WHERE email='".$this->data["email"]."' 
		AND password='".$this->data["password"]."' ";
		$result =$this->query($query);
		
		if ( $result->result_id->num_rows > 0 )
		{
			$data = $result->row_array();
			return $data;
		}
		else 
		{
		  
		   	return false;
			
	 	}	
	}
	public function get_settings(){
		$query = " SELECT setting,value
				FROM settingsn " ;

		$result =$this->query($query);
		if ( $result->result_id->num_rows > 0 )
		{
			return $result->result();		
		}
    	else
	   	{
   	 	return false;
   		}
	}

	public function get_passcode_settings(){
		$data=[]; 
		
		/*Get Right Passcode Data*/
		$query = " SELECT setting,value
				FROM settings  
				WHERE setting='right_passcode' " ;

		$result =$this->query($query);

		if ( $result->result_id->num_rows > 0 ) {
			$data['right_passcode']= $result->row_array();		
		} else {
   	 		$data['right_passcode']=['value'=>'aa'];
   		}


   		/*Get Fake Passcode Data*/
   		$query1 = " SELECT setting,value
				FROM settings  
				WHERE setting='fake_passcode' " ; 
		$result1 =$this->query($query1); 
		if ( $result1->result_id->num_rows > 0 ) { 
   	 		$data['fake_passcode']=$result1->row_array();	 
		}else{ 
   	 		$data['fake_passcode']=['value'=>'ff'];
		}


   		return $data;
	}

}
?>