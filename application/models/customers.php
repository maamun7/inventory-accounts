<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customers extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Count customer
	public function count_customer()
	{
		return $this->db->count_all("customer_information");
	}
	//customer List
	public function customer_list($limit,$page)
	{
		$this->db->select('*');
		$this->db->from('customer_information');
		$this->db->limit($limit, $page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Customer Search List
	public function customer_search_item($customer_id)
	{
		$this->db->select('*');
		$this->db->from('customer_information');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count customer
	public function customer_entry($data)
	{
		$this->db->insert('customer_information',$data);
		
		$this->update_customer_json();
		return true;
	}
	
	public function update_customer_json()
	{
		$this->db->select('*');
		$this->db->from('customer_information');
		$this->db->where('status',1);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_customer[] = array('label'=>$row->customer_name,'value'=>$row->customer_id);
		}
		$cache_file = $_SERVER['DOCUMENT_ROOT'].'/my-assets/js/admin_js/json/customer.json';
		$customerList = json_encode($json_customer);
		file_put_contents($cache_file,$customerList);
	}
	//Retrieve customer Edit Data
	public function retrieve_customer_editdata($customer_id)
	{
		$this->db->select('*');
		$this->db->from('customer_information');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve customer Personal Data 
	public function customer_personal_data($customer_id)
	{
		$this->db->select('*');
		$this->db->from('customer_information');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve customer Invoice Data 
	public function customer_invoice_data($customer_id)
	{
		$this->db->select('a.*,b.*');
		$this->db->from('invoice a');
		$this->db->join('invoice_details b','a.invoice_id = b.invoice_id');
		$this->db->where(array('a.customer_id'=>$customer_id));
		$this->db->group_by('a.invoice_id');
		$query = $this->db->get();		
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Retrieve customer Receipt Data 
	public function customer_receipt_data($customer_id)
	{
		$this->db->select('*');
		$this->db->from('customer_ledger');
		$this->db->where(array('customer_id'=>$customer_id,'invoice_no'=>NULL,'status'=>1));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Update Categories
	public function update_customer($data,$customer_id)
	{
		$this->db->where('customer_id',$customer_id);
		$this->db->update('customer_information',$data);

		$this->update_customer_json();
		return true;
	}
	// Delete customer Item
	public function delete_customer($customer_id)
	{
		$this->db->where('customer_id',$customer_id);
		$this->db->delete('customer_information'); 
		
		$this->update_customer_json();
		return true;
	}
	public function customer_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('customers a');
		$this->db->join('customer_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('customer_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

}