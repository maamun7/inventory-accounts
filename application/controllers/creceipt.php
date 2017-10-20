<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Creceipt extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'receipt';
    }
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_receipt');
		$CI->load->library('lreceipt');
		$CI->load->model('receipts');
		
		$config = array();
		$config["base_url"] = base_url()."creceipt/index";
		$config["total_rows"] = $this->receipts->count_receipt();	  
		$config["per_page"] = 15;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->lreceipt->receipt_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Manage Receipt', 'url' => 'creceipt','class' =>'active'),
				array('label'=> 'Add Receipt', 'url' => 'creceipt/add_receipt')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}

	//receipt Add Form
	public function add_receipt()
	{		
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_receipt');
		$CI->load->library('lreceipt');
		$content = $CI->lreceipt->receipt_add_form();
		$sub_menu = array(
				array('label'=> 'Manage Receipt', 'url' => 'creceipt'),
				array('label'=> 'Add Receipt', 'url' => 'creceipt/add_receipt','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Insert receipt and uload
	public function insert_receipt()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_receipt');
		$CI->load->model('receipts');

		$data=array(
			'transaction_id' => null,
			'customer_id' 	 => $this->input->post('customer_id'),
			'receipt_no' 	 => $this->receipts->receipt_no_generator(),
			'invoice_no' 	 => null,
			'description'    => $this->input->post('description'),
			'payment_type'   => $this->input->post('payment_type'),
			'cheque_no'      => $this->input->post('cheque_no'),
			'amount' 		 => $this->input->post('amount'),
			'date' 			 => $this->input->post('receipt_date'),
			'status' 		 => 1
			);
		$CI->receipts->receipt_entry($data);
		$this->session->set_userdata(array('message'=>"Successfully Added !"));
		if(isset($_POST['add-receipt'])){
			redirect(base_url('creceipt'));
			exit;
		}elseif(isset($_POST['add-receipt-another'])){
			redirect(base_url('creceipt/add_receipt'));
			exit;
		}
	}
	//receipt Update Form
	public function receipt_update_form($receipt_id=null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_receipt');
		if(!$receipt_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Receipt!"));
			redirect(base_url('creceipt'));
		}
		$CI->load->library('lreceipt');
		$content = $CI->lreceipt->receipt_edit_data($receipt_id);
		$sub_menu = array(
				array('label'=> 'Manage Receipt', 'url' => 'creceipt'),
				array('label'=> 'Add Receipt', 'url' => 'creceipt/add_receipt'),
				array('label'=> 'Edit Receipt', 'url' => 'creceipt/receipt_update_form/'.$receipt_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	// receipt Update
	public function receipt_update()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_receipt');
		$CI->load->model('receipts');
		$receipt_no  = $this->input->post('receipt_no');
		$data=array(
			'customer_id' 	 => $this->input->post('customer_id'),
			'description'    => $this->input->post('description'),
			'amount' 		 => $this->input->post('amount'),
			'date' 			 => $this->input->post('receipt_date')
			);
		$CI->receipts->update_receipt($receipt_no,$data);
		$this->session->set_userdata(array('message'=>"Successfully Updated !"));
		redirect(base_url('creceipt'));
		exit;
	}
		
	//Search Receipt Item
	public function search_receipt_item()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_receipt');
		$CI->load->library('lreceipt');
		$customer_id = $this->input->post('customer_id');
        $content = $CI->lreceipt->search_receipt_item($customer_id);
        $sub_menu = array(
				array('label'=> 'Manage Receipt', 'url' => 'creceipt','class' =>'active'),
				array('label'=> 'Add Receipt', 'url' => 'creceipt/add_receipt')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function single_receipt($transaction_id)
	{		
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('receipt_details');
		if(!$transaction_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Receipt!"));
			redirect(base_url('creceipt'));
		}
		$CI->load->library('lreceipt');
		$content = $CI->lreceipt->get_single_receipt($transaction_id);
		$sub_menu = array(
				array('label'=> 'Manage Receipt', 'url' => 'creceipt'),
				array('label'=> 'Add Receipt', 'url' => 'creceipt/add_receipt'),
				array('label'=> 'Details', 'url' => 'creceipt/single_receipt/'.$transaction_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
}