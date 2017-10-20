<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Suppliers extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Count supplier
	public function count_supplier()
	{
		return $this->db->count_all("supplier_information");
	}
	//supplier List
	public function supplier_list($limit,$page)
	{
		$this->db->select('*');
		$this->db->from('supplier_information');
		$this->db->limit($limit, $page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//supplier Search List
	public function supplier_search_item($supplier_id)
	{
		$this->db->select('*');
		$this->db->from('supplier_information');
		$this->db->where('supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count supplier
	public function supplier_entry($data)
	{
		$this->db->insert('supplier_information',$data);
		
		$this->db->select('*');
		$this->db->from('supplier_information');
		$this->db->where('status',1);
		
		$this->update_supplier_json();
		return true;
	}
	//Retrieve supplier Edit Data
	public function retrieve_supplier_editdata($supplier_id)
	{
		$this->db->select('*');
		$this->db->from('supplier_information');
		$this->db->where('supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Update Categories
	public function update_supplier($data,$supplier_id)
	{
		$this->db->where('supplier_id',$supplier_id);
		$this->db->update('supplier_information',$data); 
	
		$this->update_supplier_json();
		return true;
	}
	
	private function update_supplier_json()
	{
		$this->db->select('*');
		$this->db->from('supplier_information');
		$this->db->where('status',1);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_product[] = array('label'=>$row->supplier_name,'value'=>$row->supplier_id);
		}
		$cache_file = $_SERVER['DOCUMENT_ROOT'].'/my-assets/js/admin_js/json/supplier.json';
		$productList = json_encode($json_product);
		file_put_contents($cache_file,$productList);
		return true;
	}
	// Delete supplier Item
	public function delete_supplier($supplier_id)
	{
		$this->db->where('supplier_id',$supplier_id);
		$this->db->delete('supplier_information'); 
		
		$this->update_supplier_json();
		return true;
	}
	//Retrieve supplier Personal Data 
	public function supplier_personal_data($supplier_id)
	{
		$this->db->select('*');
		$this->db->from('supplier_information');
		$this->db->where('supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve Supplier Purchase Data 
	public function supplier_purchase_data($supplier_id)
	{
		$this->db->select("a.*,sum(c.total_amount) as total_credit");
		$this->db->from('product_purchase a');		
		$this->db->join('product_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->group_by('a.purchase_id');
		$this->db->order_by('a.supplier_id','desc');	
		$this->db->where('a.supplier_id',$supplier_id);	
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Supplier Search Data
	public function supplier_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('suppliers a');
		$this->db->join('supplier_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('supplier_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

}