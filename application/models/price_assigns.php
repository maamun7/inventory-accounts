<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Price_assigns extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Count invoice
	public function count_price_list()
	{
		$this->db->select('a.customer_name,b.price,c.product_name,c.product_model');
		$this->db->from('customer_information a');
		$this->db->join('product_price_relation b','b.customer_id = a.customer_id');
		$this->db->join('product_information c','c.product_id = b.product_id');
		$this->db->order_by('a.customer_name','asc');
		$query = $this->db->get();
		return $query->num_rows();
	}
	//invoice List
	public function retrieve_customer_price_list($limit,$page)
	{
		$this->db->select('a.customer_name,b.price,c.product_name,c.product_model');
		$this->db->from('customer_information a');
		$this->db->join('product_price_relation b','b.customer_id = a.customer_id');
		$this->db->join('product_information c','c.product_id = b.product_id');
		$this->db->limit($limit, $page);
		$this->db->order_by('a.customer_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//retrieve_product_data
	public function retrieve_product_data($all_ids)
	{
		list($product_id,$customer_id) = explode("=",$all_ids);
		$data = array();
		$data['product_model'] = "";
		$data['purchase_price'] = "";
		$data['product_price'] = "";
		
		$this->db->select('product_model,purchase_price');
		$this->db->from('product_information');
		$this->db->where(array('product_id' => $product_id,'status' => 1)); 
		$query = $this->db->get();
		$result = $query->result_array();	
		if ($query->num_rows() > 0) {
			$data['product_model'] = $result[0]['product_model'];
			$data['purchase_price'] = $result[0]['purchase_price'];
		}
		
		$this->db->select('price');
		$this->db->from('product_price_relation');
		$this->db->where(array('product_id' => $product_id,'customer_id' => $customer_id)); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$data['product_price'] = $result[0]['price'];
		}
		return $data;
	}
	//Count invoice
	public function entry_assign_price()
	{
		$product_id	= $this->input->post('product_id');
		$customer_id	= $this->input->post('customer_id');
		
		$this->db->select('price');
		$this->db->from('product_price_relation');
		$this->db->where(array('product_id' => $product_id,'customer_id' => $customer_id)); 
		$query = $this->db->get();	
		if ($query->num_rows() == 0) {
			$data=array(
				'price_relation_id' => Null,
				'product_id' 	=> $product_id,
				'customer_id' 	=> $customer_id,
				'price' 		=> $this->input->post('price'),
			);
			$this->db->insert('product_price_relation',$data);
			return "insert";
		}else{
			$data=array(
				'price' => $this->input->post('price'),
			);
			$this->db->where(array('product_id' => $product_id,'customer_id' => $customer_id)); 
			$this->db->update('product_price_relation',$data); 
			return "update";
		}	
	}
	
	//invoice Search Item
	public function get_price_search_item($customer_id)
	{
		$this->db->select('a.customer_name,b.price,c.product_name,c.product_model');
		$this->db->from('customer_information a');
		$this->db->join('product_price_relation b','b.customer_id = a.customer_id');
		$this->db->join('product_information c','c.product_id = b.product_id');
		$this->db->where('a.customer_id',$customer_id);
		$this->db->order_by('a.customer_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
}