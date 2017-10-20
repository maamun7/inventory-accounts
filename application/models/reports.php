<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class reports extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Count report
	public function count_stock_report()
	{
		$this->db->select("*");
		$this->db->from('product_information');
		$this->db->where(array('status'=>1));
		$query = $this->db->get();		
		return $query->num_rows();

	}
	//Retrieve Single Item Stock Stock Report
	public function get_all_products($limit,$page)
	{
		$this->db->select("product_id,product_name,purchase_price,quantity_type,product_model");
		$this->db->from('product_information');
		$this->db->where(array('status'=>1));
		$this->db->limit($limit, $page);
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	//Retrieve 
	public function retrieve_purchase_report($product_id){
		$this->db->select("sum(quantity) as 'totalPurchaseQnty'");
		$this->db->from('product_purchase_details');
		$this->db->where(array('product_id'=>$product_id));
		$query = $this->db->get();
		return $query->result_array();
	}
		
	//Retrieve 
	public function retrieve_sales_report($product_id){
		$this->db->select("sum(quantity) as 'totalSalesQnty'");
		$this->db->from('invoice_details');
		$this->db->where(array('product_id'=>$product_id));
		$query = $this->db->get();
		return $query->result_array();
	}
	
	//Retrieve Single Item Stock Stock Report
	public function stock_report_single_item($product_id){
		$this->db->select("product_id,product_name,purchase_price,quantity_type,product_model");
		$this->db->from('product_information');
		$this->db->where(array('product_id',$product_id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

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
	//Retrieve todays_sales_report
	public function todays_sales_report()
	{
		$today = date('Y-m-d');
		$this->db->select("a.*,b.customer_id,b.customer_name,sum(c.total_price) as total_credit");
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');	
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');	
		$this->db->where('a.created_on',$today);
		$this->db->group_by('a.invoice_id');
		$this->db->order_by('a.invoice_id','asc');
		$query = $this->db->get();	
		return $query->result_array();
	}
	//Retrieve todays_purchase_report
	public function todays_purchase_report()
	{
		$today = date('Y-m-d');
		$this->db->select("a.*,b.supplier_id,b.supplier_name,sum(c.total_amount) as total_credit");
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');	
		$this->db->join('product_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->where('a.purchase_date',$today);
		$this->db->group_by('a.purchase_id');
		$this->db->order_by('a.purchase_id','asc');
		$query = $this->db->get();	
		return $query->result_array();
	}
	//Retrieve all Report
	public function retrieve_dateWise_SalesReports($start_date,$end_date)
	{
		$dateRange = "a.created_on BETWEEN '$start_date%' AND '$end_date%'";
		
		$this->db->select("a.*,b.customer_id,b.customer_name");
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where($dateRange, NULL, FALSE); 	
		$this->db->order_by('a.created_on','asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	//Retrieve all Report
	public function retrieve_dateWise_PurchaseReports($start_date,$end_date)
	{
		$dateRange = "a.purchase_date BETWEEN '$start_date%' AND '$end_date%'";
		
		$this->db->select("a.*,b.supplier_id,b.supplier_name");
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->where($dateRange, NULL, FALSE); 	
		$this->db->order_by('a.purchase_date','asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function product_wise_report()
	{
		$today = date('Y-m-d');
		$this->db->select("a.*,b.customer_id,b.customer_name");
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('a.date',$today);
		$this->db->order_by('a.invoice_id','asc');
		$query = $this->db->get();	
		return $query->result_array();
	}
	//RETRIEVE DATE WISE SINGE PRODUCT REPORT
	public function retrieve_product_sales_report()
	{
		$today = date('Y-m-d');
		$this->db->select("a.*,b.product_name,b.product_model,c.created_on,d.customer_name");
		$this->db->from('invoice_details a');
		$this->db->join('product_information b','b.product_id = a.product_id');
		$this->db->join('invoice c','c.invoice_id = a.invoice_id');
		$this->db->join('customer_information d','d.customer_id = c.customer_id');
		$this->db->where('c.created_on',$today);
		$this->db->order_by('c.created_on','asc');
		$query = $this->db->get();	
		return $query->result_array();
	}
	//RETRIEVE DATE WISE SEARCH SINGLE PRODUCT REPORT
	public function retrieve_product_search_sales_report( $start_date,$end_date )
	{
		$dateRange = "c.created_on BETWEEN '$start_date%' AND '$end_date%'";
		$this->db->select("a.*,b.product_name,b.product_model,c.created_on,d.customer_name");
		$this->db->from('invoice_details a');
		$this->db->join('product_information b','b.product_id = a.product_id');
		$this->db->join('invoice c','c.invoice_id = a.invoice_id');
		$this->db->join('customer_information d','d.customer_id = c.customer_id');
		$this->db->where($dateRange, NULL, FALSE); 
		$this->db->order_by('c.created_on','asc');
		$query = $this->db->get();	
		return $query->result_array();
		
		//$this->db->group_by('b.product_model');
	}
	
}