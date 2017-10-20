<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banks extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//BANK LIST
	public function get_bank_list()
	{
		$this->db->select('*');
		$this->db->from('bank_add');
		$this->db->where('status',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//COUNT PRODUCT
	public function bank_entry( $data )
	{
		$this->db->insert('bank_add',$data);
	}
}