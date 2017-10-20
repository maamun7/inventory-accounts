<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cproduct extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'product';
    }
	public function index()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_product');
		$CI->load->library('lproduct');
		$CI->load->model('products');
		
		$config = array();
		$config["base_url"] = base_url()."cproduct/index";
		$config["total_rows"] = $this->products->count_product();	  
		$config["per_page"] = 15;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->lproduct->product_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Manage Product ', 'url' => 'cproduct','class' =>'active'),
				array('label'=> 'Add Product', 'url' => 'cproduct/add_product')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Product Add Form
	public function add_product()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_product');
		$CI->load->library('lproduct');
		$content = $CI->lproduct->product_add_form();
		$sub_menu = array(
				array('label'=> 'Manage Product ', 'url' => 'cproduct'),
				array('label'=> 'Add Product', 'url' => 'cproduct/add_product','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Insert Product and uload
	public function insert_product()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_product');
		$CI->load->library('lproduct');

		$data=array(
			'product_id' 			=> Null,
			'product_name' 			=> $this->input->post('product_name'),
			'purchase_price' 		=> $this->input->post('price'),
			'quantity_type' 		=> $this->input->post('quantity_type'),
			'product_model' 		=> $this->input->post('model'),
			'product_details' 		=> $this->input->post('description'),
			'status' 				=> 1
			);
		$CI->lproduct->insert_product($data);
		$this->session->set_userdata(array('message'=>"Successfully Added !"));
		if(isset($_POST['add-product'])){
			redirect(base_url('cproduct'));
			exit;
		}elseif(isset($_POST['add-product-another'])){
			redirect(base_url('cproduct/add_product'));
			exit;
		}
	}
	//Product Update Form
	public function product_update_form($product_id=null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_product');
		if(!$product_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Product!"));
			redirect(base_url('cproduct'));
		}
		$CI->load->library('lproduct');
		$content = $CI->lproduct->product_edit_data($product_id);
		$sub_menu = array(
				array('label'=> 'Manage Product ', 'url' => 'cproduct'),
				array('label'=> 'Add Product', 'url' => 'cproduct/add_product'),
				array('label'=> 'Edit Product', 'url' => 'cproduct/product_update_form/'.$product_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	// Product Update
	public function product_update()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_product');
		$CI->load->model('products');
		$product_id  = $this->input->post('product_id');
		$data=array(
			'product_name' 			=> $this->input->post('product_name'),
			'purchase_price' 		=> $this->input->post('purchase_price'),
			'quantity_type' 		=> $this->input->post('quantity_type'),
			'product_model' 		=> $this->input->post('model'),
			'product_details' 		=> $this->input->post('description'),
			'status' 				=> 1
			);
		$CI->products->update_product($data,$product_id);
		$this->session->set_userdata(array('message'=>"Successfully Updated !"));
		redirect(base_url('cproduct'));
		exit;
	}
	// product_delete
	public function product_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('delete_product');
		$CI->load->model('products');
		$product_id =  $_POST['product_id'];
		$CI->products->delete_product($product_id);
		return true;
			
	}
	//Retrieve Single Item  By Search
	public function product_by_search()
	{
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lproduct');
		$product_id = $this->input->post('product_id');		
        $content = $CI->lproduct->product_search_list($product_id);
        $sub_menu = array(
				array('label'=> 'Manage Product ', 'url' => 'cproduct','class' =>'active'),
				array('label'=> 'Add Product', 'url' => 'cproduct/add_product')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Retrieve Single Item  By Search
	public function product_details($product_id=null)
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_product');
		if(!$product_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Product!"));
			redirect(base_url('cproduct'));
		}
		$CI->load->library('lproduct');	
        $content = $CI->lproduct->product_details($product_id);
        $sub_menu = array(
				array('label'=> 'Manage Product ', 'url' => 'cproduct'),
				array('label'=> 'Add Product', 'url' => 'cproduct/add_product'),
				array('label'=> 'Product Details', 'url' => 'cproduct/product_details/'.$product_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
}