<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Csupplier extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'supplier';
    }
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manager_supplier');
		$CI->load->library('lsupplier');
		$CI->load->model('suppliers');
		
		$config = array();
		$config["base_url"] = base_url()."csupplier/index";
		$config["total_rows"] = $this->suppliers->count_supplier();	  
		$config["per_page"] = 15;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->lsupplier->supplier_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Manage Supplier', 'url' => 'csupplier', 'class' =>'active'),
				array('label'=> 'New Supplier', 'url' => 'csupplier/add_supplier')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}

	//Product Add Form
	public function add_supplier()
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_supplier');
		$CI->load->library('lsupplier');
		$content = $CI->lsupplier->supplier_add_form();
		$sub_menu = array(
				array('label'=> 'Manage Supplier', 'url' => 'csupplier'),
				array('label'=> 'New Supplier', 'url' => 'csupplier/add_supplier','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Insert Product and uload
	public function insert_supplier()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_supplier');
		$CI->load->library('lsupplier');

		$data=array(
			'supplier_id' 	=> Null,
			'supplier_name' => $this->input->post('supplier_name'),
			'address' 		=> $this->input->post('address'),
			'mobile' 		=> $this->input->post('mobile'),
			'details' 		=> $this->input->post('details'),
			'status' 		=> 1
			);
		$CI->lsupplier->insert_supplier($data);
		$this->session->set_userdata(array('message'=>"Successfully Added !"));
		if(isset($_POST['add-supplier'])){
			redirect(base_url('csupplier'));
			exit;
		}elseif(isset($_POST['add-supplier-another'])){
			redirect(base_url('csupplier/add_supplier'));
			exit;
		}
	}
	//Supplier Update Form
	public function supplier_update_form($supplier_id=null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_supplier');
		if(!$supplier_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Supplier !"));
			redirect(base_url('csupplier'));
		}
		$CI->load->library('lsupplier');
		$content = $CI->lsupplier->supplier_edit_data($supplier_id);
		$sub_menu = array(
				array('label'=> 'Manage Supplier', 'url' => 'csupplier'),
				array('label'=> 'New Supplier', 'url' => 'csupplier/add_supplier'),
				array('label'=> 'Edit Supplier', 'url' => 'csupplier/supplier_update_form/'.$supplier_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	// Supplier Update
	public function supplier_update()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_supplier');
		$CI->load->model('suppliers');
		$supplier_id  = $this->input->post('supplier_id');
		$data=array(
			'supplier_name' => $this->input->post('supplier_name'),
			'address' 		=> $this->input->post('address'),
			'mobile' 		=> $this->input->post('mobile'),
			'details' 		=> $this->input->post('details')
			);
		$CI->suppliers->update_supplier($data,$supplier_id);
		$this->session->set_userdata(array('message'=>"Successfully Updated !"));
		redirect(base_url('csupplier'));
		exit;
	}
	// product_delete
	public function supplier_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('delete_supplier');
		$CI->load->model('suppliers');
		$supplier_id =  $_POST['supplier_id'];
		$CI->suppliers->delete_supplier($supplier_id);
		return true;	
	}
	// customer Update
	public function supplier_details($supplier_id)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('supplier_details');
		if(!$supplier_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Supplier !"));
			redirect(base_url('csupplier'));
		}
		$CI->load->library('lsupplier');
		$content = $CI->lsupplier->supplier_detail_data($supplier_id);
		$sub_menu = array(
				array('label'=> 'Manage Supplier', 'url' => 'csupplier'),
				array('label'=> 'New Supplier', 'url' => 'csupplier/add_supplier'),
				array('label'=> 'Supplier Details', 'url' => 'csupplier/supplier_details/'.$supplier_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	//Supplier Search Item
	public function supplier_search_item()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manager_supplier');
		$CI->load->library('lsupplier');	
		$supplier_id = $this->input->post('supplier_id');			
        $content = $CI->lsupplier->supplier_search_item($supplier_id);
        $sub_menu = array(
				array('label'=> 'Manage Supplier', 'url' => 'csupplier', 'class' =>'active'),
				array('label'=> 'New Supplier', 'url' => 'csupplier/add_supplier')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}	
}