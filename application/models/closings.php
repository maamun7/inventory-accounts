<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Closings extends CI_Model {
	
	private $todays_date;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		date_default_timezone_set('Asia/Dhaka');
		$this->todays_date = date("Y-m-d");
	}
	
	//DRAWING ENTRY
	public function drawing_entry( $data )
	{
		$this->db->insert('drawing_add',$data);
	}
	//TRANSACTION ENTRY
	public function expence_entry( $data )
	{
		$this->db->insert('expence_add',$data);
	}
	//BANKING ENTRY
	public function banking_data_entry( $data )
	{
		$this->db->insert('daily_banking_add',$data);
	}
	//BANKING ENTRY
	public function daily_closing_entry( $data )
	{
		$this->db->insert('daily_closing',$data);
	}
	
	public function get_last_closing_amount( )
	{
		$sql = "SELECT amount FROM daily_closing WHERE date = ( SELECT MAX(date) FROM daily_closing)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}	
	
	public function get_todays_draw_amount( )
	{
		$this->db->select("sum(amount) as 'total_draw_amount'");
		$this->db->from('drawing_add');
		$this->db->where('date',$this->todays_date);
		$query = $this->db->get();			
		return $query->result_array();
	}
	
	public function get_todays_expense_amount( )
	{
		$this->db->select("sum(amount) as 'total_expense_amount'");
		$this->db->from('expence_add');
		$this->db->where('date',$this->todays_date);
		$query = $this->db->get();			
		return $query->result_array();
	}
	
	public function get_todays_cheque_sales_amount( )
	{
		$this->db->select("sum(amount) as 'total_chq_sales_amount'");
		$this->db->from('customer_ledger');
		$this->db->where(array('payment_type'=>2,'date'=>$this->todays_date));
		$query = $this->db->get();			
		return $query->result_array();
	}
	
	public function get_todays_cash_sales_amount( )
	{
		$this->db->select("sum(amount) as 'total_cash_sales_amount'");
		$this->db->from('customer_ledger');
		$this->db->where(array('payment_type'=>1,'date'=>$this->todays_date));
		$query = $this->db->get();			
		return $query->result_array();
	}	
	
	public function get_todays_cheque_to_cash( )
	{
		$this->db->select("sum(amount) as 'cheque_to_cash_amount'");
		$this->db->from('daily_banking_add');
		$this->db->where(array('deposit_type'=>"cheque",'transaction_type'=>"draw",'date'=>$this->todays_date));
		$query = $this->db->get();			
		return $query->result_array();
	}
		
	public function count_daily_closing_data( )
	{
		$this->db->select('*');
		$this->db->from('daily_closing');
		$this->db->where('status',1);
		$query = $this->db->get();			
		return $query->num_rows();
	}
	
	public function get_closing_report( $limit,$page )
	{
		$this->db->select('*');
		$this->db->from('daily_closing');
		$this->db->where('status',1);
		$this->db->limit($limit, $page);
		$this->db->order_by('date','desc');
		$query = $this->db->get();			
		return $query->result_array();
	}
	
	public function get_date_wise_closing_report( $from_date,$to_date )
	{
		
		$dateRange = "date BETWEEN '$from_date%' AND '$to_date%'";
		
		$this->db->select('*');
		$this->db->from('daily_closing');
		$this->db->where('status',1);
		$this->db->where($dateRange, NULL, FALSE); 
		$this->db->order_by('date','desc');
		$query = $this->db->get();			
		return $query->result_array();		
	}
}