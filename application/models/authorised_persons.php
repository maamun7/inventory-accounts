<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authorised_persons extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_list()
	{
		$this->db->select("*");
		$this->db->from('authorised_person');
		$this->db->order_by('id','desc');	
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function entry($datas)
	{
		$this->db->insert('authorised_person',$datas);
		return true;
	}	
	
	public function get_edit_data($id)
	{
		$this->db->select("*");
		$this->db->from('authorised_person');
		$this->db->where('id',$id);	
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function update($datas,$authp_id)
	{
		$this->db->where('id',$authp_id);
		$this->db->update('authorised_person',$datas);
	}

	public function delete($authp_id)
	{
		$this->db->where('id',$authp_id);
		$this->db->delete('authorised_person'); 
	}

}