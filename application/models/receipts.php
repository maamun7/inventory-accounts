<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receipts extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Count receipt
	public function count_receipt()
	{
		$this->db->select('receipt_no');
		$this->db->from('customer_ledger');
		$this->db->where('status',1);
		$query = $this->db->get();
		return $query->num_rows();
	}
	//receipt List
	public function receipt_list($limit,$page) 
	{
		$this->db->select('a.customer_id,a.customer_name,b.transaction_id,b.receipt_no,b.amount,b.date');
		$this->db->from('customer_information a');
		$this->db->join('customer_ledger b','b.customer_id = a.customer_id');
		$this->db->where('b.status',1);
		$this->db->where('b.receipt_no !=','');
		$this->db->limit($limit, $page);
		$this->db->order_by('b.transaction_id','asc');
		$query = $this->db->get();		
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Single receipt 
	public function retreive_single_receipt($transaction_id) 
	{
		$this->db->select('a.customer_id,a.customer_name,b.transaction_id,b.receipt_no,b.amount,b.date');
		$this->db->from('customer_information a');
		$this->db->join('customer_ledger b','b.customer_id = a.customer_id');
		$this->db->where(array('b.status'=>1,'b.receipt_no !='=>'','transaction_id'=>$transaction_id));
		$this->db->order_by('b.transaction_id','asc');
		$query = $this->db->get();		
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
		//NUMBER GENERATOR
	public function receipt_no_generator()
	{
		$this->db->select_max('receipt_no');
		$query = $this->db->get('customer_ledger');	
		$result = $query->result_array();	
		$receipt_no = $result[0]['receipt_no'];
		if ($receipt_no !='' AND $receipt_no !=0) {
			$receipt_no = $receipt_no + 1;	
		}else{
			$receipt_no = 2014001;
		}
		return $receipt_no;		
	}
	
	//Search Receipt By Customer Name
	public function search_receipt_item($customer_id)
	{
		$this->db->select('a.customer_id,a.customer_name,b.transaction_id,b.receipt_no,b.amount,b.date');
		$this->db->from('customer_information a');
		$this->db->join('customer_ledger b','b.customer_id = a.customer_id');
		$this->db->where('b.status',1);
		$this->db->where('b.receipt_no !=',0);
		$this->db->where('a.customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count receipt
	public function receipt_entry($data)
	{
		$this->db->insert('customer_ledger',$data);
		return true;
	}
	//Retrieve receipt Edit Data
	public function retrieve_receipt_editdata($receipt_id)
	{
		$this->db->select('a.customer_id,a.customer_name,b.transaction_id,b.description,b.receipt_no,b.amount,b.date');
		$this->db->from('customer_information a');
		$this->db->join('customer_ledger b','b.customer_id = a.customer_id');
		$this->db->where('b.receipt_no',$receipt_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;		
	}
	//Update Categories
	public function update_receipt($receipt_id,$data)
	{
		$this->db->where('receipt_no',$receipt_id);
		$this->db->update('customer_ledger',$data); 
	}

}