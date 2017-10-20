<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ccustomer extends CI_Controller {
	
	function __construct() {
      parent::__construct();	  
	  $this->template->current_menu = 'customer';
    }
	
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_customer');
		$CI->load->library('lcustomer');
		$CI->load->model('customers');
		
		$config = array();
		$config["base_url"] = base_url()."ccustomer/manage_customer";
		$config["total_rows"] = $this->customers->count_customer();	  
		$config["per_page"] = 15;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->lcustomer->customer_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Manage Customer', 'url' => 'ccustomer','class' =>'active'),
				array('label'=> 'New Customer', 'url' => 'ccustomer/add_customer')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}

	//Product Add Form
	public function add_customer()
	{		
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_customer');
		$CI->load->library('lcustomer');
		$content = $CI->lcustomer->customer_add_form();
		$sub_menu = array(
			array('label'=> 'Manage Customer', 'url' => 'ccustomer'),
			array('label'=> 'New Customer', 'url' => 'ccustomer/add_customer','class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Insert Product and uload
	public function insert_customer()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_customer');
		$CI->load->library('lcustomer');

		$data=array(
			'customer_id' 			=> Null,
			'customer_name' 		=> $this->input->post('customer_name'),
			'customer_address' 		=> $this->input->post('address'),
			'customer_mobile' 		=> $this->input->post('mobile'),
			'customer_email' 		=> $this->input->post('email'),
			'status' 				=> 1
			);
		$CI->lcustomer->insert_customer($data);
		$this->session->set_userdata(array('message'=>"Successfully Added !"));
		if(isset($_POST['add-customer'])){
			redirect(base_url('ccustomer'));
			exit;
		}elseif(isset($_POST['add-customer-another'])){
			redirect(base_url('ccustomer/add_customer'));
			exit;
		}
	}
	//customer Update Form
	public function customer_update_form($customer_id=null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_customer');
		if(!$customer_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Customer!"));
			redirect(base_url('ccustomer'));
		}
		$CI->load->library('lcustomer');
		$content = $CI->lcustomer->customer_edit_data($customer_id);
		$sub_menu = array(
				array('label'=> 'Manage Customer', 'url' => 'ccustomer'),
				array('label'=> 'New Customer', 'url' => 'ccustomer/add_customer'),
				array('label'=> 'Edit Customer', 'url' => 'ccustomer/customer_update_form/'.$customer_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Customer Ledger
	public function customer_ledger($customer_id=null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('ledger_customer');
		if(!$customer_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Customer!"));
			redirect(base_url('ccustomer'));
		}
		$CI->load->library('lcustomer');
		$content = $CI->lcustomer->customer_ledger_data($customer_id);
		$sub_menu = array(
				array('label'=> 'Manage customer', 'url' => 'ccustomer'),
				array('label'=> 'New Customer', 'url' => 'ccustomer/add_customer'),
				array('label'=> 'Customer Ledger', 'url' => 'ccustomer/customer_ledger/'.$customer_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	// customer Update
	public function customer_update()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_customer');
		$CI->load->model('customers');
		$customer_id  = $this->input->post('customer_id');
		$data=array(
			'customer_name' 		=> $this->input->post('customer_name'),
			'customer_address' 		=> $this->input->post('address'),
			'customer_mobile' 		=> $this->input->post('mobile'),
			'customer_email' 		=> $this->input->post('email')
			);
		$CI->customers->update_customer($data,$customer_id);
		$this->session->set_userdata(array('message'=>"Successfully Updated !"));
		redirect(base_url('ccustomer'));
		exit;
	}
	// product_delete
	public function customer_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('delete_customer');
		$CI->load->model('customers');
		$customer_id =  $_POST['customer_id'];
		$CI->customers->delete_customer($customer_id);
		return true;			
	}
	
	//customer_search_item
	public function customer_search_item()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_customer');
		$CI->load->library('lcustomer');
		$customer_id = $this->input->post('customer_id');			
        $content = $CI->lcustomer->customer_search_item($customer_id);
        $sub_menu = array(
			array('label'=> 'Manage Customer', 'url' => 'ccustomer','class' =>'active'),
			array('label'=> 'New Customer', 'url' => 'ccustomer/add_customer')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}	
}