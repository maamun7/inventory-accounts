<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permissions extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_permission_list()
	{
		$this->db->select('a.*,b.*');
		$this->db->from('permissions a');
		$this->db->join('permission_groups b','b.group_id=a.group_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	public function get_permission_group_list()
	{
		$this->db->select('a.*');
		$this->db->from('permission_groups a');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	function insert_permission($data)
	{
		$this->db->insert('permissions',$data);
        return $this->db->insert_id();
	}

}