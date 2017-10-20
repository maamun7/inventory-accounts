<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Count Product
	public function count_product()
	{
		return $this->db->count_all("product_information");
	}
	//Product List
	public function product_list($limit,$page)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->limit($limit, $page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count Product
	public function product_entry($data)
	{
		$this->db->insert('product_information',$data);
		
		$this->update_product_json();
		return true;
	}

	private function update_product_json($data)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('status',1);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_product[] = array('label'=>$row->product_name,'value'=>$row->product_id);
		}
		$cache_file = $_SERVER['DOCUMENT_ROOT'].'/my-assets/js/admin_js/json/product.json';
		$productList = json_encode($json_product);
		file_put_contents($cache_file,$productList);
	}
	//Retrieve Product Edit Data
	public function retrieve_product_editdata($product_id)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Update Categories
	public function update_product($data,$product_id)
	{
		$this->db->where('product_id',$product_id);
		$this->db->update('product_information',$data); 
		
		$this->update_product_json();
		return true;
	}
	// Delete Product Item
	public function delete_product($product_id)
	{
		$this->db->where('product_id',$product_id);
		$this->db->delete('product_information'); 
		
		$this->update_product_json();
		return true;
	}
	//Product By Search 
	public function product_search_item($product_id)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Product Details
	public function product_details_info($product_id)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Product Purchase Report
	public function product_purchase_info($product_id)
	{
		$this->db->select('a.*,b.*,c.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('product_purchase_details b','b.purchase_id = a.purchase_id');
		$this->db->join('supplier_information c','c.supplier_id = a.supplier_id');
		$this->db->where('b.product_id',$product_id);
		$this->db->order_by('a.purchase_id','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Invoice Data for specific data
	public function invoice_data($product_id)
	{
		$this->db->select('a.*,b.*,c.customer_name');
		$this->db->from('invoice a');
		$this->db->join('invoice_details b','b.invoice_id = a.invoice_id');
		$this->db->join('customer_information c','c.customer_id = a.customer_id');
		$this->db->where('b.product_id',$product_id);
		$this->db->order_by('a.invoice_id','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
}