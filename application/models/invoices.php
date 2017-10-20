<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invoices extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Count invoice
	public function count_invoice()
	{
		return $this->db->count_all("invoice");
	}
	//invoice List
	public function invoice_list($limit,$page)
	{
		$this->db->select('a.*,b.customer_name,sum(c.total_price) as total_credit');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->limit($limit, $page);
		$this->db->group_by('a.invoice_id');
		$this->db->order_by('a.invoice_id','desc');
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
	
	public function create_invoice_no($customer_id)
	{
		$number = $this->generate_number_for_invoice($customer_id);
		$no_of_zero = "";
		if(strlen($number)==1){
			$no_of_zero = "000";
		}elseif(strlen($number)==2){
			$no_of_zero = "00";
		}elseif(strlen($number)==3){
			$no_of_zero = "0";
		}
		$cust_name = $this->get_customer_name($customer_id);
		$final_invoice_no = "INV-".$cust_name."-".date('Y')."".date('m')."".$no_of_zero."".$number; 
		return $final_invoice_no;
		
		// AKT-COM-201411 000
	}
	
	//NUMBER GENERATOR
	private function generate_number_for_invoice($customer_id)
	{
		$invoice_no = 1;
		$this->db->select('invoice_no');
		$this->db->where('customer_id',$customer_id);
		$this->db->order_by('invoice_id','desc');
		$query = $this->db->get('invoice');
		if($query->num_rows() > 0) {		
			$result = $query->result_array();		
			$invoice_no = $result[0]['invoice_no'];
			$invoice_no = substr($invoice_no, 14);
			$invoice_no = $invoice_no + 1;
		}
		return $invoice_no;
	}
	
	private function get_customer_name($customer_id)
	{
		$this->db->select('customer_name');
		$this->db->from('customer_information');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$data = $query->result_array();	
			return strtoupper(substr(str_replace(' ','',$data[0]['customer_name']),0,3));
		}
		$this->session->set_userdata(array('error_message'=>"Select customer name!"));
		redirect(base_url('cinvoice/add_invoice'));
		exit;
	}
	
	public function invoice_entry($datas)
	{
		$this->db->insert('invoice',$datas);
		$invoice_id =  $this->db->insert_id();
		return $invoice_id;
	}
	
	public function invoice_details_entry($data_item)
	{
		$this->db->insert('invoice_details',$data_item);
		return true;
	}
	
	public function customer_ledger_entry($ledger_data)
	{
		$this->db->insert('customer_ledger',$ledger_data);
		return true;
	}
	
	public function customer_ledger_update($ledger_update_data,$invoice_id)
	{
		$this->db->where('invoice_no',$invoice_id);
		$this->db->update('customer_ledger',$ledger_update_data); 
		return true;
	}
	
	public function cheeck_price_assign($product_id,$customer_id)
	{
		$this->db->select('price');
		$this->db->from('product_price_relation');
		$this->db->where(array('product_id' => $product_id,'customer_id' => $customer_id)); 
		$query = $this->db->get();	
		if ($query->num_rows() >0){
			return false;			
		}else{
			return true;
		}	
	}
	
	public function insert_price_assign($product_id,$customer_id,$price)
	{
		$data=array(
			'price_relation_id' => Null,
			'product_id' 	=> $product_id,
			'customer_id' 	=> $customer_id,
			'price' 		=> $price
		);
		$this->db->insert('product_price_relation',$data);
		return true;
	}
	
	public function update_price_assign($product_id,$customer_id,$price)
	{
		$data=array(
			'price' => $price
		);
		$this->db->where(array('product_id' => $product_id,'customer_id' => $customer_id)); 
		$this->db->update('product_price_relation',$data); 
		return true;
	}

	//Retrieve invoice Edit Data
	public function get_edit_data($invoice_id)
	{
		$this->db->select('a.*,b.*,c.*,d.product_name,d.product_model,d.quantity_type,');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->where('a.invoice_id',$invoice_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	public function do_delete_single_row($detail_id)
	{
		$this->db->where('invoice_details_id',$detail_id);
		$this->db->delete('invoice_details'); 
		return true;
	}
	
	public function invoice_update($datas,$invoice_id)
	{
		$this->db->where('invoice_id',$invoice_id);
		$this->db->update('invoice',$datas);
	}
	
	public function invoice_details_update($data_item,$invoic_detail_id)
	{
		$this->db->where('invoice_details_id',$invoic_detail_id);
		$this->db->update('invoice_details',$data_item);
	}
	
	public function retrieve_details_data($invoice_id)
	{
		$this->db->select('a.*,b.*,c.*,d.product_name,d.product_model,d.quantity_type,');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->where('a.invoice_id',$invoice_id);
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
		$this->db->select('a.product_model,a.quantity_type,b.price');
		$this->db->from('product_information a');
		$this->db->join('product_price_relation b','a.product_id = b.product_id');
		$this->db->where(array('a.product_id' => $product_id,'b.customer_id' => $customer_id)); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$data['product_price'] = $result[0]['price'];
			$data['product_model'] = $result[0]['product_model'];
			$data['quantity_type'] = $result[0]['quantity_type'];
		}else{
				$this->db->select('product_model,quantity_type');
				$this->db->from('product_information a');
				$this->db->where(array('product_id' => $product_id)); 
				$query = $this->db->get();
				$result = $query->result_array();
				$data['product_price'] = "";
				$data['product_model'] = $result[0]['product_model'];
				$data['quantity_type'] = $result[0]['quantity_type'];
		}
		return $data;
	}
	// Delete invoice Item
	public function delete_invoice($invoice_id)
	{	
		//Delete Invoice table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice'); 
		//Delete invoice_details table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice_details'); 

		//Delete invoice_details table
		$this->db->where('invoice_no',$invoice_id);
		$this->db->delete('customer_ledger'); 
		return true;
	}
	public function invoice_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('invoices a');
		$this->db->join('invoice_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('invoice_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// GET TOTAL PURCHASE PRODUCT
	public function get_total_purchase_item($product_id)
	{
		$this->db->select('sum(quantity) as total_quantity');
		$this->db->from('product_purchase_details');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// GET TOTAL SALES PRODUCT
	public function get_total_sales_item($product_id)
	{
		$this->db->select('sum(quantity) as total_s_quantity');
		$this->db->from('invoice_details');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function get_by_customer_search_list($customer_id)
	{
		$this->db->select('a.*,b.customer_name,sum(c.total_price) as total_credit');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->group_by('a.invoice_id');
		$this->db->order_by('a.invoice_id','desc');
		$this->db->where('b.customer_id',$customer_id);	
		$query = $this->db->get();		
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	
	public function get_date_wise_search_list($start_date,$end_date)
	{
		$dateRange = "a.created_on BETWEEN '$start_date%' AND '$end_date%'";
		$this->db->select('a.*,b.customer_name,sum(c.total_price) as total_credit');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->group_by('a.invoice_id');
		$this->db->order_by('a.invoice_id','desc');	
		$this->db->where($dateRange, NULL, FALSE); 	
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
}