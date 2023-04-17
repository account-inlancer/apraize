<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class General_model extends MY_Generic_Model{

public function __construct()
	{
		parent::__construct();	  	
	}

public function getProfileDetail()
	{
		$query = "SELECT id,name,email
			FROM users 
			WHERE id='".$_SESSION['id']."' ";
		$result=$this->array_result($query);
		if ($result) 
			{
				return $result;	
			}	
	}

public function isOldPasswordExists()
	{
		$query=$this->query("SELECT id 
				FROM ".$this->tables['users']." 
				WHERE password='".$this->data['old_password']."' 
				AND id='".$this->data['id']."' ");

		if ($query->result_id->num_rows>0) 	
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}
?>