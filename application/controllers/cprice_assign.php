<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cprice_assign extends CI_Controller {
	
	function __construct() {
      parent::__construct();	  
	  $this->template->current_menu = 'price_assign';
    }
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('price_assign');
		$CI->load->library('lprice_assign');
		$CI->load->model('price_assigns');
		
		$config = array();
		$config["base_url"] = base_url()."cprice_assign/index";
		$config["total_rows"] = $this->price_assigns->count_price_list();	  
		$config["per_page"] = 15;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->lprice_assign->get_customer_price_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Custome Price List', 'url' => 'cprice_assign','class' =>'active'),
				array('label'=> 'New Assign', 'url' => 'cprice_assign/new_assign')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}

	//Product Add Form
	public function new_assign()
	{		
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('new_price_assign');
		$CI->load->library('lprice_assign');
		$data = array(
				'title' => 'Assign Price'
			);
		$content = $CI->parser->parse('price_assign/new_assign',$data,true);
		$sub_menu = array(
				array('label'=> 'Custome Price List', 'url' => 'cprice_assign'),
				array('label'=> 'New Assign', 'url' => 'cprice_assign/new_assign','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Insert Product and uload
	public function insert_assign_price()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->model('price_assigns');
		$feed_back = $CI->price_assigns->entry_assign_price();
		if($feed_back =="insert"){
			$this->session->set_userdata(array('message'=>"Successfully Added !"));
		}else if($feed_back =="update"){
			$this->session->set_userdata(array('message'=>"Successfully Updated !"));
		}
		if(isset($_POST['add-customer'])){
			redirect(base_url('cprice_assign'));
			exit;
		}elseif(isset($_POST['add-customer-another'])){
			redirect(base_url('cprice_assign/new_assign'));
			exit;
		}
	}
	
	//customer_search_item
	public function customer_search_item()
	{
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lprice_assign');
		$customer_id = $this->input->post('customer_id');			
        $content = $CI->lprice_assign->price_search_item($customer_id);
        $sub_menu = array(
				array('label'=> 'Custome Price List', 'url' => 'cprice_assign','class' =>'active'),
				array('label'=> 'New Assign', 'url' => 'cprice_assign/new_assign')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}

	public function retrieve_product_data()
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('price_assigns');
		$all_ids =  $_POST['all_ids'];		
		$product_info = $CI->price_assigns->retrieve_product_data($all_ids);
		echo json_encode($product_info);	
	}	
}