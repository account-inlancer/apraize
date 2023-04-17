<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends MY_Generic_Model{

	//initialize

	public function __construct()
	{
		  	parent::__construct();
		  	
	}
	
	/*
	 * Will save data to the table. NOTE: set data before calling this function
	 * Params: $tableName - String
	 * Return: Last inserted Id;
	 */
	public function save($tableName)
	{			

		 $user_id = $this->insert( $this->tables[$tableName], $this->data );
		 //echo $this->db->last_query();exit;
		 return $user_id;	
	}
    public function save_batch($tableName)
    {

        $user_id = $this->insert_batch( $this->tables[$tableName], $this->data );
        //echo $this->db->last_query();exit;
        return $user_id;
    }
	
	/*
	 * Will update data to the table. NOTE: set data before calling this function
	 * Params: $tableName - String, $where - Array with condition as key and value
	 * Return: true OR false
	 */
	public function updateData($tableName, $where )
	{
		 
		$return = $this->update( $this->tables[$tableName],$this->data, $where );
		//echo $this->db->last_query();exit;
		return $return;
	}
	
	/*
	 * Will delete records from table
	 * Params: $tableName - String, $where - Array with condition as key and value
	 * Return: true OR false
	 */
	public function remove($tableName, $where )
	{
		return $this->delete( $this->tables[$tableName],$where );
	}
	/*
	 * Will delete multiple records from table
	 * Params: $tableName - String, $where - Array with value, $where = array(4,7)
	 * Return: true OR false
	 */
	public function deleteMultiple($tableName, $where )
	{
		
		return $this->delete_multiple( $this->tables[$tableName],$where );
	}
	public function check_is_exits($tableName,$where)
		{
			$this->db->where($where);
		    $query = $this->db->get($tableName);
		    if ($query->num_rows() > 0){
		        return true;
		    }
		    else{
		        return false;
		    }
		}
	
	
}