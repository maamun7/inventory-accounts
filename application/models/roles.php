<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Roles extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_role_list()
	{
		$this->db->select('role_id,role');
		$this->db->from('roles');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	function insert_role($data)
	{
		$this->db->insert('roles',$data);
        return $this->db->insert_id();
	}
	
	function insert_role_permission_relation($datas)
	{
		$this->db->insert('role_permission_relation',$datas);
        return true;
	}
	
	function do_update($data,$role_id)
	{
		$this->db->where('role_id',$role_id);
		$this->db->update('roles',$data);
        return true;
	}
	
	public function get_all_group()
	{
		$this->db->where('status',1);
		$query = $this->db->get('permission_groups');
        return $query->result_array();
	}
	
	public function get_role_edit_data($role_id)
	{
		$this->db->where('role_id',$role_id);
		$query = $this->db->get('roles');
        return $query->result_array();
	}
	
	public function get_by_group_id($group_id)
	{
		$this->db->where('group_id',$group_id);
        $query = $this->db->get('permissions');
        return $query->result_array();
	}
	
	public function get_permission_by_role_id($role_id)
	{
		$this->db->where('role_id',$role_id);
        $query = $this->db->get('role_permission_relation');
        return $query->result_array();
	}
	
	function get_by_role_id($role_id)
	{
        $this->db->where('role_id',$role_id);
        $q = $this->db->get('roles');
        return $q->result_array();
	}
	
    function update_by_role_id($data,$role_id)
	{
		$this->db->where('role_id',$role_id);
		return $this->db->update('role_permission_relation',$data);
	}
}