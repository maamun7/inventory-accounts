<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Creport extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'report';
    }
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_report');
		$CI->load->library('lreport');
		$CI->load->model('reports');	

		$config = array();
		$config["base_url"] = base_url()."creport/index";
		$config["total_rows"] = $this->reports->count_stock_report();	  
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->lreport->stock_report($limit,$page,$links);
        $sub_menu = array(
			array('label'=> 'Stock Report', 'url' => 'creport', 'class' =>'active'),
			array('label'=> 'Sales Report ', 'url' => 'creport/todays_sales_report'),
			array('label'=> 'Purchase Report ', 'url' => 'creport/todays_purchase_report'),
			array('label'=> 'Sales Report (Product Wise) ', 'url' => 'creport/product_sales_reports_date_wise')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Retrieve Single Item Stock Report
	public function stock_report_single_item($product_id=null)
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('stock_report');
		if(!$product_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Product!"));
			redirect(base_url('creport'));
		}
		$CI->load->library('lreport');		
        $content = $CI->lreport->stock_report_single_item($product_id);
        $sub_menu = array(
				array('label'=> 'Stock Report', 'url' => 'creport', 'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Retrieve Single Item Stock Report By Search
	public function stock_report_by_search()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_report');
		$CI->load->library('lreport');
		$product_id = $this->input->post('product_id');	
		if($product_id==''){
			$this->session->set_userdata(array('error_message'=>"You didn't select Product!"));
			redirect(base_url('creport'));
		}	
        $content = $CI->lreport->stock_report_single_item($product_id);
        $sub_menu = array(
			array('label'=> 'Stock Report', 'url' => 'creport', 'class' =>'active'),
			array('label'=> 'Sales Report ', 'url' => 'creport/todays_sales_report'),
			array('label'=> 'Purchase Report ', 'url' => 'creport/todays_purchase_report'),
			array('label'=> 'Sales Report (Product Wise) ', 'url' => 'creport/product_sales_reports_date_wise')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	//todays_sales_report
	public function todays_sales_report()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('todays_sale_report');
		$CI->load->library('lreport');
		$content = $CI->lreport->todays_sales_report();
		$sub_menu = array(
			array('label'=> 'Stock Report', 'url' => 'creport'),
			array('label'=> 'Sales Report ', 'url' => 'creport/todays_sales_report','class' =>'active'),
			array('label'=> 'Purchase Report ', 'url' => 'creport/todays_purchase_report'),
			array('label'=> 'Sales Report (Product Wise) ', 'url' => 'creport/product_sales_reports_date_wise')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//todays_purchase_report
	public function todays_purchase_report()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('todays_purchase_report');
		$CI->load->library('lreport');
		$content = $CI->lreport->todays_purchase_report();
		$sub_menu = array(
			array('label'=> 'Stock Report', 'url' => 'creport'),
			array('label'=> 'Sales Report ', 'url' => 'creport/todays_sales_report'),
			array('label'=> 'Purchase Report ', 'url' => 'creport/todays_purchase_report','class' =>'active'),
			array('label'=> 'Sales Report (Product Wise) ', 'url' => 'creport/product_sales_reports_date_wise')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//All report By Serach
	public function retrieve_dateWise_SalesReports()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('date_wise_report');
		$CI->load->library('lreport');
		$from_date = $this->input->post('from_date');		
		$to_date = $this->input->post('to_date');	
        $content = $CI->lreport->retrieve_dateWise_SalesReports($from_date,$to_date);
        $sub_menu = array(
			array('label'=> 'Stock Report', 'url' => 'creport'),
			array('label'=> 'Sales Report ', 'url' => 'creport/todays_sales_report','class' =>'active'),
			array('label'=> 'Purchase Report ', 'url' => 'creport/todays_purchase_report'),
			array('label'=> 'Sales Report (Product Wise) ', 'url' => 'creport/product_sales_reports_date_wise')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}	
	//All report By Serach
	public function retrieve_dateWise_PurchaseReports()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('date_wise_report');
		$CI->load->library('lreport');
		$start_date = $this->input->post('from_date');		
		$end_date = $this->input->post('to_date');	
        $content = $CI->lreport->retrieve_dateWise_PurchaseReports($start_date,$end_date);
        $sub_menu = array(
			array('label'=> 'Stock Report', 'url' => 'creport'),
			array('label'=> 'Sales Report ', 'url' => 'creport/todays_sales_report'),
			array('label'=> 'Purchase Report ', 'url' => 'creport/todays_purchase_report','class' =>'active'),
			array('label'=> 'Sales Report (Product Wise) ', 'url' => 'creport/product_sales_reports_date_wise')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//PRODUCT WISE DAILY REPORT
	public function product_sales_reports_date_wise()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('date_wise_report');
		$CI->load->library('lreport');	
        $content = $CI->lreport->get_products_report_sales_view();
        $sub_menu = array(
			array('label'=> 'Stock Report', 'url' => 'creport'),
			array('label'=> 'Sales Report ', 'url' => 'creport/todays_sales_report'),
			array('label'=> 'Purchase Report ', 'url' => 'creport/todays_purchase_report'),
			array('label'=> 'Sales Report (Product Wise) ', 'url' => 'creport/product_sales_reports_date_wise','class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	public function product_sales_search_reports()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('todays_sale_report');
		$CI->load->library('lreport');
		$from_date = $this->input->post('from_date');		
		$to_date = $this->input->post('to_date');	
        $content = $CI->lreport->get_products_search_report( $from_date,$to_date );
        $sub_menu = array(
			array('label'=> 'Stock Report', 'url' => 'creport'),
			array('label'=> 'Sales Report ', 'url' => 'creport/todays_sales_report'),
			array('label'=> 'Purchase Report ', 'url' => 'creport/todays_purchase_report'),
			array('label'=> 'Sales Report (Product Wise) ', 'url' => 'creport/product_sales_reports_date_wise','class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
}