<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cclosing extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'daily_closing';
    }
	
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_closing');
		$CI->load->library('lclosing');
		
        $content = $CI->lclosing->get_daily_closing_view( );
        $sub_menu = array(
				array('label'=> 'Daily Closing ', 'url' => 'cclosing', 'class' =>'active'),
				array('label'=> 'Closing Report', 'url' => 'cclosing/closing_report')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function add_drawing_entry()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_drawing');
		$CI->load->model('closings');
		date_default_timezone_set('Asia/Dhaka');
		$todays_date = date("Y-m-d");
		
		$data = array(
			'drawing_id'		=>	$this->generator(15),
			'date'				=>	$todays_date,
			'drawing_title'		=>	$this->input->post('title'),
			'description'		=>	$this->input->post('description'),
			'amount'		=>	$this->input->post('amount'),
			'status'		=>1
		);
		
		$invoice_id = $CI->closings->drawing_entry( $data );
		$this->session->set_userdata(array('message'=>"Successfully Draw Added !"));
		redirect(base_url('cclosing'));exit;
	}
	
	public function add_expence_entry()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_expences');
		$CI->load->model('closings');
		date_default_timezone_set('Asia/Dhaka');
		$todays_date = date("Y-m-d");
		
		$data = array(
			'expence_id'		=>	$this->generator(15),
			'date'				=>	$todays_date,
			'expence_title'		=>	$this->input->post('title'),
			'description'		=>	$this->input->post('description'),
			'amount'		=>	$this->input->post('amount'),
			'status'		=>1
		);
		
		$invoice_id = $CI->closings->expence_entry( $data );
		$this->session->set_userdata(array('message'=>"Successfully Transaction Added !"));
		redirect(base_url('cclosing'));exit;
	}
	
	public function add_banking_entry()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_banking');
		$CI->load->model('closings');
		date_default_timezone_set('Asia/Dhaka');
		$todays_date = date("Y-m-d");
		
		$data = array(
			'banking_id'		=>	$this->generator(15),
			'date'				=>	$todays_date,
			'bank_id'			=>	$this->input->post('bank_id'),
			'deposit_type'		=>	$this->input->post('deposit_name'),
			'transaction_type'	=>	$this->input->post('transaction_type'),
			'description'		=>	$this->input->post('description'),
			'amount'			=>	$this->input->post('amount'),
			'status'			=>1
		);
		
		$invoice_id = $CI->closings->banking_data_entry( $data );
		$this->session->set_userdata(array('message'=>"Successfully Added !"));
		redirect(base_url('cclosing'));exit;
	}
	
	public function add_daily_closing()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_final_closing');
		$CI->load->model('closings');
		
		date_default_timezone_set('Asia/Dhaka');
		$todays_date = date("Y-m-d");
		
		$data = array(
			'closing_id'			=>	$this->generator(15),			
			'last_day_closing'		=>	$this->input->post('last_day_closing'),
			'sales_in_cheque'		=>	$this->input->post('sales_in_cheque'),
			'sales_in_cash'			=>	$this->input->post('sales_in_cash'),
			'cheque_to_cash'		=>	$this->input->post('cheque_to_cash'),
			'date'					=>	$todays_date,
			'expense'		=>	$this->input->post('expense'),
			'drawing'		=>	$this->input->post('drawing'),
			'amount'		=>	$this->input->post('amount'),
			'adjusment'		=>	$this->input->post('adjusment'),
			'status'		=>1
		);
		
		$invoice_id = $CI->closings->daily_closing_entry( $data );
		$this->session->set_userdata(array('message'=>"Successfully Added !"));
		redirect(base_url('cclosing'));exit;
	}
	
	//Product Add Form
	public function closing_report()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('closing_report');
		$CI->load->library('lclosing');
		$CI->load->model('closings');
		
		$config = array();
		$config["base_url"] = base_url()."cclosing/closing_report";
		$config["total_rows"] = $CI->closings->count_daily_closing_data();	  
		$config["per_page"] = 15;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->lclosing->daily_closing_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Daily Closing ', 'url' => 'cclosing'),
				array('label'=> 'Closing Report', 'url' => 'cclosing/closing_report', 'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	public function date_wise_closing_reports()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_closing');
		$CI->load->library('lclosing');		
	
		$from_date = $this->input->post('from_date');		
		$to_date = $this->input->post('to_date');	
		
        $content = $CI->lclosing->get_date_wise_closing_reports( $from_date,$to_date );
        $sub_menu = array(
				array('label'=> 'Daily Closing ', 'url' => 'cclosing'),
				array('label'=> 'Closing Report', 'url' => 'cclosing/closing_report', 'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,61);
			$rand_number=$number["$rand_value"];
		
			if(empty($con))
			{ 
			$con=$rand_number;
			}
			else
			{
			$con="$con"."$rand_number";}
		}
		return $con;
	}
		
}