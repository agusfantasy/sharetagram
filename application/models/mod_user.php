<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Model mod_user
User management from db 

*/
class Mod_user extends CI_Model{
	var $table = 'user';
	function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	
	//add user 
	function add($p=array()){
		return $this->db->insert($this->table,$p);
	}
	
	/*
		update user 
		$field_id = field name
		$value_id = value of field
	*/	
	function update($field_id,$value_id,$p=array()){
		$this->db->where($field_id,$value_id);
		return $this->db->update($this->table,$p);
	}
	
	function getDetail($pfield,$pval){
		$this->db->where($pfield,$pval);
		return $this->db->get($this->table)->row();
	}

}