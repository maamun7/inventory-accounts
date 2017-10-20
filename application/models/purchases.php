<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchases extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Count purchase
	public function count_purchase()
	{
		return $this->db->count_all("product_purchase");
	}
	//purchase List
	public function get_purchase_list($limit,$page)
	{
		$this->db->select("a.*,b.supplier_name,sum(c.total_amount) as total_credit");
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');		
		$this->db->join('product_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->group_by('a.purchase_id');
		$this->db->order_by('a.purchase_id','desc');	
		$this->db->limit($limit, $page);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	public function get_auth_person_list()
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
	
	public function retrieve_product_data($product_id)
	{
		$data = array();	
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where(array('product_id' => $product_id)); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$data['product_price'] = $result[0]['purchase_price'];
			$data['product_model'] = $result[0]['product_model'];
			$data['quantity_type'] = $result[0]['quantity_type'];
		}
		return $data;
	}
	
	public function purchase_by_search($supplier_id)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->where('b.supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Insert purchase
	public function purchase_entry($data)
	{
		$this->db->insert('product_purchase',$data);
		$purchase_id =  $this->db->insert_id();
		return $purchase_id;
	}	//Insert details purchase
	public function purchase_details_entry($data_item)
	{
		$this->db->insert('product_purchase_details',$data_item);
		return true;
	}
	
	// Delete purchase Detail Single row
	public function delete_details_row($detail_id)
	{
		$this->db->where('purchase_detail_id',$detail_id);
		$this->db->delete('product_purchase_details'); 
		return true;
	}
	
	//Retrieve purchase Edit Data
	public function retrieve_purchase_editdata($purchase_id)
	{
		$this->db->select('a.*,b.*,c.product_id,c.product_name,c.product_model,c.quantity_type,d.supplier_id,d.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('product_purchase_details b','b.purchase_id =a.purchase_id');
		$this->db->join('product_information c','c.product_id =b.product_id');
		$this->db->join('supplier_information d','d.supplier_id = a.supplier_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function purchase_update($datas,$purchase_id)
	{
		$this->db->where('purchase_id',$purchase_id);
		$this->db->update('product_purchase',$datas);
	}
	
	public function purchase_details_update($data_item,$purchase_detail_id)
	{
		$this->db->where('purchase_detail_id',$purchase_detail_id);
		$this->db->update('product_purchase_details',$data_item);
	}

	// Delete purchase Item
	public function delete_purchase($purchase_id)
	{
		//Delete product_purchase table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('product_purchase'); 
		//Delete product_purchase_details table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('product_purchase_details'); 
		return true;
	}
	
	//Retrieve purchase_details_data
	public function purchase_details_data($purchase_id)
	{
		$this->db->select('a.*,b.*,c.*,d.product_id,d.product_name,d.product_model,d.quantity_type,b.supplier_id,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->join('product_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->join('product_information d','d.product_id =c.product_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function create_purchase_no($supplier_id)
	{
		$number = $this->generate_number_for_purchase($supplier_id);
		$no_of_zero = "";
		if(strlen($number)==1){
			$no_of_zero = "000";
		}elseif(strlen($number)==2){
			$no_of_zero = "00";
		}elseif(strlen($number)==3){
			$no_of_zero = "0";
		}
		$supp_name = $this->get_supplier_name($supplier_id);
		$final_purchase_no = "AKM-".$supp_name."-".date('Y')."".date('m')."".$no_of_zero."".$number; 
		return $final_purchase_no;
		
		// AKT-COM-201411 000
	}
	
	//NUMBER GENERATOR
	private function generate_number_for_purchase($supplier_id)
	{
		$chalan_no = 1;
		$this->db->select('chalan_no');
		$this->db->where('supplier_id',$supplier_id);
		$this->db->order_by('purchase_id','desc');
		$query = $this->db->get('product_purchase');
		if($query->num_rows() > 0) {		
			$result = $query->result_array();		
			$chalan_no = $result[0]['chalan_no'];
			$chalan_no = substr($chalan_no, 14);
			$chalan_no = $chalan_no + 1;
		}
		return $chalan_no;
	}
	
	private function get_supplier_name($supplier_id)
	{
		$this->db->select('supplier_name');
		$this->db->from('supplier_information');
		$this->db->where('supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$data = $query->result_array();	
			return strtoupper(substr(str_replace(' ','',$data[0]['supplier_name']),0,3));
		}
		$this->session->set_userdata(array('error_message'=>"Select Supplier name!"));
		redirect(base_url('cpurchase/add_purchase'));
		exit;
	}
	
	public function get_purchase_no($purchase_id)
	{
		$this->db->select('chalan_no');
		$this->db->from('product_purchase a');
		$this->db->where('purchase_id',$purchase_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$data = $query->result_array();	
			return $data[0]['chalan_no'];
		}
		return false;
	}
	
	public function get_by_supplier_search_list($supplier_id)
	{
		$this->db->select("a.*,b.supplier_name,sum(c.total_amount) as total_credit");
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');		
		$this->db->join('product_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->group_by('a.purchase_id');
		$this->db->order_by('a.supplier_id','desc');	
		$this->db->where('b.supplier_id',$supplier_id);	
		$query = $this->db->get();		
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	
	public function get_date_wise_search_list($start_date,$end_date)
	{
		$dateRange = "a.purchase_date BETWEEN '$start_date%' AND '$end_date%'";
		$this->db->select("a.*,b.supplier_name,sum(c.total_amount) as total_credit");
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');		
		$this->db->join('product_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->group_by('a.purchase_id');
		$this->db->order_by('a.supplier_id','desc');	
		$this->db->where($dateRange, NULL, FALSE); 	
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

}